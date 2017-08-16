<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<script src="themes/ecmoban_jumei/js/sms.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="baidu-site-verification" content="7hfOHCtvVL" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
<script type="text/javascript" src="jquery-1.8.0.js"></script>
<script type="text/javascript" src="themes/ecmoban_jumei/js/action.js"></script>
<script type="text/javascript" src="themes/ecmoban_jumei/js/mzp-packed-me.js"></script>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.json.js"></script>
</head>
<body class="index_page" style="min-width:1200px;font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;">
<?php echo $this->fetch('library/page_header.lbi'); ?>

<?php echo $this->fetch('library/index_ad.lbi'); ?>

<?php echo $this->fetch('library/right_link.lbi'); ?>


<div style="height:111px;width:100%">
	<div class="block">
		<div style="padding-top:40px;font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;text-align:center">

			<span style="font-size:14px;color:#666;margin-left:10px">
				<a style="padding-left: 25px; background: url('themes/ecmoban_jumei/images/ico-k.png') no-repeat left center";>
				我们的足迹
				</a>
			</span>
			<span style="font-size:14px;color:#999;margin-left:50px">
				预期年化收益率 <span style="color:#e84338;font-size:24px;font-weight:400">6%-10%</span>
			</span>
			<span style="font-size:14px;color:#999;margin-left:50px">
				成交总额 <span style="color:#666;font-size: 24px;font-weight: 400;" id="total_amount">￥0</span>
			</span>
			<span style="font-size:14px;color:#999;margin-left:50px">
				实现收益 <span style="color:#666;font-size: 24px;font-weight: 400;" id="total_earn">￥0</span>
			</span>
			<span style="font-size:14px;color:#999;margin-left:50px">
				政金会员 <span style="color:#666;font-size: 24px;font-weight: 400;"><?php echo $this->_var['user_number']; ?></span>
			</span>
		</div>
	</div>
</div>







<script>
	function fmoney(s, n)   
	{   
	   n = n > 0 && n <= 20 ? n : 2;
	   s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
	   var l = s.split(".")[0].split("").reverse(),   
	   r = s.split(".")[1];   
	   t = "";   
	   for(i = 0; i < l.length; i ++ )   
	   {   
		  t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");   
	   }   
	   return t.split("").reverse().join("");   
	} 
	
	function add_number(){
		count++;
		document.getElementById("total_amount").innerHTML = "￥" + fmoney(count*adding_total_amount,0);
		document.getElementById("total_earn").innerHTML = "￥" + fmoney(count*adding_total_earn,0);
		if (count==(TIME/BLOC)){
			window.clearInterval(clock);
		}
	}
	TIME = 1000; //动画秒数
	BLOC = 50;   //每多少秒执行一次
	count= 0;    //指针
	total_amount = <?php echo $this->_var['total_amount']; ?>;
	total_earn = <?php echo $this->_var['total_earn']; ?>;
	adding_total_amount = Math.ceil(total_amount / (TIME/BLOC));
	adding_total_earn = Math.ceil(total_earn / (TIME/BLOC));
	clock=setInterval('add_number()',BLOC);
</script>
<style>
	.box_shadow:hover{
		-webkit-box-shadow: 0 1px 6px 0 #b2b2b2;
		-moz-box-shadow: 0 1px 6px 0 #b2b2b2;
		box-shadow: 0 1px 6px 0 #b2b2b2;
	}
	.index_button{
		width: 100%;
		height: 33px;
		line-height: 33px;
		text-align: center;
		font-size: 18px;
		padding: 0;
		border: 1px solid #d2d2d2;
		background: #fff;
		color: #c7000a;
		cursor: pointer;
		outline: none;
		transition: all ease-in-out 0.15s;
		border-radius: 3px;
		margin-top:20px;
		display: inline-block;
	}
	.index_button:hover{
		width: 100%;
		height: 33px;
		line-height: 33px;
		text-align: center;
		font-size: 18px;
		padding: 0;
		border: 1px solid #c7000a;
		background: #c7000a;
		color: #fff;
	}
	.box_shadow2{
		width: 236px;
		height: 330px;
		margin-right: 13px;
		margin-bottom: 12px;
		padding: 15px;
		float: left;
		background: #fff;
		position: relative;
	}
	.box_shadow2:hover{
		background: #fef9e3;
		-webkit-box-shadow: 0 1px 6px 0 #b2b2b2;
		-moz-box-shadow: 0 1px 6px 0 #b2b2b2;
		box-shadow: 0 1px 6px 0 #b2b2b2;
	}

