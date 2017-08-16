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

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

$goods_id = isset($_REQUEST['id'])  ? intval($_REQUEST['id']) : 0;

/*------------------------------------------------------ */
//-- 改变属性、数量时重新计算商品价格
/*------------------------------------------------------ */

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'price')
{
    include('includes/cls_json.php');

    $json   = new JSON;
    $res    = array('err_msg' => '', 'result' => '', 'qty' => 1);

    $attr_id    = isset($_REQUEST['attr']) ? explode(',', $_REQUEST['attr']) : array();
    $number     = (isset($_REQUEST['number'])) ? intval($_REQUEST['number']) : 1;

    if ($goods_id == 0)
    {
        $res['err_msg'] = $_LANG['err_change_attr'];
        $res['err_no']  = 1;
    }
    else
    {
        if ($number == 0)
        {
            $res['qty'] = $number = 1;
        }
        else
        {
            $res['qty'] = $number;
        }

        $shop_price  = get_final_price($goods_id, $number, true, $attr_id);
        $res['result'] = price_format($shop_price * $number);
    }

    die($json->encode($res));
}elseif($_REQUEST["act"]=="act_reserve"){
	// INPUT
	//这里的 point 已经变为省一级别，和以前的不同
	if($_POST["point"]==0){
		print_r($_POST["point"]);
		$point = 4;
	}else{
		$point = $_POST["point"];
	}
	
	$info = array(
		"name" => $_POST["name"],
		"mobile" => $_POST["mobile"],
		"mobile_code" => $_POST["mobile_code"],
		"point" => $point,
		"goods_id" => $_POST["goods_id"]
	);
	if (empty($_SESSION["sms_mobile_code"])){
		show_message("点击获取验证码。");exit;
	}
	if (empty($_POST["mobile"])){
		show_message("请填写手机号码。");exit;
	}
	if (empty($_POST["mobile_code"])){
		show_message("请填写短信验证码。");exit;
	}
	if ($info["mobile"] != $_SESSION["sms_mobile"]){
		show_message("手机号码不正确！");exit;
	}
	if ($info["mobile_code"] != $_SESSION["sms_mobile_code"]){
		show_message("短信验证码不正确！");exit;
	}
	// 判断短期内用户是否已经提交过该网点此商品的请求
	$sql = 'SELECT * FROM ' . $ecs->table("reserve") . " 
				WHERE mobile = '" . $info["mobile"]."' AND point = '" . $info["point"]."' AND goods_id = '" . $info["goods_id"]."' AND add_time > ". (gmtime()-2*60*60);
	if ($GLOBALS['db']->getAll($sql)){
		show_message("您已经在近期提交过预约申请了，我们的业务经理会尽快与您取得联系");
		exit;
	}
	
	$user_id = $_SESSION['user_id'];
	if ($user_id){
		// 如果用户已经登录了，就直接把这条预约信息分给他的业务经理
		$sql = 'SELECT seller_id FROM ' . $ecs->table("users") . " WHERE user_id = '" . $user_id."'";
		$seller_id = $GLOBALS['db']->getOne($sql);
	}else{
		// 如果用户没有登录，就分配给受分配最少的一名该网点的业务经理
		// 如果该用户在此网点有过预约记录，就分给他分配过的业务员
		$sql = 'SELECT seller_id FROM ' . $ecs->table("reserve") . " WHERE mobile = '" . $info["mobile"]."' AND point = '" . $info["point"]."'";
		$seller_id = $GLOBALS['db']->getOne($sql);
		if (!$seller_id){
			// 获取该网点受分配最少的一名该网点的业务经理
			//上海和其他归总部管，代号是4，数据库调整
			if($point==4){
				$sql = 'SELECT seller_id FROM ' . $ecs->table("seller") . " WHERE region_manager = '" . $info["point"]."' AND get_reserve = 1 ORDER BY reserve_number ASC LIMIT 0,1";
			}else{
				$sql = 'SELECT seller_id FROM ' . $ecs->table("seller") . " WHERE region_id = '" . $info["point"]."' AND get_reserve = 1 ORDER BY reserve_number ASC LIMIT 0,1";
			}
			$seller_id = $GLOBALS['db']->getOne($sql);
			// 自动增加该业务经理的获取量
			$db->query('UPDATE '.$ecs->table('seller') . " SET reserve_number = reserve_number + 1 WHERE seller_id = '$seller_id'");
		}
		$user_id = 0;
	}
	$sql = 'INSERT INTO '. $ecs->table('reserve') . ' (`name`,`user_id`, `mobile`, `point`, `goods_id`, `seller_id`, `add_time`) VALUES ("'.$info["name"].'","'.$user_id.'","'.$info["mobile"].'","'.$info["point"].'","'.$info["goods_id"].'","'.$seller_id.'","'.gmtime().'")';
    $db->query($sql);
	
	$sql = 'SELECT goods_name FROM ' . $ecs->table('goods') . ' WHERE goods_id= '. $info["goods_id"];   
    $goods_name = $db->getOne($sql);	
	
	include(ROOT_PATH . 'includes/cls_sms.php');
	$sms = new sms();
	$sms_error = array();
	$message= "尊敬的".$info["name"]."，您在政金网平台已成功预约，产品名称：".$goods_name."，我们的客服人员会在24小时内与您取得联系，确定约谈时间与地点。客服电话：400-820-7259。";
	$send_result = $sms->send($info["mobile"], $message, $sms_error);
	show_message("预约成功<br>我们会将预约信息发送至您的手机，敬请查收。");exit;
}


