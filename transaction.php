<?php

/**
 * ECSHOP 商品详情
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);

/* 未登录用户直接跳转到登录页面 */
if(!$_SESSION["user_id"]){
	ecs_header("Location:./user.php?act=login\n");
}
if(!$_POST["action"]){
	ecs_header("Location:./user.php?act=login\n");
}
$act = $_POST["action"];
$smarty->assign('act', $act);
if ($act == "buy"){

	if (!isset($_POST["goods_id"])){
		ecs_header("Location:./index.php\n");
	}
	$amount = $_POST["amount"];
	$goods_id = $_POST["goods_id"];

	/* 加载产品相关信息 */
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('goods') . " WHERE goods_id = " . $goods_id;
	$goods = $GLOBALS['db']->getRow($sql);
	if ($goods["goods_end_time"]<time()){
		show_message("非法入口，该产品已经截止销售。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	
	/* 加载用户相关信息 */
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('users') . " WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	require_once(ROOT_PATH .'includes/lib_fuiou.php');
	$user_money = get_user_money($_SESSION["user_id"],$user["user_name"]);
	$user["user_money"] = $user_money["ca_balance"];
	
	if ($amount>$user["user_money"]){
		show_message("用户账户余额不足以支付该订单。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}
	
	/* 支付条件满足，提交订单至富友 */
	require_once(ROOT_PATH .'includes/lib_fuiou.php');
	$macAddress = $_POST["macAddress"];
	pay_order($_SESSION["user_id"],$goods_id,$amount,$macAddress);
}elseif($act == "transfer"){
	if (!isset($_POST["order_id"])){
		ecs_header("Location:./index.php\n");
	}
	/* 加载订单信息 */
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('order_new') . " WHERE order_id = " . $_POST["order_id"];
	$order = $GLOBALS['db']->getRow($sql);
	
	/* 加载用户相关信息 */
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('users') . " WHERE user_id = " . $_SESSION["user_id"];
	$user = $GLOBALS['db']->getRow($sql);
	require_once(ROOT_PATH .'includes/lib_fuiou.php');
	$user_money = get_user_money($_SESSION["user_id"],$user["user_name"]);
	$user["user_money"] = $user_money["ca_balance"];
	
	if ($order["transfer_amount"]>$user["user_money"]){
		show_message("用户账户余额不足以支付该订单。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
	}

	/* 支付条件满足，提交订单至富友 */
	require_once(ROOT_PATH .'includes/lib_fuiou.php');
	pay_transfer($_SESSION["user_id"],$_POST["order_id"]);
}

?>