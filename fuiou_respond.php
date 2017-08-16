<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(dirname(__FILE__) . '/fuiou_key/fuiou_rsa.function.php');

/* INPUT */
$act = $_GET["action"];
if ($act == "link_bank_card"){
	if ($_POST["resp_code"]=="0000"){
		$sql = 'SELECT user_name,true_name, id_number,is_bank_card, fuiou_reg_sn FROM ' . $ecs->table("users") . "WHERE user_id = " . $_POST["user_id_from"];
		$user_info = $GLOBALS['db']->getRow($sql);	
		$user->set_session($user_info["user_name"]);
        $user->set_cookie($user_info["user_name"], 1);
		
		// 更新数据库
		$sql = 'UPDATE ' . $ecs->table('users') . " SET `fuiou_bank_nm`='".$_POST["bank_nm"]."', `fuiou_capacntno`='".$_POST["capAcntNo"]."', `fuiou_city_id`='".$_POST["city_id"]."', `fuiou_parent_bank_id`='".$_POST["parent_bank_id"]."', `is_bank_card`= 1 WHERE `user_id`='" . $_SESSION['user_id'] . "'";
		$db->query($sql);
		// 更新log
		$sql = 'INSERT INTO '. $ecs->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("绑定银行卡",'.$_SESSION["user_id"].','.$_POST["mchnt_txn_ssn"].')';
		$db->query($sql);
		show_message("恭喜您成功绑定了您的银行卡。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}else{
		if ($_POST["resp_code"] == 5343){
			show_message("非法操作：用户已开户，错误编码：5343。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
			exit;
		}else{
			show_message("系统异常，错误编码：".$_POST["resp_code"]."，错误环境：".$act."，请速与网站负责人联系。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
			exit;
		}
	}
}elseif($act == "recharge"){
	if ($_POST["resp_code"]=="0000"){
		$user->set_session($_POST["login_id"]);
        $user->set_cookie($_POST["login_id"], 1);
		$sql = 'SELECT user_name,true_name, id_number,is_bank_card, fuiou_reg_sn FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
		$user_info = $GLOBALS['db']->getRow($sql);	
		
		// 更新log
		$sql = 'INSERT INTO '. $ecs->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("账户充值",'.$_SESSION["user_id"].','.$_POST["mchnt_txn_ssn"].')';
		$db->query($sql);
		show_message("充值成功",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}else{
		show_message("系统异常，错误编码：".$_POST["resp_code"]."，错误环境：".$act."，请速与网站负责人联系。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}
}elseif($act == "withdraw"){
	if ($_POST["resp_code"]=="0000"){
		$sql = 'SELECT user_name,true_name, id_number,is_bank_card, fuiou_reg_sn FROM ' . $ecs->table("users") . "WHERE user_id = " . $_SESSION["user_id"];
		$user_info = $GLOBALS['db']->getRow($sql);	

		// 更新log
		$sql = 'INSERT INTO '. $ecs->table('fuiou_log') . ' (log_type,user_id,log_sn) VALUES ("账户充值",'.$_SESSION["user_id"].','.$_POST["mchnt_txn_ssn"].')';
		$db->query($sql);
		show_message("提现成功",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}else{
		show_message("系统异常，错误编码：".$_POST["resp_code"]."，错误环境：".$act."，请速与网站负责人联系。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
		exit;
	}
}


?>