<?php

/**
 * ECSHOP 前台公用文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: init.php 17217 2011-01-19 06:29:08Z liubo $
*/
/*ECSHOP 前台公用文件*/


//防止非法调用 defined-判断常量是否已定义，如果没返回false
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

//print_r("123");exit();
//报告所有错误
error_reporting(E_ALL);


//如果获取不到本文件
if (__FILE__ == '')
{
    die('Fatal error code: 0');
}
/*预定义常量
__LINE__       文件中的当前行号。
__FILE__       文件的完整路径和文件名。
__FUNCTION__   函数名称（这是 PHP 4.3.0 新加的）。
__CLASS__      类的名称（这是 PHP 4.3.0 新加的）。
__METHOD__     类的方法名（这是 PHP 5.0.0 新加的）。
*/



/* 取得当前ecshop所在的根目录 */
define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));


//检测是否已安装
if (!file_exists(ROOT_PATH . 'data/install.lock') && !file_exists(ROOT_PATH . 'includes/install.lock')
    && !defined('NO_CHECK_INSTALL'))
{
    header("Location: ./install/index.php\n");

    exit;
}

/* 初始化设置 */

//ini_set设置php.ini中的设置，memory_limit设定一个脚本所能够申请到的最大内存字节数
@ini_set('memory_limit',          '64M');
//指定会话页面在客户端cache中的有效期限(分钟),单位为分钟。
@ini_set('session.cache_expire',  180);
//关闭自动把session id嵌入到web的URL中
@ini_set('session.use_trans_sid', 0);
//允许使用cookie在客户端保存会话ID
@ini_set('session.use_cookies',   1);
//在客户访问任何页面时都自动初始化会话，0-禁止
@ini_set('session.auto_start',    0);
//是否显示错误
@ini_set('display_errors',        1);



if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path', '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path', '.:' . ROOT_PATH);
}

//包含配置文件（数据库相关）
require(ROOT_PATH . 'data/config.php');



if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}
//设定用于所有日期时间函数的默认时区
if (PHP_VERSION >= '5.1' && !empty($timezone))
{
	//date_default_timezone_set 设置时区
    date_default_timezone_set($timezone);
}

//$_SERVER['PHP_SELF']返回当前页面，获取$_SERVER['PHP_SELF']最好用htmlspecialchars过滤一下，存在XSS漏洞
$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))//如果是"/"结尾，则加上index.php
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);//放入常量

require(ROOT_PATH . 'includes/inc_constant.php');//包含预定义常量文件
require(ROOT_PATH . 'includes/cls_ecshop.php');//基础类 文件
require(ROOT_PATH . 'includes/cls_error.php');//错误类 文件
require(ROOT_PATH . 'includes/lib_time.php');//时间函数
require(ROOT_PATH . 'includes/lib_base.php');//基础函数库
require(ROOT_PATH . 'includes/lib_common.php');//基础函数库
require(ROOT_PATH . 'includes/lib_main.php');//公用函数库
require(ROOT_PATH . 'includes/lib_insert.php');//动态内容函数库
require(ROOT_PATH . 'includes/lib_goods.php');//商品相关函数库
require(ROOT_PATH . 'includes/lib_article.php');//文章及文章分类相关函数库

/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/* 创建 ECSHOP 对象 */
$ecs = new ECS($db_name, $prefix);
define('DATA_DIR', $ecs->data_dir());
define('IMAGE_DIR', $ecs->image_dir());

/* 初始化数据库类 */
require(ROOT_PATH . 'includes/cls_mysql.php');
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);

/* 设置不允许进行缓存的表 */
$db->set_disable_cache_tables(array($ecs->table('sessions'), $ecs->table('sessions_data'), $ecs->table('cart')));
$db_host = $db_user = $db_pass = $db_name = NULL;

/* 创建错误处理对象 */
$err = new ecs_error('message.dwt');

/* 载入系统参数 */
$_CFG = load_config();//载入配置信息函数在lib_common.php

