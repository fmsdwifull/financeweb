<?php

/**
 * ECSHOP 订单管理
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: yehuaixiao $
 * $Id: order.php 17219 2011-01-27 10:49:19Z yehuaixiao $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'includes/lib_goods.php');

/*------------------------------------------------------ */
//-- 订单列表
/*------------------------------------------------------ */
/* 检查权限 */
admin_priv('team_order');
$admin_id = $_SESSION["admin_id"];
/* INPUT */
$seller_id = $_GET["seller_id"];
$smarty->assign('selected_seller_id', $seller_id);
if ($_REQUEST['act'] == 'list')
{
	/* 判断该用户是网点经理或者区域经理 */
	$sql = "SELECT store_manager, region_manager FROM " . $GLOBALS['ecs']->table('seller') .
			" WHERE admin_id =".$admin_id;
	$seller_info = $GLOBALS['db']->getRow($sql);
	
	/* 获取所属团队的列表 */
	if($admin_id=='1'){
		$manager_type = "all";
		$seller_info=1;
	}
	elseif ($seller_info["region_manager"]!=0){
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
    /* 模板赋值 */
    $smarty->assign('ur_here', "团队订单列表");

    $smarty->assign('status_list', $_LANG['cs']);   // 订单状态

    $smarty->assign('os_unconfirmed',   OS_UNCONFIRMED);
    $smarty->assign('cs_await_pay',     CS_AWAIT_PAY);
    $smarty->assign('cs_await_ship',    CS_AWAIT_SHIP);
    $smarty->assign('full_page',        1);

    $order_list = order_list($manager_type,$manager_id,$seller_id);
	//echo "<pre>";print_r($order_list);exit;
    $smarty->assign('order_list',   $order_list['orders']);
    $smarty->assign('filter',       $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count',   $order_list['page_count']);
    $smarty->assign('sort_order_time', '<img src="images/sort_desc.gif">');

    /* 显示模板 */
    assign_query_info();
    $smarty->display('team_order_list.htm');
}
elseif ($_REQUEST['act'] == 'query')
{
	/* 判断该用户是网点经理或者区域经理 */
	$sql = "SELECT store_manager, region_manager FROM " . $GLOBALS['ecs']->table('seller') .
			" WHERE admin_id =".$admin_id;
	$seller_info = $GLOBALS['db']->getRow($sql);
	/* 获取所属团队的列表 */
	if ($seller_info["region_manager"]!=0){
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
    $order_list = order_list($manager_type,$manager_id,$seller_id);
	
    $smarty->assign('order_list',   $order_list['orders']);
    $smarty->assign('filter',       $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count',   $order_list['page_count']);
    $sort_flag  = sort_flag($order_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    make_json_result($smarty->fetch('team_order_list.htm'), '', array('filter' => $order_list['filter'], 'page_count' => $order_list['page_count']));
}
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

/**
 *  获取订单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function order_list($manager_type,$manager_id,$seller_id = NULL)
{
        /* 过滤信息 */
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        if (!empty($_GET['is_ajax']) && $_GET['is_ajax'] == 1)
        {
            $_REQUEST['consignee'] = json_str_iconv($_REQUEST['consignee']);
            //$_REQUEST['address'] = json_str_iconv($_REQUEST['address']);
        }
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
        $filter['email'] = empty($_REQUEST['email']) ? '' : trim($_REQUEST['email']);
        $filter['address'] = empty($_REQUEST['address']) ? '' : trim($_REQUEST['address']);
        $filter['zipcode'] = empty($_REQUEST['zipcode']) ? '' : trim($_REQUEST['zipcode']);
        $filter['tel'] = empty($_REQUEST['tel']) ? '' : trim($_REQUEST['tel']);
        $filter['mobile'] = empty($_REQUEST['mobile']) ? 0 : intval($_REQUEST['mobile']);
        $filter['country'] = empty($_REQUEST['country']) ? 0 : intval($_REQUEST['country']);
        $filter['province'] = empty($_REQUEST['province']) ? 0 : intval($_REQUEST['province']);
        $filter['city'] = empty($_REQUEST['city']) ? 0 : intval($_REQUEST['city']);
        $filter['district'] = empty($_REQUEST['district']) ? 0 : intval($_REQUEST['district']);
        $filter['shipping_id'] = empty($_REQUEST['shipping_id']) ? 0 : intval($_REQUEST['shipping_id']);
        $filter['pay_id'] = empty($_REQUEST['pay_id']) ? 0 : intval($_REQUEST['pay_id']);
        $filter['order_status'] = isset($_REQUEST['order_status']) ? intval($_REQUEST['order_status']) : -1;
        $filter['shipping_status'] = isset($_REQUEST['shipping_status']) ? intval($_REQUEST['shipping_status']) : -1;
        $filter['pay_status'] = isset($_REQUEST['pay_status']) ? intval($_REQUEST['pay_status']) : -1;
        $filter['user_id'] = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
        $filter['user_name'] = empty($_REQUEST['user_name']) ? '' : trim($_REQUEST['user_name']);
        $filter['composite_status'] = isset($_REQUEST['composite_status']) ? intval($_REQUEST['composite_status']) : -1;
        $filter['group_buy_id'] = isset($_REQUEST['group_buy_id']) ? intval($_REQUEST['group_buy_id']) : 0;

        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'pay_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $filter['start_time'] = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ?  local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
        $filter['end_time'] = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ?  local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);

        $where = 'WHERE 1 ';
        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 15;
        }
		if ($seller_id){
			$where .= " AND s.seller_id = ".$seller_id;
		}
        /* 记录总数 */
		if($manager_type=='all'){
			$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_new') . " AS o ". 
			" LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=o.user_id ".
			" LEFT JOIN " .$GLOBALS['ecs']->table('goods'). " AS g ON g.goods_id=o.goods_id ".
			" LEFT JOIN " .$GLOBALS['ecs']->table('seller'). " AS s ON s.seller_id=u.seller_id ".$where;
		}else{
			$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_new') . " AS o ". 
			" LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=o.user_id ".
			" LEFT JOIN " .$GLOBALS['ecs']->table('goods'). " AS g ON g.goods_id=o.goods_id ".
			" LEFT JOIN " .$GLOBALS['ecs']->table('seller'). " AS s ON s.seller_id=u.seller_id ".
			$where. " AND s.".$manager_type." =". $manager_id;
		}
        


        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
		if($manager_type=='all'){
			$sql = "SELECT o.*,u.*,g.goods_name,s.* " .
                " FROM " . $GLOBALS['ecs']->table('order_new') . " AS o " .
                " LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=o.user_id ".
				" LEFT JOIN " .$GLOBALS['ecs']->table('goods'). " AS g ON g.goods_id=o.goods_id ".
				" LEFT JOIN " .$GLOBALS['ecs']->table('seller'). " AS s ON s.seller_id=u.seller_id ".
				$where .
                " ORDER BY $filter[sort_by] $filter[sort_order] ".
                " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
		}else{
			$sql = "SELECT o.*,u.*,g.goods_name,s.* " .
                " FROM " . $GLOBALS['ecs']->table('order_new') . " AS o " .
                " LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=o.user_id ".
				" LEFT JOIN " .$GLOBALS['ecs']->table('goods'). " AS g ON g.goods_id=o.goods_id ".
				" LEFT JOIN " .$GLOBALS['ecs']->table('seller'). " AS s ON s.seller_id=u.seller_id ".
				$where . " AND s.".$manager_type." =". $manager_id.
                " ORDER BY $filter[sort_by] $filter[sort_order] ".
                " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
		}
        
    $row = $GLOBALS['db']->getAll($sql);

    /* 格式话数据 */
    foreach ($row AS $key => $value)
    {
        $row[$key]['formated_order_amount'] = price_format($value['amount']);
        $row[$key]['short_order_time'] = local_date('Y-m-d H:i:s', $value['pay_time']);
    }
    $arr = array('orders' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}


/**
 * 获取站点根目录网址
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . ADMIN_PATH . '/order.php', '', PHP_SELF);

}
?>