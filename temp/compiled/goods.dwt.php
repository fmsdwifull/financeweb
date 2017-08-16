<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<script src="themes/ecmoban_jumei/js/sms.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8">
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>

<script type="text/javascript" src="themes/ecmoban_jumei/js/action.js"></script>
<script type="text/javascript" src="themes/ecmoban_jumei/js/mzp-packed-me.js"></script>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.json.js"></script>
<script type="text/javascript">
function $id(element) {
  return document.getElementById(element);
}
//切屏--是按钮，_v是内容平台，_h是内容库
function reg(str){
  var bt=$id(str+"_b").getElementsByTagName("h2");
  for(var i=0;i<bt.length;i++){
    bt[i].subj=str;
    bt[i].pai=i;
    bt[i].style.cursor="pointer";
    bt[i].onclick=function(){
      $id(this.subj+"_v").innerHTML=$id(this.subj+"_h").getElementsByTagName("blockquote")[this.pai].innerHTML;
      for(var j=0;j<$id(this.subj+"_b").getElementsByTagName("h2").length;j++){
        var _bt=$id(this.subj+"_b").getElementsByTagName("h2")[j];
        var ison=j==this.pai;
        _bt.className=(ison?"":"h2bg");
      }
    }
  }
  $id(str+"_h").className="none";
  $id(str+"_v").innerHTML=$id(str+"_h").getElementsByTagName("blockquote")[0].innerHTML;
}

</script>

</head>
<body  style="background-color:#ecedee;">
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="block clearfix" style="position:relative">
	<div style="position:fixed;width:1105px;top:5%;z-index:1001;font-family:微软雅黑;display:none" id="pop_window">
	
	<form action="goods.php" method="post">
	<input type="hidden" name="flag" id="flag" value="act_reserve">
	<input type="hidden" name="goods_id" value="<?php echo $this->_var['goods']['goods_id']; ?>">
	<div style="margin-bottom: 60px;margin-top: 30px;width:500px">
		<div style="background-color: #fff;border: 1px solid #e0e0e0;margin-left: auto;margin-right: auto;width:500px">
			<div style="width: 350px;padding-bottom: 20px;margin-left: 50px;float: left;">
				<div style="margin-top:48px;margin-bottom:10px">
					<p style="position: relative;font-size: 32px;color: #aaa;font-family:黑体;font-weight:bold">
						在线预约
					</p>
				</div>
				<div style="font-size:16px;margin-bottom:5px">
					您预约的产品是：<?php echo $this->_var['goods']['goods_name']; ?>
				</div>
				<div style="font-size:16px">
					请您填写以下信息完成预约
				</div>
				<div style="display: table;width: 100%;margin-top: 0px;">
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span>
							 客户姓名：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;padding-top:3px;padding-bottom:3px" placeholder="请填写您的姓名" name="name">
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 手机号码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="text" style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;padding-top:3px;padding-bottom:3px" name="mobile" placeholder="请输入手机号码" id="mobile_phone" onchange="checkForm1()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice1">
								请输入正确手机号码。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;text-align: right;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span> 验证码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="width: 149px;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;float: left;padding-top:3px;padding-bottom:3px" type="text" placeholder="输入验证码" name="mobile_code" id="mobile_code">
							<input style="text-align:center;width: 108px;line-height: 24px;color: #ed8a32;background: #f8eacb;border: 1px solid #f8eacb;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float: right;" id="zphone" name="sendsms" onclick="sendSms();" value="发送验证码">
						</div>
					</div>
					
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 所在区域：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<select name="point" style="width:150px;">
								<option value="2">四川</option>
								<option value="4">上海</option>
								<option value="0">其他</option>
							</select>
						</div>
					</div>
					
					<div style="display: table-row;margin-top:10px">
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
						</div>
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;position: relative;	display: table-cell;vertical-align: middle;">
<style>
	.box_shadow{
		background: #f75151;
	}
	.box_shadow:hover{
		background: #f52020;
	}
	.box_shadow20{
		background: #f62d0a;
	}
	.box_shadow20:hover{
		background: #d31600;
	}
</style>
							
							<input style="width:110px;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border: none;border-radius: 3px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float:left;margin-right:40px" name="Submit" type="submit" value="立即预约" class="box_shadow20">
							<div style="width:110px;text-align:center;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border: none;border-radius: 3px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float:left" class="box_shadow" onclick="document.getElementById('pop_window').style.display='none'">
							取消
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<input name="act" type="hidden" value="act_reserve">
	<input name="enabled_sms" type="hidden" value="1">
	<input type="hidden" name="back_act" value="">
