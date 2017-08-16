<?php

define('IN_ECS', true);

require_once(ROOT_PATH . '/fuiou_key/fuiou_rsa.function.php');
//print_r(ROOT_PATH . '/fuiou_key/fuiou_rsa.function.php');
require_once "AospClient.php";
/* 富友常量 */
//测试环境
//$mchnt_cd = "0002900F0041077";
//正式环境
//$mchnt_cd = "0002900F0278327";

/* 获取用户所在的富友金账户mchnt_cd, pbkey, prkey */
/* 变量：$user_id：用户在政金网平台上的id   */
function get_user_fuiou_account($user_id){
	$sql = "SELECT fac.* FROM ". $GLOBALS["ecs"]->table('users'). " AS u
				LEFT JOIN ". $GLOBALS["ecs"]->table('seller'). " AS s ON s.seller_id = u.seller_id 
				LEFT JOIN ". $GLOBALS["ecs"]->table('fuiou_account_config'). " AS fac ON fac.account_id = s.fuiou_account_id 
				WHERE u.user_id = ".$user_id;
	return $GLOBALS["db"]->getRow($sql);
}

/* 获取指定用户的充值提现流水               */
/* 变量：开始日期和结束日期不能跨月         */
/* 变量：$busi_tp：PW11 充值 
                   PWTX 提现                */
/* 变量：$start_time：yyyy-MM-dd HH:mm:ss   */
function get_recharge_log($user_id,$busi_tp,$start_time,$end_time,$page=1,$page_size=100,$txn_ssn=""){
	$fuiou_account = get_user_fuiou_account($user_id);
	$mchnt_cd = $fuiou_account["mchnt_cd"];
	$pbkey = $fuiou_account["pbkey"];
	$prkey = $fuiou_account["prkey"];
	$fuiou_reg_id = "6003".time().$user_id; 

	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("充值提现查询",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);

	/* 获取用户数据 */
    $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 初始化参数 */
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/querycztx.action";
	//正式环境
	$url = "https://jzh.fuiou.com/querycztx.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"busi_tp"			=> $busi_tp,
		"start_time"		=> $start_time,
		"end_time"			=> $end_time,
		"cust_no"			=> $user["user_name"],
		"txn_st"			=> 1,
		"page_no"			=> $page,
		"page_size"			=> $page_size
	);	
	
	/* 生成签名 */
	$signature = get_signature($parameters,$prkey);

	/* 将签名导入提交数据 */
	$parameters["signature"] = $signature;	

	/* 发送请求 */
	$post_data = $parameters;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$response = curl_exec($ch);	
	if(curl_errno($ch)){
		print curl_error($ch);
	}
	curl_close($ch);
	// 处理返回数据 验签
	$rss = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);
	//echo $rss->plain->total_number;exit;
	$result_array = (array)$rss->plain;
	$result_array["results"] = (array)$rss->plain->results;
	$results = (array)$rss->plain->results;
	
	if(is_array($results["result"])){ //处理很多条数据的情况
		$result = array();
		foreach ($results["result"] as $key => $val){
			$result[] = (array)$val;
		}
		$result_array["results"]["result"] = $result;
		$result_string = "<plain>";
		foreach ($result_array as $key => $val){
			$add = "<".$key.">";
			if (is_array($val)){
				foreach ($val as $key1 => $val1){
					if (is_array($val1)){
						foreach ($val1 as $key2 => $val2){
							$add2 .="<".$key1.">";
							foreach ($val2 as $key3 => $val3){
								$add3 = "<".$key3.">".$val3."</".$key3.">";
								$add2 .= $add3;
							}
							$add2 .= "</".$key1.">";
						}
						$add1.= $add2;
					}else{
						$add1 .= $val1;
					}
					$add .= $add1;
				}
			}else{
				$add .= $val;
			}
			$add .= "</".$key.">";
			$result_string .= $add;
		}
		$result_string .= "</plain>";
	}else{            // 处理单条或者没有数据的情况
		if (count((array)$rss->plain->results)){
			$result_array["results"]["result"] = (array)$rss->plain->results->result;
		}
		$result_string = "<plain>";
		foreach ($result_array as $key => $val){
			$add = "<".$key.">";
			if (is_array($val)){
				foreach ($val as $key1 => $val1){
					$add1 = "<".$key1.">";
					if (is_array($val1)){
						foreach ($val1 as $key2 => $val2){
							$add2 = "<".$key2.">".$val2."</".$key2.">";
							$add1 .= $add2;
						}
					}else{
						$add1 .= $val1;
					}
					$add1 .= "</".$key1.">";
					$add .= $add1;
				}
			}else{
				$add .= $val;
			}
			$add .= "</".$key.">";
			$result_string .= $add;
		}
		$result_string .= "</plain>";		
	}
	$sign = $rss->signature;
	$result = rsaVerify($result_string, "./fuiou_key/".$pbkey, $sign);
	//print_r('1');exit();
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	/* 验签成功，处理返回数据 */
	$total_number = $rss->plain->total_number;
	$log_list = array();
	if(is_array($results["result"])){ // 收到了很多条返回信息
		$log_list = $result_array["results"]["result"];
	}else{ // 收到了0,1条返回信息
		if (count((array)$rss->plain->results)){ // 返回了1条信息
			$result = (array)$rss->plain->results->result;
			$log_list[] = $result;
		}
	}
	return $log_list;
}

