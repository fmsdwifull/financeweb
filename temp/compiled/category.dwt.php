<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<?php if ($this->_var['cat_style']): ?>
<link href="<?php echo $this->_var['cat_style']; ?>" rel="stylesheet" type="text/css" />
<?php endif; ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
</head>
<body style="background-color:#ecedee;font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;font-size:16px">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/right_link.lbi'); ?>

<?php if ($this->_var['page_type'] == 1): ?>
<div style="height: 370px;background: #f14747 url(data/afficheimg/<?php echo $this->_var['banner1']['ad_code']; ?>) no-repeat center center;">
</div>
<div class="block clearfix" style="background-color:#ecedee;">
	<div style="margin-top: 20px;width: 1100px;margin-left: auto;margin-right: auto;">
		<div style="position: relative;border-top: 1px solid #d8d8d8;margin: 50px 0 40px 0;">
			<div style="font-size: 24px;font-weight: normal;color: #888;padding: 0 10px;background: #efefef;position: absolute;left: 20px;bottom: 50%;margin-bottom: -12px;">
				<?php if ($this->_var['category'] == 1): ?>新手专享<?php endif; ?><?php if ($this->_var['category'] == 3): ?>VIP专享<?php endif; ?><?php if ($this->_var['category'] == 1): ?><small style="margin-left: 10px;color: #888;font-size: 12px;">（新用户福利，限投一次）</small><?php endif; ?>
			</div>
		</div>
		
	</div>

<style>
	.box_shadow:hover{
		background: #f7f7f7;
	}	
</style>
<style>
	.box_shadow2:hover{background-color:#d31600;}
	.box_shadow2{background: #f62d0a;}
</style>
<div style="background: #ffffff;border: 1px solid #e1e1e1;-webkit-box-shadow: 0 2px 1px 0 rgb( 231, 231, 231 );-moz-box-shadow: 0 2px 1px 0 rgb( 231, 231, 231 );box-shadow: 0 2px 1px 0 rgb( 231, 231, 231 );">
	<ul style="list-style:none">
		<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
		<li style="position: relative;padding: 20px;border-bottom: 1px solid #ededed" class="box_shadow">
			<a href="<?php echo $this->_var['goods']['url']; ?>" style="color: #333;text-decoration: none;">
				<div style="font-size: 18px;font-weight: normal;height: 50px;">
					<?php echo $this->_var['goods']['goods_name']; ?>
				</div>
			</a>	
			<p style="font-size: 14px;color: #888;">
				<span style="color: #e34949;font-size: 24px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?></span>
				<span style="color: #e34949;font-size: 14px;">%</span>
				 预期年化收益率
			</p>
			<p style="left: 250px;position: absolute;bottom: 20px;font-size: 14px;color: #888;">
				<span style="color: #333;font-size: 24px;"><?php echo $this->_var['goods']['goods_period']; ?></span>
				<span style="color: #333;font-size: 14px;">天</span>
				 产品期限			
			</p>
			<p style="left: 435px;position: absolute;bottom: 20px;font-size: 14px;color: #888;">
				<span style="color: #333;font-size: 24px;"><?php echo $this->_var['goods']['format_goods_min_buy']; ?></span>
				<span style="color: #333;font-size: 14px;">元</span>
				起投		
			</p>
			<div style="width: 180px;position: absolute;bottom: 20px;right: 206px;">
				<div style="background: #e1dbd3;height: 6px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;">
					<div style="width: <?php echo $this->_var['goods']['goods_rest_rate']; ?>%;background: #ff8a44;height: 6px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;margin:0 0">
					</div>
				</div>
				<p style="color: #888;font-size: 12px;margin-top: 10px;">已售：<?php echo $this->_var['goods']['goods_rest_rate']; ?>%，剩余：<?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</p>
			</div>
		<?php if ($this->_var['goods']['goods_status'] == 0): ?>	
			<a href="<?php echo $this->_var['goods']['url']; ?>" style="position: absolute;right: 20px;bottom: 20px;width: 110px;height: 40px;text-align: center;line-height: 40px;font-size: 14px;color: #ffffff;padding: 0;border-radius: 3px;background-color:#b6b5b6;cursor:default">未开始</a>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 1): ?>	
			<a href="<?php echo $this->_var['goods']['url']; ?>" style="position: absolute;right: 20px;bottom: 20px;width: 110px;height: 40px;text-align: center;line-height: 40px;font-size: 14px;color: #ffffff;padding: 0;border-radius: 3px;" class="box_shadow2"><?php if ($this->_var['is_seller']): ?>立即投资<?php else: ?>立即预约<?php endif; ?></a>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 2): ?>	
			<a href="<?php echo $this->_var['goods']['url']; ?>" style="position: absolute;right: 20px;bottom: 20px;width: 110px;height: 40px;text-align: center;line-height: 40px;font-size: 14px;color: #ffffff;padding: 0;border-radius: 3px;background-color:#b6b5b6;cursor:default">已投满</a>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 3): ?>	
			<a href="<?php echo $this->_var['goods']['url']; ?>" style="position: absolute;right: 20px;bottom: 20px;width: 110px;height: 40px;text-align: center;line-height: 40px;font-size: 14px;color: #ffffff;padding: 0;border-radius: 3px;background-color:#b6b5b6;cursor:default">已截止</a>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 4): ?>	
			<a href="<?php echo $this->_var['goods']['url']; ?>" style="position: absolute;right: 20px;bottom: 20px;width: 110px;height: 40px;text-align: center;line-height: 40px;font-size: 14px;color: #ffffff;padding: 0;border-radius: 3px;background-color:#b6b5b6;cursor:default">已结清</a>
		<?php endif; ?>
		</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

	</ul>