/*------------------------------------------------------ */
//-- 商品购买记录ajax处理
/*------------------------------------------------------ */

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'gotopage')
{
    include('includes/cls_json.php');

    $json   = new JSON;
    $res    = array('err_msg' => '', 'result' => '');

    $goods_id   = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    $page    = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;

    if (!empty($goods_id))
    {
        $need_cache = $GLOBALS['smarty']->caching;
        $need_compile = $GLOBALS['smarty']->force_compile;

        $GLOBALS['smarty']->caching = false;
        $GLOBALS['smarty']->force_compile = true;

        /* 商品购买记录 */
        $sql = 'SELECT u.user_name, og.goods_number, oi.add_time, IF(oi.order_status IN (2, 3, 4), 0, 1) AS order_status ' .
               'FROM ' . $ecs->table('order_info') . ' AS oi LEFT JOIN ' . $ecs->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $ecs->table('order_goods') . ' AS og ' .
               'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $goods_id . ' ORDER BY oi.add_time DESC LIMIT ' . (($page > 1) ? ($page-1) : 0) * 5 . ',5';
        $bought_notes = $db->getAll($sql);

        foreach ($bought_notes as $key => $val)
        {
            $bought_notes[$key]['add_time'] = local_date("Y-m-d G:i:s", $val['add_time']);
        }

        $sql = 'SELECT count(*) ' .
               'FROM ' . $ecs->table('order_info') . ' AS oi LEFT JOIN ' . $ecs->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $ecs->table('order_goods') . ' AS og ' .
               'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $goods_id;
        $count = $db->getOne($sql);


        /* 商品购买记录分页样式 */
        $pager = array();
        $pager['page']         = $page;
        $pager['size']         = $size = 5;
        $pager['record_count'] = $count;
        $pager['page_count']   = $page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;;
        $pager['page_first']   = "javascript:gotoBuyPage(1,$goods_id)";
        $pager['page_prev']    = $page > 1 ? "javascript:gotoBuyPage(" .($page-1). ",$goods_id)" : 'javascript:;';
        $pager['page_next']    = $page < $page_count ? 'javascript:gotoBuyPage(' .($page + 1) . ",$goods_id)" : 'javascript:;';
        $pager['page_last']    = $page < $page_count ? 'javascript:gotoBuyPage(' .$page_count. ",$goods_id)"  : 'javascript:;';

        $smarty->assign('notes', $bought_notes);
        $smarty->assign('pager', $pager);


        $res['result'] = $GLOBALS['smarty']->fetch('library/bought_notes.lbi');

        $GLOBALS['smarty']->caching = $need_cache;
        $GLOBALS['smarty']->force_compile = $need_compile;
    }

    die($json->encode($res));
}


