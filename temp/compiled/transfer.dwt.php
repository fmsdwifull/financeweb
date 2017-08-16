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
	
	window.onload=function(){
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
		
	}
</script>
<div class="block clearfix" style="background-color:#ecedee;">
	<div style= "height: 50px;line-height: 50px;font-size: 14px;color: #666;">
		<a href="index.php" style="color:#666">政金网</a> &nbsp; &gt;&nbsp;&nbsp; 转让专区
	</div>

	<div style="margin-top: 30px;margin-bottom: 20px;">
		<h2 style="height: 60px;line-height: 60px;font-size: 30px;font-weight: normal;">
			转让列表
			<ul style="font-size: 18px;color: #111;float: right;list-style: none;">
				<li style="float: left;line-height: 25px;text-align: left;padding-left: 30px;padding-right: 30px;position: relative;">
					<p style="font-size: 14px;color: #888;">累积成交总额</p>
					<p><?php echo $this->_var['total_amount']; ?>元</p>
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
		<?php $_from = $this->_var['transfer_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['transfer_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['transfer_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['transfer_list']['iteration']++;
?>
		<?php if ($this->_var['goods']['transfer_flag'] == 2): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;color:#bbb">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<a href="transfer_detail.php?order_id=<?php echo $this->_var['goods']['order_id']; ?>" style="color:#bbb;text-decoration: none;"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong style="font-size:20px"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong><?php echo $this->_var['goods']['transfer_value']; ?></strong>元
								</p>
								<p style="font-size: 14px;">
									项目价值
								</p>
							</td>
							<td style="width:13%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 18px;">
									<?php echo $this->_var['goods']['goods_rest_period']; ?>天
								</p>
								<p style="font-size: 14px;">
									剩余投资期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;">
									<?php echo $this->_var['goods']['formed_next_earn_time']; ?>
								</p>
								<p style="font-size: 14px;">预计下一收款日</p>
							</td>
							<td style="width:16%;padding-left: 15px;padding-right: 15px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong><?php echo $this->_var['goods']['formed_transfer_amount']; ?>元</strong>
								</p>
								<p style="font-size: 14px;">
									转让价格
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="javascript:void(0)" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;background: #c5c9cc;color:#fff;border: 1px solid #c5c9cc;">已转让</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<?php if ($this->_var['goods']['transfer_flag'] == 1): ?>	
			<div style="margin-top: 20px;position: relative;" class="box_shadow9">
				<table style="width: 100%;position: relative;z-index: 1;border-collapse: collapse;border-spacing: 0;">
					<tbody>
						<tr>
							<td style="padding-left: 15px;width:20%;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<a href="transfer_detail.php?order_id=<?php echo $this->_var['goods']['order_id']; ?>" style="color: #333;text-decoration: none;"><?php echo $this->_var['goods']['goods_name']; ?></a>
								</p>
								<p style="font-size: 14px;">
									剩余时间：
									<em style="color: #e34949;font-style: normal;"><?php echo $this->_var['goods']['goods_rest_hour']; ?></em>
									小时
									<em style="color: #e34949;font-style: normal;"><?php echo $this->_var['goods']['goods_rest_minute']; ?></em>
									分
								</p>
							</td>
							<td style="width:13%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<p style="line-height: 36px;color: #e34949;font-size: 18px;">
									<strong style="font-size:20px"><?php echo $this->_var['goods']['goods_interest_rate']; ?></strong>%
								</p>
								<p style="color: #666;font-size: 14px;">
									预期年化收益率
								</p>
							</td>
							<td style="width:11%;padding: 0 15px;position: relative;">
								<p style="line-height: 36px;font-size: 18px;">
									<strong><?php echo $this->_var['goods']['transfer_value']; ?></strong>元
								</p>
								<p style="color: #666;font-size: 14px;">
									项目价值
								</p>
							</td>
							<td style="width:13%;padding: 0 15px;">
								<p style="line-height: 36px;font-size: 18px;">
									<?php echo $this->_var['goods']['goods_rest_period']; ?>天
								</p>
								<p style="color: #666;font-size: 14px;">
									剩余投资期限
								</p>
							</td>
							<td style="padding: 0 15px;position: relative;">
								<p style="line-height: 36px;">
									<?php echo $this->_var['goods']['formed_next_earn_time']; ?>
								</p>
								<p style="color: #666;font-size: 14px;">预计下一收款日</p>
							</td>
							<td style="width:16%;padding-left: 15px;padding-right: 15px;position: relative;">
								<p style="line-height: 36px;color: #e34949;font-size: 18px;">
									<strong><?php echo $this->_var['goods']['formed_transfer_amount']; ?>元</strong>
								</p>
								<p style="color: #666;font-size: 14px;">
									转让价格
								</p>
							</td>
							<td style="width:14%;padding-left: 15px;padding-right: 15px;padding-top: 22px;padding-bottom: 27px;position: relative;">
								<a href="transfer_detail.php?order_id=<?php echo $this->_var['goods']['order_id']; ?>" style="width: 120px;height: 45px;line-height: 45px;text-align: center;font-size: 16px;border-radius: 3px;padding: 0;display: inline-block;" class="box_shadow8">立即投资</a>
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

</div>  
</div>

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
