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
<body style="background-color:#ecedee;font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;font-size:14px">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div style="height: 50px;line-height: 50px;font-size: 14px;color: #666;width: 1100px;margin-left: auto;margin-right: auto;">
	<a href="index.php" style="color: #666;text-decoration:none">政金网</a>&nbsp;>&nbsp;<a href="transfer.php" style="color: #666;text-decoration:none">产品转让</a>&nbsp;>&nbsp;<?php echo $this->_var['order']['goods_name']; ?>
</div>
<div style="margin-bottom: 20px;width: 1100px;margin-left: auto;margin-right: auto;font-size: 14px;">
	<div style="font-weight: normal;height: 40px;line-height: 40px;background-color: #ececec;border-radius: 2px 2px 0 0;">
		<span style="padding-left: 30px;background: url(themes/ecmoban_jumei/images/ico-arrow.png) no-repeat 10px center;font-size: 24px;line-height: 40px;">
			<strong><?php echo $this->_var['order']['goods_name']; ?></strong>
		</span>
		<span style="background-color: #ffa61a;color: #fff;height: 21px;line-height: 21px;font-size: 12px;padding: 0 5px;    display: inline-block;">
			转让
		</span>
		<span style="margin-left: 35px;font-size: 14px;line-height: 40px;">
			参考评级：<span style="color: #e34949;font-size: 24px;line-height: 40px;"><?php echo $this->_var['order']['goods_level']; ?></span>
		</span>
	</div>
	<div style="height: 165px;background: #fff;border: 1px solid #e1e1e1;border-radius: 2px;font-size: 14px;">
		<div style="width: 606px;height: 125px;border-right: 1px solid #e1e1e1;padding: 20px;float: left;font-size: 14px;">
			<table cellspacing="0" cellpadding="0" style="	border:none;width:600px;border-collapse: collapse;border-spacing: 0;">
				<tbody>
					<tr style="border:none">
						<td style="text-align: left;position: relative;line-height: 30px;padding-right: 15px;font-size: 14px; height: 49px;">
							<p style="font-size: 14px;">
								转让金额：
							</p>
							<p style="font-size: 24px;">
								<?php echo $this->_var['order']['amount']; ?>元
							</p>
						</td>
						<td style="padding-left: 15px;text-align: left;position: relative;line-height: 30px;padding-right: 15px;font-size: 14px;height: 49px;">
							<p style="font-size: 14px;">
								预期年化收益率：
							</p>
							<p style="color: #e34949;font-size: 24px;">
								<?php echo $this->_var['order']['goods_interest_rate']; ?>%
							</p>
						</td>
						<td style="padding-left: 15px;text-align: left;position: relative;line-height: 30px;padding-right: 15px;font-size: 14px;height: 49px;">
							<p style="font-size: 14px;">
								剩余天数：
							</p>
							<p style="font-size: 24px;">
								<?php echo $this->_var['order']['goods_rest_period']; ?>天
							</p>
						</td>
						<td style="padding-left: 15px;text-align: left;position: relative;line-height: 30px;padding-right: 15px;font-size: 14px;height: 49px;">
						<?php if ($this->_var['order']['transfer_flag'] == 2): ?>
							<p style="font-size: 14px;">
								转让生效日：
							</p>
							<p style="font-size: 24px;">
								<?php echo $this->_var['order']['formed_transfer_end_time']; ?>
							</p>
						<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
			<p style="font-size: 12px;margin-top: 30px;">
				<span style="#e34949;font-size: 12px;">
					注：
				</span>根据“投资金额<?php echo $this->_var['order']['amount']; ?> 元、期限<?php echo $this->_var['order']['goods_period']; ?>天”计算，预计<?php if ($this->_var['order']['goods_earn_method'] == 1): ?>到期<?php endif; ?><?php if ($this->_var['order']['goods_earn_method'] == 2): ?>到期<?php endif; ?><?php if ($this->_var['order']['goods_earn_method'] == 3): ?>每月<?php endif; ?><?php if ($this->_var['order']['goods_earn_method'] == 4): ?>每季<?php endif; ?>应收投资收益：<?php echo $this->_var['order']['formed_average_earn_money']; ?>元
			</p>
		</div>
		<div style="width: 420px;height: 140px;padding-left: 30px;padding-top: 15px;padding-bottom: 10px;background: #fbfbea;float: right;font-size: 14px;">
			<p style="font-size: 14px;">
				转让价格：
			</p>
			<div style="font-size: 12px;margin-top: 5px;">
				<span style="color: #e34949;font-size: 24px;">
					<?php echo $this->_var['order']['transfer_amount']; ?><span style="color: #333;">元</span>
				</span>
				<span style="position: relative;cursor: default;font-size: 14px;">
					= 项目价值：<?php echo $this->_var['order']['transfer_current_value']; ?> 
				</span>
				<span style="position: relative;cursor: default;font-size: 14px;">
					<?php echo $this->_var['order']['transfer_correction']; ?> 元
					<?php if ($this->_var['order']['transfer_correction_sign'] == 1): ?>
						<span style="color:#e34949">（加价）</span>
					<?php endif; ?>
					<?php if ($this->_var['order']['transfer_correction_sign'] == - 1): ?>
						<span style="color:#3ab63a">（降价）</span>
					<?php endif; ?>
				</span>
			</div>
			<div style="margin-top: 10px;font-size: 14px;">
			<?php if ($this->_var['order']['transfer_flag'] == 1): ?>