/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */
	$sql='select p.* from '.$GLOBALS['ecs']->table('project_file').' as p left join '.$GLOBALS['ecs']->table('goods').' as g on p.project_id=g.project_id where g.goods_id='.$goods_id.' and p.type=1';
	$trade=$GLOBALS['db']->getAll($sql);
	$sql='select p.* from '.$GLOBALS['ecs']->table('project_file').' as p left join '.$GLOBALS['ecs']->table('goods').' as g on p.project_id=g.project_id where g.goods_id='.$goods_id.' and p.type=2';
	$other=$GLOBALS['db']->getAll($sql);
	$sql='select * from '.$GLOBALS['ecs']->table('project').' as p left join '.$GLOBALS['ecs']->table('goods').' as g on p.project_id=g.project_id where g.goods_id='.$goods_id;
	$project=$GLOBALS['db']->getRow($sql);
	$smarty->assign('trade',$trade);
	$smarty->assign('other',$other);
	$smarty->assign('project',$project);
	//print_r($project);
    $smarty->assign('image_width',  $_CFG['image_width']);
    $smarty->assign('image_height', $_CFG['image_height']);
    $smarty->assign('helps',        get_shop_help()); // 网店帮助
    $smarty->assign('id',           $goods_id);
    $smarty->assign('type',         0);
    $smarty->assign('cfg',          $_CFG);
    $smarty->assign('promotion',       get_promotion_info($goods_id));//促销信息
    $smarty->assign('promotion_info', get_promotion_info());

    /* 获得商品的信息 */
    $goods = get_goods_info($goods_id);

	$goods["format_goods_min_buy"] = number_format($goods["goods_min_buy"],0);
	$goods["format_goods_total_number"] = number_format($goods["goods_total_number"],0);
	
	//$goods["format_goods_rest_number"] = number_format($goods["goods_rest_number"],0);
	$sold_number = get_sold_number($goods_id);
	
	//print_r($sold_number);
	if (($goods["goods_total_number"] - $sold_number)<0){
		$goods["format_goods_rest_number"] = 0 ;
	}else{
		$goods["format_goods_rest_number"] = number_format(($goods["goods_total_number"] - $sold_number),0);
	}
	
	//goods表剩余可投资额：goods_rest_number
	
	$goods_rest_num = ($goods["goods_total_number"] - $sold_number);
	
	//print_r($goods_rest_num);
	
	$sql = "UPDATE".$GLOBALS['ecs']->table('goods')." SET goods_rest_number = '$goods_rest_num'" . " WHERE goods_id = ".$goods_id;
	//print_r($sql);
	$result = $GLOBALS["db"]->query($sql);
	
	
	function get_sold_number($goods_id){
		$sql = "SELECT SUM(amount) FROM ".$GLOBALS["ecs"]->table("order_new"). " WHERE goods_id =".$goods_id;
		$sold_number = $GLOBALS["db"]->getOne($sql);
		return $sold_number;
	}
	$goods["formed_start_time"] = date("Y-m-d",$goods["goods_start_time"]);
	$goods["formed_return_time"] = date("Y-m-d",$goods["goods_start_time"]+$goods["goods_period"]*24*60*60+$goods["t"]*24*60*60);
	
	/* 判断用户是否已经登录 */
	if ($_SESSION["user_id"]){
		$smarty->assign('is_login',1);
	}else{
		$smarty->assign('is_login',0);
	}
	
	/* 获取所有网点信息 */
	$sql = "SELECT * FROM " . $ecs->table('store');
	//print_r($sql);
	
	
    $store_info = $db->getAll($sql);
	$smarty->assign('store_info',$store_info);
	
    if ($goods === false)
    {
        /* 如果没有找到任何记录则跳回到首页 */
        ecs_header("Location: ./\n");
        exit;
    }
    else
    {
        if ($goods['brand_id'] > 0)
        {
            $goods['goods_brand_url'] = build_uri('brand', array('bid'=>$goods['brand_id']), $goods['goods_brand']);
        }

        $shop_price   = $goods['shop_price'];
        $linked_goods = get_linked_goods($goods_id);

        $goods['goods_style_name'] = add_style($goods['goods_name'], $goods['goods_name_style']);

        /* 购买该商品可以得到多少钱的红包 */
        if ($goods['bonus_type_id'] > 0)
        {
            $time = gmtime();
            $sql = "SELECT type_money FROM " . $ecs->table('bonus_type') .
                    " WHERE type_id = '$goods[bonus_type_id]' " .
                    " AND send_type = '" . SEND_BY_GOODS . "' " .
                    " AND send_start_date <= '$time'" .
                    " AND send_end_date >= '$time'";
            $goods['bonus_money'] = floatval($db->getOne($sql));
            if ($goods['bonus_money'] > 0)
            {
                $goods['bonus_money'] = price_format($goods['bonus_money']);
            }
        }
		
		
		
		
		
		
		
		
		
		
		
		
		/* 计算产品的已购买率 */
		/* 获取商品的已购买数量 */
		$sql = "SELECT SUM(amount) FROM ".$ecs->table("order_new")." WHERE goods_id = ".$goods_id;
		$sold_number = $db->getOne($sql);
	
		
		
		
		$goods["goods_rest_rate"] = floor(10000*$sold_number/$goods["goods_total_number"])/100;

		/* 计算产品的当前状态 */

		if (time()>($goods['goods_start_time']+$goods['goods_period']*24*60*60)){
			$smarty->assign('goods_status',              4);
		}else{
			if (time()>($goods['goods_end_time'])){
				$smarty->assign('goods_status',              3);
			}else{
				if ($goods['goods_rest_number']<=0){
					$smarty->assign('goods_status',              2);
				}else{
					if (time()<($goods['goods_start_time'])){
						$smarty->assign('goods_status',              0);
					}else{
						$smarty->assign('goods_status',              1);
					}
				}
			}
		}
		$smarty->assign('formated_start_time',date("Y-m-d H:i",$goods['goods_start_time']));
		
		/* 获取商品的投资记录 */
		$sql = "SELECT o.*,u.user_name FROM " . $GLOBALS['ecs']->table('order_new') ." AS o INNER JOIN ".$GLOBALS['ecs']->table('users')." AS u ON o.user_id = u.user_id 
            WHERE goods_id = ".$_GET["id"]." ORDER BY order_id DESC";
		$order_list = $GLOBALS['db']->getAll($sql);
		$compteur = 0;
		foreach ($order_list as $key => $val){
			$compteur++;
			$order_list[$key]["compteur"]=$compteur;
			$order_list[$key]["formed_pay_time"]=date("Y-m-d H:i:s",$val["pay_time"]);
		}
		
		$smarty->assign('order_list',         $order_list);
		// 获取商品其他信息
		$sql = "SELECT p.*
					FROM " . $GLOBALS['ecs']->table('goods') ." AS g 
					LEFT JOIN " .$GLOBALS['ecs']->table('project')." AS p ON p.project_id = g.project_id 
					WHERE g.goods_id = ".$goods["goods_id"];
		$goods_info_ex = $GLOBALS['db']->getRow($sql);
		$goods_info_ex["format_project_max"] = number_format($goods_info_ex["project_max"],2);
		$array_tmp = array("A" => $goods_info_ex["A"]?$goods_info_ex["A"]*30:0,
							"B"=> $goods_info_ex["B"]?$goods_info_ex["B"]*30:0,
							"C"=> $goods_info_ex["C"]?$goods_info_ex["C"]*30:0,
							"D"=> $goods_info_ex["D"]?$goods_info_ex["D"]*30:0,
							"E"=> $goods_info_ex["E"]?$goods_info_ex["E"]*30:0,
							"F"=> $goods_info_ex["F"]?$goods_info_ex["F"]*30:0);
		$interest_rate_array = array();
		$sql = "SELECT DISTINCT(goods_min_buy) FROM ".$GLOBALS["ecs"]->table("goods")." WHERE goods_min_buy >1000 AND project_id = ".$goods_info_ex["project_id"]." ORDER BY goods_min_buy";
		$goods_min_buy_array = $GLOBALS["db"]->getAll($sql);
		foreach($array_tmp as $k=>$v){
			foreach ($goods_min_buy_array as $val){
				$sql = "SELECT goods_interest_rate FROM ".$GLOBALS["ecs"]->table("goods")." WHERE goods_period = ".$v ." AND goods_min_buy =".$val["goods_min_buy"]." AND project_id = ".$goods_info_ex["project_id"]." ORDER BY goods_min_buy";
				$interest_rate_array[$k][] = array("goods_min_buy"=>$val["goods_min_buy"],"goods_interest_rate"=>$GLOBALS["db"]->getOne($sql));
			}
		}
		$format_goods_min_buy_array = array();
		foreach ($goods_min_buy_array as $k=>$v){
			$format_goods_min_buy_array[] = array(
				"x"=>($v["goods_min_buy"]/10000)."万",
				"y"=>$goods_min_buy_array[$k+1]?($goods_min_buy_array[$k+1]["goods_min_buy"]/10000)."万":"",
				"z"=>"R".($k+1)
			);
		}
		$smarty->assign('format_goods_min_buy_array',$format_goods_min_buy_array);
		$smarty->assign('interest_rate_array',$interest_rate_array);
		$smarty->assign('goods_info_ex',      $goods_info_ex);
		//print_r($goods);		
        $smarty->assign('goods',              $goods);
        $smarty->assign('goods_id',           $goods['goods_id']);
        $smarty->assign('promote_end_time',   $goods['gmt_end_time']);
        $smarty->assign('categories',         get_categories_tree($goods['cat_id']));  // 分类树

        /* meta */
        $smarty->assign('keywords',           htmlspecialchars($goods['keywords']));
        $smarty->assign('description',        htmlspecialchars($goods['goods_brief']));


        $catlist = array();
        foreach(get_parent_cats($goods['cat_id']) as $k=>$v)
        {
            $catlist[] = $v['cat_id'];
        }

        assign_template('c', $catlist);

         /* 上一个商品下一个商品 */
        $prev_gid = $db->getOne("SELECT goods_id FROM " .$ecs->table('goods'). " WHERE cat_id=" . $goods['cat_id'] . " AND goods_id > " . $goods['goods_id'] . " AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0 LIMIT 1");
        if (!empty($prev_gid))
        {
            $prev_good['url'] = build_uri('goods', array('gid' => $prev_gid), $goods['goods_name']);
            $smarty->assign('prev_good', $prev_good);//上一个商品
        }

        $next_gid = $db->getOne("SELECT max(goods_id) FROM " . $ecs->table('goods') . " WHERE cat_id=".$goods['cat_id']." AND goods_id < ".$goods['goods_id'] . " AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0");
        if (!empty($next_gid))
        {
            $next_good['url'] = build_uri('goods', array('gid' => $next_gid), $goods['goods_name']);
            $smarty->assign('next_good', $next_good);//下一个商品
        }

        $position = assign_ur_here($goods['cat_id'], $goods['goods_name']);

        /* current position */
        $smarty->assign('page_title',          $position['title']);                    // 页面标题
        $smarty->assign('ur_here',             $position['ur_here']);                  // 当前位置

        $properties = get_goods_properties($goods_id);  // 获得商品的规格和属性

        $smarty->assign('properties',          $properties['pro']);                              // 商品属性
        $smarty->assign('specification',       $properties['spe']);                              // 商品规格
        $smarty->assign('attribute_linked',    get_same_attribute_goods($properties));           // 相同属性的关联商品
        $smarty->assign('related_goods',       $linked_goods);                                   // 关联商品
        $smarty->assign('goods_article_list',  get_linked_articles($goods_id));                  // 关联文章
        $smarty->assign('fittings',            get_goods_fittings(array($goods_id)));                   // 配件
        $smarty->assign('rank_prices',         get_user_rank_prices($goods_id, $shop_price));    // 会员等级价格
        $smarty->assign('pictures',            get_goods_gallery($goods_id));                    // 商品相册
        $smarty->assign('bought_goods',        get_also_bought($goods_id));                      // 购买了该商品的用户还购买了哪些商品
        $smarty->assign('goods_rank',          get_goods_rank($goods_id));                       // 商品的销售排名

        //获取tag
        $tag_array = get_tags($goods_id);
        $smarty->assign('tags',                $tag_array);                                       // 商品的标记

        //获取关联礼包
        $package_goods_list = get_package_goods_list($goods['goods_id']);
        $smarty->assign('package_goods_list',$package_goods_list);    // 获取关联礼包

        assign_dynamic('goods');
        $volume_price_list = get_volume_price_list($goods['goods_id'], '1');
        $smarty->assign('volume_price_list',$volume_price_list);    // 商品优惠价格区间
    }


