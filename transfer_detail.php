<?php

/**
 * 政金网 转让详情
 * $Author: ligeng
*/

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
if ((DEBUG_MODE & 2) != 2){
    $smarty->caching = true;
}
assign_template();

// 获取订单及产品详细信息
$sql = 'SELECT o.*,g.* FROM ' . $GLOBALS['ecs']->table('order_new') . " AS o INNER JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON o.goods_id = g.goods_id WHERE o.order_id = " . $_GET["order_id"];
$order = $GLOBALS['db']->getRow($sql);

/* 计算产品总收益 */
$goods_total_earn = $order["goods_total_number"] * $order["goods_period"] * $order["goods_interest_rate"]/36500;
$order["goods_total_earn"] = round($goods_total_earn*100)/100;

/* 计算订单返利列表 */
$order_repay_list = array();
if (($order["goods_earn_method"] == 1)||($order["goods_earn_method"] == 2)){
	$repay["serie"] = 1;
	$repay["repay_time"] = $order["goods_start_time"] + $order["goods_period"] * 24*60*60;
	$repay["formed_repay_time"] = date("Y-m-d",$repay["repay_time"]);
	$pay_day = time_to_day($repay["repay_time"]) - time_to_day($order["pay_time"])-$order['t'];
	$repay["return_money"] = $order["amount"]*$order["goods_interest_rate"]* $pay_day/36500 + $order["amount"];
	$repay["invest_money"] = $order["amount"];
	$repay["interest_money"] = $order["amount"]*$order["goods_interest_rate"]* $pay_day/36500;
	$repay["formed_return_money"] = round($repay["return_money"]*100)/100;
	$repay["formed_invest_money"] = round($repay["invest_money"]*100)/100;
	$repay["formed_interest_money"] = round($repay["interest_money"]*100)/100;
	$order_repay_list[] = $repay;
}
if ($order["goods_earn_method"] == 3){
	$serie = 0;
	$date = time_to_day($order["pay_time"]);
	$rest_day = time_to_day($order["goods_start_time"]) + $order["goods_period"] - time_to_day($order["pay_time"])-$order['t'];
	while($rest_day>30){
		$serie++;
		$repay["serie"] = $serie;
		$date = $date + 30 +$order['t'];
		$repay["repay_time"] = $date*24*60*60;
		$repay["formed_repay_time"] = date("Y-m-d",$repay["repay_time"]);		
		$repay["return_money"] = $order["amount"]*$order["goods_interest_rate"]* 30/36500;
		$repay["invest_money"] = 0;
		$repay["interest_money"] = $order["amount"]*$order["goods_interest_rate"]* 30/36500;
		$repay["formed_return_money"] = round($repay["return_money"]*100)/100;
		$repay["formed_invest_money"] = round($repay["invest_money"]*100)/100;
		$repay["formed_interest_money"] = round($repay["interest_money"]*100)/100;
		$order_repay_list[] = $repay;
		$rest_day = $rest_day - 30;
	}
	$serie++;
	$repay["serie"] = $serie;
	$repay["repay_time"] = $order["goods_start_time"] + $order["goods_period"] * 24*60*60;
	$repay["formed_repay_time"] = date("Y-m-d",$repay["repay_time"]);
	$repay["return_money"] = $order["amount"]*$order["goods_interest_rate"]* $rest_day/36500 + $order["amount"];
	$repay["invest_money"] = $order["amount"];
	$repay["interest_money"] = $order["amount"]*$order["goods_interest_rate"]* $rest_day/36500;
	$repay["formed_return_money"] = round($repay["return_money"]*100)/100;
	$repay["formed_invest_money"] = round($repay["invest_money"]*100)/100;
	$repay["formed_interest_money"] = round($repay["interest_money"]*100)/100;
	$order_repay_list[] = $repay;
}
if ($order["goods_earn_method"] == 4){
	$serie = 0;
	$date = time_to_day($order["pay_time"]);
	$rest_day = time_to_day($order["goods_start_time"]) + $order["goods_period"] - time_to_day($order["pay_time"])-$order['t'];
	while($rest_day>90){
		$serie++;
		$repay["serie"] = $serie;
		$date = $date + 90 +$order['t'];
		$repay["repay_time"] = $date*24*60*60;
		$repay["formed_repay_time"] = date("Y-m-d",$repay["repay_time"]);		
		$repay["return_money"] = $order["amount"]*$order["goods_interest_rate"]* 90/36500;
		$repay["invest_money"] = 0;
		$repay["interest_money"] = $order["amount"]*$order["goods_interest_rate"]* 90/36500;
		$repay["formed_return_money"] = round($repay["return_money"]*100)/100;
		$repay["formed_invest_money"] = round($repay["invest_money"]*100)/100;
		$repay["formed_interest_money"] = round($repay["interest_money"]*100)/100;
		$order_repay_list[] = $repay;
		$rest_day = $rest_day - 90;
	}
	$serie++;
	$repay["serie"] = $serie;
	$repay["repay_time"] = $order["goods_start_time"] + $order["goods_period"] * 24*60*60;
	$repay["formed_repay_time"] = date("Y-m-d",$repay["repay_time"]);
	$repay["return_money"] = $order["amount"]*$order["goods_interest_rate"]* $rest_day/36500 + $order["amount"];
	$repay["invest_money"] = $order["amount"];
	$repay["interest_money"] = $order["amount"]*$order["goods_interest_rate"]* $rest_day/36500;
	$repay["formed_return_money"] = round($repay["return_money"]*100)/100;
	$repay["formed_invest_money"] = round($repay["invest_money"]*100)/100;
	$repay["formed_interest_money"] = round($repay["interest_money"]*100)/100;
	$order_repay_list[] = $repay;
}

