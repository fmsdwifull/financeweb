<?php

/**
 * ECSHOP 用户相关函数库
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_clips.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

//向系统购买的订单 最后系统结清的 
function  orderA_detail($order_id){
	$order_detail=array();
	$sql = 'SELECT o.*,g.cat_id,g.goods_transfer_flag, g.goods_name, g.goods_start_time, g.goods_period, g.goods_interest_rate, g.goods_earn_method, g.t  FROM ' . $GLOBALS['ecs']->table('order_new') . " AS o INNER JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON o.goods_id = g.goods_id WHERE o.user_id = " . $_SESSION["user_id"].' and order_id='.$order_id;
	$val = $GLOBALS['db']->getRow($sql);
	if ($val["pay_time"]>0){
			/* 计算此订单是否已经结清 */
			$pay_time = $val["pay_time"];
			if ($val["cat_id"]==1){
				$goods_return_time_0 = $val["pay_time"] + $val["goods_period"]*24*60*60;
			}else{
				$goods_return_time_0 = $val["goods_start_time"] + $val["goods_period"]*24*60*60;
			}
			
			$order_detail["goods_return_time"] = $goods_return_time_0;
			$order_detail["formed_goods_return_time"] = date("Y.m.d",$goods_return_time_0);
			$order_detail["formed_pay_time"] = date("Y.m.d",$val["pay_time"]);
			
			// 计算项目总收益
			$day_number = time_to_day($goods_return_time_0)-time_to_day($val["pay_time"])-$val['t'];
			
			$all_earn_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
			/* 判断项目是否已经结清 */
			if ($goods_return_time_0 > time()){
				//还未结清
				if (($val["transfer_flag"]==0)||($val["transfer_flag"]==1)){
					$order_detail["order_status"] = 1;
				}else{
					$order_detail["order_status"] = 4;
				}
				$order_detail["is_return"] = 0;
				// 计算正在投资的金额，即还未结清的项目总额
				$order_detail['total_inverst_money'] = $val["amount"];
				// 计算该项目应该获得的当前收益（按天来计算）
				
				if(time_to_day(time())-time_to_day($val["pay_time"])-$val['t']>=0){
					$day_number = time_to_day(time())-time_to_day($val["pay_time"])-$val['t'];
				}else{
					$day_number=0;
				}
					
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
					
					if(time_to_day(time())-time_to_day($val["pay_time"])-$val['t']>=0){
						$day_number = floor((time_to_day(time())-time_to_day($val["pay_time"])-$val['t'])/30)*30;
					}else{
						$day_number=0;
					}
					
					$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
					//计算下一次收益时间
					$next_earn_time_0 = $val["pay_time"];
					
					while (($next_earn_time_0+$val['t']*24*3600<time())  || (($val['pay_time']+$val['t']*24*3600>=time())) && ($next_earn_time_0 == $val["pay_time"]) ){
						$next_earn_time_0 += 30*24*60*60;
					}
					$last_earn_time_0 = $next_earn_time_0 - 30*24*60*60;
					//计算下一次收益金额
					if ($next_earn_time_0>$goods_return_time_0){
						$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * (30 - time_to_day($next_earn_time_0)+ time_to_day($goods_return_time_0)-$val['t'])/36500;
					}else{
						$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * 30 /36500;
					}
					
					$next_earn_time_0 = min($next_earn_time_0+$val['t']*24*3600,$goods_return_time_0);

				}
				if ($val["goods_earn_method"] == 4){
					//按季收益，到期回本
					//计算该项目得到的收益，未结清项目计算至当前日期
					
					if(time_to_day(time())-time_to_day($val["pay_time"])-$val['t']>=0){
						$day_number = floor((time_to_day(time())-time_to_day($val["pay_time"])-$val['t'])/90)*90;
					}else{
						$day_number=0;
					}
					
					$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;


					//计算下一次收益时间
					$next_earn_time_0 = $val["pay_time"];

					while (($next_earn_time_0+$val['t']*24*3600<time())  || (($val['pay_time']+$val['t']*24*3600>=time())) && ($next_earn_time_0 == $val["pay_time"]) ){
						$next_earn_time_0 += 90*24*60*60;
					}
					$last_earn_time_0 = $next_earn_time_0 - 90*24*60*60;

					//计算下一次收益金额
					if ($next_earn_time_0>$goods_return_time_0){
						$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * (90 - time_to_day($next_earn_time_0)+ time_to_day($goods_return_time_0)-$val['t'])/36500;
					}else{
						$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * 90 /36500;
					}
					
					$next_earn_time_0 = min($next_earn_time_0+$val['t']*24*3600,$goods_return_time_0);
				}
				
				
				
				$order_detail["total_earn_money"] = round($total_earn_money_0*100)/100;
				// 计算该项目待收收益，即该项目总收益减去已经收去的收益
				$rest_earn_money_0 = $all_earn_0 - $total_earn_money_0;
				$order_detail['rest_earn_money_0'] = $rest_earn_money_0;
				$order_detail["rest_earn_money"] = round($rest_earn_money_0*100)/100;
				// 计算该项目的持有收益，即该项目的当前收益（天）减去已经收去的收益
				$taking_earn_money_0 = $total_earn_money_day_0 - $total_earn_money_0;
				$order_detail['taking_earn_money_0']= $taking_earn_money_0;

				$order_detail["next_earn_money"] = round($next_earn_money_0*100)/100;

					if ((time_to_day($next_earn_time_0)-time_to_day(time())>5)
						&&(time_to_day(time())-time_to_day($val["pay_time"])>5)
						&&(time_to_day(time())<>time_to_day($last_earn_time_0))){
						$order_detail["can_transfer"]=1;
					}else{
						$order_detail["can_transfer"]=0;
					}

				$order_detail["formed_next_earn_time"] = date("Y.m.d",$next_earn_time_0);
				$order_detail["taking_earn_money"] = round($taking_earn_money_0*100)/100;
				$order_detail["taking_earn_money_and_amount"] = round($taking_earn_money_0*100)/100 + $val["amount"];
			}else{
				
				$order_detail["order_status"] = 2;
				//已结清
				$order_detail["is_return"] = 1;
				// 计算已收总收益，即该项目总收益
				$total_earn_money_0 =$all_earn_0;
				$order_detail["total_earn"] = round($all_earn_0*100)/100;
				$order_detail["total_get"] = round(($all_earn_0 + $val["amount"])*100)/100;
				$order_detail['total_earn_money_0'] = $total_earn_money_0;
				$order_detail["total_earn_money"] = round($total_earn_money_0*100)/100;
			}
		}else{
			$order_detail["order_status"]=3;
		}
	return $order_detail;
	
}
//向系统购买的订单 转让给他人的
function  orderB_detail($order_id){
	$order_detail=array();
	$sql = 'SELECT o.*,g.cat_id,g.goods_transfer_flag, g.goods_name, g.goods_start_time, g.goods_period, g.goods_interest_rate, g.goods_earn_method, g.t  FROM ' . $GLOBALS['ecs']->table('order_new') . " AS o INNER JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON o.goods_id = g.goods_id WHERE o.user_id = " . $_SESSION["user_id"].' and order_id='.$order_id;
	$val = $GLOBALS['db']->getRow($sql);
	
	//第一次购买 转让的人 卖着 只拥有转出时间的字段 : transfer_end_time
				$order_detail["taking_day"] = time_to_day($val["transfer_end_time"])-time_to_day($val["pay_time"]);//持有时间 ok 卖掉的时间-支付时间
				$order_detail["formed_transfer_end_time"] = date("Y-m-d",$val["transfer_end_time"]);//格式化
			
				$pay_time = $val["pay_time"];//投资时间
				$goods_return_time_0 = $val["goods_start_time"] + $val["goods_period"]*24*60*60;//到期时间
				$order_detail["goods_return_time"] = $goods_return_time_0;
				$order_detail["formed_goods_return_time"] = date("Y.m.d",$goods_return_time_0);
				$order_detail["formed_pay_time"] = date("Y.m.d",$val["pay_time"]);

				$order_detail["order_status"] = 4;//说明是已转让的订单
				
				$order_detail["is_return"] = 0;
				// 计算正在投资的金额，即还未结清的项目总额
				//$total_inverst_money += $val["amount"]; 转手了 不可能有投资金额的
				
				/* 
					卖出时间字段是 transfer_end_time  支付时间字段 pay_time
					等于1和2的时候 不可能拿到赚的钱 所以 赚的钱就是卖出价- 自己当时的买入价 (transfer_amount-amount);
					等于3的时候   【floor((卖出时间-支付时间)/30)*利率】 =赚的钱
					等于4的时候	【floor((卖出时间-支付时间)/90)*利率】 =赚的钱
				*/
			
				if ($val["goods_earn_method"] == 1){
					//到期一次兑付
					//计算该项目得到的收益，未结清项目计算至当前日期
					$total_earn_money_0 = 0;
					$order_detail['total_earn_money_0'] += $total_earn_money_0;//一次结清的订单类型 不可能有有收益
				}
				if ($val["goods_earn_method"] == 2){
					//到期一次回购
					//计算该项目得到的收益，未结清项目计算至当前日期
					$total_earn_money_0 = 0;
					$order_detail['total_earn_money_0'] += $total_earn_money_0;	//一次结清的订单类型 不可能有有收益
				}
				if ($val["goods_earn_method"] == 3){
					//按月收益，到期回本
					//计算该项目得到的收益，未结清项目计算至当前日期
					$day_number = floor((time_to_day($val["transfer_end_time"])-time_to_day($val["pay_time"])-$val['t'])/30)*30;	
					$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
					$order_detail['total_earn_money_0'] += $total_earn_money_0;
				}
				if ($val["goods_earn_method"] == 4){
					//按季收益，到期回本
					//计算该项目得到的收益，未结清项目计算至当前日期
					$day_number = floor((time_to_day($val["transfer_end_time"])-time_to_day($val["pay_time"])-$val['t'])/90)*90;
					$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
					$order_detail['total_earn_money_0'] += $total_earn_money_0;
				}
				$order_earn_money=$val["transfer_amount"] - $val["amount"]+$total_earn_money_0;//该订单的收益
				//$transfer_win_0 = $val["transfer_amount"] - $val["amount"];		
				//$order_detail['total_earn_money'] += $transfer_win_0;//未完待续 不知道什么鬼
				$order_detail["total_earn_money"] = round($order_earn_money*100)/100;//该订单赚的钱
				return $order_detail;
}