/* 记录浏览历史 */
if (!empty($_COOKIE['ECS']['history']))
{
    $history = explode(',', $_COOKIE['ECS']['history']);

    array_unshift($history, $goods_id);
    $history = array_unique($history);

    while (count($history) > $_CFG['history_number'])
    {
        array_pop($history);
    }

    setcookie('ECS[history]', implode(',', $history), gmtime() + 3600 * 24 * 30);
}
else
{
    setcookie('ECS[history]', $goods_id, gmtime() + 3600 * 24 * 30);
}


/* 更新点击次数 */
$db->query('UPDATE ' . $ecs->table('goods') . " SET click_count = click_count + 1 WHERE goods_id = '$_REQUEST[id]'");

$smarty->assign('now_time',  gmtime());           // 当前系统时间


$smarty->assign('is_seller', $_SESSION["is_seller"]);
/* 获取登陆用户信息 */
if ($_SESSION["user_id"]){
	$sql = 'SELECT true_name, user_name FROM '.$ecs->table('users')." WHERE user_id = ". $_SESSION["user_id"];
    $user_info = $GLOBALS['db']->getRow($sql);
}
$smarty->assign('user_info', $user_info);
$smarty->display('goods.dwt',      $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 获得指定商品的关联商品
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_linked_goods($goods_id)
{
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                'g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('link_goods') . ' lg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = lg.link_goods_id ' .
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE lg.goods_id = '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".
            "LIMIT " . $GLOBALS['_CFG']['related_goods_number'];
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$row['goods_id']]['goods_id']     = $row['goods_id'];
        $arr[$row['goods_id']]['goods_name']   = $row['goods_name'];
        $arr[$row['goods_id']]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$row['goods_id']]['goods_thumb']  = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']   = price_format($row['shop_price']);
        $arr[$row['goods_id']]['url']          = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);

        if ($row['promote_price'] > 0)
        {
            $arr[$row['goods_id']]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            $arr[$row['goods_id']]['formated_promote_price'] = price_format($arr[$row['goods_id']]['promote_price']);
        }
        else
        {
            $arr[$row['goods_id']]['promote_price'] = 0;
        }
    }

    return $arr;
}

