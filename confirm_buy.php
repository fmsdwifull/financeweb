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

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);


/* 未登录用户直接跳转到登录页面 */
if(!$_SESSION["user_id"]){
	ecs_header("Location:./user.php?act=login\n");
}


/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */
if (!isset($_POST["goods_id"])){
	ecs_header("Location:./index.php\n");
}
$goods_amount = $_POST["goods_amount"];
$goods_id = $_POST["goods_id"];
$smarty->assign('goods_amount', $goods_amount);

/* 加载产品相关信息 */
$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('goods') . " WHERE goods_id = " . $goods_id;
$goods = $GLOBALS['db']->getRow($sql);
$goods["format_goods_min_buy"] = number_format($goods["goods_min_buy"],0);
$goods["format_goods_rest_number"] = number_format($goods["goods_rest_number"],0);
$end_time = $goods["goods_start_time"] + $goods["goods_period"]*24*60*60;
$formed_end_time = date("Y 年m 月 d日",$end_time);
$goods["formed_end_time"] = $formed_end_time;
//$period = $end_time - time();
//$period_day = floor($end_time/(24*60*60))-floor(time()/(24*60*60));

$period_day = floor(time_to_day($end_time))-floor(time_to_day(time()))-$goods['t'];

$default_earn = $goods_amount*$goods["goods_interest_rate"]*$period_day/36500;
$formed_default_earn = round($default_earn*100)/100;

$smarty->assign('formed_default_earn', $formed_default_earn);
$smarty->assign('period_day', $period_day);
$smarty->assign('goods', $goods);

/* 加载用户相关信息 */
$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('users') . " WHERE user_id = " . $_SESSION["user_id"];
$user = $GLOBALS['db']->getRow($sql);
require_once(ROOT_PATH .'includes/lib_fuiou.php');
$user_money = get_user_money($_SESSION["user_id"],$user["user_name"]);

$user["user_money"] = $user_money["ca_balance"];


$smarty->assign('user', $user);



$smarty->display('confirm_buy.dwt',      $cache_id);


?>