/* 获取指定用户的资金流水 */
function get_money_log($user_id,$start_day,$end_day,$page=1,$page_size=100,$txn_ssn=""){
	$fuiou_account = get_user_fuiou_account($user_id);
	$mchnt_cd = $fuiou_account["mchnt_cd"];
	$pbkey = $fuiou_account["pbkey"];
	$prkey = $fuiou_account["prkey"];
	$fuiou_reg_id = "5007".time().$user_id;
	
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("流水查询",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	

	/* 获取用户数据 */
    $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 初始化参数 */
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/queryTxn.action";
	//正式环境
	$url = "https://jzh.fuiou.com/queryTxn.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"busi_tp"			=> "PWPC",
		"start_day"			=> $start_day,
		"end_day"			=> $end_day,
		"txn_ssn"			=> $txn_ssn,
		"cust_no"			=> $user["user_name"],
		"txn_st"			=> 1,
		"remark"			=> "",
		"page_no"			=> $page,
		"page_size"			=> $page_size
	);	

	/* 生成签名 */
	$signature = get_signature($parameters,$prkey);

	/* 将签名导入提交数据 */
	$parameters["signature"] = $signature;	
	
	/* 发送请求 */
	$post_data = $parameters;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$response = curl_exec($ch);	
	if(curl_errno($ch)){
		print curl_error($ch);
	}
	curl_close($ch);
	// 处理返回数据 验签

	$rss = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);
	
	//echo $rss->plain->total_number;exit;
	$result_array = (array)$rss->plain;
	$result_array["results"] = (array)$rss->plain->results;
	$results = (array)$rss->plain->results;
	
	if(is_array($results["result"])){ //处理很多条数据的情况
		$result = array();
		foreach ($results["result"] as $key => $val){
			$result[] = (array)$val;
		}
		$result_array["results"]["result"] = $result;
		$result_string = "<plain>";
		foreach ($result_array as $key => $val){
			$add = "<".$key.">";
			if (is_array($val)){
				foreach ($val as $key1 => $val1){
					if (is_array($val1)){
						foreach ($val1 as $key2 => $val2){
							$add2 .="<".$key1.">";
							foreach ($val2 as $key3 => $val3){
								$add3 = "<".$key3.">".$val3."</".$key3.">";
								$add2 .= $add3;
							}
							$add2 .= "</".$key1.">";
						}
						$add1.= $add2;
					}else{
						$add1 .= $val1;
					}
					$add .= $add1;
				}
			}else{
				$add .= $val;
			}
			$add .= "</".$key.">";
			$result_string .= $add;
		}
		$result_string .= "</plain>";
	}else{            // 处理单条或者没有数据的情况
		if (count((array)$rss->plain->results)){
			$result_array["results"]["result"] = (array)$rss->plain->results->result;
		}
		$result_string = "<plain>";
		foreach ($result_array as $key => $val){
			$add = "<".$key.">";
			if (is_array($val)){
				foreach ($val as $key1 => $val1){
					$add1 = "<".$key1.">";
					if (is_array($val1)){
						foreach ($val1 as $key2 => $val2){
							$add2 = "<".$key2.">".$val2."</".$key2.">";
							$add1 .= $add2;
						}
					}else{
						$add1 .= $val1;
					}
					$add1 .= "</".$key1.">";
					$add .= $add1;
				}
			}else{
				$add .= $val;
			}
			$add .= "</".$key.">";
			$result_string .= $add;
		}
		$result_string .= "</plain>";		
	}
	$sign = $rss->signature;
	$result = rsaVerify($result_string, "./fuiou_key/".$pbkey, $sign);
	//print_r('2');exit();
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	/* 验签成功，处理返回数据 */
	$total_number = $rss->plain->total_number;
	$log_list = array();
	if(is_array($results["result"])){ // 收到了很多条返回信息
		$log_list = $result_array["results"]["result"];
	}else{ // 收到了0,1条返回信息
		if (count((array)$rss->plain->results)){ // 返回了1条信息
			$result = (array)$rss->plain->results->result;
			$log_list[] = $result;
		}
	}
	return $log_list;
}