<style>
	.box_shadow0{background-color:#f62d0a}
	.box_shadow0:hover{background-color:#d31600}
</style>
				<form action="transaction.php" method="POST" id="id_form">
					<input type="hidden" name="action" value="transfer">
					<input type="hidden" name="order_id" value="<?php echo $this->_var['order']['order_id']; ?>">
				</form>
			<button style="height: 42px;line-height: 42px;background-image: none;border-color: #b6b5b6;box-shadow: none;font-size: 18px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" onclick="if(confirm('确认立即投资？')){document.getElementById('id_form').submit()}" class="box_shadow0">立即投资</button>
			<?php endif; ?>
			<?php if ($this->_var['order']['transfer_flag'] == 2): ?>
				<button style="height: 42px;line-height: 42px;background-color: #b6b5b6;background-image: none;border-color: #b6b5b6;box-shadow: none;font-size: 18px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: default;outline: none;transition: all ease-in-out 0.15s;" onclick="javascript:void(0)">已转让</button>
			<?php endif; ?>
				<!--
				<div style="text-align: left;position: static;border-top: none;background: transparent;width: 100%;height: 31px;line-height: 31px;font-size: 14px;color: #333;left: 0;bottom: 0;vertical-align: middle;margin-top: 5px;">
					<a href="color: #333;text-decoration: none;text-align: left;line-height: 31px;font-size: 14px;">
						<span style="margin-right: 5px;color: #333;text-align: left;line-height: 31px;font-size: 14px;">
							<img src="themes/ecmoban_jumei/images/ico-shield.png">
						</span>
						<span>账户安全由人保财险承保</span>
					</a>
				</div>-->
				<div style="cursor: default;font-size: 14px;text-align: left;position: static;border-top: none;background: transparent;width: 100%;height: 31px;line-height: 31px;left: 0;bottom: 0;vertical-align: middle;margin-top: 5px;">
					项目价值 = 项目本金 + 当期至今收益
				</div>
			</div>
		</div>
	</div>
<style>
	.active_tab{
		background-color: #fff !important;
		border-top-width: 3px !important;
		border-top-color: #d01e10 !important;
		border-left-color: #e1e1e1 !important;
		border-right-color: #e1e1e1 !important;
		color: #111 !important;
	}
	.tab{
		border: 1px solid transparent;float: left;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;padding-left: 25px;padding-right: 25px;font-size: 16px;letter-spacing: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;background-color:transparent
	}
</style>
<script>
	function show_tab(i){
		document.getElementById("tab1").style.display="none";
		document.getElementById("tab2").style.display="none";
		document.getElementById("tab"+i).style.display="";
		
		document.getElementById("button1").className="tab";
		document.getElementById("button2").className="tab";
		document.getElementById("button"+i).className="tab active_tab";
	}
</script>
	<div style="background-color: #fff;border: 1px solid #e1e1e1;border-radius: 2px;margin-top: 20px;font-size: 14px;">
		<div style="height: 50px;border-bottom: 1px solid #e1e1e1;background-color: #f8f8f8;">
			<span style="padding-left: 20px;line-height: 50px;display: block;margin-right: 50px;float: left;"><?php echo $this->_var['order']['goods_name']; ?>产品详情</span>
			<div style="float: left;">
				<button id="button1" onclick="show_tab(1)" class="tab active_tab">产品介绍</button>
				<button id="button2" class="tab" onclick="show_tab(2)">预期收益</button>
				<!--
				<button style="float: left;border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">项目动态</button>
				<button style="float: left;border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">相关资料</button>
				-->
			</div>
		</div>
		<div style="padding:30px" id="tab1">
			<table style="border: none;margin-bottom: 30px;width: 100%;border-collapse: collapse;border-spacing: 0;">
				<tbody>
					<tr style="border:none">
						<th colspan="2" style="font-size: 18px;font-weight: normal;height: 40px;background-color: #ecedee;">
							产品要素
						</th>
					</tr>
					<tr style="border:none">
						<td style="height: 35px;padding: 0;font-size: 14px;text-align: center;">
							收益方式
						</td>
						<td style="height:35px; border-left:1px solid #ededee; padding:0 0 0 25px; text-align:left;">
							<?php if ($this->_var['order']['goods_earn_method'] == 1): ?>
								到期一次兑付
							<?php endif; ?>
							<?php if ($this->_var['order']['goods_earn_method'] == 2): ?>
								到期一次回购
							<?php endif; ?>
							<?php if ($this->_var['order']['goods_earn_method'] == 3): ?>
								按月收益，到期回购
							<?php endif; ?>
							<?php if ($this->_var['order']['goods_earn_method'] == 4): ?>
								按季收益，到期回购
							<?php endif; ?>
						</td>
					</tr>
					<tr style="border:none; background:#f8f8f8;">
						<td style="height: 35px;padding: 0;font-size: 14px;text-align: center;">
							增信措施
						</td>
						<td style="height:35px; border-left:1px solid #ededee; padding:0 0 0 25px; text-align:left;">
							<?php echo $this->_var['order']['goods_garentee']; ?>
						</td>
					</tr>
					<tr style="border:none">
						<td style="height: 35px;padding: 0;font-size: 14px;text-align: center;">
							融资主体
						</td>
						<td style="height:35px; border-left:1px solid #ededee; padding:0 0 0 25px; text-align:left;">
							<?php echo $this->_var['order']['goods_main_body']; ?>
						</td>
					</tr>
					<tr style="border:none; background:#f8f8f8;">
						<td style="height: 35px;padding: 0;font-size: 14px;text-align: center;">
							投资项目
						</td>
						<td style="height:35px; border-left:1px solid #ededee; padding:0 0 0 25px; text-align:left;">
							<?php echo $this->_var['order']['goods_use']; ?>
						</td>
					</tr>
				</tbody>
			</table>
			<div>
			<?php echo $this->_var['order']['goods_desc']; ?>
			</div>
		</div>
		<div style="padding:30px;display:none" id="tab2">
			<div style="height: 32px;">
				预期收益 
				<small style="color: #e34949;">
					（按起投额<?php echo $this->_var['order']['amount']; ?>元，项目预期收益率 <?php echo $this->_var['order']['goods_interest_rate']; ?>%计算）
				</small>
			</div>
			<table style="width: 100%;border: 1px solid #ecedee;border-collapse: collapse;border-spacing: 0;">
				<thead>
					<tr style="border-bottom: 1px solid #ecedee;">
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							序号
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							偿付日期
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							应收金额（元）
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							投资金额（元）
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							预期收益（元）
						</th>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_var['order_repay_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'repay');if (count($_from)):
    foreach ($_from AS $this->_var['repay']):
?>
					<tr style="border-bottom: 1px solid #ecedee;">
						<td style="font-size: 14px;height: 49px;text-align: center;"><?php echo $this->_var['repay']['serie']; ?></td>
						<td style="font-size: 14px;height: 49px;text-align: center;"><?php echo $this->_var['repay']['formed_repay_time']; ?></td>
						<td style="font-size: 14px;height: 49px;text-align: center;"><?php echo $this->_var['repay']['formed_return_money']; ?></td>
						<td style="font-size: 14px;height: 49px;text-align: center;"><?php echo $this->_var['repay']['formed_invest_money']; ?></td>
						<td style="font-size: 14px;height: 49px;text-align: center;"><?php echo $this->_var['repay']['formed_interest_money']; ?></td>
					</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</tbody>
				<tfoot>
					<tr style="border-bottom: 1px solid #ecedee;">
						<td colspan="2" style="font-size: 14px;height: 49px;text-align: center;">合计</td>
						<td style="font-size: 14px;height: 49px;text-align: center;">
							<span id="totalAmount"><?php echo $this->_var['formed_total_return_money']; ?></span>
						</td>
						<td style="font-size: 14px;height: 49px;text-align: center;">
							<span id="totalAmount"><?php echo $this->_var['formed_total_invest_money']; ?></span>
						</td>
						<td style="font-size: 14px;height: 49px;text-align: center;">
							<span id="totalAmount"><?php echo $this->_var['formed_total_interest_money']; ?></span>
						</td>
					</tr>
				</tfoot>
			</table>
			<div style="height: 32px;margin-top: 30px;">
				项目收益
			</div>
			<table style="width: 100%;border: 1px solid #ecedee;">
				<tbody>
					<tr style="border-bottom: 1px solid #ecedee;">
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							融资总额
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							预期年化收益率
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							预期总收益
						</th>
						<th style="font-size: 14px;height: 33px;background-color: #ecedee;">
							收益发放
						</th>
					</tr>
					<tr style="border-bottom: 1px solid #ecedee;">
						<td style="height: 100px;border: 1px solid #ecedee;text-align: center;">
							<span style="color: #e34949;font-weight: bold;font-size: 30px;">
								<?php echo $this->_var['order']['goods_total_number']; ?>
							</span>元
						</td>
						<td style="height: 100px;border: 1px solid #ecedee;text-align: center;">
							<span style="color: #e34949;font-weight: bold;font-size: 30px;">
								<?php echo $this->_var['order']['goods_interest_rate']; ?>
							</span>%
						</td>
						<td style="height: 100px;border: 1px solid #ecedee;text-align: center;">
							<span style="color: #e34949;font-weight: bold;font-size: 30px;">
								<?php echo $this->_var['order']['goods_total_earn']; ?>
							</span>元
						</td>
						<td style="height: 100px;border: 1px solid #ecedee;text-align: center;">
							<?php if ($this->_var['order']['goods_earn_method'] == 1): ?>
								到期一次兑付
							<?php endif; ?>
							<?php if ($this->_var['order']['goods_earn_method'] == 2): ?>
								到期一次回购
							<?php endif; ?>
							<?php if ($this->_var['order']['goods_earn_method'] == 3): ?>
								按月收益，到期回购
							<?php endif; ?>
							<?php if ($this->_var['order']['goods_earn_method'] == 4): ?>
								按季收益，到期回购
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