//购买他人的 又转让给别人的订单
function  orderC_detail($order_id){
	$order_detail=array();
	$sql = 'SELECT o.*,g.cat_id,g.goods_transfer_flag, g.goods_name, g.goods_start_time, g.goods_period, g.goods_interest_rate, g.goods_earn_method, g.t  FROM ' . $GLOBALS['ecs']->table('order_new') . " AS o INNER JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON o.goods_id = g.goods_id WHERE o.user_id = " . $_SESSION["user_id"].' and order_id='.$order_id;
	$val = $GLOBALS['db']->getRow($sql);
	
	//多次转手的人 卖者
				$sql='select transfer_time from'.$GLOBALS['ecs']->table('order_new').' where parent_id='.$val['order_id'];
				$transfer_time=$GLOBALS['db']->getOne($sql);
			
				$order_detail["taking_day"] = time_to_day($val["transfer_end_time"])-time_to_day($val["transfer_time"]);//持有时间=卖掉的时间-那次买入的时间 ok
				$order_detail["formed_transfer_end_time"] = date("Y-m-d",$val["transfer_end_time"]);//格式化转让时间  ok
			
				$pay_time = $val["pay_time"];//投资时间
				$goods_return_time_0 = $val["goods_start_time"] + $val["goods_period"]*24*60*60;// 商品最后的结算时间 到期时间 ok
				$order_detail["goods_return_time"] = $goods_return_time_0;
				$order_detail["formed_goods_return_time"] = date("Y.m.d",$goods_return_time_0); //格式化到期时间 ok
				$order_detail["formed_pay_time"] = date("Y.m.d",$val["pay_time"]); // 格式化投资时间  ok

				$order_detail["order_status"] = 4;//说明是已转让的订单
				
				$order_detail["is_return"] = 0;
				// 计算正在投资的金额，即还未结清的项目总额
				//$total_inverst_money += $val["amount"];
			
				//转让了又转出的人 
				/* 
					等于1和2的时候 不可能拿到赚的钱 所以 赚的钱就是卖出价-买入价 (transfer_amount-buy_transfer_amount);
					等于3的时候   【 (卖出时间-支付时间)/30*利率=这段时间可以赚的钱  】 减  【 (买入时间-支付时间)/30*利率=那个人当时赚的钱】   等于  【转手进来赚的钱】
					等于4的时候	【 (卖出时间-支付时间)/90*利率=这段时间可以赚的钱  】 减  【 (买入时间-支付时间)/90*利率=那个人当时赚的钱】   等于  【转手进来赚的钱】
				*/
				if ($val["goods_earn_method"] == 1){
					//到期一次兑付
					//计算该项目得到的收益，未结清项目计算至当前日期
					$total_earn_money_0 = 0; 
					$order_detail['total_earn_money_0'] = $total_earn_money_0;//总收益肯定为0
				}
				if ($val["goods_earn_method"] == 2){
					//到期一次回购
					//计算该项目得到的收益，未结清项目计算至当前日期
					$total_earn_money_0 = 0;
					$order_detail['total_earn_money_0'] = $total_earn_money_0;//总收益肯定为0
				}
				if ($val["goods_earn_method"] == 3){
					//按月收益，到期回本
					//计算该项目得到的收益，未结清项目计算至当前日期
						
					$old_get_paid=floor(time_to_day($val['transfer_end_time']-$val['pay_time']+$goods['t'])/30);
					$new_get_paid=floor(time_to_day($val['transfer_time']-$val['pay_time']+$goods['t'])/30);
					$day_number=($old_get_paid-$new_get_paid)*30;
					$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500; //转手进来赚的钱 ok
					$order_detail['total_earn_money_0'] = $total_earn_money_0;
					
				}
				if ($val["goods_earn_method"] == 4){
					//按季收益，到期回本
					//计算该项目得到的收益，未结清项目计算至当前日期
					$old_get_paid=floor(time_to_day($val['transfer_end_time']-$val['pay_time']+$goods['t'])/90);
					$new_get_paid=floor(time_to_day($val['transfer_time']-$val['pay_time']+$goods['t'])/90);
					$day_number=($old_get_paid-$new_get_paid)*90;
					$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500; //转手进来赚的钱 ok
					$order_detail['total_earn_money_0'] = $total_earn_money_0;
				}
				$order_earn_money=$val["transfer_amount"] - $val["buy_transfer_amount"]+$total_earn_money_0;//这比订单的总收益 ok
				//$transfer_win_0 = $val["transfer_amount"] - $val["buy_transfer_amount"];
				$order_detail["total_earn_money"] = round($order_earn_money*100)/100;//该订单赚的钱
				return $order_detail;
	
}
//购买他人的订单 最后系统结清的
function  orderD_detail($order_id){
	
	$order_detail=array();
	$sql = 'SELECT o.*,g.cat_id,g.goods_transfer_flag, g.goods_name, g.goods_start_time, g.goods_period, g.goods_interest_rate, g.goods_earn_method, g.t  FROM ' . $GLOBALS['ecs']->table('order_new') . " AS o INNER JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON o.goods_id = g.goods_id WHERE o.user_id = " . $_SESSION["user_id"].' and order_id='.$order_id;
	$val = $GLOBALS['db']->getRow($sql);
	
	if ($val["pay_time"]>0){
		/* 计算此订单是否已经结清 */
		$pay_time = $val["pay_time"];
		if ($val["cat_id"]==1){
			$goods_return_time_0 = $val["pay_time"] + $val["goods_period"]*24*60*60;
		}else{
			$goods_return_time_0 = $val["goods_start_time"] + $val["goods_period"]*24*60*60;
		}
		
		$order_detail["goods_return_time"] = $goods_return_time_0;//到期时间 已经没有新手包了 所以就是$val["goods_start_time"] + $val["goods_period"]*24*60*60;
		$order_detail["formed_goods_return_time"] = date("Y.m.d",$goods_return_time_0);//格式化
		$order_detail["formed_pay_time"] = date("Y.m.d",$val["pay_time"]);//格式化
		// 计算项目总收益
		$day_number = time_to_day($goods_return_time_0)-time_to_day($val["pay_time"])-$val['t'];//该项目从支付时间到到期时间 一共 可以获得的天数 因为是t+3 所以收益稍了3天
		
		$all_earn_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;//该项目一共可以获得的收益
		/* 判断项目是否已经结清 */
		if ($goods_return_time_0 > time()){

			$order_detail["order_status"] = 1;//因为有parent_id 所以它就是转让订单 并且未结清的
			$order_detail["is_return"] = 0;
			$order_detail['total_inverst_money']  += $val["amount"];//投资金额
			// 计算该项目应该获得的当前收益（按天来计算）
			
			if(time_to_day(time())-time_to_day($val["pay_time"])-$val['t']>=0){
				$day_number = time_to_day(time())-time_to_day($val["pay_time"])-$val['t'];
			}else{
				$day_number=0;
			}//因为是t+3 所以前3天是没有收益的 所以 $day_number=0 大于的话就正常计算
			
			$total_earn_money_day_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;//感觉像是新手包的东西
			if ($val["goods_earn_method"] == 1){
				//到期一次兑付
				//计算该项目得到的收益，未结清项目计算至当前日期
				$day_number = 0;
				$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;//肯定为0 改订单的已收益
				$order_detail['total_earn_money_0'] = $total_earn_money_0;
				//计算下一次收益金额
				$next_earn_money_0 = $all_earn_0;//ok  到期时间-支付时间 *利率  675行已经计算过了
				//计算下一次收益时间
				$next_earn_time_0 = $goods_return_time_0;//ok 到期时间
			}
			if ($val["goods_earn_method"] == 2){
				//到期一次回购
				//计算该项目得到的收益，未结清项目计算至当前日期
				$day_number = 0;
				$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;//肯定为0 改订单的已收益
				$order_detail['total_earn_money_0'] = $total_earn_money_0;
				//计算下一次收益金额
				$next_earn_money_0 = $all_earn_0;//ok  到期时间-支付时间 *利率  675行已经计算过了
				//计算下一次收益时间
				$next_earn_time_0 = $goods_return_time_0;//ok 到期时间
			}
			if ($val["goods_earn_method"] == 3){
				//按月收益，到期回本
				//计算该项目得到的收益，未结清项目计算至当前日期
				$day_number1 = floor((time_to_day(time())-time_to_day($val["pay_time"])-$val['t'])/30)*30;
				$day_number2 = floor((time_to_day($val["transfer_time"])-time_to_day($val["pay_time"])-$val['t'])/30)*30; 
				$day_number = $day_number1 - $day_number2;//已获得收益的天数=【floor((当前时间-支付时间-3)/30)】-【floor((买入时间-支付时间)/30)】  原理 当前的总收益-以前买的人的收益
				$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;//已获得收益的天数
				//$order_earn_money_0=$val["amount"] * $val["goods_interest_rate"] * $day_number /36500+$val['amount']-$val['buy_transfer_amount'];//目前赚的钱
				$orignial_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number2 /36500;//前面人赚的钱
				$order_detail['total_earn_money_0'] = $total_earn_money_0;//总的已收益

				//计算下一次收益时间
				$next_earn_time_0 = $val["pay_time"];
				while (($next_earn_time_0+$val['t']*24*3600<time())  || (($val['pay_time']+$val['t']*24*3600>=time())) && ($next_earn_time_0 == $val["pay_time"]) ){
					$next_earn_time_0 += 30*24*60*60;
				}
				$last_earn_time_0 = $next_earn_time_0-30*24*60*60;
				//计算下一次收益金额
				if ($next_earn_time_0>$goods_return_time_0){
					$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * (30 - time_to_day($next_earn_time_0)+ time_to_day($goods_return_time_0)-$val['t'])/36500;
				}else{
					$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * 30 /36500;
				}//如果下次收益时间大于到期时间 那么他的收益是 利率*（下次收益-30+到期时间 未完待续 
				
				$next_earn_time_0 = min($next_earn_time_0+$val['t']*3600*24,$goods_return_time_0);

			}
			if ($val["goods_earn_method"] == 4){
				//按季收益，到期回本
				//计算该项目得到的收益，未结清项目计算至当前日期
				$day_number1 = floor((time_to_day(time())-time_to_day($val["pay_time"]))/90)*90;
				$day_number2 = floor((time_to_day($val["transfer_time"])-time_to_day($val["pay_time"])-$val['t'])/90)*90;
				$day_number = $day_number1 - $day_number2;
				
				$total_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;
				$orignial_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number2 /36500;//前面人赚的钱
				//$order_earn_money_0=$val["amount"] * $val["goods_interest_rate"] * $day_number /36500+$val['amount']-$val['buy_transfer_amount'];
				$order_detail['total_earn_money_0'] = $total_earn_money_0;//总的已收益

				//计算下一次收益时间
				$next_earn_time_0 = $val["pay_time"];
				while (($next_earn_time_0+$val['t']*24*3600<time())  || (($val['pay_time']+$val['t']*24*3600>=time())) && ($next_earn_time_0 == $val["pay_time"]) ){
					$next_earn_time_0 += 90*24*60*60;
				}
				$last_earn_time_0 = $next_earn_time_0-90*24*60*60;
				//计算下一次收益金额
				if ($next_earn_time_0>$goods_return_time_0){
					$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * (90 - time_to_day($next_earn_time_0)+ time_to_day($goods_return_time_0)-$val['t'])/36500;
				}else{
					$next_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * 90 /36500;
				}
				
				$next_earn_time_0 = min($next_earn_time_0+$val['t']*3600*24,$goods_return_time_0);
			}
			
			// 计算该项目待收收益，即该项目总收益减去已经收去的收益
			//$rest_earn_money_0 = $all_earn_0 - $total_earn_money_0 - $orignial_earn_money_0;
			$rest_earn_money_0 = $all_earn_0 - $day_number1*$val["amount"] * $val["goods_interest_rate"]/36500  ;
			$rest_earn_money += $rest_earn_money_0;
			$order_detail["rest_earn_money"] = round($rest_earn_money_0*100)/100;
			$total_earn_money_0+=$val['amount']-$val['buy_transfer_amount']; 
			$order_detail["total_earn_money"] = round($total_earn_money_0*100)/100;
			// 计算该项目的持有收益，即该项目的当前收益（天）减去已经收去的收益
			//$taking_earn_money_0 = $total_earn_money_day_0 - $total_earn_money_0 - $orignial_earn_money_0;
			$taking_earn_money_0 = $total_earn_money_day_0 - $orignial_earn_money_0;
			$order_detail['taking_earn_money_0'] = $taking_earn_money_0;

			$order_detail["next_earn_money"] = round($next_earn_money_0*100)/100;

				if ((time_to_day($next_earn_time_0)-time_to_day(time())>5)
					&&(time_to_day(time())-time_to_day($val["transfer_time"])>5)
					&&(time_to_day(time())<>time_to_day($last_earn_time_0))){
					$order_detail["can_transfer"]=1;
				}else{
					$order_detail["can_transfer"]=0;
				}

			$order_detail["formed_next_earn_time"] = date("Y.m.d",$next_earn_time_0);
			$order_detail["taking_earn_money"] = round($taking_earn_money_0*100)/100;
			$order_detail["taking_earn_money_and_amount"] = round($taking_earn_money_0*100)/100 + $val["amount"];
		}else{

				//转入买的人结清了 
				
				/* 
					卖入时间字段是 transfer_time   支付时间字段 pay_time   买入价 buy_transfer_amount 
					等于1和2的时候 不可能拿到赚的钱 所以 赚的钱就是买入价- 本金 (buy_transfer_amount-amount);
					等于3的时候   【floor((到期时间-支付时间)/30)*利率】-【floor((买入时间-支付时间)/30)*利率】 =赚的钱
					等于4的时候	【floor((到期时间-支付时间)/90)*利率】-【floor((买入时间-支付时间)/90)*利率】 =赚的钱
				*/
				if ($val["goods_earn_method"] == 1){
					$day_number = 0;
				}
				if ($val["goods_earn_method"] == 2){
						$day_number = 0;
				}
				if ($val["goods_earn_method"] == 3){
					//按月收益，到期回本

					$old_get_paid=floor((time_to_day($val['transfer_time'])-time_to_day($val["pay_time"]+$val['t']*3600*24))/30);	//上一个人收益的次数
					$day_number = time_to_day($goods_return_time_0)-time_to_day($val['pay_time'])-$val['t']-$old_get_paid*30;//转入以后  现在是否可以获取收益

				}
				if ($val["goods_earn_method"] == 4){
					//按季收益，到期回本
					$old_get_paid=floor((time_to_day($val['transfer_time'])-time_to_day($val["pay_time"]+$val['t']*3600*24))/90);	//上一个人收益的次数
					$day_number = time_to_day($goods_return_time_0)-time_to_day($val['pay_time'])-$val['t']-$old_get_paid*90;//转入以后  现在是否可以获取收益
				}
				$order_earn_money_0 = $val["amount"] * $val["goods_interest_rate"] * $day_number /36500;//该订单赚的利息

				$all_earn_0=$val["amount"]-$val["buy_transfer_amount"]+$order_earn_money_0;//该订单总共赚了的钱
				$order_detail["order_status"] = 2;
			//已结清
				$order_detail["is_return"] = 1;
			// 计算已收总收益，即该项目总收益
			$total_earn_money_0 =$all_earn_0;
			$order_detail["total_earn"] = round($all_earn_0*100)/100;
			$order_detail["total_get"] = round(($order_earn_money_0 + $val["amount"])*100)/100;
			$order_detail['total_earn_money_0'] = $total_earn_money_0;
			$order_detail["total_earn_money"] = round($total_earn_money_0*100)/100;
		}
	}else{
		$order_detail["order_status"]=3;
	}
	return $order_detail;
}


 function order_detail($order_id){

	$sql = 'SELECT parent_id,transfer_flag  FROM ' . $GLOBALS['ecs']->table('order_new') .' where order_id='.$order_id;
	$val = $GLOBALS['db']->getRow($sql);

		if(empty($val['parent_id']) && $val['transfer_flag']!=2){
			//var_dump(1);
			return orderA_detail($order_id);//ok
			
		}elseif(empty($val['parent_id']) && $val['transfer_flag']==2){
			//var_dump(2);
			return orderB_detail($order_id);//ok
			
		}elseif($val['parent_id'] && $val['transfer_flag']==2){
			//var_dump(3);
			return orderC_detail($order_id);//ok
			
		}elseif($val['parent_id'] && $val['transfer_flag']!=2){
			//var_dump(4);
			return orderD_detail($order_id);//ok
		}
}  





