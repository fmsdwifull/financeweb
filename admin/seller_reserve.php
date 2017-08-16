<?php

/**
 * ECSHOP 客户留言
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user_msg.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
/* 权限判断 */
admin_priv('seller_reserve');

/* 获取当前登陆管理员的seller_id */
$admin_id = $_SESSION["admin_id"];
$sql = "SELECT * FROM ".$ecs->table('seller')." WHERE admin_id = ".$admin_id;
$seller_info = $db->getRow($sql);

$seller_id = $seller_info["seller_id"];
$smarty->assign('seller_id',  $seller_id);
if ($seller_id){
	if ($_POST["time"]){
		if ($_GET["act"]=="submit_time"){
			if (($_POST["year"])&&($_POST["month"])&&($_POST["day"])&&($_POST["hour"])&&($_POST["minute"])
				&&is_numeric($_POST["hour"])&&is_numeric($_POST["minute"])
				&&($_POST["hour"]<=23)&&($_POST["hour"]>=0)&&($_POST["minute"]<=59)&&($_POST["minute"]>=0)
			){
				$sql = "UPDATE " .$ecs->table('reserve'). " SET ".
						   "year   = '".$_POST["year"]."', ".
						   "month    = '".$_POST["month"]."', ".
						   "day      = '".$_POST["day"]."', ".
						   "hour      = '".$_POST["hour"]."', ".
						   "minute      = '".$_POST["minute"]."' ".
						  "WHERE reserve_id      = '".$_POST["id"]."'";
				$db->query($sql);
			}else{
				echo "<script>alert('请完整填写时间信息');</script>";
			}
		}
	}elseif($_POST["come"]==1){
			$sql = "UPDATE " .$ecs->table('reserve'). " SET ".
				"is_come = 1 WHERE reserve_id = '".$_POST["id"]."'";
				$db->query($sql);
	}elseif($_POST["cancel"]==1){
			$sql = "UPDATE " .$ecs->table('reserve'). " SET ".
				"is_cancel = 1 WHERE reserve_id = '".$_POST["id"]."'";
				$db->query($sql);
	}elseif($_GET["act"]=="submit_seller"){
		if ($_POST["seller_id"]){
			$sql = "UPDATE " .$ecs->table('reserve'). " SET ".
				"seller_id = ".$_POST["seller_id"]." WHERE reserve_id = '".$_POST["id"]."'";
				$db->query($sql);
		}
	}
	if ($seller_id == 1){
		$sql = "SELECT * FROM "  . $ecs->table('reserve')." ORDER BY reserve_id DESC";
	}else{
		$sql = "SELECT * FROM "  . $ecs->table('reserve')." WHERE seller_id = ".$seller_id." ORDER BY reserve_id DESC";
	}
		$reserve_info = $db->getAll($sql);
		
		foreach($reserve_info as $key=>$val){
			$sql = "SELECT * FROM "  . $ecs->table('store')." WHERE code = ".$val["point"];
			$store_info = $db->getRow($sql);
			$reserve_info[$key]["store_name"] = $store_info["store_name"];
			$reserve_info[$key]["store_address"] = $store_info["store_address"];
			$sql = "SELECT goods_name FROM "  . $ecs->table('goods')." WHERE goods_id = ".$val["goods_id"];
			$goods_name = $db->getOne($sql);
			$reserve_info[$key]["goods_name"] = $goods_name;
			if ($val["seller_id"]){
				$sql = "SELECT * FROM "  . $ecs->table('seller')." WHERE seller_id = ".$val["seller_id"];
				$seller_info = $db->getRow($sql);
				$reserve_info[$key]["seller_name"] = $seller_info["seller_name"];
				$reserve_info[$key]["seller_no"] = $seller_info["seller_no"];
			}
		}
		$year = array(2016,2017);
		$month = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$day = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
		$smarty->assign('reserve_info',  $reserve_info);
		$smarty->assign('year',  $year);
		$smarty->assign('month',  $month);
		$smarty->assign('day',  $day);
		
		$sql = "SELECT * FROM "  . $ecs->table('seller');
		$seller_list = $db->getAll($sql);
		$smarty->assign('seller_list',  $seller_list);
}
    $smarty->display('seller_reserve.htm');


?>