/**
 * 获得指定商品的关联文章
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_linked_articles($goods_id)
{
    $sql = 'SELECT a.article_id, a.title, a.file_url, a.open_type, a.add_time ' .
            'FROM ' . $GLOBALS['ecs']->table('goods_article') . ' AS g, ' .
                $GLOBALS['ecs']->table('article') . ' AS a ' .
            "WHERE g.article_id = a.article_id AND g.goods_id = '$goods_id' AND a.is_open = 1 " .
            'ORDER BY a.add_time DESC';
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['url']         = $row['open_type'] != 1 ?
            build_uri('article', array('aid'=>$row['article_id']), $row['title']) : trim($row['file_url']);
        $row['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $row['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
            sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];

        $arr[] = $row;
    }

    return $arr;
}

/**
 * 获得指定商品的各会员等级对应的价格
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_user_rank_prices($goods_id, $shop_price)
{
    $sql = "SELECT rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount " .
            'FROM ' . $GLOBALS['ecs']->table('user_rank') . ' AS r ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                "ON mp.goods_id = '$goods_id' AND mp.user_rank = r.rank_id " .
            "WHERE r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'";
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {

        $arr[$row['rank_id']] = array(
                        'rank_name' => htmlspecialchars($row['rank_name']),
                        'price'     => price_format($row['price']));
    }

    return $arr;
}

/**
 * 获得购买过该商品的人还买过的商品
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_also_bought($goods_id)
{
    $sql = 'SELECT COUNT(b.goods_id ) AS num, g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS a ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('order_goods') . ' AS b ON b.order_id = a.order_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = b.goods_id ' .
            "WHERE a.goods_id = '$goods_id' AND b.goods_id <> '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 " .
            'GROUP BY b.goods_id ' .
            'ORDER BY num DESC ' .
            'LIMIT ' . $GLOBALS['_CFG']['bought_goods'];
    $res = $GLOBALS['db']->query($sql);

    $key = 0;
    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$key]['goods_id']    = $row['goods_id'];
        $arr[$key]['goods_name']  = $row['goods_name'];
        $arr[$key]['short_name']  = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$key]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$key]['goods_img']   = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$key]['shop_price']  = price_format($row['shop_price']);
        $arr[$key]['url']         = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);

        if ($row['promote_price'] > 0)
        {
            $arr[$key]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            $arr[$key]['formated_promote_price'] = price_format($arr[$key]['promote_price']);
        }
        else
        {
            $arr[$key]['promote_price'] = 0;
        }

        $key++;
    }

    return $arr;
}

/**
 * 获得指定商品的销售排名
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  integer
 */
