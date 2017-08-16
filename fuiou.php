<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(dirname(__FILE__) . '/fuiou_key/fuiou_rsa.function.php');

/* 富友常量 */
//测试环境
//$mchnt_cd = "0002900F0041077";
//正式环境
//$mchnt_cd = "0002900F0278327";

$sql = "SELECT fac.* FROM ". $GLOBALS["ecs"]->table('users'). " AS u
				LEFT JOIN ". $GLOBALS["ecs"]->table('seller'). " AS s ON s.seller_id = u.seller_id 
				LEFT JOIN ". $GLOBALS["ecs"]->table('fuiou_account_config'). " AS fac ON fac.account_id = s.fuiou_account_id 
				WHERE u.user_id = ".$_SESSION["user_id"];
$fuiou_account = $GLOBALS["db"]->getRow($sql);
$mchnt_cd = $fuiou_account["mchnt_cd"];
$prkey = $fuiou_account["prkey"];

/* INPUT */
$act = $_GET["action"];

if ($act == "link_bank_card"){
	/* 检测用户是否已经实名认证绑定银行卡 */
	$sql = 'SELECT is_bank_card, is_id_card FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	$is_id_card = $user["is_id_card"];
	$is_bank_card = $user["is_bank_card"];
	if (!$is_id_card){
		show_message("您还没有进行实名认证，为保护您的账户安全，请进行实名认证并绑定银行卡后进行充值。",array("立刻进行实名认证", "前往用户中心"), array("user.php?act=identify", 'user.php'), 'info',false);
	}
	if ($is_bank_card){
		show_message("非法入口，您已经绑定了您的银行卡信息。",array("立刻前往绑定", "前往用户中心"), array("fuiou.php?action=link_bank_card", 'user.php'), 'info',false);
	}
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/webReg.action";
	//正式环境
	$url = "https://jzh.fuiou.com/webReg.action";
	
	/* 获取用户信息 */
	$sql = 'SELECT user_id, user_name, true_name, id_number FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	
	$fuiou_reg_id = "1007".time().$_SESSION["user_id"];
	/* 插入数据库 */
    $sql = 'UPDATE ' . $ecs->table('users') . " SET `fuiou_reg_sn`='$fuiou_reg_id' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);
	
	/* 初始化参数 */
	$parameters = array(
		"mchnt_cd" 		=> $mchnt_cd,
		"mchnt_txn_ssn" => $fuiou_reg_id,
		"user_id_from"  => $_SESSION["user_id"],
		"mobile_no"		=> $user["user_name"],
		"cust_nm" 		=> $user["true_name"],
		"certif_tp" 	=> 0,
		"certif_id" 	=> $user["id_number"],
		"email"         => "",
		"city_id"       => "",
		"parent_bank_id"=> "",
		"bank_nm"       => "",
		"capAcntNo"     => "",
		"page_notify_url" => "http://www.zhengjinnet.com/fuiou_respond.php?action=link_bank_card",
		"back_notify_url" => ""
	);

	/* 生成签名 */
	  // 按字母顺序排序
	ksort($parameters);
	  // 拼接字符串
	$buff = "";
	foreach ($parameters as $k => $v) {
		if ($k != "certif_tp"){
			$buff .= $v . "|";
		}
	}
    $string="";
    if (strlen($buff) > 0) {
        $string = substr($buff, 0, strlen($buff) - 1);
    }
	  // 生成签名
	$signature = rsaSign($string,"./fuiou_key/".$prkey);

	  // 将签名导入提交数据
	$parameters["signature"] = $signature;

	/* 发送请求 */

	//send_post($url, $parameters);  

	$file = '<form action="'.$url.'" method="POST" id = "form0">';
	foreach ($parameters as $key => $val){
		$file .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
	}
	$file .= "<script>document.getElementById('form0').submit()</script>";
	echo $file;
	exit;
}elseif($act == "login"){
	// 判断用户是否已经登录
	if (!$_SESSION["user_id"]){
		show_message("会话过期，请返回重新登录",array("前往登陆", "返回首页"), array("user.php?act=login", 'index.php'), 'info',false);
	}
	//正式环境
	$url = "https://jzh.fuiou.com/webLogin.action";
	
	/* 获取用户信息 */
	$sql = 'SELECT user_id, user_name, true_name, id_number FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	
	$fuiou_reg_id = "3009".time().$_SESSION["user_id"];
	/* 插入数据库 */
    $sql = 'UPDATE ' . $ecs->table('users') . " SET `fuiou_reg_sn`='$fuiou_reg_id' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);
	
	/* 初始化参数 */
	$parameters = array(
		"mchnt_cd" 		=> $mchnt_cd,
		"mchnt_txn_ssn" => $fuiou_reg_id,
		"cust_no"  		=> $user["user_name"],
		"location"		=> "",
		"amt" 			=> "",
	);

	/* 生成签名 */
	  // 按字母顺序排序
	ksort($parameters);
	  // 拼接字符串
	$buff = "";
	foreach ($parameters as $k => $v) {
		if ($k != "certif_tp"){
			$buff .= $v . "|";
		}
	}
    $string="";
    if (strlen($buff) > 0) {
        $string = substr($buff, 0, strlen($buff) - 1);
    }
	  // 生成签名
	$signature = rsaSign($string,"./fuiou_key/".$prkey);

	  // 将签名导入提交数据
	$parameters["signature"] = $signature;

	/* 发送请求 */

	//send_post($url, $parameters);  

	$file = '<form action="'.$url.'" method="POST" id = "form0">';
	foreach ($parameters as $key => $val){
		$file .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
	}
	$file .= "<script>document.getElementById('form0').submit()</script>";
	echo $file;
	exit;	
}elseif($act == "recharge"){
	/* 检测用户是否已经实名认证绑定银行卡 */
	$sql = 'SELECT is_bank_card, is_id_card FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	//print_r($user);exit();
	$is_id_card = $user["is_id_card"];
	$is_bank_card = $user["is_bank_card"];
	if (!$is_id_card){
		show_message("您还没有进行实名认证，为保护您的账户安全，请进行实名认证并绑定银行卡后进行充值。",array("立刻进行实名认证", "前往用户中心"), array("user.php?act=identify", 'user.php'), 'info',false);
	}
	
	if (!$is_bank_card){
		show_message("您还没有帮您您的银行卡，请绑定后进行充值。",array("立刻前往绑定", "前往用户中心"), array("fuiou.php?action=link_bank_card", 'user.php'), 'info',false);
	}
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/500002.action";
	//正式环境
	$url = "https://jzh.fuiou.com/500002.action";

	/* 获取用户信息 */
	$sql = 'SELECT user_id, user_name, true_name, id_number FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	
	$fuiou_reg_id = "3001".time().$_SESSION["user_id"];
	/* 插入数据库 */
    $sql = 'UPDATE ' . $ecs->table('users') . " SET `fuiou_reg_sn`='$fuiou_reg_id' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);

	/* 初始化参数 */
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn" 	=> $fuiou_reg_id,
		"login_id"  		=> $_SESSION["user_name"],
		"amt"				=> $_POST["recharge_amount"]*100,
		"page_notify_url" 	=> 'http://www.zhengjinnet.com/fuiou_respond.php?action=recharge',
		"back_notify_url"	=> ""
	);
	//print_r($parameters);exit();
	/* 生成签名 */
	  // 按字母顺序排序
	ksort($parameters);
	  // 拼接字符串
	$buff = "";
	foreach ($parameters as $k => $v) {
		if ($k != "certif_tp"){
			$buff .= $v . "|";
		}
	}
    $string="";
    if (strlen($buff) > 0) {
        $string = substr($buff, 0, strlen($buff) - 1);
    }
	  // 生成签名
	$signature = rsaSign($string,"./fuiou_key/".$prkey);

	  // 将签名导入提交数据
	$parameters["signature"] = $signature;

	/* 发送请求 */
	//print_r($url);exit();
	$file = '<form action="'.$url.'" method="POST" id = "form0">';
	foreach ($parameters as $key => $val){
		$file .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
	}
	$file .= "<script>document.getElementById('form0').submit()</script>";
	echo $file;
	exit;
}elseif($act == "withdraw"){
	//测试环境
	//$url = "http://www-1.fuiou.com:9057/jzh/500003.action";
	//正式环境
	$url = "https://jzh.fuiou.com/500003.action";
	
	/* 获取用户信息 */
	$sql = 'SELECT user_id, user_name, true_name, id_number FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	
	$fuiou_reg_id = "3005".time().$_SESSION["user_id"];
	/* 插入数据库 */
    $sql = 'UPDATE ' . $ecs->table('users') . " SET `fuiou_reg_sn`='$fuiou_reg_id' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);

	/* 初始化参数 */
	$parameters = array(
		"mchnt_cd" 			=> $mchnt_cd,
		"mchnt_txn_ssn" 	=> $fuiou_reg_id,
		"login_id"  		=> $_SESSION["user_name"],
		"amt"				=> $_POST["withdraw_amount"]*100,
		"page_notify_url" 	=> 'http://www.zhengjinnet.com/fuiou_respond.php?action=withdraw',
		"back_notify_url"	=> ""
	);

	/* 生成签名 */
	  // 按字母顺序排序
	ksort($parameters);
	  // 拼接字符串
	$buff = "";
	foreach ($parameters as $k => $v) {
		if ($k != "certif_tp"){
			$buff .= $v . "|";
		}
	}
    $string="";
    if (strlen($buff) > 0) {
        $string = substr($buff, 0, strlen($buff) - 1);
    }
	  // 生成签名
	$signature = rsaSign($string,"./fuiou_key/".$prkey);

	  // 将签名导入提交数据
	$parameters["signature"] = $signature;

	/* 发送请求 */
	$file = '<form action="'.$url.'" method="POST" id = "form0">';
	foreach ($parameters as $key => $val){
		$file .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
	}
	$file .= "<script>document.getElementById('form0').submit()</script>";
	echo $file;
	exit;
}

?>