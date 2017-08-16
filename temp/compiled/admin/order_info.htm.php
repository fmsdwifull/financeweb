<!-- $Id: order_info.htm 17060 2010-03-25 03:44:42Z liuhui $ -->

<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'topbar.js,../js/utils.js,listtable.js,selectzone.js,../js/common.js')); ?>

<style>

td{height:35px;}

</style>

<div style="width:100%">
<table border="1" style="text-align:center;padding:10px;margin:0 auto;width:70%">
<tr>
<td colspan="4" style="height:30px;">产品信息<?php if ($this->_var['order_info']['transfer_flag'] == 1): ?> （转让中）<?php elseif ($this->_var['order_info']['transfer_flag'] == 2): ?>（已转让）<?php endif; ?></td>
</tr>
<tr>
	<td>
		产品编号
	</td>
	<td>
		<?php echo $this->_var['order_info']['goods_id']; ?>
	</td>
	<td>
		产品名称
	</td>
	<td>
		<?php echo $this->_var['order_info']['goods_name']; ?>
	</td>
</tr>
<tr>
	<td>
		年化收益率
	</td>
	<td>
		<?php echo $this->_var['order_info']['goods_interest_rate']; ?>%
	</td>
	<td>
		所属项目
	</td>
	<td>
		<?php echo $this->_var['order_info']['project_name']; ?>
	</td>
</tr>

<tr>
	<td>
		发行人
	</td>
	<td>
		<?php echo $this->_var['order_info']['owner_name']; ?>
	</td>
	<td>
		<a href="https://jzh.fuiou.com">虚拟账户</a>
	</td>
	<td>
		<?php echo $this->_var['order_info']['fuiou_id']; ?>
	</td>
</tr>
<div>	
	
	
	
</tr>
<tr>
<td colspan="4" style="height:30px;">认购人信息</td>
</tr>
<tr>
<td>
用户姓名
</td>
<td>
<?php echo $this->_var['order_info']['true_name']; ?>
</td>
<td>
手机号码
</td>
<td>
<?php echo $this->_var['order_info']['user_name']; ?>
</td>
</tr>

<tr>
	<td>
		身份证号码
	</td>
	<td>
		<?php echo $this->_var['order_info']['id_number']; ?>
	</td>
	
	<td>
		联系的业务员
	</td>
	<td>
		<?php echo $this->_var['order_info']['seller_name']; ?>
	</td>
	
</tr>


<tr >
	<td colspan="4">购买信息</td>
</tr>

	<td>
		认购金额
	</td>
		
	<td>
		<?php echo $this->_var['order_info']['amount']; ?>
	</td>
	
	<td>
		到期收益(总)
	</td>
		
	<td>
		<?php echo $this->_var['order_info']['interest_amount']; ?>
	</td>
	
	
<tr>
	<td>认购时间</td>
	<td><?php echo $this->_var['pay_time']; ?></td>
	<td>到期兑付日</td>
	<td><?php echo $this->_var['pay_end_time']; ?></td>
</tr>

<tr>
	<td colspan="4"><?php if ($this->_var['order_info']['transfer_flag'] == 2): ?>转让收益表格<?php else: ?>预期收益表格<?php endif; ?></td>
<tr>

<?php if ($this->_var['earn_list']): ?>
<tr>
<td colspan="2">付息日</td>
<td colspan="2">付息金额</td>
</tr>
<?php $_from = $this->_var['earn_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
<tr>
	
	<td colspan="2"><?php echo $this->_var['list']['time']; ?></td>
	
	<td colspan="2"><?php echo $this->_var['list']['interest']; ?></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>

<?php if ($this->_var['order_info']['transfer_flag'] == 2): ?>
<tr>
	<td>转让日</td>
	<td><?php echo $this->_var['pay_time']; ?></td>
	<td>转让结束日</td>
	<td><?php echo $this->_var['principal_list']['time']; ?></td>
</tr>
<tr>
	<td colspan="2">转让收益</td>
	<td colspan="2"><?php echo $this->_var['principal_list']['principal']; ?></td>
</tr>

<?php else: ?>
<tr>
	<td>付本付息日</td>
	<td><?php echo $this->_var['principal_list']['time']; ?></td>
	<td>付本付息金额</td>
	<td><?php echo $this->_var['principal_list']['principal']; ?></td>
</tr>
<?php endif; ?>
</table>






<?php echo $this->fetch('pagefooter.htm'); ?>