<?php

/**
 * ECSHOP 会员管理程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: users.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*------------------------------------------------------ */
//-- 用户帐号列表
/*------------------------------------------------------ */
/* 检查权限 */
admin_priv('seller_user');
/* 获取当前登陆管理员的seller_id */
$admin_id = $_SESSION["admin_id"];
$sql = "SELECT * FROM ".$ecs->table('seller')." WHERE admin_id = ".$admin_id;
$seller_info = $db->getRow($sql);
if ($_REQUEST['act'] == 'list')
{
	$sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
	$rs = $db->query($sql);

	$ranks = array();
	while ($row = $db->FetchRow($rs))
	{
		$ranks[$row['rank_id']] = $row['rank_name'];
	}

	$smarty->assign('user_ranks',   $ranks);
	$smarty->assign('ur_here',      $_LANG['03_users_list']);
	if ($seller_info){
		$user_list = user_list($seller_info);
		
		require_once(ROOT_PATH .'includes/lib_fuiou.php');
		require_once(ROOT_PATH .'includes/lib_clips.php');
		foreach ($user_list["user_list"] as $key => $user){
			/* 获取用户账户余额 */
			$user_id = $user["user_id"];
			$user_name = $user["user_name"];
			$user_money = get_user_money($user_id,$user_name);
			$user_list["user_list"][$key]["user_money"] = price_format($user_money["format_ca_balance"],false);

			/* 获取用户总投资金额 */
			$buy_info = get_user_order_total($user_id,$user_money["ca_balance"]);
			$user_list["user_list"][$key]["total_money"] = price_format($buy_info["total_money"],false);
			$user_list["user_list"][$key]["total_inverst_money"] = price_format($buy_info["total_inverst_money"],false);
			$user_list["user_list"][$key]["total_earn_money"] = price_format($buy_info["total_earn_money"],false);
			$user_list["user_list"][$key]["rest_earn_money"] = price_format($buy_info["rest_earn_money"],false);
		}
	}else{
		sys_msg("您的账号还没有匹配到任何的业务员信息。", 1, array(), false);
	}
	$smarty->assign('user_list',    $user_list['user_list']);
	$smarty->assign('filter',       $user_list['filter']);
	$smarty->assign('record_count', $user_list['record_count']);
	$smarty->assign('page_count',   $user_list['page_count']);
	$smarty->assign('full_page',    1);
	$smarty->assign('sort_user_id', '<img src="images/sort_desc.gif">');

	assign_query_info();
	$smarty->display('seller_user.htm');
}
elseif ($_REQUEST['act'] == 'query')
{
    $user_list = user_list($seller_info);
	require_once(ROOT_PATH .'includes/lib_fuiou.php');
	require_once(ROOT_PATH .'includes/lib_clips.php');
	foreach ($user_list["user_list"] as $key => $user){
		/* 获取用户账户余额 */
		$user_id = $user["user_id"];
		$user_name = $user["user_name"];
		$user_money = get_user_money($user_id,$user_name);
		$user_list["user_list"][$key]["user_money"] = price_format($user_money["format_ca_balance"],false);

		/* 获取用户总投资金额 */
		$buy_info = get_user_order_total($user_id,$user_money["ca_balance"]);
		$user_list["user_list"][$key]["total_money"] = price_format($buy_info["total_money"],false);
		$user_list["user_list"][$key]["total_inverst_money"] = price_format($buy_info["total_inverst_money"],false);
		$user_list["user_list"][$key]["total_earn_money"] = price_format($buy_info["total_earn_money"],false);
		$user_list["user_list"][$key]["rest_earn_money"] = price_format($buy_info["rest_earn_money"],false);
	}
    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('filter',       $user_list['filter']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('page_count',   $user_list['page_count']);

    $sort_flag  = sort_flag($user_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('seller_user.htm'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
}

function time_to_day($time){
	return (floor(($time+28800)/(24*60*60)));
}
/**
 *  返回用户列表数据
 *
 * @access  public
 * @param
 *
 * @return void
 */
function user_list($seller_info)
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤条件 */
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
        $filter['rank'] = empty($_REQUEST['rank']) ? 0 : intval($_REQUEST['rank']);
        $filter['pay_points_gt'] = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
        $filter['pay_points_lt'] = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);

        $filter['sort_by']    = empty($_REQUEST['sort_by'])    ? 'user_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC'     : trim($_REQUEST['sort_order']);

        $ex_where = ' WHERE 1 ';
        if ($filter['keywords'])
        {
            $ex_where .= " AND user_name LIKE '%" . mysql_like_quote($filter['keywords']) ."%'";
        }
        if ($filter['rank'])
        {
            $sql = "SELECT min_points, max_points, special_rank FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '$filter[rank]'";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row['special_rank'] > 0)
            {
                /* 特殊等级 */
                $ex_where .= " AND user_rank = '$filter[rank]' ";
            }
            else
            {
                $ex_where .= " AND rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
            }
        }
        if ($filter['pay_points_gt'])
        {
             $ex_where .=" AND pay_points >= '$filter[pay_points_gt]' ";
        }
        if ($filter['pay_points_lt'])
        {
            $ex_where .=" AND pay_points < '$filter[pay_points_lt]' ";
        }
		// 仅获取该业务员的会员列表
		$ex_where .=" AND seller_id = ".$seller_info["seller_id"];
		
        $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('users') . $ex_where);

        /* 分页大小 */
        $filter = page_and_size($filter);
        $sql = "SELECT user_id, user_name, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time ".
                " FROM " . $GLOBALS['ecs']->table('users') . $ex_where .
                " ORDER by " . $filter['sort_by'] . ' ' . $filter['sort_order'] .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];

        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $user_list = $GLOBALS['db']->getAll($sql);

    $count = count($user_list);
    for ($i=0; $i<$count; $i++)
    {
        $user_list[$i]['reg_time'] = local_date($GLOBALS['_CFG']['date_format'], $user_list[$i]['reg_time']);
    }

    $arr = array('user_list' => $user_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

?>