</style>

<div style="width:100%;padding-top:25px;padding-bottom:25px;">
	<img style="display:block;margin:0 auto;" src="themes/ecmoban_jumei/images/instro.png"/>
</div>







<div class="clearfix"></div><div style="width:100%;padding-top:15px;">
	<div class="block">
		<div style="padding-left: 0;border-left: none;margin: 10px 0;width: 50%;float: left;box-sizing: border-box;padding: 0 30px;border-right: 1px dashed #cacaca;">
			<div style="height: 55px;line-height: 55px;font-size: 18px;font-weight:bold;">
				<img style="margin-top:18px;display:block;float:left;" src="themes/ecmoban_jumei/images/squr_icon.png"/>
				<a id="label1" href="article_cat-20.html" style="font-size:18px;display:block;float:left;margin-left:5px"><?php echo $this->_var['cat_name4']; ?></a>
				<span>>></span>
			</div>
			<style>
				.a_shadow{color:#333;}
				.a_shadow:hover{color:#d01a0b;}
			</style>
			<div style="padding-top:10px">
				<ul style="list-style:none" id="tab1">
				<?php $_from = $this->_var['article_list4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article_list4'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list4']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article_list4']['iteration']++;
?>
					<li style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
						<span style="float:right;font-size:14px"><?php echo $this->_var['article']['formed_add_time']; ?></span>
						<a href="article-<?php echo $this->_var['article']['article_id']; ?>.html" style="height: 36px;font-size: 14px;display: block;padding-left: 18px;background: url(themes/ecmoban_jumei/images/ico-arrow.png) no-repeat left 5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="a_shadow"><?php echo $this->_var['article']['title']; ?></a>
					</li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
				
			</div>
		</div>
		<div style="padding-left: 0;margin: 10px 0;width: 50%;float: right;box-sizing: border-box;padding: 0 30px;">
			<div style="height: 55px;line-height: 55px;font-size: 18px;font-weight:bold;">
				<img style="margin-top:18px;display:block;float:left;" src="themes/ecmoban_jumei/images/squr_icon.png"/>
				<a id="label2" href="article_cat-21.html" style="font-size:18px;display:block;float:left;margin-left:5px"><?php echo $this->_var['cat_name5']; ?></a>
				<span>>></span>
			</div>
			<div style="padding-top:10px">
				<ul style="list-style:none;" id="tab2">
				<?php $_from = $this->_var['article_list5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article_list5'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list5']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article_list5']['iteration']++;
?>
					<li style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
						<span style="float:right;font-size:14px"><?php echo $this->_var['article']['formed_add_time']; ?></span>
						<a href="user.php?login_status=2&art_id=<?php echo $this->_var['article']['article_id']; ?>" style="height: 36px;font-size: 14px;display: block;padding-left: 18px;background: url(themes/ecmoban_jumei/images/ico-arrow.png) no-repeat left 5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="a_shadow"><?php echo $this->_var['article']['title']; ?></a>
					</li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
			</div>
		</div><div class="clearfix"></div>
	</div>
</div>




<div style="width:100%;padding-top:15px;padding-bottom:25px">
	<div class="block">
		<span style="font-size:18px;">热门项目</span>
		<!--<a href="http://zhengjinnet.com/user.php?login_status=1">-->
		<a href="category-5-3-0-0.html">
			<img style="display:block;margin:0 auto;margin-top:10px;" src="themes/ecmoban_jumei/images/best_good.png">
		</a>
		<!--
		<a>
			<img style="display:block;margin:0 auto;margin-top:30px;" src="themes/ecmoban_jumei/images/wygood.png">
		</a>
		-->
		<a>
			<img style="display:block;margin:0 auto;margin-top:30px;" src="themes/ecmoban_jumei/images/yuyao.png">
		</a>
		
		
		
		
		
		
		<div style="overflow:hidden;margin-top:15px">
			<ul style="width:1116px">
		<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
		<?php if ($this->_var['goods']['goods_status'] == 1): ?>
				<li class="box_shadow2">
					<div style="height: 36px;line-height: 36px;font-size: 18px;font-weight: normal;text-align: center;margin-top: 10px;">
						<a style="color:#333" href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a>
					</div>
					<center>
						<span style="width: 83px;padding: 0;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background-color: #7fcef4;color: #fff;height: 21px;line-height: 21px;font-size: 12px;padding: 0 5px;display: inline-block;text-align: center;"><?php echo $this->_var['goods']['cat_name']; ?></span>
					</center>
					<div style="border-width: 1px 0;border-style: solid;border-color: #dcdcdc;padding: 26px 0;margin-top: 22px;">
						<div style="float:left">
							<p style="font-size:30px;color: #e34949"><?php echo $this->_var['goods']['goods_interest_rate']; ?>%</p>
							<p style="font-size:14px;color: #888">预期年化收益率</p>
						</div>
						<div style="float:right">
							<p style="font-size:30px;color: #e34949"><?php echo $this->_var['goods']['goods_period']; ?></p>
							<p style="font-size:14px;color: #888">计划期限（天）</p>
						</div><div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
					<p style="margin-top:10px">
						<span style="color:#888">起投金额 </span><?php echo $this->_var['goods']['format_goods_min_buy']; ?>元
					</p>
					<div style="height: 11px;background-color: #e5e5e5;margin-top: 10px;">
						<div style="width: <?php echo $this->_var['goods']['rest_rate']; ?>%;height: 11px;background-color: #f93535;margin:0 0">
						</div>
					</div>
					<p style="color:#888;margin-top:5px">
						<span style="float:left">已售<?php echo $this->_var['goods']['rest_rate']; ?>%</span>
						<span style="float:right">剩余：<?php echo $this->_var['goods']['format_goods_rest_number']; ?><span style="font-weight:normal">元</span></span>
					</p>
					<div class="clearfix"></div>
					<a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" style="" class="index_button">
					<?php if ($this->_var['is_seller']): ?>立即投资<?php else: ?>立即预约<?php endif; ?>
					</a>
				</li>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 2): ?>
				<li class="box_shadow2">
					<div style="height: 36px;line-height: 36px;font-size: 18px;font-weight: normal;text-align: center;margin-top: 10px;">
						<a style="color:#333" href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a>
					</div>
					<center>
						<span style="width: 83px;padding: 0;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background-color: #787878;color: #fff;height: 21px;line-height: 21px;font-size: 12px;padding: 0 5px;display: inline-block;text-align: center;"><?php echo $this->_var['goods']['cat_name']; ?></span>
					</center>
					<div style="border-width: 1px 0;border-style: solid;border-color: #dcdcdc;padding: 26px 0;margin-top: 22px;">
						<div style="float:left">
							<p style="font-size:30px;color: #333"><?php echo $this->_var['goods']['goods_interest_rate']; ?>%</p>
							<p style="font-size:14px;color: #888">预期年化收益率</p>
						</div>
						<div style="float:right">
							<p style="font-size:30px;color: #333"><?php echo $this->_var['goods']['goods_period']; ?></p>
							<p style="font-size:14px;color: #888">计划期限（天）</p>
						</div><div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
					<p style="margin-top:10px">
						<span style="color:#888">起投金额</span><?php echo $this->_var['goods']['goods_min_buy']; ?>元
					</p>
					<div style="height: 11px;background-color: #e5e5e5;margin-top: 10px;">

					</div>
					<p style="color:#888;margin-top:5px">
						<span style="float:left">已售<?php echo $this->_var['goods']['rest_rate']; ?>%</span>
						<span style="float:right">剩余：<?php echo $this->_var['goods']['goods_rest_number']; ?><span style="font-weight:normal">元</span></span>
					</p>
					<div class="clearfix"></div>
					<a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" style="width: 100%;height: 33px;line-height: 33px;text-align: center;font-size: 18px;padding: 0;border: 1px solid #a0a0a0;background: #a0a0a0;color: #fff;cursor: pointer;	outline: none;transition: all ease-in-out 0.15s;border-radius: 3px;margin-top:20px;display: inline-block;" >已售罄</a>
					<div style="position: absolute;right: 15px;bottom: 50px;"><img src="themes/ecmoban_jumei/images/seal-ytm.png"></div>
				</li>
				
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 0): ?>
				<li class="box_shadow2">
					<div style="height: 36px;line-height: 36px;font-size: 18px;font-weight: normal;text-align: center;margin-top: 10px;">
						<a style="color:#333" href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a>
					</div>
					<center>
						<span style="width: 83px;padding: 0;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background-color: #787878;color: #fff;height: 21px;line-height: 21px;font-size: 12px;padding: 0 5px;display: inline-block;text-align: center;"><?php echo $this->_var['goods']['cat_name']; ?></span>
					</center>
					<div style="border-width: 1px 0;border-style: solid;border-color: #dcdcdc;padding: 26px 0;margin-top: 22px;">
						<div style="float:left">
							<p style="font-size:30px;color: #333"><?php echo $this->_var['goods']['goods_interest_rate']; ?>%</p>
							<p style="font-size:14px;color: #888">预期年化收益率</p>
						</div>
						<div style="float:right">
							<p style="font-size:30px;color: #333"><?php echo $this->_var['goods']['goods_period']; ?></p>
							<p style="font-size:14px;color: #888">计划期限（天）</p>
						</div><div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
					<p style="margin-top:10px">
						<span style="color:#888">起投金额</span><?php echo $this->_var['goods']['goods_min_buy']; ?>元
					</p>
					<div style="height: 11px;background-color: #e5e5e5;margin-top: 10px;">

					</div>
					<p style="color:#888;margin-top:5px">
						<span style="float:left">已售<?php echo $this->_var['goods']['rest_rate']; ?>%</span>
						<span style="float:right">剩余：<?php echo $this->_var['goods']['goods_rest_number']; ?><span style="font-weight:normal">元</span></span>
					</p>
					<div class="clearfix"></div>
					<a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" style="width: 100%;height: 33px;line-height: 33px;text-align: center;font-size: 18px;padding: 0;border: 1px solid #a0a0a0;background: #a0a0a0;color: #fff;cursor: pointer;	outline: none;transition: all ease-in-out 0.15s;border-radius: 3px;margin-top:20px;display: inline-block;" ><?php echo $this->_var['goods']['formed_start_time']; ?> 开始</a>
				</li>
				
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	
			</ul>
		</div>
	</div>
