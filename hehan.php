<?php

/**
 * 政金网 首页文件
 * Author: ligeng 
*/
//echo("123");exit();
header("Access-Control-Allow-Origin: *");
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');


if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}




	/* 获取用户的购买信息 */
	$key = $_POST['key'];
	//$key = 1;
	// 插入数据库
	
	if (!$key){
		$result=array(
				'status'=>'0',
				'msg'=>'请登陆后再进行操作'
		);
		die(json_encode($result));
	}
	
	
    
	
	$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('goods')." WHERE is_on_sale = 1 AND goods_end_time > " .time(). " ORDER BY add_time DESC limit 3 ";
	
	$goods_list = $GLOBALS['db']->getAll($sql);
	//print_r($order_list);exit();
	if($goods_list){
		$result=array(
			'status'=>'1',
			'msg'=>'操作成功',
			'data_list'=>$goods_list,
		);
		die(json_encode($result));
	}
	
	


?>