/* 身份证实名验证对接 by LIGENG */
	function idcard_verify($realname,$idcard){
		
		global $mall_id,$appkey,$url;
		
		$realname=$realname;
		$idcard=strtolower($idcard);
		$tm=time().'000';
		$md5_param=$mall_id.$realname.$idcard.$tm.$appkey;
		$sign=md5($md5_param);

		$param=http_build_query(array('mall_id'=>$mall_id,'realname'=>$realname,'idcard'=>$idcard,'tm'=>$tm,'sign'=>$sign));
		$url.=$param;
		//echo $url;
		$result=json_decode(file_get_contents($url));
		//var_dump($result);
		
		$status=intval($result->status);
		$code=intval($result->data->code);
		$message=$result->data->message;
		
		
		/*客户可以根据自己的业务需求进行处理*/
		if($status==2001){
			//2001=正常服务
			
			if($code==1000){
				/* 信息入库 */
				$idcard = strtoupper($idcard);
				$sql = 'UPDATE ' .$GLOBALS['ecs']->table('users'). ' SET '.
					   "true_name     = '$realname', ".
					   "id_number  = '$idcard', ".
					   "is_id_card    = 1 ".
					   "WHERE user_id   = ".$_SESSION["user_id"];
				$GLOBALS['db']->query($sql);				
				show_message("成功完成身份证实名认证",array("返回首页","前往个人中心"),array("index.php","user.php"));//一致
				
			}else if($code==1001){
				show_message("身份证信息不符，请确认后重新输入");
					
			}else if($code==1002){
				show_message("身份证信息不存在");
					
			}

			
			else if($code==1101){
				show_message("商家ID不合法");
				
			}else if($code==1102){
				show_message("身份证姓名不合法");
				
			}else if($code==1103){
				show_message("身份证号码不合法");
				
			}else if($code==1104){
				show_message("签名不合法");
				
			}else if($code==1107){
				show_message("tm不合法");
				
			}
				
		}
		//正常情况下不需要处理，商家也可以根据自己的业务进行处理
		else if($status==2002){
			show_message("第三方服务器异常");
			
		}else if($status==2003){
			show_message("服务器维护");
			
		}else if($status==2004){
			show_message("账号余额不足");
			
		}else if($status==2005){
			show_message("参数异常");
			
		}
		//1000=一致
		//1001=不一致
		//1002=库中无此号
		//1101=商家ID不合法
		//1102=身份证姓名不合法
		//1103=身份证号码不合法
		//1104=签名不合法
		//1105=第三方服务器异常
		//1106=账户余额不足
		//1107=tm不合法
		//1108=其他异常
		//1109=账号被暂停
		
		return $code;
	}