$total_return_money = 0;
$total_invest_money = 0;
$total_interest_money = 0;
foreach($order_repay_list as $val){
	$total_return_money += $val["return_money"];
	$total_invest_money += $val["invest_money"];
	$total_interest_money += $val["interest_money"];
}
$smarty->assign('formed_total_return_money',round($total_return_money*100)/100);
$smarty->assign('formed_total_invest_money',round($total_invest_money*100)/100);
$smarty->assign('formed_total_interest_money',round($total_interest_money*100)/100);
$smarty->assign('order_repay_list',$order_repay_list);

/* 计算产品剩余投资期限 */
$order["goods_rest_period"] = time_to_day($order["goods_start_time"]) + $order["goods_period"] - time_to_day(time());

/* 计算产品每季收益 */
if (($order["goods_earn_method"] == 1)||($order["goods_earn_method"] == 2)){
	if ($order["cat_id"]==1){
		$goods_return_time_0 = $order["pay_time"] + $order["goods_period"]*24*60*60;
	}else{
		$goods_return_time_0 = $order["goods_start_time"] + $order["goods_period"]*24*60*60;
	}	
	$day_number =  time_to_day($goods_return_time_0)-time_to_day($order["pay_time"]);
	$average_earn_money = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
}
if ($order["goods_earn_method"] == 3){
	$average_earn_money = $order["amount"] * $order["goods_interest_rate"] * 30 /36500;
}
if ($order["goods_earn_method"] == 4){
	$average_earn_money = $order["amount"] * $order["goods_interest_rate"] * 90 /36500;
}
$order["average_earn_money"] = $average_earn_money;
$order["formed_average_earn_money"] = number_format($average_earn_money,2);
$order["formed_transfer_end_time"] = date("Y-m-d",$order["transfer_end_time"]);
if ($order["transfer_flag"] == 1){
	$day_number = time_to_day(time())-time_to_day($order["pay_time"])-$order['t'];
	$total_earn_money_day_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	if ($order["goods_earn_method"] == 1){
		$day_number = 0;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}
	if ($order["goods_earn_method"] == 2){
		$day_number = 0;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}
	if ($order["goods_earn_method"] == 3){
		$day_number = floor((time_to_day(time())-time_to_day($order["pay_time"]))/30)*30;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}
	if ($order["goods_earn_method"] == 4){
		$day_number = floor((time_to_day(time())-time_to_day($order["pay_time"]))/90)*90;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}

	$transfer_current_value = round(($order["amount"]+$total_earn_money_day_0-$total_earn_money_0)*100)/100;
}
if ($order["transfer_flag"] == 2){
	$day_number = time_to_day($order["transfer_end_time"])-time_to_day($order["pay_time"])-$order['t'];
	$total_earn_money_day_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	if ($order["goods_earn_method"] == 1){
		$day_number = 0;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}
	if ($order["goods_earn_method"] == 2){
		$day_number = 0;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}
	if ($order["goods_earn_method"] == 3){
		$day_number = floor((time_to_day($order["transfer_end_time"])-time_to_day($order["pay_time"]))/30)*30;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}
	if ($order["goods_earn_method"] == 4){
		$day_number = floor((time_to_day($order["transfer_end_time"])-time_to_day($order["pay_time"]))/90)*90;
		$total_earn_money_0 = $order["amount"] * $order["goods_interest_rate"] * $day_number /36500;
	}

	$transfer_current_value = round(($order["amount"]+$total_earn_money_day_0-$total_earn_money_0)*100)/100;
}
$order["transfer_current_value"] = round($transfer_current_value*100)/100;
$transfer_correction = round(($order["transfer_amount"] - round($transfer_current_value*100)/100)*100)/100;
if ($transfer_correction > 0){
	$order["transfer_correction_sign"] = 1;
	$order["transfer_correction"] = "+".$transfer_correction;
}else{
	$order["transfer_correction_sign"] = -1;
	$order["transfer_correction"] = $transfer_correction;
}
$smarty->assign('order',$order);
$smarty->display('transfer_detail.dwt');

?>
