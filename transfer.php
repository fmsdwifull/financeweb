<?php

/**
 * 政金网 转让列表
 * $Author: ligeng
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
assign_template();

if ($_GET["act"]=="cancel"){
	if (!$_GET["order_id"]){
		show_message("非法入口");
		exit;
	}
	if	(!$_SESSION["user_id"]){
		ecs_header("Location: user.php\n");
	}
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('order_new') .
            " WHERE order_id = " . $_GET["order_id"];
	$order = $GLOBALS['db']->getRow($sql);
	if ($order["user_id"] != $_SESSION["user_id"]){
		show_message("非法入口,订单不存在");
		exit;
	}
	$sql = "UPDATE " . $ecs->table('order_new') . " SET transfer_flag = 0, transfer_start_time = 0 WHERE order_id=" . $_GET["order_id"];
    $db->query($sql);
	show_message("成功撤销转让申请。",array("返回首页", "前往用户中心"), array("index.php", 'user.php'), 'info',false);
}
$sql = 'SELECT SUM(transfer_amount) FROM ' . $GLOBALS['ecs']->table('order_new') . 
            " WHERE transfer_flag AND get_paid > -1 AND pay_time > 0";
$total_amount = $GLOBALS['db']->getOne($sql);
$total_amount = number_format($total_amount,2);
$smarty->assign('total_amount', $total_amount);
$sql = 'SELECT o.*, g.* FROM ' . $GLOBALS['ecs']->table('order_new') . ' AS o' .
            ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = o.goods_id' .
            " WHERE (o.transfer_flag = 1 OR o.transfer_flag = 2) AND o.get_paid > -1 AND o.pay_time > 0
             ORDER BY o.transfer_start_time DESC";
$transfer_list = $GLOBALS['db']->getAll($sql);

foreach ($transfer_list as $key => $val){
	$waiting_time = $val["transfer_start_time"] + 24*60*60 - time();
	
	$transfer_list[$key]["goods_rest_hour"] = floor($waiting_time/3600);
	$transfer_list[$key]["goods_rest_minute"] = floor(($waiting_time-floor($waiting_time/3600)*3600)/60);
	
	/* 计算产品剩余投资期限 */
	$transfer_list[$key]["goods_rest_period"] = floor($val["goods_start_time"]/(24*60*60)) + $val["goods_period"] - floor(time()/(24*60*60));
	
	/* 计算项目价值，下一次收款时间 */
	// 计算该项目应该获得的当前收益（按天来计算）
	$pay_time = $val["pay_time"];
	if ($val["cat_id"]==1){
		$goods_return_time_0 = $val["pay_time"] + $val["goods_period"]*24*60*60;
	}else{
		$goods_return_time_0 = $val["goods_start_time"] + $val["goods_period"]*24*60*60;
	}
	$order_list[$key]["goods_return_time"] = $goods_return_time_0;
	
	$day_number = floor(time()/(24*60*60))-floor($val["pay_time"]/(24*60*60))-$val['t'];
	$total_earn_money_day_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
	if ($val["goods_earn_method"] == 1){
		//到期一次兑付
		//计算该项目得到的收益，未结清项目计算至当前日期
		$day_number = 0;
		$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
		//计算下一次收益金额
		$next_earn_money_0 = $all_earn_0;
		//计算下一次收益时间
		$next_earn_time_0 = $goods_return_time_0;
	}
	if ($val["goods_earn_method"] == 2){
		//到期一次回购
		//计算该项目得到的收益，未结清项目计算至当前日期
		$day_number = 0;
		$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
		//计算下一次收益金额
		$next_earn_money_0 = $all_earn_0;
		//计算下一次收益时间
		$next_earn_time_0 = $goods_return_time_0;
	}
	if ($val["goods_earn_method"] == 3){
		//按月收益，到期回本
		//计算该项目得到的收益，未结清项目计算至当前日期
		$day_number = floor((floor(time()/(24*60*60))-floor($val["pay_time"]/(24*60*60)))/30)*30;
		$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
		//计算下一次收益金额
		$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * 30 /36500;
		//计算下一次收益时间
		$next_earn_time_0 = $val["pay_time"];
		while ($next_earn_time_0<time()){
			$next_earn_time_0 += 30*24*60*60;
		}
		$next_earn_time_0 = min($next_earn_time_0,$goods_return_time_0);
	}
	if ($val["goods_earn_method"] == 4){
		//按季收益，到期回本
		//计算该项目得到的收益，未结清项目计算至当前日期
		$day_number = floor((floor(time()/(24*60*60))-floor($val["pay_time"]/(24*60*60)))/90)*90;
		$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
		//计算下一次收益金额
		$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * 90 /36500;
		//计算下一次收益时间
		$next_earn_time_0 = $val["pay_time"];
		while ($next_earn_time_0<time()){
			$next_earn_time_0 += 90*24*60*60;
		}
		$next_earn_time_0 = min($next_earn_time_0,$goods_return_time_0);
	}

	$transfer_list[$key]["transfer_value"] = round(($val["amount"]+$total_earn_money_day_0-$total_earn_money_0)*100)/100;
	$transfer_list[$key]["formed_next_earn_time"] = date("Y-m-d",$next_earn_time_0);
	$transfer_list[$key]["formed_transfer_amount"] = number_format($val["transfer_amount"],2);
}
$smarty->assign('transfer_list', $transfer_list);

$smarty->display('transfer.dwt');

?>