/**
 *  获取指定用户的收藏商品列表
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $num            列表最大数量
 * @param   int     $start          列表其实位置
 *
 * @return  array   $arr
 */
function get_collection_goods($user_id, $num = 10, $start = 0)
{
    $sql = 'SELECT g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price, '.
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                'g.promote_price, g.promote_start_date,g.promote_end_date, c.rec_id, c.is_attention' .
            ' FROM ' . $GLOBALS['ecs']->table('collect_goods') . ' AS c' .
            " LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ".
                "ON g.goods_id = c.goods_id ".
            " LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            " WHERE c.user_id = '$user_id' ORDER BY c.rec_id DESC";
    $res = $GLOBALS['db'] -> selectLimit($sql, $num, $start);

    $goods_list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['promote_price'] > 0)
        {
            $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
        }
        else
        {
            $promote_price = 0;
        }

        $goods_list[$row['goods_id']]['rec_id']        = $row['rec_id'];
        $goods_list[$row['goods_id']]['is_attention']  = $row['is_attention'];
        $goods_list[$row['goods_id']]['goods_id']      = $row['goods_id'];
        $goods_list[$row['goods_id']]['goods_name']    = $row['goods_name'];
        $goods_list[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $goods_list[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $goods_list[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
        $goods_list[$row['goods_id']]['url']           = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
    }

    return $goods_list;
}

/**
 *  查看此商品是否已进行过缺货登记
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $goods_id       商品ID
 *
 * @return  int
 */
function get_booking_rec($user_id, $goods_id)
{
    $sql = 'SELECT COUNT(*) '.
           'FROM ' .$GLOBALS['ecs']->table('booking_goods').
           "WHERE user_id = '$user_id' AND goods_id = '$goods_id' AND is_dispose = 0";

    return $GLOBALS['db']->getOne($sql);
}

/**
 *  获取指定用户的留言
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $user_name      用户名
 * @param   int     $num            列表最大数量
 * @param   int     $start          列表其实位置
 * @return  array   $msg            留言及回复列表
 * @return  string  $order_id       订单ID
 */
function get_message_list($user_id, $user_name, $num, $start, $order_id = 0)
{
    /* 获取留言数据 */
    $msg = array();
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('feedback');
    if ($order_id)
    {
        $sql .= " WHERE parent_id = 0 AND order_id = '$order_id' AND user_id = '$user_id' ORDER BY msg_time DESC";
    }
    else
    {
        $sql .= " WHERE parent_id = 0 AND user_id = '$user_id' AND user_name = '" . $_SESSION['user_name'] . "' AND order_id=0 ORDER BY msg_time DESC";
    }

    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        /* 取得留言的回复 */
        //if (empty($order_id))
        //{
            $reply = array();
            $sql   = "SELECT user_name, user_email, msg_time, msg_content".
                     " FROM " .$GLOBALS['ecs']->table('feedback') .
                     " WHERE parent_id = '" . $rows['msg_id'] . "'";
            $reply = $GLOBALS['db']->getRow($sql);

            if ($reply)
            {
                $msg[$rows['msg_id']]['re_user_name']   = $reply['user_name'];
                $msg[$rows['msg_id']]['re_user_email']  = $reply['user_email'];
                $msg[$rows['msg_id']]['re_msg_time']    = local_date($GLOBALS['_CFG']['time_format'], $reply['msg_time']);
                $msg[$rows['msg_id']]['re_msg_content'] = nl2br(htmlspecialchars($reply['msg_content']));
            }
        //}

        $msg[$rows['msg_id']]['msg_content'] = nl2br(htmlspecialchars($rows['msg_content']));
        $msg[$rows['msg_id']]['msg_time']    = local_date($GLOBALS['_CFG']['time_format'], $rows['msg_time']);
        $msg[$rows['msg_id']]['msg_type']    = $order_id ? $rows['user_name'] : $GLOBALS['_LANG']['type'][$rows['msg_type']];
        $msg[$rows['msg_id']]['msg_title']   = nl2br(htmlspecialchars($rows['msg_title']));
        $msg[$rows['msg_id']]['message_img'] = $rows['message_img'];
        $msg[$rows['msg_id']]['order_id'] = $rows['order_id'];
    }

    return $msg;
}