</form>
</div>
<div style="position:fixed;width:1105px;top:5%;z-index:1001;font-family:微软雅黑;display:none" id="pop_window2">
	<form action="goods.php" method="post" >
	<input type="hidden" name="flag" id="flag0" value="act_reserve">
	<input type="hidden" name="goods_id" value="<?php echo $this->_var['goods']['goods_id']; ?>">
	<div style="margin-bottom: 60px;margin-top: 30px;width:500px">
		<div style="background-color: #fff;border: 1px solid #e0e0e0;margin-left: auto;margin-right: auto;width:500px">
			<div style="width: 350px;padding-bottom: 20px;margin-left: 50px;float: left;">
				<div style="margin-top:48px;margin-bottom:10px">
					<p style="position: relative;font-size: 32px;color: #aaa;font-family:黑体;font-weight:bold">
						在线预约
					</p>
				</div>
				<div style="font-size:16px;margin-bottom:5px">
					您预约的产品是：<?php echo $this->_var['goods']['goods_name']; ?>
				</div>
				<div style="font-size:16px">
					请您填写以下信息完成预约
				</div>
				<div style="display: table;width: 100%;margin-top: 0px;">
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span>
							 客户姓名：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;padding-top:3px;padding-bottom:3px" <?php if (! $this->_var['user_info']['true_name']): ?>placeholder="请填写您的姓名"<?php else: ?>value="<?php echo $this->_var['user_info']['true_name']; ?>"<?php endif; ?> name="name">
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 手机号码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="text" style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;padding-top:3px;padding-bottom:3px" name="mobile" value="<?php echo $this->_var['user_info']['user_name']; ?>" id="mobile_phone0" onchange="checkForm1()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice1">
								请输入正确手机号码。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;text-align: right;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span> 验证码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="width: 149px;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;float: left;padding-top:3px;padding-bottom:3px" type="text" placeholder="输入验证码" name="mobile_code" id="mobile_code">
							<input style="text-align:center;width: 108px;line-height: 24px;color: #ed8a32;background: #f8eacb;border: 1px solid #f8eacb;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float: right;" id="zphone" name="sendsms" onclick="sendSms0();" value="发送验证码">
						</div>
					</div>

					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 线下网点：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<select name="point" style="width:150px;">
								<option value="2">四川</option>
								<option value="4">上海</option>
								<option value="0">其他</option>
							</select>
						</div>
					</div>
					
					<div style="display: table-row;margin-top:10px">
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
						</div>
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;position: relative;	display: table-cell;vertical-align: middle;">
<style>
	.box_shadow{
		background: #f75151;
	}
	.box_shadow:hover{
		background: #f52020;
	}
	.box_shadow20{
		background: #f62d0a;
	}
	.box_shadow20:hover{
		background: #d31600;
	}
</style>
							
							<input style="width:110px;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border: none;border-radius: 3px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float:left;margin-right:40px" name="Submit" type="submit" value="立即预约" class="box_shadow20">
							<div style="width:110px;text-align:center;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border: none;border-radius: 3px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float:left" class="box_shadow" onclick="document.getElementById('pop_window2').style.display='none'">
							取消
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<input name="act" type="hidden" value="act_reserve">
	<input name="enabled_sms" type="hidden" value="1">
	<input type="hidden" name="back_act" value="">