</div>



<div style="width:100%;height:30px"></div>
</div>
<div class="blank5"></div>
<script type="Text/Javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>
<script type="text/javascript">
window.onload = function()
{
  Compare.init();
  fixpng();
}
<?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
<?php if ($this->_var['key'] != 'button_compare'): ?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php else: ?>
var button_compare = '';
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>


<?php endif; ?>
<?php if ($this->_var['page_type'] == 2): ?>
<style>
	.box_shadow4{background-position: left top;}
	.box_shadow4:hover{background-position: left bottom;}
	.box_shadow5{background-position: right top;}
	.box_shadow5:hover{background-position: right bottom;}
	.box_shadow6{height:auto}
	.box_shadow7{height:0}
</style>
<style>
	.select_a{display: inline-block;padding-left: 20px;padding-right: 20px;height: 27px;line-height: 27px;border-radius: 3px;margin-left: 10px;}
	.active{background-color: #d01a0b;color: #fff;}
</style>
<script>
	function click_button(){
		if (document.getElementById("button1").className=="box_shadow4"){
			document.getElementById("button1").className="box_shadow5";
			document.getElementById("content1").className="box_shadow7";
			document.getElementById("content2").style.display="";
		}else{
			document.getElementById("button1").className="box_shadow4";
			document.getElementById("content1").className="box_shadow6";
			document.getElementById("content2").style.display="none";
		}
	}
</script>
<div class="block clearfix" style="background-color:#ecedee;">
	<div style= "height: 50px;line-height: 50px;font-size: 14px;color: #666;">
		<a href="index.php" style="color:#666">政金网</a> &nbsp; &gt;&nbsp;&nbsp; 理财频道
	</div>
	<div style="position: relative;background-color: #fff;">
		<button style="position: absolute;top: -26px;right: 0;background-color: #fff;width: 45px;height: 26px;border: none;background-image: url(themes/ecmoban_jumei/images/btn-extend-bg.png);background-repeat: no-repeat;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" class="box_shadow4" onclick="click_button()" id="button1"></button>
		<div style="overflow:hidden;transition: all ease-in-out 0.15s;display:none" class="box_shadow6" id="content2">
			<dl style="padding: 20px;">
				<dt style="line-height: 27px;float: left;color:#111"></dt>
				<?php if ($this->_var['category'] == 5): ?>
				<a href="javascript:void(0)" class="active select_a"><?php if ($this->_var['url_project'] == 0): ?>不限<?php endif; ?><?php if ($this->_var['url_project'] == 2): ?>民生系列<?php endif; ?><?php if ($this->_var['url_project'] == 3): ?>基建系列<?php endif; ?></a>
				<?php endif; ?>
				<a href="javascript:void(0)" class="active select_a"><?php if ($this->_var['url_period'] == 0): ?>不限<?php endif; ?><?php if ($this->_var['url_period'] == 1): ?>半年<?php endif; ?><?php if ($this->_var['url_period'] == 2): ?>一年<?php endif; ?><?php if ($this->_var['url_period'] == 3): ?>一年半<?php endif; ?><?php if ($this->_var['url_period'] == 4): ?>2年<?php endif; ?><?php if ($this->_var['url_period'] == 5): ?>2年以上<?php endif; ?></a>
				<a href="javascript:void(0)" class="active select_a"><?php if ($this->_var['url_status'] == 0): ?>不限<?php endif; ?><?php if ($this->_var['url_status'] == 1): ?>即将发行<?php endif; ?><?php if ($this->_var['url_status'] == 2): ?>正在发行<?php endif; ?><?php if ($this->_var['url_status'] == 3): ?>已截止<?php endif; ?><?php if ($this->_var['url_status'] == 4): ?>已售罄<?php endif; ?><?php if ($this->_var['url_status'] == 5): ?>已结清<?php endif; ?></a>
			</dl>
		</div>
		<div style="overflow:hidden;transition: all ease-in-out 0.15s;" class="box_shadow6" id="content1">
		<dl style="padding: 20px;">
			<?php if ($this->_var['category'] == 5): ?>
			<dt style="line-height: 27px;float: left;color:#111">系列：</dt>
			<dd style="height:45px">
				<a href="category-5-0-<?php echo $this->_var['url_period']; ?>-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_project'] == 0): ?>active<?php endif; ?> select_a">不限</a>
				
				<a href="category-5-2-<?php echo $this->_var['url_period']; ?>-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_project'] == 2): ?>active<?php endif; ?> select_a">民生系列</a>
				<a href="category-5-3-<?php echo $this->_var['url_period']; ?>-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_project'] == 3): ?>active<?php endif; ?> select_a">基建系列</a>
			</dd>
			<?php endif; ?>
			<dt style="line-height: 27px;float: left;color:#111">期限：</dt>
			<dd style="height:45px">
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-0-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_period'] == 0): ?>active<?php endif; ?> select_a">不限</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-1-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_period'] == 1): ?>active<?php endif; ?> select_a">半年</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-2-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_period'] == 2): ?>active<?php endif; ?> select_a">一年</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-3-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_period'] == 3): ?>active<?php endif; ?> select_a">一年半</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-4-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_period'] == 4): ?>active<?php endif; ?> select_a">2年</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-5-<?php echo $this->_var['url_status']; ?>.html" class="<?php if ($this->_var['url_period'] == 5): ?>active<?php endif; ?> select_a">2年以上</a>
			</dd>
			<dt style="line-height: 27px;float: left;color:#111">状态：</dt>
			<dd style="height:45px">
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-<?php echo $this->_var['url_period']; ?>-0.html" class="<?php if ($this->_var['url_status'] == 0): ?>active<?php endif; ?> select_a">不限</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-<?php echo $this->_var['url_period']; ?>-1.html" class="<?php if ($this->_var['url_status'] == 1): ?>active<?php endif; ?> select_a">即将发行</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-<?php echo $this->_var['url_period']; ?>-2.html" class="<?php if ($this->_var['url_status'] == 2): ?>active<?php endif; ?> select_a">正在发行</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-<?php echo $this->_var['url_period']; ?>-3.html" class="<?php if ($this->_var['url_status'] == 3): ?>active<?php endif; ?> select_a">已截止</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-<?php echo $this->_var['url_period']; ?>-4.html" class="<?php if ($this->_var['url_status'] == 4): ?>active<?php endif; ?> select_a">已售罄</a>
				<a href="category-5-<?php echo $this->_var['url_project']; ?>-<?php echo $this->_var['url_period']; ?>-5.html" class="<?php if ($this->_var['url_status'] == 5): ?>active<?php endif; ?> select_a">已结清</a>
			</dd>
		</dl>
		</div>
	</div>
	<div style="margin-top: 30px;margin-bottom: 20px;">
		<h2 style="height: 60px;line-height: 60px;font-size: 30px;font-weight: normal;">
			项目列表
			<ul style="font-size: 18px;color: #111;float: right;list-style: none;">
				<li style="float: left;line-height: 25px;text-align: left;padding-left: 30px;padding-right: 30px;position: relative;">
					<p style="font-size: 14px;color: #888;">累积成交总额</p>
					<p><?php echo $this->_var['total_amount']; ?> 元</p>
				</li>
				<li style="padding-right: 0;float: left;line-height: 25px;text-align: left;padding-left: 30px;position: relative;">
					<p style="font-size: 14px;color: #888;">用户收益</p>
					<p><?php echo $this->_var['total_earn']; ?>&nbsp;元</p>
				</li>
			</ul>
		</h2>
		<style>
			.box_shadow9{background-color: #fff;}
			.box_shadow9:hover{background-color: #fbfbea;}
			.box_shadow9:hover .box_shadow8:hover{background-color: #d01a0b;border-color: #d01a0b;color: #fff;}
			.box_shadow9:hover .box_shadow8 {background-color: #f3301f;border-color: #f3301f;color: #fff;}
			.box_shadow8{color: #d01a0b;background: #fff;border: 1px solid #d5d5d5;}
			
		</style>
		<div style="background-color: #ededed;">
		<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
		<?php if ($this->_var['goods']['goods_status'] == 0): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;color:#bbb">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<a href="<?php echo $this->_var['goods']['url']; ?>" style="text-decoration: none;color:#bbb"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
								<p style="font-size: 14px;">金额<em><?php echo $this->_var['goods']['goods_total_number']; ?>元</em>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong style="font-size: 30px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['format_goods_min_buy']; ?></strong>元
								</p>
								<p style="font-size: 14px;">
									最低投资金额
								</p>
							</td>
							<td style="width:9%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_period']; ?></strong>天
								</p>
								<p style="font-size: 14px;">
									计划期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_level']; ?></strong>
								</p>
								<p style="font-size: 14px;">参考评级</p>
							</td>
							<td style="width:17%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 14px;">
									剩余金额：<em style="font-style: normal;"><?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</em>
								</p>
								<p style="font-size: 14px;">
									距离开始时间：
									<em style="font-style: normal;"><?php echo $this->_var['goods']['goods_waiting_hour']; ?></em>
									小时
									<em style="font-style: normal;"><?php echo $this->_var['goods']['goods_waiting_minute']; ?></em>
									分
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="<?php echo $this->_var['goods']['url']; ?>" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;background: #c5c9cc;color:#fff;border: 1px solid #c5c9cc;">未开始</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 1): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<a href="<?php echo $this->_var['goods']['url']; ?>" style="color: #333;text-decoration: none;"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
								<p style="font-size: 14px;">金额<em style="color:#e34949;"><?php echo $this->_var['goods']['goods_total_number']; ?>元</em>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;color: #e34949;font-size: 18px;">
									<strong style="font-size: 30px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="color: #666;font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['format_goods_min_buy']; ?></strong>元
								</p>
								<p style="color: #666;font-size: 14px;">
									最低投资金额
								</p>
							</td>
							<td style="width:9%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_period']; ?></strong>天
								</p>
								<p style="color: #666;font-size: 14px;">
									计划期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_level']; ?></strong>
								</p>
								<p style="color: #666;font-size: 14px;">参考评级</p>
							</td>
							<td style="width:17%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 14px;">
									剩余金额：<em style="color: #e34949;font-style: normal;"><?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</em>
								</p>
								<p style="font-size: 14px;">
									剩余时间：
									<em style="color: #e34949;font-style: normal;"><?php echo $this->_var['goods']['goods_rest_hour']; ?></em>
									小时
									<em style="color: #e34949;font-style: normal;"><?php echo $this->_var['goods']['goods_rest_minute']; ?></em>
									分
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="<?php echo $this->_var['goods']['url']; ?>" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;" class="box_shadow8"><?php if ($this->_var['is_seller']): ?>立即投资<?php else: ?>立即预约<?php endif; ?></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 2): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;color:#bbb">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<a href="<?php echo $this->_var['goods']['url']; ?>" style="text-decoration: none;color:#bbb"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
								<p style="font-size: 14px;">金额<em><?php echo $this->_var['goods']['goods_total_number']; ?>元</em>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong style="font-size: 30px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['format_goods_min_buy']; ?></strong>元
								</p>
								<p style="font-size: 14px;">
									最低投资金额
								</p>
							</td>
							<td style="width:9%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_period']; ?></strong>天
								</p>
								<p style="font-size: 14px;">
									计划期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_level']; ?></strong>
								</p>
								<p style="font-size: 14px;">参考评级</p>
							</td>
							<td style="width:17%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 14px;">
									剩余金额：<em style="font-style: normal;"><?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</em>
								</p>
								<p style="font-size: 14px;">
									剩余时间：
									<em style="font-style: normal;"><?php echo $this->_var['goods']['goods_rest_hour']; ?></em>
									小时
									<em style="font-style: normal;"><?php echo $this->_var['goods']['goods_rest_minute']; ?></em>
									分
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="<?php echo $this->_var['goods']['url']; ?>" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;background: #c5c9cc;color:#fff;border: 1px solid #c5c9cc;">已售罄</a>
							</td>
						</tr>
					</tbody>
				</table>
				<div style="width: 100px;height: 100%;background: url(themes/ecmoban_jumei/images/mf-p.png) no-repeat center center;position: absolute;top: 0;right: 110px;z-index: 200;box-sizing: border-box;">
				</div>
			</div>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 3): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;color:#bbb">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<a href="<?php echo $this->_var['goods']['url']; ?>" style="text-decoration: none;color:#bbb"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
								<p style="font-size: 14px;">金额<em><?php echo $this->_var['goods']['goods_total_number']; ?>元</em>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong style="font-size: 30px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['format_goods_min_buy']; ?></strong>元
								</p>
								<p style="font-size: 14px;">
									最低投资金额
								</p>
							</td>
							<td style="width:9%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_period']; ?></strong>天
								</p>
								<p style="font-size: 14px;">
									计划期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_level']; ?></strong>
								</p>
								<p style="font-size: 14px;">参考评级</p>
							</td>
							<td style="width:17%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 14px;">
									剩余金额：<em style="font-style: normal;"><?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</em>
								</p>
								<p style="font-size: 14px;">
									剩余时间：
									<em style="font-style: normal;">0</em>
									小时
									<em style="font-style: normal;">0</em>
									分
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="<?php echo $this->_var['goods']['url']; ?>" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;background: #c5c9cc;color:#fff;border: 1px solid #c5c9cc;">已截止</a>
							</td>
						</tr>
					</tbody>
				</table>
				<div style="width: 100px;height: 100%;background: url(themes/ecmoban_jumei/images/stop2.png) no-repeat center center;position: absolute;top: 0;right: 110px;z-index: 200;box-sizing: border-box;">
				</div>
			</div>
		<?php endif; ?>
		<?php if ($this->_var['goods']['goods_status'] == 4): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;color:#bbb">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<a href="<?php echo $this->_var['goods']['url']; ?>" style="text-decoration: none;color:#bbb"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
								<p style="font-size: 14px;">金额<em><?php echo $this->_var['goods']['goods_total_number']; ?>元</em>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong style="font-size: 30px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['format_goods_min_buy']; ?></strong>元
								</p>
								<p style="font-size: 14px;">
									最低投资金额
								</p>
							</td>
							<td style="width:9%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_period']; ?></strong>天
								</p>
								<p style="font-size: 14px;">
									计划期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 20px;">
									<strong><?php echo $this->_var['goods']['goods_level']; ?></strong>
								</p>
								<p style="font-size: 14px;">参考评级</p>
							</td>
							<td style="width:17%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 14px;">
									剩余金额：<em style="font-style: normal;"><?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</em>
								</p>
								<p style="font-size: 14px;">
									剩余时间：
									<em style="font-style: normal;">0</em>
									小时
									<em style="font-style: normal;">0</em>
									分
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="<?php echo $this->_var['goods']['url']; ?>" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;background: #c5c9cc;color:#fff;border: 1px solid #c5c9cc;">已结清</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	</div>









	
<div style="width:100%;height:30px"></div>
</div>
<div class="blank5"></div>
<script type="Text/Javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>
<script type="text/javascript">
	
	function show_block(key){
		
		document.getElementById("b_1").style.display="none";
		document.getElementById("b_2").style.display="none";
		document.getElementById("b_3").style.display="none";
		document.getElementById("b_4").style.display="none";
		
		
		
		document.getElementById("bt_1").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_2").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_3").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_4").style.backgroundColor="#7a6e6e";
		
		if(key==1){
			document.getElementById("b_1").style.display="";
			document.getElementById("bt_1").style.backgroundColor="red";
		}
		if(key==2){
			document.getElementById("b_2").style.display="";
			document.getElementById("bt_2").style.backgroundColor="red";
		}
		if(key==3){
			document.getElementById("b_3").style.display="";
			document.getElementById("bt_3").style.backgroundColor="red";
		}
		if(key==4){
			document.getElementById("b_4").style.display="";
			document.getElementById("bt_4").style.backgroundColor="red";
		}
		
	}


	
window.onload = function()
{
	var oTop = document.getElementById("b_4");
	  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
	  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
	  oTop.style.left = screenw - oTop.offsetWidth +"px";
	  oTop.style.top = screenh - oTop.offsetHeight + "px";
	  window.onscroll = function(){
		var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
		oTop.style.top = screenh - oTop.offsetHeight + scrolltop +"px";
	  }
	  oTop.onclick = function(){
		document.documentElement.scrollTop = document.body.scrollTop =0;
	  }
	  
	  var oTop = document.getElementById("bt_4");
	  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
	  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
	  oTop.style.left = screenw - oTop.offsetWidth +"px";
	  oTop.style.top = screenh - oTop.offsetHeight + "px";
	  window.onscroll = function(){
		var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
		oTop.style.top = screenh - oTop.offsetHeight + scrolltop +"px";
	  }
	  oTop.onclick = function(){
		document.documentElement.scrollTop = document.body.scrollTop =0;
	  }

	
	
  Compare.init();
  fixpng();
}
<?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
<?php if ($this->_var['key'] != 'button_compare'): ?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php else: ?>
var button_compare = '';
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>





<?php endif; ?>
<div style="width:1100px;margin:0 auto">
<?php echo $this->fetch('library/pages.lbi'); ?>

<div class="clearfix"></div>
</div>
<div style="height:10px;width:100%"></div>
  </div>  
  
</div>

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