/**
 *  添加留言函数
 *
 * @access  public
 * @param   array       $message
 *
 * @return  boolen      $bool
 */
function add_message($message)
{
    $upload_size_limit = $GLOBALS['_CFG']['upload_size_limit'] == '-1' ? ini_get('upload_max_filesize') : $GLOBALS['_CFG']['upload_size_limit'];
    $status = 1 - $GLOBALS['_CFG']['message_check'];

    $last_char = strtolower($upload_size_limit{strlen($upload_size_limit)-1});

    switch ($last_char)
    {
        case 'm':
            $upload_size_limit *= 1024*1024;
            break;
        case 'k':
            $upload_size_limit *= 1024;
            break;
    }

    if ($message['upload'])
    {
        if($_FILES['message_img']['size'] / 1024 > $upload_size_limit)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['upload_file_limit'], $upload_size_limit));
            return false;
        }
        $img_name = upload_file($_FILES['message_img'], 'feedbackimg');

        if ($img_name === false)
        {
            return false;
        }
    }
    else
    {
        $img_name = '';
    }

    if (empty($message['msg_title']))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['msg_title_empty']);

        return false;
    }

    $message['msg_area'] = isset($message['msg_area']) ? intval($message['msg_area']) : 0;
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('feedback') .
            " (msg_id, parent_id, user_id, user_name, user_email, msg_title, msg_type, msg_status,  msg_content, msg_time, message_img, order_id, msg_area)".
            " VALUES (NULL, 0, '$message[user_id]', '$message[user_name]', '$message[user_email]', ".
            " '$message[msg_title]', '$message[msg_type]', '$status', '$message[msg_content]', '".gmtime()."', '$img_name', '$message[order_id]', '$message[msg_area]')";
    $GLOBALS['db']->query($sql);

    return true;
}

/**
 *  获取用户的tags
 *
 * @access  public
 * @param   int         $user_id        用户ID
 *
 * @return array        $arr            tags列表
 */
function get_user_tags($user_id = 0)
{
    if (empty($user_id))
    {
        $GLOBALS['error_no'] = 1;

        return false;
    }

    $tags = get_tags(0, $user_id);

    if (!empty($tags))
    {
        color_tag($tags);
    }

    return $tags;
}

/**
 *  验证性的删除某个tag
 *
 * @access  public
 * @param   int         $tag_words      tag的ID
 * @param   int         $user_id        用户的ID
 *
 * @return  boolen      bool
 */
function delete_tag($tag_words, $user_id)
{
     $sql = "DELETE FROM ".$GLOBALS['ecs']->table('tag').
            " WHERE tag_words = '$tag_words' AND user_id = '$user_id'";

     return $GLOBALS['db']->query($sql);
}

/**
 *  获取某用户的缺货登记列表
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $num            列表最大数量
 * @param   int     $start          列表其实位置
 *
 * @return  array   $booking
 */
function get_booking_list($user_id, $num, $start)
{
    $booking = array();
    $sql = "SELECT bg.rec_id, bg.goods_id, bg.goods_number, bg.booking_time, bg.dispose_note, g.goods_name ".
           "FROM " .$GLOBALS['ecs']->table('booking_goods')." AS bg , " .$GLOBALS['ecs']->table('goods')." AS g". " WHERE bg.goods_id = g.goods_id AND bg.user_id = '$user_id' ORDER BY bg.booking_time DESC";
    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if (empty($row['dispose_note']))
        {
            $row['dispose_note'] = 'N/A';
        }
        $booking[] = array('rec_id'       => $row['rec_id'],
                           'goods_name'   => $row['goods_name'],
                           'goods_number' => $row['goods_number'],
                           'booking_time' => local_date($GLOBALS['_CFG']['date_format'], $row['booking_time']),
                           'dispose_note' => $row['dispose_note'],
                           'url'          => build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']));
    }

    return $booking;
}