/* 载入语言文件 */
require(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/common.php');

if ($_CFG['shop_closed'] == 1)
{
    /* 商店关闭了，输出关闭的消息 */
    header('Content-type: text/html; charset='.EC_CHARSET);

    die('<div style="margin: 150px; text-align: center; font-size: 14px"><p>' . $_LANG['shop_closed'] . '</p><p>' . $_CFG['close_comment'] . '</p></div>');
}

if (is_spider())
{
    /* 如果是蜘蛛的访问，那么默认为访客方式，并且不记录到日志中 */
    if (!defined('INIT_NO_USERS'))
    {
        define('INIT_NO_USERS', true);
        /* 整合UC后，如果是蜘蛛访问，初始化UC需要的常量 */
        if($_CFG['integrate_code'] == 'ucenter')
        {
             $user = & init_users();
        }
    }
    $_SESSION = array();
    $_SESSION['user_id']     = 0;
    $_SESSION['user_name']   = '';
    $_SESSION['email']       = '';
    $_SESSION['user_rank']   = 0;
    $_SESSION['discount']    = 1.00;
}


//非搜索引擎蜘蛛，记录session
if (!defined('INIT_NO_USERS'))
{
    /* 初始化session */
    include(ROOT_PATH . 'includes/cls_session.php');

    $sess = new cls_session($db, $ecs->table('sessions'), $ecs->table('sessions_data'));

    define('SESS_ID', $sess->get_session_id());
}

获取$_SERVER['PHP_SELF']最好用htmlspecialchars过滤一下，存在XSS漏洞

if(isset($_SERVER['PHP_SELF']))
{
    $_SERVER['PHP_SELF']=htmlspecialchars($_SERVER['PHP_SELF']);
}


//如果使用Smarty
if (!defined('INIT_NO_SMARTY'))
{
    header('Cache-control: private');
    header('Content-type: text/html; charset='.EC_CHARSET);

    /* 创建 Smarty 对象。*/
    require(ROOT_PATH . 'includes/cls_template.php');
    $smarty = new cls_template;

    $smarty->cache_lifetime = $_CFG['cache_time'];//缓存时间
    $smarty->template_dir   = ROOT_PATH . 'themes/' . $_CFG['template'];//模板所在
    $smarty->cache_dir      = ROOT_PATH . 'temp/caches';//缓存所在
    $smarty->compile_dir    = ROOT_PATH . 'temp/compiled';//模板编译后的文件所在

    if ((DEBUG_MODE & 2) == 2)//如果常量DEBUG_MODE值为 2、3、6、7.时
    {
        $smarty->direct_output = true;//不使用缓存直接输出
        $smarty->force_compile = true;//强行编译
    }
    else
    {
        $smarty->direct_output = false;
        $smarty->force_compile = false;
    }

    $smarty->assign('lang', $_LANG);
    $smarty->assign('ecs_charset', EC_CHARSET);
    if (!empty($_CFG['stylename']))//如果自己定义样式文件就用自己的
    {
        $smarty->assign('ecs_css_path', 'themes/' . $_CFG['template'] . '/style_' . $_CFG['stylename'] . '.css');
    }
    else
    {
        $smarty->assign('ecs_css_path', 'themes/' . $_CFG['template'] . '/style.css');
    }

}
//非搜索引擎爬虫，记录用户信息
if (!defined('INIT_NO_USERS'))
{
    /* 会员信息 */
    $user =& init_users();

    if (!isset($_SESSION['user_id']))
    {
        /* 获取投放站点的名称 */
        $site_name = isset($_GET['from'])   ? htmlspecialchars($_GET['from']) : addslashes($_LANG['self_site']);
        $from_ad   = !empty($_GET['ad_id']) ? intval($_GET['ad_id']) : 0;

        $_SESSION['from_ad'] = $from_ad; // 用户点击的广告ID
        $_SESSION['referer'] = stripslashes($site_name); // 用户来源

        unset($site_name);

        if (!defined('INGORE_VISIT_STATS'))
        {
            visit_stats();
        }
    }

    if (empty($_SESSION['user_id']))
    {
        if ($user->get_cookie())
        {
            /* 如果会员已经登录并且还没有获得会员的帐户余额、积分以及优惠券 */
            if ($_SESSION['user_id'] > 0)
            {
                update_user_info();
            }
        }
        else
        {
            $_SESSION['user_id']     = 0;
            $_SESSION['user_name']   = '';
            $_SESSION['email']       = '';
            $_SESSION['user_rank']   = 0;
            $_SESSION['discount']    = 1.00;
            if (!isset($_SESSION['login_fail']))
            {
                $_SESSION['login_fail'] = 0;
            }
        }
    }

    /* 设置推荐会员 */
    if (isset($_GET['u']))
    {
        set_affiliate();
    }

    /* session 不存在，检查cookie */
    if (!empty($_COOKIE['ECS']['user_id']) && !empty($_COOKIE['ECS']['password']))
    {
        // 找到了cookie, 验证cookie信息
        $sql = 'SELECT user_id, user_name, password ' .
                ' FROM ' .$ecs->table('users') .
                " WHERE user_id = '" . intval($_COOKIE['ECS']['user_id']) . "' AND password = '" .$_COOKIE['ECS']['password']. "'";

        $row = $db->GetRow($sql);

        if (!$row)
        {
            // 没有找到这个记录
           $time = time() - 3600;
           setcookie("ECS[user_id]",  '', $time, '/');
           setcookie("ECS[password]", '', $time, '/');
        }
        else
        {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            update_user_info();
        }
    }

    if (isset($smarty))
    {
        $smarty->assign('ecs_session', $_SESSION);
    }
}

if ((DEBUG_MODE & 1) == 1)
{
    error_reporting(E_ALL);
}
else
{
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 
}
if ((DEBUG_MODE & 4) == 4)
{
    include(ROOT_PATH . 'includes/lib.debug.php');
}

/* 判断是否支持 Gzip 模式 */
if (!defined('INIT_NO_SMARTY') && gzip_enabled())
{
    ob_start('ob_gzhandler');
}
else
{
    ob_start();
}

/* 加载底部页脚文章列表页内容 */
    $sql = 'SELECT article_id,title FROM ' . $GLOBALS['ecs']->table('article') . " WHERE cat_id = 15";	
	$article_list1 = $GLOBALS['db']->getAll($sql);	
	$smarty->assign('article_list1', $article_list1);
	
    $sql = 'SELECT article_id,title FROM ' . $GLOBALS['ecs']->table('article') . " WHERE cat_id = 17";	
	$article_list2 = $GLOBALS['db']->getAll($sql);	
	$smarty->assign('article_list2', $article_list2);
	
    $sql = 'SELECT article_id,title FROM ' . $GLOBALS['ecs']->table('article') . " WHERE cat_id = 18";	
	$article_list3 = $GLOBALS['db']->getAll($sql);	
	$smarty->assign('article_list3', $article_list3);


/* 自动更新转让请求过期的订单 */
$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('order_new') . " WHERE transfer_flag = 1";
$order_list = $GLOBALS['db']->getAll($sql);	



foreach($order_list as $key => $val){
	if (($val["transfer_start_time"]+24*60*60)<time()){
		$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `transfer_flag`= 0, `transfer_start_time`= 0 WHERE `order_id`='" . $val["order_id"] . "'";
        $db->query($sql);
	}
}
	
/* 自动更新客户订单信息，产生利润时产出划账信息 */
$sql = 'SELECT o.*,g.cat_id, g.goods_name, g.goods_start_time,g.goods_period,g.goods_interest_rate,g.goods_earn_method FROM ' . $GLOBALS['ecs']->table('order_new') . " AS o INNER JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON o.goods_id = g.goods_id WHERE o.get_paid > -1 AND o.transfer_flag <> 2";
$order_list = $GLOBALS['db']->getAll($sql);

foreach ($order_list as $key => $val){
	// 处理新手包订单
	if($val["cat_id"] == 1){
		if (time()>$val["pay_time"]+$val["goods_period"]*24*60*60){
			// 给利息
			$earn = $val["amount"]*$val["goods_interest_rate"]*$val["goods_period"]/36500;
			/* 旧版 更新本地数据库 */
			/*$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
            $ouser_money = $db->getOne($sql);
			$nuser_money = $ouser_money + $earn;
			$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
            $db->query($sql);*/
			/* 新版 同步富友数据库 */
			require_once(ROOT_PATH .'includes/lib_fuiou.php');
			$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");
			  // 入资金流水数据库
			/*$insert_log_time = $val["pay_time"]+$val["goods_period"]*24*60*60;
			$insert_log_name = $val["goods_name"];
			$insert_type = 3;
			$insert_amount = $earn;
			$insert_beizhu = "";
			$insert_status = 1;
			$insert_user_id = $_SESSION["user_id"];
			$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
                    "VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
			$GLOBALS['db']->query($sql);*/
			// 给本金
			$earn = $val["amount"];
			$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返本");
			/*
			$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
            $ouser_money = $db->getOne($sql);
			$nuser_money = $ouser_money + $earn;
			$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
            $db->query($sql);
			*/
			
			  // 入资金流水数据库
			/*$insert_log_time = $val["pay_time"]+$val["goods_period"]*24*60*60;
			$insert_log_name = $val["goods_name"];
			$insert_type = 4;
			$insert_amount = $earn;
			$insert_beizhu = "";
			$insert_status = 1;
			$insert_user_id = $_SESSION["user_id"];
			$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
                    "VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
			$GLOBALS['db']->query($sql);*/
			// 设置订单为已结清订单
			$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `get_paid`= -1 WHERE `order_id`='" . $val["order_id"] . "'";
            $db->query($sql);
		}
	}else{
	// 处理非新手包订单
		if ((($val["goods_earn_method"] == 1)||($val["goods_earn_method"] == 2))&&($val["transfer_flag"]!=2)){
			// 到期一次结款
			
			if (time()>$val["goods_start_time"]+$val["goods_period"]*24*60*60){
				// 给利息
				$earn_period = floor(($val["goods_start_time"]+$val["goods_period"]*24*60*60)/(24*60*60)) - floor($val["pay_time"]/(24*60*60));
				$earn = $val["amount"]*$val["goods_interest_rate"]*$earn_period/36500;
				/*
				$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
				$ouser_money = $db->getOne($sql);
				$nuser_money = $ouser_money + $earn;
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
				$db->query($sql);*/
				require_once(ROOT_PATH .'includes/lib_fuiou.php');

				$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");
				  // 入资金流水数据库
				  /*
				$insert_log_time = $val["goods_start_time"]+$val["goods_period"]*24*60*60;
				$insert_log_name = $val["goods_name"];
				$insert_type = 3;
				$insert_amount = $earn;
				$insert_beizhu = "";
				$insert_status = 1;
				$insert_user_id = $_SESSION["user_id"];
				$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
						"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
				$GLOBALS['db']->query($sql);*/
				// 给本金
				$earn = $val["amount"];
				$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返本");
				/*
				$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
				$ouser_money = $db->getOne($sql);
				$nuser_money = $ouser_money + $earn;
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
				$db->query($sql);*/
				  // 入资金流水数据库
				/*$insert_log_time = $val["goods_start_time"]+$val["goods_period"]*24*60*60;
				$insert_log_name = $val["goods_name"];
				$insert_type = 4;
				$insert_amount = $earn;
				$insert_beizhu = "";
				$insert_status = 1;
				$insert_user_id = $_SESSION["user_id"];
				$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
						"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
				$GLOBALS['db']->query($sql);*/
				// 设置订单为已结清订单
				$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `get_paid`= -1 WHERE `order_id`='" . $val["order_id"] . "'";
				$db->query($sql);
			}
		}
		if (($val["goods_earn_method"] == 3)&&($val["transfer_flag"]!=2)){
			// 30天结款
			// 结清
			if (time()>$val["goods_start_time"]+$val["goods_period"]*24*60*60){
				// 给利息
				$earn_period = floor(($val["goods_start_time"]+$val["goods_period"]*24*60*60)/(24*60*60)) - floor($val["pay_time"]/(24*60*60) + $val["get_paid"]*30);
				$earn = $val["amount"]*$val["goods_interest_rate"]*$earn_period/36500;
				/*
				$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
				$ouser_money = $db->getOne($sql);
				$nuser_money = $ouser_money + $earn;
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
				$db->query($sql);*/
				require_once(ROOT_PATH .'includes/lib_fuiou.php');
				$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");
				 // 入资金流水数据库
				 /*
				$record_number = floor($earn_period / 30);
				for ($i = 1; $i<=$record_number;$i++){
					$insert_log_time = $val["pay_time"]+(30*24*60*60*($val["get_paid"]+$i));
					$insert_log_name = $val["goods_name"];
					$insert_type = 3;
					$insert_amount = $val["amount"]*$val["goods_interest_rate"]*30/36500;
					$insert_beizhu = "";
					$insert_status = 1;
					$insert_user_id = $_SESSION["user_id"];
					$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
							"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
					$GLOBALS['db']->query($sql);					
				}*/
				/*$insert_log_time = $val["goods_start_time"]+$val["goods_period"]*24*60*60;
				$insert_log_name = $val["goods_name"];
				$insert_type = 3;
				$insert_amount = $val["amount"]*$val["goods_interest_rate"]*($earn_period - $record_number*30)/36500;
				$insert_beizhu = "";
				$insert_status = 1;
				$insert_user_id = $_SESSION["user_id"];
				$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
						"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
				$GLOBALS['db']->query($sql);	*/			
				
				// 给本金
				$earn = $val["amount"];
				$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返本");
				/*$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
				$ouser_money = $db->getOne($sql);
				$nuser_money = $ouser_money + $earn;
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
				$db->query($sql);*/
				 // 入资金流水数据库
				 /*
				$insert_log_time = $val["goods_start_time"]+$val["goods_period"]*24*60*60;
				$insert_log_name = $val["goods_name"];
				$insert_type = 4;
				$insert_amount = $earn;
				$insert_beizhu = "";
				$insert_status = 1;
				$insert_user_id = $_SESSION["user_id"];
				$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
						"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
				$GLOBALS['db']->query($sql);	*/
				// 设置订单为已结清订单
				$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `get_paid`= -1 WHERE `order_id`='" . $val["order_id"] . "'";
				$db->query($sql);
			}
			// 不结清
			if (time()<$val["goods_start_time"]+$val["goods_period"]*24*60*60){
				if (time()>$val["pay_time"]+30*24*60*60*($val["get_paid"]+1)){
					// 给利息
					$period_number = floor((floor(time()/(24*60*60))-floor(($val["pay_time"]+30*24*60*60*$val["get_paid"])/(24*60*60)))/30);
					$earn_period = $period_number * 30;
					echo $earn_period;exit;
					$earn = $val["amount"]*$val["goods_interest_rate"]*$earn_period/36500;
					/*
					$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
					$ouser_money = $db->getOne($sql);
					$nuser_money = $ouser_money + $earn;
					$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
					$db->query($sql);		*/
					require_once(ROOT_PATH .'includes/lib_fuiou.php');
					
					$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");
					 // 入资金流水数据库
					/*$record_number = $period_number;
					for ($i = 1; $i<=$record_number;$i++){
						$insert_log_time = $val["pay_time"]+(30*24*60*60*($val["get_paid"]+$i));
						$insert_log_name = $val["goods_name"];
						$insert_type = 3;
						$insert_amount = $val["amount"]*$val["goods_interest_rate"]*30/36500;
						$insert_beizhu = "";
						$insert_status = 1;
						$insert_user_id = $_SESSION["user_id"];
						$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
								"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
						$GLOBALS['db']->query($sql);					
					}				*/
					// 设置订单的结款次数
					$nget_paid = $val["get_paid"] + $period_number;
					$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `get_paid`= ".$nget_paid." WHERE `order_id`='" . $val["order_id"] . "'";
					$db->query($sql);
				}
			}
		}
		if (($val["goods_earn_method"] == 4)&&($val["transfer_flag"]!=2)){
			// 90天结款
			// 结清
			if (time()>$val["goods_start_time"]+$val["goods_period"]*24*60*60){
				// 给利息
				$earn_period = floor(($val["goods_start_time"]+$val["goods_period"]*24*60*60)/(24*60*60)) - floor($val["pay_time"]/(24*60*60) + $val["get_paid"]*90);
				$earn = $val["amount"]*$val["goods_interest_rate"]*$earn_period/36500;
				/*
				$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
				$ouser_money = $db->getOne($sql);
				$nuser_money = $ouser_money + $earn;
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
				$db->query($sql);*/
				require_once(ROOT_PATH .'includes/lib_fuiou.php');
				$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");
				
				 // 入资金流水数据库
				/*$record_number = floor($earn_period / 90);
				for ($i = 1; $i<=$record_number;$i++){
					$insert_log_time = $val["pay_time"]+(90*24*60*60*($val["get_paid"]+$i));
					$insert_log_name = $val["goods_name"];
					$insert_type = 3;
					$insert_amount = $val["amount"]*$val["goods_interest_rate"]*90/36500;
					$insert_beizhu = "";
					$insert_status = 1;
					$insert_user_id = $_SESSION["user_id"];
					$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
							"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
					$GLOBALS['db']->query($sql);				
				}*/	
				/*$insert_log_time = $val["goods_start_time"]+$val["goods_period"]*24*60*60;
				$insert_log_name = $val["goods_name"];
				$insert_type = 3;
				$insert_amount = $val["amount"]*$val["goods_interest_rate"]*($earn_period - $record_number*90)/36500;
				$insert_beizhu = "";
				$insert_status = 1;
				$insert_user_id = $_SESSION["user_id"];
				$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
						"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
				$GLOBALS['db']->query($sql);	*/
				
				// 给本金
				$earn = $val["amount"];
				/*$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
				$ouser_money = $db->getOne($sql);
				$nuser_money = $ouser_money + $earn;
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
				$db->query($sql);*/
				$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");
				
				 // 入资金流水数据库
				/*$insert_log_time = $val["goods_start_time"]+$val["goods_period"]*24*60*60;
				$insert_log_name = $val["goods_name"];
				$insert_type = 4;
				$insert_amount = $earn;
				$insert_beizhu = "";
				$insert_status = 1;
				$insert_user_id = $_SESSION["user_id"];
				$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
						"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
				$GLOBALS['db']->query($sql);	*/
				
				// 设置订单为已结清订单
				$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `get_paid`= -1 WHERE `order_id`='" . $val["order_id"] . "'";
				$db->query($sql);
			}
			// 不结清
			if (time()<$val["goods_start_time"]+$val["goods_period"]*24*60*60){
				if (time()>$val["pay_time"]+90*24*60*60*($val["get_paid"]+1)){
					// 给利息
					$period_number = floor((floor(time()/(24*60*60))-floor(($val["pay_time"]+90*24*60*60*$val["get_paid"])/(24*60*60)))/90);
					$earn_period = $period_number * 90;
					$earn = $val["amount"]*$val["goods_interest_rate"]*$earn_period/36500;
					
					/*$sql = 'SELECT user_money FROM ' . $ecs->table('users') . " WHERE user_id = ". $val["user_id"];
					$ouser_money = $db->getOne($sql);
					$nuser_money = $ouser_money + $earn;
					$sql = 'UPDATE ' . $ecs->table('users') . " SET `user_money`= ".$nuser_money." WHERE `user_id`='" . $val["user_id"] . "'";
					$db->query($sql);		*/	
					require_once(ROOT_PATH .'includes/lib_fuiou.php');
					$result_array = return_interest($val["user_id"],$val["goods_id"],$earn,$val["goods_name"]."-返利");					
					
					 // 入资金流水数据库
					/*$record_number = $period_number;
					for ($i = 1; $i<=$record_number;$i++){
						$insert_log_time = $val["pay_time"]+(90*24*60*60*($val["get_paid"]+$i));
						$insert_log_name = $val["goods_name"];
						$insert_type = 3;
						$insert_amount = $val["amount"]*$val["goods_interest_rate"]*90/36500;
						$insert_beizhu = "";
						$insert_status = 1;
						$insert_user_id = $_SESSION["user_id"];
						$sql = "INSERT INTO " .$GLOBALS['ecs']->table('money_log'). " (user_id,log_time, log_name, type, amount, beizhu, status)" .
								"VALUES ('$insert_user_id', '$insert_log_time', '$insert_log_name', '$insert_type', '$insert_amount', '$insert_beizhu', '$insert_status')";
						$GLOBALS['db']->query($sql);			
					}		*/		
					
					// 设置订单的结款次数
					$nget_paid = $val["get_paid"] + $period_number;
					$sql = 'UPDATE ' . $ecs->table('order_new') . " SET `get_paid`= ".$nget_paid." WHERE `order_id`='" . $val["order_id"] . "'";
					$db->query($sql);
				}
			}
		}
	}
}
$r_ip = $_SERVER["REMOTE_ADDR"];
$smarty->assign('r_ip', $r_ip);

function time_to_day($time){
	return (floor(($time+28800)/(24*60*60)));
}

?>