function get_goods_rank($goods_id)
{
    /* 统计时间段 */
    $period = intval($GLOBALS['_CFG']['top10_time']);
    if ($period == 1) // 一年
    {
        $ext = " AND o.add_time > '" . local_strtotime('-1 years') . "'";
    }
    elseif ($period == 2) // 半年
    {
        $ext = " AND o.add_time > '" . local_strtotime('-6 months') . "'";
    }
    elseif ($period == 3) // 三个月
    {
        $ext = " AND o.add_time > '" . local_strtotime('-3 months') . "'";
    }
    elseif ($period == 4) // 一个月
    {
        $ext = " AND o.add_time > '" . local_strtotime('-1 months') . "'";
    }
    else
    {
        $ext = '';
    }

    /* 查询该商品销量 */
    $sql = 'SELECT IFNULL(SUM(g.goods_number), 0) ' .
        'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o, ' .
            $GLOBALS['ecs']->table('order_goods') . ' AS g ' .
        "WHERE o.order_id = g.order_id " .
        "AND o.order_status = '" . OS_CONFIRMED . "' " .
        "AND o.shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
        " AND o.pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) .
        " AND g.goods_id = '$goods_id'" . $ext;
    $sales_count = $GLOBALS['db']->getOne($sql);

    if ($sales_count > 0)
    {
        /* 只有在商品销售量大于0时才去计算该商品的排行 */
        $sql = 'SELECT DISTINCT SUM(goods_number) AS num ' .
                'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o, ' .
                    $GLOBALS['ecs']->table('order_goods') . ' AS g ' .
                "WHERE o.order_id = g.order_id " .
                "AND o.order_status = '" . OS_CONFIRMED . "' " .
                "AND o.shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
                " AND o.pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . $ext .
                " GROUP BY g.goods_id HAVING num > $sales_count";
        $res = $GLOBALS['db']->query($sql);

        $rank = $GLOBALS['db']->num_rows($res) + 1;

        if ($rank > 10)
        {
            $rank = 0;
        }
    }
    else
    {
        $rank = 0;
    }

    return $rank;
}

