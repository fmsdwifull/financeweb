<?php

define('IN_ECS', true);

require_once(ROOT_PATH . '/fuiou_key/fuiou_rsa.function.php');
require_once "AospClient.php";
/* 富友常量 */
$mchnt_cd = "0002900F0041077";

/* 获取指定用户的充值提现流水               */
/* 变量：开始日期和结束日期不能跨月         */
/* 变量：$busi_tp：PW11 充值 
                   PWTX 提现                */
/* 变量：$start_time：yyyy-MM-dd HH:mm:ss   */
function get_recharge_log($user_id,$busi_tp,$start_time,$end_time,$page=1,$page_size=100,$txn_ssn=""){
	global $mchnt_cd;
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
	$url = "http://www-1.fuiou.com:9057/jzh/querycztx.action";
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
	$signature = get_signature($parameters);

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
	$result = rsaVerify($result_string, "./fuiou_key/php_pbkey.pem", $sign);

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
	global $mchnt_cd;
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
	$url = "http://www-1.fuiou.com:9057/jzh/queryTxn.action";
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
	$signature = get_signature($parameters);

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
	$result = rsaVerify($result_string, "./fuiou_key/php_pbkey.pem", $sign);

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
	$item_key = "I-9999001";
	save_wuyou(37,$item_key);
	global $mchnt_cd;
	$fuiou_reg_id = "2001".time().$user_id;
	
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("余额查询1",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	
	
	/* 初始化参数 */
	$url = "http://www-1.fuiou.com:9057/jzh/BalanceAction.action";
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn"		=> $fuiou_reg_id,
		"mchnt_txn_dt"		=> date("Ymd",time()),
		"cust_no"			=> $mobile
	);	
	
	/* 生成签名 */
	$signature = get_signature($parameters);
	
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
	$result = rsaVerify($result_string, "./fuiou_key/php_pbkey.pem", $sign);
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

/* 用户购买产品（商户与用户之间） */
function pay_order($user_id,$goods_id,$amount){
	global $mchnt_cd;
	$fuiou_reg_id = "4003".time().$user_id;

	/* 获取用户数据 */
    $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 获取产品数据 */
	$sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('goods').
           "WHERE goods_id = ".$goods_id;
	$goods = $GLOBALS['db']->getRow($sql);
	
	if (($goods["cat_id"]==1)&&($user["is_xinshoubao"]==1)){
		show_message("每个用户只能购买一次新手包。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}

	$result_array = fuiou_transaction($fuiou_reg_id,$user_id,$user["user_name"],$goods["fuiou_id"],$amount);
	if ($result_array["resp_code"]=="0000"){
		$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('order_new') . ' (pay_sn,goods_id,user_id,amount,pay_time) VALUES ('.$result_array["mchnt_txn_ssn"].','.$goods_id.','.$user_id.','.$amount.', '.time().')';
		$GLOBALS['db']->query($sql);
		if ($goods["cat_id"]==1){
            $sql = 'UPDATE ' . $GLOBALS['ecs']->table('users') . " SET `is_xinshoubao`= 1 WHERE `user_id`='" . $user_id . "'";
            $GLOBALS['db']->query($sql);
		}
		show_message("订单完成<br>交易金额：".$amount."元<br>订购产品：".$goods["goods_name"]."。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}else{
		show_message("系统异常，错误编码：".$_POST["resp_code"]."，错误环境：pay_order，请速与网站负责人联系。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}
}

/* 产品返还用户利息（商户与用户之间） */
function return_interest($user_id,$goods_id,$amount,$remark){
	global $mchnt_cd;
	$fuiou_reg_id = "4005".time().$user_id;
	
	// 此处填写还款的付款账号
	$out_cust_no = "jzh09";
	
	/* 获取用户数据 */
    $sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('users').
           "WHERE user_id = ".$user_id;
    $user = $GLOBALS['db']->getRow($sql);
	
	/* 获取产品数据 */
	$sql = 'SELECT * '.
           'FROM ' .$GLOBALS['ecs']->table('goods').
           "WHERE goods_id = ".$goods_id;
	$goods = $GLOBALS['db']->getRow($sql);
	
	/* 还款 */
	$result_array = fuiou_transaction($fuiou_reg_id,$user_id,$out_cust_no,$user["user_name"],$amount,$remark);
	
	return $result_array;
}

/********************************************************************************/
/*  PRIVATE FUNCTION
*********************************************************************************/
/* 无忧存证提交信息*/
	class wuyou{
		
		private $apiAddress="http://openapi-test1.51cunzheng.com";
		private $partnerKey="25fc1dc655a3129d8f4610eb09b66d10";
		private $secret="800aad195eccc73cec0985a3da433382b165b312";

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
			$map["goods_name"]=$goods["goods_name"];
			$map["true_name"]=$user["true_name"];
			$map["goods_owner"]=$goods["goods_owner_name"];
			$map["platform"]="政金网";
			$map["garentee"]="无忧存证";
			$map["time"]=date("Y-m-d H:i:s",time());
			
			$map["goods_owner_licence"]=$goods["goods_owner_licence"];
			$map["goods_owner_code"]=$goods["goods_owner_code"];
			$map["user_id_type"]="身份证";
			$map["user_id_number"]=$user["id_number"];
			$map["goods_total_number"]=number_format($goods["goods_total_number"],0)."元";
			$map["goods_interest_rate"]=$goods["goods_interest_rate"]."%";
			$map["goods_period"]=$goods["goods_period"]."天";
			$map["goods_earn_method"]="T+0";
			$map["buy_date"]=date("Y-m-d",$order["pay_time"]);
			if ($goods["goods_transfer_flag"]){
				$map["transfer_flag"]="是";
			}else{
				$map["transfer_flag"]="否";
			}
			$map["goods_min_buy"]=$goods["goods_min_buy"]."元";
			$map["pay_info"]="";
			$map["pay_method"]="富友在线支付";
			$map["amount"]=number_format($order["amount"],2)."元";
			$map["pay_account"]=$user["user_name"];
			$map["receive_account"]=$goods["fuiou_id"];
			$map["pay_ssn"]=$order["pay_sn"];
			$map["pay_time"]=date("Y-m-d H:i:s",$order["pay_time"]);
			$map["buy_time"]=date("Y-m-d H:i:s",$order["pay_time"]);
			$map["remark"]="";

	//附件上传
	//以下是附件，附件可以没有(附件中的两个参数，前者是，附件的全路径，后者是附件的一个描述信息)
			//$aospRequest->addFile("D:/1111111111.pdf", "1-1417663890314");
			//$aospRequest->addFile("c:/222222222222.pdf", "1-1417663890313");

			$aospRequest->setData($map);
			$aospClient=new AospClient($this->apiAddress,$this->partnerKey,$this->secret);
			echo "<pre>";print_r($aospRequest);exit;
			$aospResponse = $aospClient->save($aospRequest);
		//	echo "<pre>";print_r($aospResponse);exit;
		    $ancun_Data = $aospResponse->getData();
			$ancun_code = $aospResponse->getCode();
			if($ancun_code=100000){
				$ancun_Record = $ancun_Data['recordNo'];
			}
		}
	}
function save_wuyou($order_id,$item_key){
	$wuyou=new wuyou();
	$data=$wuyou->main_wuyou($order_id,$item_key);
}

function fuiou_transaction($fuiou_reg_id,$user_id,$out_cust_no,$in_cust_no,$amount,$remark=""){
	global $mchnt_cd;
	
	/* 插入记录数据库 */
	$sql = 'INSERT INTO '. $GLOBALS['ecs']->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("订单支付",'.$user_id.','.$fuiou_reg_id.')';
	$GLOBALS['db']->query($sql);	
	
	/* 初始化参数 */
	$url = "http://www-1.fuiou.com:9057/jzh/transferBmu.action";
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
	$signature = get_signature($parameters);	
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
	$result = rsaVerify($result_string, "./fuiou_key/php_pbkey.pem", $sign);
	if (!$result){
		show_message("非法数据入侵，签名不正确。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	return $result_array;
}

function get_signature($parameters){
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
	$signature = rsaSign($string,"./fuiou_key/php_prkey.pem");
	return $signature;
}
?>