/**
 *  获取某用户的缺货登记列表
 *
 * @access  public
 * @param   int     $goods_id    商品ID
 *
 * @return  array   $info
 */
function get_goodsinfo($goods_id)
{
    $info = array();
    $sql  = "SELECT goods_name FROM " .$GLOBALS['ecs']->table('goods'). " WHERE goods_id = '$goods_id'";

    $info['goods_name']   = $GLOBALS['db']->getOne($sql);
    $info['goods_number'] = 1;
    $info['id']           = $goods_id;

    if (!empty($_SESSION['user_id']))
    {
        $row = array();
        $sql = "SELECT ua.consignee, ua.email, ua.tel, ua.mobile ".
               "FROM ".$GLOBALS['ecs']->table('user_address')." AS ua, ".$GLOBALS['ecs']->table('users')." AS u".
               " WHERE u.address_id = ua.address_id AND u.user_id = '$_SESSION[user_id]'";
        $row = $GLOBALS['db']->getRow($sql) ;
        $info['consignee'] = empty($row['consignee']) ? '' : $row['consignee'];
        $info['email']     = empty($row['email'])     ? '' : $row['email'];
        $info['tel']       = empty($row['mobile'])    ? (empty($row['tel']) ? '' : $row['tel']) : $row['mobile'];
    }

    return $info;
}

/**
 *  验证删除某个收藏商品
 *
 * @access  public
 * @param   int         $booking_id     缺货登记的ID
 * @param   int         $user_id        会员的ID
 * @return  boolen      $bool
 */
function delete_booking($booking_id, $user_id)
{
    $sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('booking_goods').
           " WHERE rec_id = '$booking_id' AND user_id = '$user_id'";

    return $GLOBALS['db']->query($sql);
}

/**
 * 添加缺货登记记录到数据表
 * @access  public
 * @param   array $booking
 *
 * @return void
 */
function add_booking($booking)
{
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('booking_goods').
            " VALUES ('', '$_SESSION[user_id]', '$booking[email]', '$booking[linkman]', ".
                "'$booking[tel]', '$booking[goods_id]', '$booking[desc]', ".
                "'$booking[goods_amount]', '".gmtime()."', 0, '', 0, '')";
    $GLOBALS['db']->query($sql) or die ($GLOBALS['db']->errorMsg());

    return $GLOBALS['db']->insert_id();
}

/**
 * 插入会员账目明细
 *
 * @access  public
 * @param   array     $surplus  会员余额信息
 * @param   string    $amount   余额
 *
 * @return  int
 */
function insert_user_account($surplus, $amount)
{
    $sql = 'INSERT INTO ' .$GLOBALS['ecs']->table('user_account').
           ' (user_id, admin_user, amount, add_time, paid_time, admin_note, user_note, process_type, payment, is_paid)'.
            " VALUES ('$surplus[user_id]', '', '$amount', '".gmtime()."', 0, '', '$surplus[user_note]', '$surplus[process_type]', '$surplus[payment]', 0)";
    $GLOBALS['db']->query($sql);

    return $GLOBALS['db']->insert_id();
}

/**
 * 更新会员账目明细
 *
 * @access  public
 * @param   array     $surplus  会员余额信息
 *
 * @return  int
 */
function update_user_account($surplus)
{
    $sql = 'UPDATE ' .$GLOBALS['ecs']->table('user_account'). ' SET '.
           "amount     = '$surplus[amount]', ".
           "user_note  = '$surplus[user_note]', ".
           "payment    = '$surplus[payment]' ".
           "WHERE id   = '$surplus[rec_id]'";
    $GLOBALS['db']->query($sql);

    return $surplus['rec_id'];
}

/**
 * 将支付LOG插入数据表
 *
 * @access  public
 * @param   integer     $id         订单编号
 * @param   float       $amount     订单金额
 * @param   integer     $type       支付类型
 * @param   integer     $is_paid    是否已支付
 *
 * @return  int
 */
function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0)
{
    $sql = 'INSERT INTO ' .$GLOBALS['ecs']->table('pay_log')." (order_id, order_amount, order_type, is_paid)".
            " VALUES  ('$id', '$amount', '$type', '$is_paid')";
    $GLOBALS['db']->query($sql);

     return $GLOBALS['db']->insert_id();
}

/**
 * 取得上次未支付的pay_lig_id
 *
 * @access  public
 * @param   array     $surplus_id  余额记录的ID
 * @param   array     $pay_type    支付的类型：预付款/订单支付
 *
 * @return  int
 */