/**
 * 获得商品选定的属性的附加总价格
 *
 * @param   integer     $goods_id
 * @param   array       $attr
 *
 * @return  void
 */
function get_attr_amount($goods_id, $attr)
{
    $sql = "SELECT SUM(attr_price) FROM " . $GLOBALS['ecs']->table('goods_attr') .
        " WHERE goods_id='$goods_id' AND " . db_create_in($attr, 'goods_attr_id');

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 取得跟商品关联的礼包列表
 *
 * @param   string  $goods_id    商品编号
 *
 * @return  礼包列表
 */
function get_package_goods_list($goods_id)
{
    $now = gmtime();
    $sql = "SELECT pg.goods_id, ga.act_id, ga.act_name, ga.act_desc, ga.goods_name, ga.start_time,
                   ga.end_time, ga.is_finished, ga.ext_info
            FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS ga, " . $GLOBALS['ecs']->table('package_goods') . " AS pg
            WHERE pg.package_id = ga.act_id
            AND ga.start_time <= '" . $now . "'
            AND ga.end_time >= '" . $now . "'
            AND pg.goods_id = " . $goods_id . "
            GROUP BY ga.act_id
            ORDER BY ga.act_id ";
    $res = $GLOBALS['db']->getAll($sql);

    foreach ($res as $tempkey => $value)
    {
        $subtotal = 0;
        $row = unserialize($value['ext_info']);
        unset($value['ext_info']);
        if ($row)
        {
            foreach ($row as $key=>$val)
            {
                $res[$tempkey][$key] = $val;
            }
        }

        $sql = "SELECT pg.package_id, pg.goods_id, pg.goods_number, pg.admin_id, p.goods_attr, g.goods_sn, g.goods_name, g.market_price, g.goods_thumb, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price
                FROM " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                    LEFT JOIN ". $GLOBALS['ecs']->table('goods') . " AS g
                        ON g.goods_id = pg.goods_id
                    LEFT JOIN ". $GLOBALS['ecs']->table('products') . " AS p
                        ON p.product_id = pg.product_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp
                        ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'
                WHERE pg.package_id = " . $value['act_id']. "
                ORDER BY pg.package_id, pg.goods_id";

        $goods_res = $GLOBALS['db']->getAll($sql);

        foreach($goods_res as $key => $val)
        {
            $goods_id_array[] = $val['goods_id'];
            $goods_res[$key]['goods_thumb']  = get_image_path($val['goods_id'], $val['goods_thumb'], true);
            $goods_res[$key]['market_price'] = price_format($val['market_price']);
            $goods_res[$key]['rank_price']   = price_format($val['rank_price']);
            $subtotal += $val['rank_price'] * $val['goods_number'];
        }

        /* 取商品属性 */
        $sql = "SELECT ga.goods_attr_id, ga.attr_value
                FROM " .$GLOBALS['ecs']->table('goods_attr'). " AS ga, " .$GLOBALS['ecs']->table('attribute'). " AS a
                WHERE a.attr_id = ga.attr_id
                AND a.attr_type = 1
                AND " . db_create_in($goods_id_array, 'goods_id');
        $result_goods_attr = $GLOBALS['db']->getAll($sql);

        $_goods_attr = array();
        foreach ($result_goods_attr as $value)
        {
            $_goods_attr[$value['goods_attr_id']] = $value['attr_value'];
        }

        /* 处理货品 */
        $format = '[%s]';
        foreach($goods_res as $key => $val)
        {
            if ($val['goods_attr'] != '')
            {
                $goods_attr_array = explode('|', $val['goods_attr']);

                $goods_attr = array();
                foreach ($goods_attr_array as $_attr)
                {
                    $goods_attr[] = $_goods_attr[$_attr];
                }

                $goods_res[$key]['goods_attr_str'] = sprintf($format, implode('，', $goods_attr));
            }
        }

        $res[$tempkey]['goods_list']    = $goods_res;
        $res[$tempkey]['subtotal']      = price_format($subtotal);
        $res[$tempkey]['saving']        = price_format(($subtotal - $res[$tempkey]['package_price']));
        $res[$tempkey]['package_price'] = price_format($res[$tempkey]['package_price']);
    }

    return $res;
}

?>