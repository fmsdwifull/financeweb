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
$admin_id = $_SESSION["admin_id"];

/* INPUT */
$seller_id = $_GET["seller_id"];
$smarty->assign('selected_seller_id', $seller_id);

/* 判断该用户是网点经理或者区域经理 */
$sql = "SELECT store_manager, region_manager FROM " . $GLOBALS['ecs']->table('seller') .
			" WHERE admin_id =".$admin_id;
$seller_info = $GLOBALS['db']->getRow($sql);
	
/* 获取所属团队的列表 */

if($admin_id=='1'){
	$manager_type = "all";
}elseif ($seller_info["region_manager"]!=0){
	$manager_type = "region_id";
	$manager_id = $seller_info["region_manager"];
}elseif($seller_info["store_manager"]!=0){
	$manager_type = "store_id";
	$manager_id = $seller_info["store_manager"];
}else{
	sys_msg("您没有权限进行该操作，详情咨询网络管理员。", 1, array(), false);
	exit;
}
$team_members = get_team_member($manager_type,$manager_id);
$smarty->assign('team_members', $team_members);

if($manager_type=='all'){
		if ($seller_id){
				$sql = "SELECT * FROM "  . $ecs->table('reserve')." AS r 
				LEFT JOIN "  . $ecs->table('seller')." AS s ON r.seller_id = s.seller_id 
				WHERE  s.seller_id = ".$seller_id." ORDER BY reserve_id DESC";
				$reserve_info = $db->getAll($sql);	
		}else{
				$sql = "SELECT * FROM "  . $ecs->table('reserve')." AS r 
				LEFT JOIN "  . $ecs->table('seller')." AS s ON r.seller_id = s.seller_id  ORDER BY reserve_id DESC";
				$reserve_info = $db->getAll($sql);	
		}
	
}else{
		if ($seller_id){
				$sql = "SELECT * FROM "  . $ecs->table('reserve')." AS r 
				LEFT JOIN "  . $ecs->table('seller')." AS s ON r.seller_id = s.seller_id 
				WHERE s.".$manager_type."=".$manager_id." AND s.seller_id = ".$seller_id." ORDER BY reserve_id DESC";
				$reserve_info = $db->getAll($sql);	
		}else{
				$sql = "SELECT * FROM "  . $ecs->table('reserve')." AS r 
				LEFT JOIN "  . $ecs->table('seller')." AS s ON r.seller_id = s.seller_id 
				WHERE s.".$manager_type."=".$manager_id." ORDER BY reserve_id DESC";
				$reserve_info = $db->getAll($sql);	
		}
	
}




		
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
$smarty->assign('reserve_info',  $reserve_info);
$smarty->assign('ur_here', '团队预约管理');
$smarty->display('team_reserve.htm');
/**
 *  获取下属所有业务员列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function get_team_member($manager_type,$manager_id){
	if($manager_type == 'all'){
		$sql = "SELECT seller_id, seller_name FROM " . $GLOBALS['ecs']->table('seller') ;
	}else{
		$sql = "SELECT seller_id, seller_name FROM " . $GLOBALS['ecs']->table('seller') . " WHERE ".$manager_type."=".$manager_id;
	}
    return $GLOBALS['db']->getAll($sql);
}

?>