</form>
	</div>
	<div style="height: 50px;line-height: 50px;font-size: 14px;color: #666;width: 1100px;margin-left: auto;margin-right: auto;">
		<a href="index.php" style="color: #666;">政金网</a> > <a href="index.php" style="color: #666;">理财频道</a> > <?php echo $this->_var['goods']['goods_name']; ?>
	</div>
	<div style="margin-bottom: 20px;width: 1100px;margin-left: auto;margin-right: auto;">
		<div style="border: 1px solid #e1e1e1;background: #ffffff;padding: 15px 25px 25px 25px;">
			<div style="height: 50px;font-size: 24px;font-weight: normal;font-weight: 400;">
				<span style="float: left;">
					<?php echo $this->_var['goods']['goods_name']; ?>
				</span>
				<?php if ($this->_var['goods']['cat_id'] == 1): ?>
				<span style="font-size: 14px;padding-left: 15px;padding-top: 10px;float: left;">（新用户福利,<span style="color: #e34949;">限投一次</span>）</span>
				<?php endif; ?>
				<button style="height: 24px;padding-left: 28px;font-size: 14px;border: none;background: url('themes/ecmoban_jumei/images/btn-calc2.png') no-repeat left center;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float: right;" class="box_shadow5" onclick="document.getElementById('cover').style.display='';document.getElementById('calculator').style.display='';document.getElementById('calculator_amount').value=document.getElementById('buy_number').value;">收益计算器</button>
			</div>
			<div class="clearfix"></div>
			<div>
				<div style="width: 685px;float: left;">
					<div style="height: 78px;padding-top: 22px;border-bottom: 1px solid #e6e6e6;">
						<div style="float:left">
							<div style="font-size: 36px;font-weight: normal;color: #e34949;">
								<?php echo $this->_var['goods']['goods_interest_rate']; ?><span style="font-size: 14px;">%</span>
							</div>
							<p class="color: #888;font-size: 14px;">预期年化收益率</p>
						</div>
						<div style="border-width: 0 1px;border-style: solid;border-color: #efefef;margin: 0 30px 0 40px;padding: 0 40px 0 30px;float: left;">
							<p style="font-size: 36px;font-weight: normal;">
								<?php echo $this->_var['goods']['format_goods_min_buy']; ?><span style="font-size: 14px;">元</span>
							</p>
							<p style="color: #888;font-size: 14px;">
								起投额度
							</p>
						</div>
						<div style="float: left;">
							<p style="font-size: 36px;font-weight: normal;">
								<?php echo $this->_var['goods']['goods_period']; ?><span style="font-size: 14px;">天</span>
							</p>
							<p style="color: #888;font-size: 14px;">产品期限</span>
						</div>
					</div>
					<div style="position: relative;font-size: 14px;padding-top: 20px;">
						<p style="width: 250px;">
							<span style="color: #888;">产品规模：</span>
							<?php echo $this->_var['goods']['format_goods_total_number']; ?>元
						</p>
						<p style="position: absolute;left: 0;top: 46px;width: 250px;">
							<span style="color: #888;">收益方式：</span>
							<?php if ($this->_var['goods']['goods_earn_method'] == 1): ?>到期一次兑付<?php endif; ?>
							<?php if ($this->_var['goods']['goods_earn_method'] == 2): ?>到期一次回购<?php endif; ?>
							<?php if ($this->_var['goods']['goods_earn_method'] == 3): ?>按月收益，到期回本<?php endif; ?>
							<?php if ($this->_var['goods']['goods_earn_method'] == 4): ?>按季收益，到期回本<?php endif; ?>
						</p>
						<p style="top: 20px;position: absolute;left: 260px;">
							<span style="color: #888;">参考评级：</span>
							<?php echo $this->_var['goods']['goods_level']; ?>
						</p>
						<div style="top: 46px;position: absolute;left: 260px;">
							<span style="color: #888;">投资进度：</span>
							<div style="position: absolute;left: 75px;top: 7px;width: 168px;height: 7px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background: #efefef;">
								<div style="width: <?php echo $this->_var['goods']['goods_rest_rate']; ?>%;position: absolute;left: 0;top: 0;height: 100%;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background: #f7a634;"></div>
								<span style="position: absolute;right: -45px;top: -5px;font-size: 12px;color: #999;"><?php echo $this->_var['goods']['goods_rest_rate']; ?>%</span>
							</div>
						</div>
					</div>
				</div>
				<?php if ($this->_var['goods_status'] == 0): ?>
				<div style="width: 295px;height: 170px;background: #fcf8e8;padding: 15px 0 0 40px;float: right;">
				<?php endif; ?>
				<?php if ($this->_var['goods_status'] == 1): ?>
				<div style="width: 295px;height: 170px;background: #fcf8e8;padding: 15px 0 0 40px;float: right;">
				<?php endif; ?>
				<?php if ($this->_var['goods_status'] == 2): ?>
				<div style="width: 295px;height: 150px;background: #fcf8e8;padding: 30px 0 0 40px;float: right;">
				<?php endif; ?>
				<?php if ($this->_var['goods_status'] == 3): ?>
				<div style="width: 295px;height: 150px;background: #fcf8e8;padding: 30px 0 0 40px;float: right;">
				<?php endif; ?>
				<?php if ($this->_var['goods_status'] == 4): ?>
				<div style="width: 295px;height: 150px;background: #fcf8e8;padding: 30px 0 0 40px;float: right;">
				<?php endif; ?>
					<style>
						.box_shadow:hover{background-color:#cacab2;}
						.box_shadow{background: #dfdfcc url(themes/ecmoban_jumei/images/ico-add-sub.png) no-repeat;}
						.box_shadow2:hover{background-color:#cacab2;}
						.box_shadow2{background: #dfdfcc url(themes/ecmoban_jumei/images/ico-add-sub.png) no-repeat 100% 0;}
						.box_shadow4:hover{background-color: #b20f02;background-image: -moz-linear-gradient(90deg, #b20f02 0%, #bd1306 100%);background-image: -webkit-linear-gradient(90deg, #b20f02 0%, #bd1306 100%);background-image: -ms-linear-gradient(90deg, #b20f02 0%, #bd1306 100%);background-image: linear-gradient(90deg, #b20f02 0%, #bd1306 100%);}
						.box_shadow4{background-color: #d01a0b;background-image: -moz-linear-gradient(90deg, #d01a0b 0%, #dc2112 100%);background-image: -webkit-linear-gradient(90deg, #d01a0b 0%, #dc2112 100%);background-image: -ms-linear-gradient(90deg, #d01a0b 0%, #dc2112 100%);background-image: linear-gradient(90deg, #d01a0b 0%, #dc2112 100%);}
						.box_shadow5{color: #888;}
						.box_shadow5:hover{color: #333;}
						.box_shadow6{background-color: transparent;}
						.box_shadow6:hover{background-color: #ededed;border-radius: 3px;}
						.box_shadow7{background-color: #034e8d;}
						.box_shadow7:hover{background-color: #034174;}
					</style>
					<form action="confirm_buy.php" id="" method="post">
						<div style="padding-top: 5px;margin-top: 5px;">
						<?php if ($this->_var['goods_status'] == 0): ?>
							<p style="font-size:14px;">
								<span style="color: #888;">
									剩余可投：
								</span>
								<span style="color: #e34949;">
									<?php echo $this->_var['goods']['format_goods_rest_number']; ?>
								</span>元
							</p>
						<?php endif; ?>
						<?php if ($this->_var['goods_status'] == 1): ?>
							<p style="font-size:14px;">
								<span style="color: #888;">
									剩余可投：
								</span>
								<span style="color: #e34949;">
									<?php echo $this->_var['goods']['format_goods_rest_number']; ?>
								</span>元
							</p>
						<?php endif; ?>
						<?php if ($this->_var['is_seller']): ?>
							<div style="width: 33px;height: 33px;border: none;border-radius: 2px;float: left;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" class="box_shadow" onclick="change_price(-1)"></div>
							<input name="goods_amount" style="background-color: #fff;border-radius: 2px;border: 1px solid #e7e7e7;float: left;margin: 0 5px;box-sizing: border-box;height: 33px;padding: 5px;line-height: 23px;color: #999;font-size: 14px;width: 115px;" value="<?php echo $this->_var['goods']['goods_min_buy']; ?>" id="buy_number" onblur="onblur_price()">
							<div style="width: 33px;height: 33px;border: none;border-radius: 2px;float: left;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" class="box_shadow2" onclick="change_price(1)"></div>
							<input type="hidden" name="goods_id" value="<?php echo $this->_var['goods']['goods_id']; ?>">
							<div class="clearfix"></div>
						<?php endif; ?>
						</div>
						<?php if ($this->_var['goods_status'] == 0): ?>
						<button style="font-size: 16px;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;background-color:#b6b5b6;cursor:default" disabled><?php echo $this->_var['formated_start_time']; ?> 开始</button>
						<?php endif; ?>
						<?php if ($this->_var['goods_status'] == 1): ?>
							<?php if ($this->_var['is_login'] == 1): ?>
								<?php if ($this->_var['is_seller']): ?>
								<input type="submit" style="font-size: 16px;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;" class="box_shadow4" value="立即投资">
								<?php else: ?>
								<div style="font-size: 16px;width:64px;text-align:center;margin-left:0;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;cursor:pointer"class="box_shadow4"onclick="document.getElementById('pop_window2').style.display=''">立即预约</div>
								<?php endif; ?>
							<?php else: ?>
							<div style="font-size: 16px;width:64px;text-align:center;margin-left:0;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;cursor:pointer"class="box_shadow4"onclick="document.getElementById('pop_window').style.display=''">立即预约</div>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ($this->_var['goods_status'] == 2): ?>
						<button style="font-size: 16px;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;background-color:#b6b5b6;cursor:default" disabled>已售罄</button>
						<?php endif; ?>
						<?php if ($this->_var['goods_status'] == 3): ?>
						<button style="font-size: 16px;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;background-color:#b6b5b6;cursor:default" disabled>已截止</button>		
						<?php endif; ?>		
						<?php if ($this->_var['goods_status'] == 4): ?>
						<button style="font-size: 16px;height: 42px;line-height: 42px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin-top: 25px;background-color:#b6b5b6;cursor:default" disabled>已结清</button>		
						<?php endif; ?>							
					</form>
					<!--
					<div style="margin-left: -60px;position: static;border-top: none;background: transparent;width: 100%;height: 31px;line-height: 31px;font-size: 14px;color: #333;text-align: center;left: 0;bottom: 0;vertical-align: middle;margin-top: 10px;">
						<a href="javascript:void(0)" style="color: #333;cursor: auto;text-decoration: none;">
							<span style="margin-right: 5px;">
								<img src="themes/ecmoban_jumei/images/ico-shield.png" style="position: relative;top: 3px;">
							</span>
							
							<span>账户安全由人保财险承保</span>
							
						</a>
					</div>
					-->
				<div class="clearfix"></div>
			</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<style>
		
		.goods_button{border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;}
		.active{background-color: #fff;border-top-width: 3px;border-top-color: #d01e10;border-left-color: #e1e1e1;border-right-color: #e1e1e1;color: #111;}
	</style>
	<div style="background-color: #fff;border: 1px solid #e1e1e1;border-radius: 2px;margin-top: 30px;">
		<div style="height: 50px;border-bottom: 1px solid #e1e1e1;background-color: #f8f8f8;">
			<button style="float: left;" class="active goods_button" id="button1" onclick="document.getElementById('button1').className='active goods_button';
			document.getElementById('button2').className='goods_button';
			document.getElementById('button3').className='goods_button';
			document.getElementById('button4').className='goods_button';
			document.getElementById('tab1').style.display='block';
			document.getElementById('tab2').style.display='none';
			document.getElementById('tab3').style.display='none';
			document.getElementById('tab4').style.display='none';">
			项目介绍
			</button>
			<button style="float: left;" class="goods_button" id="button2" onclick="document.getElementById('button3').className='goods_button';
			document.getElementById('button2').className='active goods_button';
			document.getElementById('button1').className='goods_button';
			document.getElementById('button4').className='goods_button';
			document.getElementById('tab4').style.display='none';
			document.getElementById('tab3').style.display='none';
			document.getElementById('tab2').style.display='block';
			document.getElementById('tab1').style.display='none';">
			投资记录
			</button>
			<button style="float: left;" class="goods_button" id="button3" onclick="document.getElementById('button3').className='active goods_button';
			document.getElementById('button2').className='goods_button';
			document.getElementById('button1').className='goods_button';
			document.getElementById('button4').className='goods_button';
			document.getElementById('tab3').style.display='block';
			document.getElementById('tab2').style.display='none';
			document.getElementById('tab1').style.display='none';
			document.getElementById('tab4').style.display='none';">
			投资协议
			</button>
			<button style="float: left;" class="goods_button" id="button4" onclick="document.getElementById('button4').className='active goods_button';
			document.getElementById('button2').className='goods_button';
			document.getElementById('button1').className='goods_button';
			document.getElementById('button3').className='goods_button';
			document.getElementById('tab4').style.display='block';
			document.getElementById('tab3').style.display='none';
			document.getElementById('tab2').style.display='none';
			document.getElementById('tab1').style.display='none';">
			相关资料
			</button>
			<div class="clearfix"></div>
		</div>
		<div style="height:2px;width:100%"></div>
<style>
	table{width: 100%;border: 1px solid #ecedee;border-collapse: collapse;border-spacing: 0;}
	tr{border-bottom: 1px solid #ecedee;}
	table th{height:33px}
	table td{font-size: 14px;height: 49px;text-align: center;}
	.table_v2 th, .table_v2 tbody th{width: 128px;font-size: 13px;font-weight: normal;color: #333;}
	.table_v2 th, .table_v2 tbody th, .table_v2 td, .table_v2 tbody td {
		border: 1px solid #ecedee;background: #f8f8f8;
	}
	.table_v2 td, .table_v2 tbody td {
		padding: 0 24px;
		text-align: left;
	}
	.table_v2 tr:nth-child(2n-1) td {
		background: #ffffff;
	}
	.table_v2 tr:nth-child(2n-1) th {
		background: #ecedee;
	}
</style>

		<div style="padding: 30px;display:block;display:none" id="tab1">
			<table class="table_v2" style="margin-top:30px">
				<tbody>
					<tr>
						<th>产品名称</th>
						<td><?php echo $this->_var['goods']['goods_name']; ?></td>
						<th>预期年化收益率</th>
						<td><?php echo $this->_var['goods']['goods_interest_rate']; ?>%</td>
					</tr>
					<tr>
						<th>产品规模</th>
						<td><?php echo $this->_var['goods']['format_goods_total_number']; ?> <span style="font-size:14px">元</span></td>
						<th>投资起点</th>
						<td>
                           <?php echo $this->_var['goods']['format_goods_min_buy']; ?> <span style="font-size:14px">元</span>
                        </td>
					</tr>
					<tr>
						<th>计划期限</th>
						<td><?php echo $this->_var['goods']['goods_period']; ?>天</td>
						<th>收益方式</th>
						<td><?php if ($this->_var['goods']['goods_earn_method'] == 1): ?>到期一次兑付<?php endif; ?>
							<?php if ($this->_var['goods']['goods_earn_method'] == 2): ?>到期一次回购<?php endif; ?>
							<?php if ($this->_var['goods']['goods_earn_method'] == 3): ?>按月收益，到期回本<?php endif; ?>
							<?php if ($this->_var['goods']['goods_earn_method'] == 4): ?>按季收益，到期回本<?php endif; ?></td>
					</tr>
					<tr>
						<th>融资主体</th>
						<td><?php echo $this->_var['project']['owner_name']; ?></td>
						<th>资金用途</th>
						<td><?php echo $this->_var['project']['project_usage']; ?></td>
					</tr>
					<tr>
						<th>上线交易日</th>
						<td><?php echo $this->_var['goods']['formed_start_time']; ?></td>
						<th>到期兑付日</th>
						<td><?php echo $this->_var['goods']['formed_return_time']; ?></td>
					</tr>
					<tr>
						<th>收益起算日</th>
						<td>T+<?php echo $this->_var['goods']['t']; ?></td>
						<th>销售时间</th>
						<td><?php echo $this->_var['goods']['goods_sale_time_start']; ?>~<?php echo $this->_var['goods']['goods_sale_time_end']; ?></td>						
					</tr>
				</tbody>
			</table>
			
			<div style="color:black;">
			
				<div style="margin-top:30px;padding: 0 20px;height: 38px;line-height: 38px;font-size: 16px;background: #efefef;">
					项目简介
				</div>
				<div style="padding:20px;font-size:14px;line-height: 30px;text-indent:2em;">
					<?php echo $this->_var['project']['project_briefintro']; ?>
				</div>
				
				<div style="margin-top:30px;padding: 0 20px;height: 38px;line-height: 38px;font-size: 16px;background: #efefef;">
					融资主体
				</div>
				<div style="padding:20px;font-size:14px;line-height: 30px;">
					<?php echo $this->_var['project']['finaenti_intro']; ?>
				</div>
				
				<div style="margin-top:30px;padding: 0 20px;height: 38px;line-height: 38px;font-size: 16px;background: #efefef;">
					担保主体
				</div>
				<div style="padding:20px;font-size:14px;line-height: 30px;">
					<?php echo $this->_var['project']['guarbody_intro']; ?>
				</div>
				
				<!--
				<div style="margin-top:30px;padding: 0 20px;height: 38px;line-height: 38px;font-size: 16px;background: #efefef;">
					资金用途
				</div>
				<div style="padding:20px;font-size:14px;">
					<?php echo $this->_var['project']['founds_use']; ?>
				</div>
				-->
				
				<div style="margin-top:30px;padding: 0 20px;height: 38px;line-height: 38px;font-size: 16px;background: #efefef;">
					还款来源
				</div>
				<div style="padding:20px;font-size:14px;line-height: 30px;">
					<?php echo $this->_var['project']['payment']; ?>
				</div>
				
				<div style="margin-top:30px;padding: 0 20px;height: 38px;line-height: 38px;font-size: 16px;background: #efefef;">
					增信措施
				</div>
				<div style="padding:20px 20px 0px 20px;font-size:14px;line-height: 30px;">
					<?php echo $this->_var['project']['increase_trust']; ?>
				</div>
				<div style="padding:0px 20px 20px 20px;font-size:14px;line-height: 30px;">
					备案机构：<?php echo $this->_var['project']['filing_agency']; ?>
				</div>
			
			</div>
			
		</div>
		<div style="padding: 30px;display:block;display:none;text-align:center;" id="login_need">
			<span>查阅项目介绍请先&nbsp;<a style="color:blue" href="user.php?act=register">注册</a>&nbsp;或&nbsp;<a style="color:blue" href="user.php">登录</a>&nbsp;，请前往&nbsp;<a style="color:blue" href="store.php">线下门店</a>&nbsp;进行现场注册，谢谢！</span>
		</div>
		

		<div style="display: block;padding: 30px;display:none" id="tab2">
<table>
  <tbody><tr>
    <th style="font-size: 14px;height: 33px;font-weight:bold;background-color: #ecedee;">序号</th>
    <th style="font-size: 14px;height: 33px;font-weight:bold;background-color: #ecedee;">投资人</th>
    <th style="font-size: 14px;height: 33px;font-weight:bold;background-color: #ecedee;">投资金额</th>
    <th style="font-size: 14px;height: 33px;font-weight:bold;background-color: #ecedee;">投资时间</th>
    <th style="font-size: 14px;height: 33px;font-weight:bold;background-color: #ecedee;">状态</th>
  </tr>
  <?php $_from = $this->_var['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
              <tr>
      <td><?php echo $this->_var['order']['compteur']; ?></td>
      <td><?php echo $this->_var['order']['user_name']; ?></td>
      <td>￥<?php echo $this->_var['order']['amount']; ?></td>
      <td><?php echo $this->_var['order']['formed_pay_time']; ?></td>
      <td><span class="status success">成功</span></td>
    </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</tbody></table>		
		</div>
		<div style="display: block;padding-top: 70px;padding-bottom:70px;padding-left:120px;padding-right:120px;display:none;height:500px;overflow:auto" id="tab3">
			<?php echo $this->fetch('library/contract.lbi'); ?>
		</div>
		<div style="display: block;padding-top: 70px;padding-bottom:70px;padding-left:120px;padding-right:120px;display:none;height:500px;overflow:auto" id="tab4">
			<div class="container hide" style="display: block;">
			<p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', 微软雅黑, SimSun, 宋体, Heiti, 黑体, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); line-height: 1.5em;">
			<span style="font-family: 微软雅黑, 'Microsoft YaHei';">交易说明书：</span>
			</p>
			<?php $_from = $this->_var['trade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'trade_0_62254400_1483951614');if (count($_from)):
    foreach ($_from AS $this->_var['trade_0_62254400_1483951614']):
?>
			<p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', 微软雅黑, SimSun, 宋体, Heiti, 黑体, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); line-height: 1.5em;">
			<img src="http://zhengjinnet.com/project_file/<?php if ($this->_var['other']['type'] == 1): ?>icon_pdf.gif<?php else: ?>icon_jpg.gif<?php endif; ?>" style="border: 0px; vertical-align: middle; margin-right: 2px;">
			<a href="http://zhengjinnet.com/<?php echo $this->_var['trade_0_62254400_1483951614']['file_path']; ?>" title="“<?php echo $this->_var['trade_0_62254400_1483951614']['file_name']; ?>" style="color: rgb(0, 102, 204); text-decoration: none; font-size: 12px;"><?php echo $this->_var['trade_0_62254400_1483951614']['file_name']; ?></a></p>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
			<p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', 微软雅黑, SimSun, 宋体, Heiti, 黑体, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); line-height: 1.5em;"><span style="font-family: 微软雅黑, 'Microsoft YaHei';">其它资料：</span></p>
			<?php $_from = $this->_var['other']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'other_0_62270800_1483951614');if (count($_from)):
    foreach ($_from AS $this->_var['other_0_62270800_1483951614']):
?>
			<p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', 微软雅黑, SimSun, 宋体, Heiti, 黑体, sans-serif; white-space: normal; background-color: rgb(255, 255, 255); line-height: 1.5em;">
			<img src="http://zhengjinnet.com/project_file/<?php if ($this->_var['other_0_62270800_1483951614']['type'] == 1): ?>icon_pdf.gif<?php else: ?>icon_jpg.gif<?php endif; ?>" style="border: 0px; vertical-align: middle; margin-right: 2px;">
			<a href="http://zhengjinnet.com/<?php echo $this->_var['other_0_62270800_1483951614']['file_path']; ?>" title="“<?php echo $this->_var['other_0_62270800_1483951614']['file_name']; ?>" style="color: rgb(0, 102, 204); text-decoration: none; font-size: 12px;"><?php echo $this->_var['other_0_62270800_1483951614']['file_name']; ?></a></p>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			
		</div>
	</div>
<div style="height:20px;width:100%"></div>
<div style="position:fixed;top:0;left:0;height:100%;width:100%;background-color:black;opacity:0.7;z-index:9;display:none" id="cover"></div>
<div style="left: 413.5px;top: 104px;display: block;opacity: 1;position: absolute;width: 522px;box-sizing: border-box;border-radius: 3px;background-color: #fff;z-index: 10;display:none" id="calculator">

	<button style="float: right;font-size: 21px;font-weight: bold;color: #627689;text-shadow: 0 1px 0 #ffffff;padding: 0;border: 0;-webkit-appearance: none;width: 35px;height: 35px;line-height: 35px;text-align: center;margin-top: 10px;margin-right: 10px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" onclick="document.getElementById('cover').style.display='none';document.getElementById('calculator').style.display='none'" class="box_shadow6">
		×
	</button>	<div style="height: 56px;line-height: 56px;font-size: 18px;font-weight: normal;color: #d01a0b;padding-left: 30px;">
		投资计算器
	</div>

	<div style="padding: 30px;">
		<dl style="font-size: 14px;">
			<dt style="height: 50px;line-height: 30px;float: left;width: 104px;text-align: right;position: relative;">
				投资产品：
			</dt>
			<dd style="height: 50px;line-height: 30px;padding-left: 122px;position: relative;">
				<?php echo $this->_var['goods']['goods_name']; ?>
			</dd>
			<div class="clearfix"></div>
			<dt style="float: left;width: 104px;line-height: 40px;text-align: right;">
				投入金额：
			</dt>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<input type="text" style="width: 240px;height: 40px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="total" value="" id="calculator_amount">   元
			</dd>
			<div class="clearfix"></div>
			<dt style="float: left;width: 104px;line-height: 40px;text-align: right;position: relative;">
				投入时长：
			</dt>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<input type="text" style="width: 240px;height: 40px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="days" value="<?php echo $this->_var['goods']['goods_period']; ?>" id="calculator_period">   天
			</dd>
			<div class="clearfix"></div>
			<dt style="float: left;width: 104px;line-height: 40px;text-align: right;position: relative;">
				年化利率：
			</dt>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<input type="text" style="width: 240px;height: 40px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="rate" value="<?php echo $this->_var['goods']['goods_interest_rate']; ?>" id="calculator_interest_rate">   %
			</dd>
			<div class="clearfix"></div>
			
			<script>
				function calculate(){
					document.getElementById('calculator_earn').innerHTML=
					(document.getElementById('calculator_amount').value * document.getElementById('calculator_interest_rate').value*document.getElementById('calculator_period').value/36500).toFixed(2);
					
					document.getElementById('calculator_total').innerHTML=parseFloat((document.getElementById('calculator_amount').value*document.getElementById('calculator_interest_rate').value*document.getElementById('calculator_period').value/36500).toFixed(2))+parseFloat(document.getElementById('calculator_amount').value);
				}
			</script>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<button style="width: 114px;height: 45px;font-size: 14px;color: #fff;border: none;border-radius: 3px;padding-left: 35px;padding-right: 35px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin: 0;padding: 0;" onclick="calculate()" class="box_shadow7">
					计算
				</button>
			</dd>
		</dl>
		<h4 style="position: relative;height: 30px;line-height: 30px;font-size: 18px;font-weight: normal;color: #d01a0b;">
			<span style="background-color: #fff;padding-right: 10px;display: inline-block;position: relative;">
				计算结果
			</span>
		</h4>
		<dl style="font-size: 14px;">
			<dt style="height: 33px;float: left;width: 104px;line-height: 40px;text-align: right;position: relative;">
				到期收益：
			</dt>
			<dd style="height: 20px;padding-left: 10px;line-height: 20px;position: relative;">
				到期收款合计 
				<em style="color: #e34949;line-height: 40px;" id="calculator_total">0</em>
				 元
			</dd>
			<dd style="height: 20px;padding-left: 10px;line-height: 20px;position: relative;">
				收益收入共 
				 <em style="color: #e34949;line-height: 40px;" id="calculator_earn">0</em>
				  元
			</dd>
		</dl>
	</div>
</div>

</div>



<script type="text/javascript">
function myfun()
{
	var object_user = document.getElementById("user_have");
	var object_table = document.getElementById("tab1");
	var object_login = document.getElementById("login_need");
	if(object_user){
		//alert("yes");
		object_table.style.display = "";
	}else{
		object_login.style.display = "";
		document.getElementById('tab1').innerHTML='';
		document.getElementById('tab2').innerHTML='';
		document.getElementById('tab3').innerHTML='';
		document.getElementById('tab4').innerHTML='';
		//alert("no");
	}
	

}
/*用window.onload调用myfun()*/
window.onload=myfun();//不要括号
</script>


<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script>
	function change_price(i){
		current_value = document.getElementById("buy_number").value;
		if (i==1){
			result = parseInt(current_value) + 100;
		}
		if (i==-1){
			result = parseInt(current_value) - 100;
		}
		if (result<<?php echo $this->_var['goods']['goods_min_buy']; ?>){
			alert("不能低于起投额度");
		}
		if (result><?php echo $this->_var['goods']['goods_rest_number']; ?>){
			alert("不能超过可购买金额");
		}
		if ((result>=<?php echo $this->_var['goods']['goods_min_buy']; ?>)&&(result<=<?php echo $this->_var['goods']['goods_rest_number']; ?>)){
			document.getElementById("buy_number").value = result;
		}
	}
	function onblur_price(){
		result = document.getElementById("buy_number").value;
		if (result<<?php echo $this->_var['goods']['goods_min_buy']; ?>){
			alert("不能低于起投额度");
			document.getElementById("buy_number").value = <?php echo $this->_var['goods']['goods_min_buy']; ?>;
		}
		if (result><?php echo $this->_var['goods']['goods_rest_number']; ?>){
			alert("不能超过可购买金额");
			document.getElementById("buy_number").value = <?php echo $this->_var['goods']['goods_rest_number']; ?>;
		}
	}
</script>





<script type="text/javascript">
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;


onload = function(){
  changePrice();
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}

/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;

  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}

/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;

    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
  }
}

</script>
</html>