</div>
<script>
	function hover1(){
		document.getElementById('tab1').style.display='';
		document.getElementById('tab2').style.display='none';
		document.getElementById('label1').style.color='#d01a0b';
		document.getElementById('label2').style.color='#666';
	}
	function hover2(){
		document.getElementById('tab1').style.display='none';
		document.getElementById('tab2').style.display='';
		document.getElementById('label1').style.color='#666';
		document.getElementById('label2').style.color='#d01a0b';
	}
	function hover3(){
		document.getElementById('tab3').style.display='';
		document.getElementById('tab4').style.display='none';
		document.getElementById('label3').style.color='#d01a0b';
		document.getElementById('label4').style.color='#666';
	}
	function hover4(){
		document.getElementById('tab3').style.display='none';
		document.getElementById('tab4').style.display='';
		document.getElementById('label3').style.color='#666';
		document.getElementById('label4').style.color='#d01a0b';
	}

</script>
<div class="clearfix"></div><div style="background-color:#fff;width:100%;padding-top:15px">
	<div class="block">
		<div style="padding-left: 0;border-left: none;margin: 10px 0;width: 50%;float: left;box-sizing: border-box;padding: 0 30px;">
			<div style="height: 55px;line-height: 55px;font-size: 18px;font-weight:bold;">
				<img style="margin-top:18px;display:block;float:left;" src="themes/ecmoban_jumei/images/squr_icon.png"/>
				<a id="label1" href="article_cat-29.html" style="font-size:18px;display:block;float:left;margin-left:5px;" onmouseover="hover1()"><?php echo $this->_var['cat_name6']; ?></a>
				<span>>></span>
			</div>
			<style>
				.a_shadow{color:#333;}
				.a_shadow:hover{color:#d01a0b;}
			</style>
			<div style="padding-top:10px">
				<ul style="list-style:none" id="tab1">
				<?php $_from = $this->_var['article_list6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article_list6'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list6']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article_list6']['iteration']++;
?>
					<li style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
						<span style="float:right;font-size:14px"><?php echo $this->_var['article']['formed_add_time']; ?></span>
						<a href="article-<?php echo $this->_var['article']['article_id']; ?>.html" style="height: 36px;font-size: 14px;display: block;padding-left: 18px;background: url(themes/ecmoban_jumei/images/ico-arrow.png) no-repeat left 5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="a_shadow"><?php echo $this->_var['article']['title']; ?></a>
					</li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
			</div>
		</div>
		<div style="padding-left: 0;margin: 10px 0;width: 50%;float: right;box-sizing: border-box;padding: 0 30px;border-left: 1px dashed #cacaca;">
			<div style="height: 55px;line-height: 55px;font-size: 18px;font-weight:bold;">
				<img style="margin-top:18px;display:block;float:left;" src="themes/ecmoban_jumei/images/squr_icon.png"/>
				<a id="label3" href="article_cat-22.html" style="font-size:18px;display:block;float:left;margin-left:5px;" onmouseover="hover3()"><?php echo $this->_var['cat_name7']; ?></a>
				<span>>></span>
			</div>
			<div style="padding-top:10px">
				<ul style="list-style:none" id="tab3">
				<?php $_from = $this->_var['article_list7']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article_list7'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list7']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article_list7']['iteration']++;
?>
					<li style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
						<span style="float:right;font-size:14px"><?php echo $this->_var['article']['formed_add_time']; ?></span>
						<a href="article-<?php echo $this->_var['article']['article_id']; ?>.html" style="height: 36px;font-size: 14px;display: block;padding-left: 18px;background: url(themes/ecmoban_jumei/images/ico-arrow.png) no-repeat left 5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="a_shadow"><?php echo $this->_var['article']['title']; ?></a>
					</li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
			</div>
		</div><div class="clearfix"></div>
	</div>
</div>
<div style="background: #fff;font-size: 0;padding-bottom: 20px;padding-top:10px">
	<div class="block">
		<div style="font-size: 18px;height: 60px;line-height: 60px;color:#000">
			合作伙伴
		</div>
		<a href="javascript:void(0)" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/04.png">
		</a>
		<a target="blank" href="http://www.gfae.com.cn" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/02.jpg" style="width:138px;height:45px">
		</a>
		<a target="blank" href="http://www.gfae.com.cn" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/03.jpg" style="width:138px;height:45px">
		</a>
		<a target="blank" href="http://www.ccb.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/01.png">
		</a>
		<a target="blank" href="http://www.fuioupay.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/05.png">
		</a>
		<a target="blank" href="http://www.boss-young.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/06.png">
		</a>
		<a target="blank" href="http://www.ancun.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/07.png">
		</a>
		<a href="javascript:void(0)" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/08.png">
		</a>
		<a target="blank" href="http://www.chenghuicpa.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/09.png">
		</a>
		<a target="blank" href="http://www.neafex.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/10.png">
		</a>
		<a target="blank" href="http://www.teeshare.cn" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/11.png">
		</a>
		<a target="blank" href="http://www.hnexchange.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/12.png">
		</a>
		<a target="blank" href="http://www.attorney.sh.cn" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/13.png">
		</a>
		<a target="blank" href="http://www.hhansh.com" style="margin-bottom: 5px;margin-right: 14px;display: inline-block;">
			<img src="themes/ecmoban_jumei/images/14.png">
		</a>
	</div>
	
</div>
<div class="clearfix"></div>
<div style="background: #fff;font-size: 0;padding-bottom: 20px;padding-top:10px">
	<div class="block">
		<div style="font-size: 18px;height: 60px;line-height: 60px;color:#000">
			友情链接
		</div>
		<a href="http://www.01caijing.com/ " style="margin-right: 14px;display: inline-block;margin-bottom: 5px;font-size: 16px;">零壹财经</a>
		<span style="display: inline-block;margin-bottom: 5px;font-size: 16px;">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<a href="https://www.okcoin.cn/" style="margin-right: 14px;display: inline-block;margin-bottom: 5px;font-size: 16px;">okcoin</a>
		<span style="display: inline-block;margin-bottom: 5px;font-size: 16px;">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<a href="http://www.ancun.com/ " style="margin-right: 14px;display: inline-block;margin-bottom: 5px;font-size: 16px;">数据保全</a>
		<span style="display: inline-block;margin-bottom: 5px;font-size: 16px;">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<a href="https://www.51cunzheng.com/ " style="margin-right: 14px;display: inline-block;margin-bottom: 5px;font-size: 16px;">数据公证</a>
		<span style="display: inline-block;margin-bottom: 5px;font-size: 16px;">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<a href="http://www.mingin.com/" style="margin-right: 14px;display: inline-block;margin-bottom: 5px;font-size: 16px;">鸣金网</a>
	</div>
</div>


<script type="text/javascript">

 
 
</script>






<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