/* 获取指定用户的划账流水（用户间） */
function get_money_log2($user_id,$start_day,$end_day,$page=1,$page_size=100,$txn_ssn=""){
	$fuiou_account = get_user_fuiou_account($user_id);
	$mchnt_cd = $fuiou_account["mchnt_cd"];
	$pbkey = $fuiou_account["pbkey"];
	$prkey = $fuiou_account["prkey"];
	$fuiou_reg_id = "5007".time().$user_id;
	
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("流水查询",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	

	/* 获取用户数据 */
    $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 初始化参数 */
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/queryTxn.action";
	//正式环境
	$url = "https://jzh.fuiou.com/queryTxn.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"busi_tp"			=> "PW03",
		"start_day"			=> $start_day,
		"end_day"			=> $end_day,
		"txn_ssn"			=> $txn_ssn,
		"cust_no"			=> $user["user_name"],
		"txn_st"			=> 1,
		"remark"			=> "",
		"page_no"			=> $page,
		"page_size"			=> $page_size
	);	
	
	/* 生成签名 */
	$signature = get_signature($parameters,$prkey);

	/* 将签名导入提交数据 */
	$parameters["signature"] = $signature;	
	
	/* 发送请求 */
	$post_data = $parameters;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$response = curl_exec($ch);	
	if(curl_errno($ch)){
		print curl_error($ch);
	}
	curl_close($ch);
	// 处理返回数据 验签

	$rss = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);
	$result_array = (array)$rss->plain;
	$result_array["results"] = (array)$rss->plain->results;
	$results = (array)$rss->plain->results;
	
	if(is_array($results["result"])){ //处理很多条数据的情况
		$result = array();
		foreach ($results["result"] as $key => $val){
			$result[] = (array)$val;
		}
		$result_array["results"]["result"] = $result;
		$result_string = "<plain>";
		foreach ($result_array as $key => $val){
			$add = "<".$key.">";
			if (is_array($val)){
				foreach ($val as $key1 => $val1){
					if (is_array($val1)){
						foreach ($val1 as $key2 => $val2){
							$add2 .="<".$key1.">";
							foreach ($val2 as $key3 => $val3){
								$add3 = "<".$key3.">".$val3."</".$key3.">";
								$add2 .= $add3;
							}
							$add2 .= "</".$key1.">";
						}
						$add1.= $add2;
					}else{
						$add1 .= $val1;
					}
					$add .= $add1;
				}
			}else{
				$add .= $val;
			}
			$add .= "</".$key.">";
			$result_string .= $add;
		}
		$result_string .= "</plain>";
	}else{            // 处理单条或者没有数据的情况
		if (count((array)$rss->plain->results)){
			$result_array["results"]["result"] = (array)$rss->plain->results->result;
		}
		$result_string = "<plain>";
		foreach ($result_array as $key => $val){
			$add = "<".$key.">";
			if (is_array($val)){
				foreach ($val as $key1 => $val1){
					$add1 = "<".$key1.">";
					if (is_array($val1)){
						foreach ($val1 as $key2 => $val2){
							$add2 = "<".$key2.">".$val2."</".$key2.">";
							$add1 .= $add2;
						}
					}else{
						$add1 .= $val1;
					}
					$add1 .= "</".$key1.">";
					$add .= $add1;
				}
			}else{
				$add .= $val;
			}
			$add .= "</".$key.">";
			$result_string .= $add;
		}
		$result_string .= "</plain>";		
	}
	$sign = $rss->signature;
	$result = rsaVerify($result_string, "./fuiou_key/".$pbkey, $sign);
	//print_r('3');exit();
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	/* 验签成功，处理返回数据 */
	$total_number = $rss->plain->total_number;
	$log_list = array();
	if(is_array($results["result"])){ // 收到了很多条返回信息
		$log_list = $result_array["results"]["result"];
	}else{ // 收到了0,1条返回信息
		if (count((array)$rss->plain->results)){ // 返回了1条信息
			$result = (array)$rss->plain->results->result;
			$log_list[] = $result;
		}
	}
	return $log_list;
}
/* 获取指定用户的余额 */
function get_user_money($user_id,$mobile){
	$sql = 'SELECT is_bank_card '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;

    if($GLOBALS['db']->getOne($sql) == 0){
		return 0;
	}
	$fuiou_account = get_user_fuiou_account($user_id);
	$mchnt_cd = $fuiou_account["mchnt_cd"];
	$pbkey = $fuiou_account["pbkey"];
	//print_r($pbkey);exit();
	$prkey = $fuiou_account["prkey"];
	$fuiou_reg_id = "2001".time().$user_id;
	
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("余额查询1",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	
	
	/* 初始化参数 */
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/BalanceAction.action";
	//正式环境
	$url = "https://jzh.fuiou.com/BalanceAction.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"mchnt_txn_dt"		=> date("Ymd",time()),
		"cust_no"			=> $mobile
	);	
	
	/* 生成签名 */
	$signature = get_signature($parameters,$prkey);
	
	  // 将签名导入提交数据
	$parameters["signature"] = $signature;	

	/* 发送请求 */
	$post_data = $parameters;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$response = curl_exec($ch);	

	if(curl_errno($ch)){
		print curl_error($ch);
	}
	curl_close($ch);

	// 处理返回数据 验签
	$rss = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);
	$result_array = (array)$rss->plain;
	$result_array["results"] = (array)$rss->plain->results;
	$result_array["results"]["result"] = (array)$rss->plain->results->result;
	$result_string = "<plain>";
	foreach ($result_array as $key => $val){
		$add = "<".$key.">";
		if (is_array($val)){
			foreach ($val as $key1 => $val1){
				$add1 = "<".$key1.">";
				if (is_array($val1)){
					foreach ($val1 as $key2 => $val2){
						$add2 = "<".$key2.">".$val2."</".$key2.">";
						$add1 .= $add2;
					}
				}else{
					$add1 .= $val1;
				}
				$add1 .= "</".$key1.">";
				$add .= $add1;
			}
		}else{
			$add .= $val;
		}
		$add .= "</".$key.">";
		$result_string .= $add;
	}
	$result_string .= "</plain>";
	$sign = $rss->signature;
	$result = rsaVerify($result_string, ROOT_PATH ."./fuiou_key/".$pbkey, $sign);
	//print_r($result);exit();
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}

	$user_money = array(
		"ct_balance" => $rss->plain->results->result->ct_balance/100,
		"ca_balance" => $rss->plain->results->result->ca_balance/100,
		"cf_balance" => $rss->plain->results->result->cf_balance/100,
		"cu_balance" => $rss->plain->results->result->cu_balance/100,
		"format_ct_balance" => number_format(($rss->plain->results->result->ct_balance / 100),2),
		"format_ca_balance" => number_format(($rss->plain->results->result->ca_balance / 100),2),
		"format_cf_balance" => number_format(($rss->plain->results->result->cf_balance / 100),2),
		"format_cu_balance" => number_format(($rss->plain->results->result->cu_balance / 100),2)
	);
	return $user_money;
}