function get_paylog_id($surplus_id, $pay_type = PAY_SURPLUS)
{
    $sql = 'SELECT log_id FROM' .$GLOBALS['ecs']->table('pay_log').
           " WHERE order_id = '$surplus_id' AND order_type = '$pay_type' AND is_paid = 0";

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 根据ID获取当前余额操作信息
 *
 * @access  public
 * @param   int     $surplus_id  会员余额的ID
 *
 * @return  int
 */
function get_surplus_info($surplus_id)
{
    $sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('user_account').
           " WHERE id = '$surplus_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * 取得已安装的支付方式(其中不包括线下支付的)
 * @param   bool    $include_balance    是否包含余额支付（冲值时不应包括）
 * @return  array   已安装的配送方式列表
 */
function get_online_payment_list($include_balance = true)
{
    $sql = 'SELECT pay_id, pay_code, pay_name, pay_fee, pay_desc ' .
            'FROM ' . $GLOBALS['ecs']->table('payment') .
            " WHERE enabled = 1 AND is_cod <> 1";
    if (!$include_balance)
    {
        $sql .= " AND pay_code <> 'balance' ";
    }

    $modules = $GLOBALS['db']->getAll($sql);

    include_once(ROOT_PATH.'includes/lib_compositor.php');

    return $modules;
}

/**
 * 查询会员余额的操作记录
 *
 * @access  public
 * @param   int     $user_id    会员ID
 * @param   int     $num        每页显示数量
 * @param   int     $start      开始显示的条数
 * @return  array
 */
function get_account_log($user_id, $num, $start)
{
    $account_log = array();
    $sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('user_account').
           " WHERE user_id = '$user_id'" .
           " AND process_type " . db_create_in(array(SURPLUS_SAVE, SURPLUS_RETURN)) .
           " ORDER BY add_time DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $num, $start);

    if ($res)
    {
        while ($rows = $GLOBALS['db']->fetchRow($res))
        {
            $rows['add_time']         = local_date($GLOBALS['_CFG']['date_format'], $rows['add_time']);
            $rows['admin_note']       = nl2br(htmlspecialchars($rows['admin_note']));
            $rows['short_admin_note'] = ($rows['admin_note'] > '') ? sub_str($rows['admin_note'], 30) : 'N/A';
            $rows['user_note']        = nl2br(htmlspecialchars($rows['user_note']));
            $rows['short_user_note']  = ($rows['user_note'] > '') ? sub_str($rows['user_note'], 30) : 'N/A';
            $rows['pay_status']       = ($rows['is_paid'] == 0) ? $GLOBALS['_LANG']['un_confirm'] : $GLOBALS['_LANG']['is_confirm'];
            $rows['amount']           = price_format(abs($rows['amount']), false);

            /* 会员的操作类型： 冲值，提现 */
            if ($rows['process_type'] == 0)
            {
                $rows['type'] = $GLOBALS['_LANG']['surplus_type_0'];
            }
            else
            {
                $rows['type'] = $GLOBALS['_LANG']['surplus_type_1'];
            }

            /* 支付方式的ID */
            $sql = 'SELECT pay_id FROM ' .$GLOBALS['ecs']->table('payment').
                   " WHERE pay_name = '$rows[payment]' AND enabled = 1";
            $pid = $GLOBALS['db']->getOne($sql);

            /* 如果是预付款而且还没有付款, 允许付款 */
            if (($rows['is_paid'] == 0) && ($rows['process_type'] == 0))
            {
                $rows['handle'] = '<a href="user.php?act=pay&id='.$rows['id'].'&pid='.$pid.'">'.$GLOBALS['_LANG']['pay'].'</a>';
            }

            $account_log[] = $rows;
        }

        return $account_log;
    }
    else
    {
         return false;
    }
}

/**
 *  删除未确认的会员帐目信息
 *
 * @access  public
 * @param   int         $rec_id     会员余额记录的ID
 * @param   int         $user_id    会员的ID
 * @return  boolen
 */
function del_user_account($rec_id, $user_id)
{
    $sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('user_account').
           " WHERE is_paid = 0 AND id = '$rec_id' AND user_id = '$user_id'";

    return $GLOBALS['db']->query($sql);
}

/**
 * 查询会员余额的数量
 * @access  public
 * @param   int     $user_id        会员ID
 * @return  int
 */
function get_user_surplus($user_id)
{
    $sql = "SELECT SUM(user_money) FROM " .$GLOBALS['ecs']->table('account_log').
           " WHERE user_id = '$user_id'";

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 获取用户中心默认页面所需的数据
 *
 * @access  public
 * @param   int         $user_id            用户ID
 *
 * @return  array       $info               默认页面所需资料数组
 */
function get_user_default($user_id)
{
    $user_bonus = get_user_bonus();

    $sql = "SELECT pay_points, user_money, credit_line, last_login, is_validated FROM " .$GLOBALS['ecs']->table('users'). " WHERE user_id = '$user_id'";
    $row = $GLOBALS['db']->getRow($sql);
    $info = array();
    $info['username']  = stripslashes($_SESSION['user_name']);
    $info['shop_name'] = $GLOBALS['_CFG']['shop_name'];
    $info['integral']  = $row['pay_points'] . $GLOBALS['_CFG']['integral_name'];
    /* 增加是否开启会员邮件验证开关 */
    $info['is_validate'] = ($GLOBALS['_CFG']['member_email_validate'] && !$row['is_validated'])?0:1;
    $info['credit_line'] = $row['credit_line'];
    $info['formated_credit_line'] = price_format($info['credit_line'], false);

    //如果$_SESSION中时间无效说明用户是第一次登录。取当前登录时间。
    $last_time = !isset($_SESSION['last_time']) ? $row['last_login'] : $_SESSION['last_time'];

    if ($last_time == 0)
    {
        $_SESSION['last_time'] = $last_time = gmtime();
    }

    $info['last_time'] = local_date($GLOBALS['_CFG']['time_format'], $last_time);
    $info['surplus']   = price_format($row['user_money'], false);
    $info['bonus']     = sprintf($GLOBALS['_LANG']['user_bonus_info'], $user_bonus['bonus_count'], price_format($user_bonus['bonus_value'], false));

    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('order_info').
            " WHERE user_id = '" .$user_id. "' AND add_time > '" .local_strtotime('-1 months'). "'";
    $info['order_count'] = $GLOBALS['db']->getOne($sql);

    include_once(ROOT_PATH . 'includes/lib_order.php');
    $sql = "SELECT order_id, order_sn ".
            " FROM " .$GLOBALS['ecs']->table('order_info').
            " WHERE user_id = '" .$user_id. "' AND shipping_time > '" .$last_time. "'". order_query_sql('shipped');
    $info['shipped_order'] = $GLOBALS['db']->getAll($sql);

    return $info;
}

/**
 * 添加商品标签
 *
 * @access  public
 * @param   integer     $id
 * @param   string      $tag
 * @return  void
 */
function add_tag($id, $tag)
{
    if (empty($tag))
    {
        return;
    }

    $arr = explode(',', $tag);

    foreach ($arr AS $val)
    {
        /* 检查是否重复 */
        $sql = "SELECT COUNT(*) FROM ". $GLOBALS['ecs']->table("tag").
                " WHERE user_id = '".$_SESSION['user_id']."' AND goods_id = '$id' AND tag_words = '$val'";

        if ($GLOBALS['db']->getOne($sql) == 0)
        {
            $sql = "INSERT INTO ".$GLOBALS['ecs']->table("tag")." (user_id, goods_id, tag_words) ".
                    "VALUES ('".$_SESSION['user_id']."', '$id', '$val')";
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * 标签着色
 *
 * @access   public
 * @param    array
 * @author   Xuan Yan
 *
 * @return   none
 */
function color_tag(&$tags)
{
    $tagmark = array(
        array('color'=>'#666666','size'=>'0.8em','ifbold'=>1),
        array('color'=>'#333333','size'=>'0.9em','ifbold'=>0),
        array('color'=>'#006699','size'=>'1.0em','ifbold'=>1),
        array('color'=>'#CC9900','size'=>'1.1em','ifbold'=>0),
        array('color'=>'#666633','size'=>'1.2em','ifbold'=>1),
        array('color'=>'#993300','size'=>'1.3em','ifbold'=>0),
        array('color'=>'#669933','size'=>'1.4em','ifbold'=>1),
        array('color'=>'#3366FF','size'=>'1.5em','ifbold'=>0),
        array('color'=>'#197B30','size'=>'1.6em','ifbold'=>1),
    );

    $maxlevel = count($tagmark);
    $tcount = $scount = array();

    foreach($tags AS $val)
    {
        $tcount[] = $val['tag_count']; // 获得tag个数数组
    }
    $tcount = array_unique($tcount); // 去除相同个数的tag

    sort($tcount); // 从小到大排序

    $tempcount = count($tcount); // 真正的tag级数
    $per = $maxlevel >= $tempcount ? 1 : $maxlevel / ($tempcount - 1);

    foreach ($tcount AS $key => $val)
    {
        $lvl = floor($per * $key);
        $scount[$val] = $lvl; // 计算不同个数的tag相对应的着色数组key
    }

    $rewrite = intval($GLOBALS['_CFG']['rewrite']) > 0;

    /* 遍历所有标签，根据引用次数设定字体大小 */
    foreach ($tags AS $key => $val)
    {
        $lvl = $scount[$val['tag_count']]; // 着色数组key

        $tags[$key]['color'] = $tagmark[$lvl]['color'];
        $tags[$key]['size']  = $tagmark[$lvl]['size'];
        $tags[$key]['bold']  = $tagmark[$lvl]['ifbold'];
        if ($rewrite)
        {
            if (strtolower(EC_CHARSET) !== 'utf-8')
            {
                $tags[$key]['url'] = 'tag-' . urlencode(urlencode($val['tag_words'])) . '.html';
            }
            else
            {
                $tags[$key]['url'] = 'tag-' . urlencode($val['tag_words']) . '.html';
            }
        }
        else
        {
            $tags[$key]['url'] = 'search.php?keywords=' . urlencode($val['tag_words']);
        }
    }
    shuffle($tags);
}

/**
 * 取得用户等级信息
 * @access   public
 * @author   Xuan Yan
 *
 * @return array
 */
function get_rank_info()
{
    global $db,$ecs;

    if (!empty($_SESSION['user_rank']))
    {
        $sql = "SELECT rank_name, special_rank FROM " . $ecs->table('user_rank') . " WHERE rank_id = '$_SESSION[user_rank]'";
        $row = $db->getRow($sql);
        if (empty($row))
        {
            return array();
        }
        $rank_name = $row['rank_name'];
        if ($row['special_rank'])
        {
            return array('rank_name'=>$rank_name);
        }
        else
        {
            $user_rank = $db->getOne("SELECT rank_points FROM " . $ecs->table('users') . " WHERE user_id = '$_SESSION[user_id]'");
            $sql = "SELECT rank_name,min_points FROM " . $ecs->table('user_rank') . " WHERE min_points > '$user_rank' ORDER BY min_points ASC LIMIT 1";
            $rt  = $db->getRow($sql);
            $next_rank_name = $rt['rank_name'];
            $next_rank = $rt['min_points'] - $user_rank;
            return array('rank_name'=>$rank_name,'next_rank_name'=>$next_rank_name,'next_rank'=>$next_rank);
        }
    }
    else
    {
        return array();
    }
}

/**
 *  获取用户参与活动信息
 *
 * @access  public
 * @param   int     $user_id        用户id
 *
 * @return  array
 */
function get_user_prompt ($user_id)
{
    $prompt = array();
    $now = gmtime();
    /* 夺宝奇兵 */
    $sql = "SELECT act_id, goods_name, end_time " .
            "FROM " . $GLOBALS['ecs']->table('goods_activity') .
            " WHERE act_type = '" . GAT_SNATCH . "'" .
            " AND (is_finished = 1 OR (is_finished = 0 AND end_time <= '$now'))";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $act_id = $row['act_id'];
        $result = get_snatch_result($act_id);
        if (isset($result['order_count']) && $result['order_count'] == 0 && $result['user_id'] == $user_id)
        {
            $prompt[] = array(
                   'text'=>sprintf($GLOBALS['_LANG']['your_snatch'],$row['goods_name'], $row['act_id']),
                   'add_time'=> $row['end_time']
            );
        }
        if (isset($auction['last_bid']) && $auction['last_bid']['bid_user'] == $user_id && $auction['order_count'] == 0)
        {
            $prompt[] = array(
                'text' => sprintf($GLOBALS['_LANG']['your_auction'], $row['goods_name'], $row['act_id']),
                'add_time' => $row['end_time']
            );
        }
    }


    /* 竞拍 */

    $sql = "SELECT act_id, goods_name, end_time " .
            "FROM " . $GLOBALS['ecs']->table('goods_activity') .
            " WHERE act_type = '" . GAT_AUCTION . "'" .
            " AND (is_finished = 1 OR (is_finished = 0 AND end_time <= '$now'))";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $act_id = $row['act_id'];
        $auction = auction_info($act_id);
        if (isset($auction['last_bid']) && $auction['last_bid']['bid_user'] == $user_id && $auction['order_count'] == 0)
        {
            $prompt[] = array(
                'text' => sprintf($GLOBALS['_LANG']['your_auction'], $row['goods_name'], $row['act_id']),
                'add_time' => $row['end_time']
            );
        }
    }

    /* 排序 */
    $cmp = create_function('$a, $b', 'if($a["add_time"] == $b["add_time"]){return 0;};return $a["add_time"] < $b["add_time"] ? 1 : -1;');
    usort($prompt, $cmp);

    /* 格式化时间 */
    foreach ($prompt as $key => $val)
    {
        $prompt[$key]['formated_time'] = local_date($GLOBALS['_CFG']['time_format'], $val['add_time']);
    }

    return $prompt;
}

/**
 *  获取用户评论
 *
 * @access  public
 * @param   int     $user_id        用户id
 * @param   int     $page_size      列表最大数量
 * @param   int     $start          列表起始页
 * @return  array
 */
function get_comment_list($user_id, $page_size, $start)
{
    $sql = "SELECT c.*, g.goods_name AS cmt_name, r.content AS reply_content, r.add_time AS reply_time ".
           " FROM " . $GLOBALS['ecs']->table('comment') . " AS c ".
           " LEFT JOIN " . $GLOBALS['ecs']->table('comment') . " AS r ".
           " ON r.parent_id = c.comment_id AND r.parent_id > 0 ".
           " LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ".
           " ON c.comment_type=0 AND c.id_value = g.goods_id ".
           " WHERE c.user_id='$user_id'";
    $res = $GLOBALS['db']->SelectLimit($sql, $page_size, $start);

    $comments = array();
    $to_article = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['formated_add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
        if ($row['reply_time'])
        {
            $row['formated_reply_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['reply_time']);
        }
        if ($row['comment_type'] == 1)
        {
            $to_article[] = $row["id_value"];
        }
        $comments[] = $row;
    }

    if ($to_article)
    {
        $sql = "SELECT article_id , title FROM " . $GLOBALS['ecs']->table('article') . " WHERE " . db_create_in($to_article, 'article_id');
        $arr = $GLOBALS['db']->getAll($sql);
        $to_cmt_name = array();
        foreach ($arr as $row)
        {
            $to_cmt_name[$row['article_id']] = $row['title'];
        }

        foreach ($comments as $key=>$row)
        {
            if ($row['comment_type'] == 1)
            {
                $comments[$key]['cmt_name'] = isset($to_cmt_name[$row['id_value']]) ? $to_cmt_name[$row['id_value']] : '';
            }
        }
    }

    return $comments;
}
/* 获取用户的投资总览 */
/* 输入 user_id 用户id */
/* 返回 array */
/* 	total_money 总资产
	total_inverst_money 投资金额
	total_earn_money 总收益
	rest_earn_money 代收收益
	*/
	
function get_user_order_total($user_id, $user_money){
	GLOBAL $ecs;GLOBAL $db;
	
		/* 获取用户的购买信息 */
    $sql = 'SELECT * FROM ' . $ecs->table("order_new") . "WHERE user_id = " . $user_id . " AND pay_time > 0 ";
	$order_list = $GLOBALS['db']->getAll($sql);
	$total_inverst_money = 0;
	$total_earn_money = 0;
	$rest_earn_money = 0;
	
	foreach ($order_list as $key => $val){

		// 计算已转让项目的持有天数 转让时间 转让价格 总收益
		$order=order_detail($val['order_id']);
		/* echo '<pre>';
		var_dump($order); */
		$order_list[$key]=array_merge($order_list[$key],$order);
		$total_earn_money += $order['total_earn_money'];
		$total_inverst_money += $order["total_inverst_money"];
		// 计算该项目待收收益，即该项目总收益减去已经收去的收益		
		$rest_earn_money +=  $order['rest_earn_money'];
		// 计算该项目的持有收益，即该项目的当前收益（天）减去已经收去的收益
		//$taking_earn_money +=  $order['taking_earn_money'];
		
		
	}
	// 计算用户总资产
	$total_money = $total_inverst_money + $rest_earn_money + $user_money;
	return array(	"total_money"			=> $total_money,
					"total_inverst_money" 	=> $total_inverst_money,
					"total_earn_money"		=> $total_earn_money,
					"rest_earn_money"		=> $rest_earn_money);
}

?>