/* 用户之间的转让产品（用户与用户之间）*/
function pay_transfer($user_id,$order_id){
	$fuiou_reg_id = "7001".time().$user_id;
	/* 获取用户数据 */
	$sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 获取订单数据 */
	$sql = 'SELECT o.*, u.*,g.* '.
           'FROM ' .$GLOBALS['ecs']->table('order_new'). " AS o LEFT JOIN " 
		   .$GLOBALS['ecs']->table('users')
		   . " AS u ON o.user_id = u.user_id"
		   . " LEFT JOIN ". $GLOBALS['ecs']->table('goods')
		   . " AS g ON o.goods_id = g.goods_id"
           ." WHERE order_id = ".$order_id;
	$order = $GLOBALS['db']->getRow($sql);
	
	$result_array = fuiou_trade($fuiou_reg_id,$user_id,$user["user_name"],$order["user_name"],$order["transfer_amount"],$order["goods_name"]."-转让");
	if ($result_array["resp_code"]=="0000"){
		/* 将被转让的订单设置成已转让状态，并设置转让时间戳 */
		$sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_new') . " SET `transfer_flag`=2, `transfer_end_time`= ".time()." WHERE `order_id`='" . $order_id . "'";
        $GLOBALS['db']->query($sql);
		
		/* 生成新订单给买方 */
		$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('order_new') . ' (pay_sn,goods_id,user_id,amount,pay_time,get_paid,is_noticed,buy_transfer_amount,transfer_time,parent_id) VALUES ('.$result_array["mchnt_txn_ssn"].','.$order["goods_id"].','.$user["user_id"].','.$order["amount"].', '.$order["pay_time"].','.$order["get_paid"].','.$order["is_noticed"].','.$order["transfer_amount"].','.time().",".$order["order_id"].')';
		$GLOBALS['db']->query($sql);

		
		/* 收取平台手续费 */
		// 此处填写平台的虚拟账号
		/************************** 重要 **************************/
		$in_cust_no = "HHJRXX001k";
		$fuiou_reg_id = "9001".time().$user_id;
		$amount =floor($order["transfer_amount"]*100/500)/100;
		// 获取付款人账号
		$sql = 'SELECT user_name '.'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$order["user_id"];
		$user_name = $GLOBALS['db']->getOne($sql);
		$result_array2 = fuiou_transaction($fuiou_reg_id,$order["user_id"],$user_name,$in_cust_no,$amount,"手续费");
		
		
		show_message("成功完成此次订购<br>交易金额：".$order["transfer_amount"]."元<br>您可以在用户中心中查询到订单详情。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}else{
		show_message("系统异常，错误编码：".$_POST["resp_code"]."，错误环境：pay_order，请速与网站负责人联系。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}
}

/* 用户购买产品（企业用户与个人用户之间） */
function pay_order($user_id,$goods_id,$amount,$mac=""){
	$fuiou_reg_id = "4003".time().$user_id;

	/* 获取用户数据 */
    $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 获取产品数据 */
	$sql = 'SELECT g.*,c.cat_name '.
           'FROM ' .$GLOBALS['ecs']->table('goods').
           " AS g LEFT JOIN ".$GLOBALS['ecs']->table('category')." AS c ON g.cat_id = c.cat_id  WHERE goods_id = ".$goods_id;
	$goods = $GLOBALS['db']->getRow($sql);
	
	if (($goods["cat_id"]==1)&&($user["is_xinshoubao"]==1)){
		show_message("每个用户只能购买一次新手包。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}
	//这里是根据用户表推出的seller,所以一切取决于用户是哪一边的，门店用户的seller是没有Mac一说的，所以$mac_num存在就是媒体订单，否则是门店订单！	
	$seller_id = $user['seller_id'];
	//这里$mac_num 是后台设置的，根据seller_id
	$sql = 'SELECT seller_mac FROM ' . $GLOBALS['ecs']->table('seller'). " WHERE seller_id = ".$seller_id;
	$mac_num = $GLOBALS['db']->getOne($sql);
	
	$sql = 'SELECT mac FROM ' . $GLOBALS['ecs']->table('mac_list');
	$mac_list = $GLOBALS['db']->getAll($sql);
	//print_r(count($mac_list));
	for($i=0;$i<count($mac_list);$i++){
		$mac_array[$i] = $mac_list[$i]['mac'];
	}
	//print_r($mac_array);
	if (!$seller_id){
		show_message("您填写的业务员编号不存在<br>如果您想登陆查询您的账户，可以在此处留空并重新登录");
		exit;
	}
	else{
		if($mac_num){ //区分门店和媒体，前提是媒体店的电脑都是能提取到mac地址的
			if(in_array($_SESSION['mac'],$mac_array)){  //此处应该是,判断 业务员使用的电脑的mac地址 是否在规定的媒体电脑的mac地址集合内
				if($mac_num == $_SESSION['mac']){
					//插入到orser_new的mac字段，后台显示登陆的状态
					$mac_status = "Mac地址正常";
				}else{
					$mac_status = "Mac地址不匹配";//此处表示,媒体业务员用的是，店内其他业务员的电脑
				}
			}else{
				$mac_status = "Mac地址不在集合范围内！";
			}
		}else{
			$mac_status = "";//空字符串，为门店订单
		}
			
	}
	
	
	
	
	
	//$goods["fuiou_id"]，分两种情况：1.和瀚1的子帐号，2.和瀚2的子帐号，$user_id=>$seller_id,$seller=>区分那个大账户，=>得到对应的子帐号，即=>$goods["fuiou_id"]
	$seller_id = $user['seller_id'];
	
	$sql = "SELECT fuiou_account_id FROM ". $GLOBALS['ecs']->table('seller') .  " WHERE seller_id = ".$seller_id ." ORDER BY seller_id DESC LIMIT 0,1";
	//以及账户
	$ol_fuiou_id = $GLOBALS['db']->getOne($sql);
	//print_r($ol_fuiou_id);
	//print_r($goods['fuiou_id']);
	$goods_fuiou_id = explode(",",$goods['fuiou_id']);
	if($ol_fuiou_id==1){
		//print_r($goods_fuiou_id[0]);
		$tl_fuiou_id = $goods_fuiou_id[0];
	}else if($ol_fuiou_id==7){
		//print_r($goods_fuiou_id[1]);
		$tl_fuiou_id = $goods_fuiou_id[1];
	}
	$result_array = fuiou_trade($fuiou_reg_id,$user_id,$user["user_name"],$tl_fuiou_id,$amount,$goods["goods_name"]);
	//print_r($result_array["resp_code"]);
	if ($result_array["resp_code"]=="0000"){
		// 添加订单
		$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('order_new') . ' (pay_sn,goods_id,user_id,amount,pay_time,mac) VALUES ('.$result_array["mchnt_txn_ssn"].','.$goods_id.','.$user_id.','.$amount.', '.time().',"'.$mac_status.'")';
		$GLOBALS['db']->query($sql);
		$sql = "SELECT order_id FROM ". $GLOBALS['ecs']->table('order_new') .  " WHERE user_id = ".$user_id ." ORDER BY order_id DESC LIMIT 0,1";
		$order_id = $GLOBALS['db']->getOne($sql);
		if ($goods["cat_id"]==1){
            $sql = 'UPDATE ' . $GLOBALS['ecs']->table('users') . " SET `is_xinshoubao`= 1 WHERE `user_id`='" . $user_id . "'";
            $GLOBALS['db']->query($sql);
		}
			
		/* 生成pdf电子合同 */
		require_once('includes/lib_rmb.php');
		$ext = new Ext_Num2Cny();
		$amount_daxie = $ext->ParseNumber($amount);
		
		$sql = "SELECT g.project_id FROM ".$GLOBALS["ecs"]->table("order_new")." AS o 
			LEFT JOIN ".$GLOBALS["ecs"]->table("goods"). " AS g ON g.goods_id = o.goods_id 
			WHERE o.order_id = ".$order_id;
		$project_id = $GLOBALS["db"]->getOne($sql);
		//print_r($project_id);
		//分情况,$project_id==6,余姚产品
		//$project_id = 6;
		if($project_id==6){
			require_once('includes/lib_contactnew.php');
		}else{
			require_once('includes/lib_contact.php');
		}
		creatContact($order_id);

		/* 无忧存证开证 */
		// 获取新订单信息
		$sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('order_new').
           "WHERE pay_sn = ".$result_array["mchnt_txn_ssn"];
		$order = $GLOBALS['db']->getRow($sql);
		
		$item_key = "I-0087001";
	
		save_wuyou($order["order_id"],$item_key);	
		// 减少库存
		$new_stock = $goods["goods_rest_number"] - $amount;
		$new_stock = max($new_stock,0);
		$sql = 'UPDATE ' . $GLOBALS['ecs']->table('goods') . " SET `goods_rest_number`=".$new_stock." WHERE `goods_id`='" . $goods["goods_id"]. "'";
        $GLOBALS['db']->query($sql);

		show_message("订单完成<br>交易金额：".$amount."元<br>订购产品：".$goods["goods_name"]."。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}else{
		show_message("系统异常，错误编码：".$_POST["resp_code"]."，错误环境：pay_order，请速与网站负责人联系。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}
}

/* 产品返还用户利息（商户与用户之间） */
function return_interest($user_id,$goods_id,$amount,$remark){
	$fuiou_reg_id = "4005".time().$user_id;
	
	// 此处填写平台的虚拟账号
	$out_cust_no = "HHJRXX001k";
	
	/* 获取用户数据 */
    $sql = 'SELECT user_name '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user_name = $GLOBALS['db']->getOne($sql);
	
	/* 获取产品数据 */
	/* $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('goods').
           "WHERE goods_id = ".$goods_id;
	$goods = $GLOBALS['db']->getRow($sql); */
	
	/* 还款 */
	$result_array = fuiou_transaction($fuiou_reg_id,$user_id,$out_cust_no,$user_name,$amount,$remark);
	
	return $result_array;
}

/********************************************************************************/
/*  PRIVATE FUNCTION
*********************************************************************************/
/* 无忧存证提交信息-客户投资*/
	class wuyou{
		private $apiAddress="https://www.51cunzheng.com/openapi";

		private $partnerKey="89d4a347c99352891ffb2634a4fe3bc0";
		private $secret="8c6bc0e6dead13a7eac6aa24e570dbfa09e0e44c";
		function main_wuyou($order_id,$item_key){
			$aospRequest =new AospRequest();
			$aospRequest->setItemKey($item_key);
			
			/* 获取订单数据 */
			$sql = 'SELECT * '.
				   'FROM ' .$GLOBALS['ecs']->table('order_new').
				   "WHERE order_id = ".$order_id;
			$order = $GLOBALS['db']->getRow($sql);
			
			/* 获取用户数据 */
			$sql = 'SELECT * '.
				   'FROM ' .$GLOBALS['ecs']->table('users').
				   "WHERE user_id = ".$order["user_id"];
			$user = $GLOBALS['db']->getRow($sql);
			
			/* 获取产品数据 */	
			$sql = 'SELECT * '.
				   'FROM ' .$GLOBALS['ecs']->table('goods').
				   "WHERE goods_id = ".$order["goods_id"];
			$goods = $GLOBALS['db']->getRow($sql);
		    
			$map =array();
			// 转让人信息
			$map["goods_owner"]=$goods["goods_owner_name"];
			$map["goods_owner_licence"]=$goods["goods_owner_licence"];
			$map["goods_owner_code"]=$goods["goods_owner_code"];
			
			// 受让人信息
			$map["true_name"]=$user["true_name"];
			$map["user_id_type"]="身份证";
			$map["user_id_number"]=$user["id_number"];
			
			// 项目信息
			$map["goods_name"]=$goods["goods_name"];
			$map["goods_total_number"]=number_format($goods["goods_total_number"],0)."元";
			$map["goods_interest_rate"]=$goods["goods_interest_rate"]."%";
			$map["goods_period"]=$goods["goods_period"]."天";
			$map["goods_earn_method"]="T+".$goods["t"];
			$map["buy_date"]=date("Y-m-d H:i:s",$order["pay_time"]);
			if ($goods["goods_transfer_flag"]==1){
				$map["goods_transfer_flag"]="是";
			}else{
				$map["goods_transfer_flag"]="否";
			}
			$map["goods_min_buy"]=$goods["goods_min_buy"]."元";
			
			// 支付信息
			$map["pay_method"]="富友在线支付";
			$map["amount"]=number_format($order["amount"],2)."元";
			$map["pay_account"]=$user["true_name"];                  //$user["user_name"];//todo
			$map["receive_account"]=$goods["goods_owner_name"];      //$goods["fuiou_id"];//todo
			$map["buy_time"]=date("Y-m-d H:i:s",$order["pay_time"]);
			$map["pay_ssn"]=$order["pay_sn"];
			$map["pay_time"]=date("Y-m-d H:i:s",$order["pay_time"]);
			$map["remark"]="";

	//附件上传
	//以下是附件，附件可以没有(附件中的两个参数，前者是，附件的全路径，后者是附件的一个描述信息)
			$aospRequest->addFile("http://www.zhengjinnet.com/contact/contact_".$order["pay_sn"].".pdf", $order["pay_sn"].".pdf");
			//$aospRequest->addFile("c:/222222222222.pdf", "1-1417663890313");

			$aospRequest->setData($map);
			$aospClient=new AospClient($this->apiAddress,$this->partnerKey,$this->secret);
	//echo "<pre>";print_r($aospRequest);exit;	
			$aospResponse = $aospClient->save($aospRequest);
	
		    $ancun_Data = $aospResponse->getData();
			$ancun_code = $aospResponse->getCode();
			if($ancun_code=100000){
				// 将存证信息插入目标订单
				$sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_new') . " SET `wuyou_recordno`= '".$ancun_Data["recordNo"]."', `wuyou_attchurl`= '".$ancun_Data["attchUrl"]."' WHERE `order_id`='" . $order_id . "'";
				$GLOBALS['db']->query($sql);
			}
		}
	}
function save_wuyou($order_id,$item_key){
	$wuyou=new wuyou();
	$data=$wuyou->main_wuyou($order_id,$item_key);
}

function fuiou_trade($fuiou_reg_id,$user_id,$payer_id,$receiver_id,$amount,$remark=""){
	$fuiou_account = get_user_fuiou_account($user_id);
	//print_r($fuiou_account);
	$mchnt_cd = $fuiou_account["mchnt_cd"];
	$pbkey = $fuiou_account["pbkey"];
	$prkey = $fuiou_account["prkey"];
	
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("订单支付",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	
	
	/* 初始化参数 */
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/transferBu.action";
	//正式环境
	$url = "https://jzh.fuiou.com/transferBu.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"out_cust_no"		=> $payer_id,
		"in_cust_no"		=> $receiver_id,
		"amt"				=> intval($amount*100),
		"contract_no" 		=> "",
		"rem"				=> $remark
	);	

	/* 生成签名 */
	$signature = get_signature($parameters,$prkey);	
	  // 将签名导入提交数据
	$parameters["signature"] = $signature;	
	//print_r($parameters);
	/* 发送请求 */
	$post_data = $parameters;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$response = curl_exec($ch);	
	if(curl_errno($ch)){
		print curl_error($ch);
	}
	curl_close($ch);

	// 处理返回数据 验签
	$rss = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);
	
	//print_r($rss);
	$result_array = (array)$rss->plain;
	$result_string = "<plain>";
	foreach ($result_array as $key => $val){
		$add = "<".$key.">";
		$add .= $val;
		$add .= "</".$key.">";
		$result_string .= $add;
	}
	$result_string .= "</plain>";
	$sign = $rss->signature;
	$result = rsaVerify($result_string, "./fuiou_key/".$pbkey, $sign);
	//print_r($result);
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	return $result_array;
}


function fuiou_transaction($fuiou_reg_id,$user_id,$out_cust_no,$in_cust_no,$amount,$remark=""){
	$fuiou_account = get_user_fuiou_account($user_id);
	$mchnt_cd = $fuiou_account["mchnt_cd"];
	$pbkey = $fuiou_account["pbkey"];
	$prkey = $fuiou_account["prkey"];
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("订单支付",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	
	
	/* 初始化参数 */
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/transferBmu.action";
	//正式环境
	$url = "https://jzh.fuiou.com/transferBmu.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"out_cust_no"		=> $out_cust_no,
		"in_cust_no"		=> $in_cust_no,
		"amt"				=> intval($amount*100),
		"contract_no" 		=> "",
		"rem"				=> $remark
	);	
	
	/* 生成签名 */
	$signature = get_signature($parameters,$prkey);	
	  // 将签名导入提交数据
	$parameters["signature"] = $signature;	

	/* 发送请求 */
	$post_data = $parameters;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$response = curl_exec($ch);	
	if(curl_errno($ch)){
		print curl_error($ch);
	}
	curl_close($ch);
	
	// 处理返回数据 验签
	$rss = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);
	$result_array = (array)$rss->plain;

	$result_string = "<plain>";
	foreach ($result_array as $key => $val){
		$add = "<".$key.">";
		$add .= $val;
		$add .= "</".$key.">";
		$result_string .= $add;
	}
	$result_string .= "</plain>";
	$sign = $rss->signature;
	$result = rsaVerify($result_string, "./fuiou_key/".$pbkey, $sign);
	//print_r('6');exit();
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	return $result_array;
}

function get_signature($parameters,$prkey){
	// 按字母顺序排序
	ksort($parameters);
	  // 拼接字符串
	$buff = "";
	foreach ($parameters as $k => $v) {
		$buff .= $v . "|";
	}
    $string="";
    if (strlen($buff) > 0) {
        $string = substr($buff, 0, strlen($buff) - 1);
    }
	  // 生成签名
	$signature = rsaSign($string,ROOT_PATH ."./fuiou_key/".$prkey);
	return $signature;
}
?>