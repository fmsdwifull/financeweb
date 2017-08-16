<?php if ($this->_var['full_page']): ?>
<!-- $Id: users_list.htm 17053 2010-03-15 06:50:26Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- start users list -->
<div class="list-div" id="listDiv">
<?php endif; ?>
<!--用户列表部分-->
<style>
.table1{background-color:#eee;width:100%}
.table1 tr{background-color:#fff}
</style>
<script>
	function modifier_time(id){
		document.getElementById("fix_time_"+id).style.display="none";
		document.getElementById("modifier_time_"+id).style.display="";
	}
  </script>
<table cellpadding="3" cellspacing="1" class="table1">
  <tr>
    <th>
      <?php echo $this->_var['lang']['record_id']; ?>
    </th>
    <th>客户姓名</th>
    <th>手机号码</th>
	<th>业务员姓名</th>
    <th>预约产品</th>
    <th>线下门店</th>
	<th>预约时间</th>
	<th><?php if ($this->_var['seller_id'] != 1): ?>操作<?php else: ?>状态<?php endif; ?></th>
  <tr>

  <?php $_from = $this->_var['reserve_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
  <tr  style="<?php if ($this->_var['item']['is_cancel']): ?>color:#ddd<?php endif; ?>">
    <td><?php echo $this->_var['item']['reserve_id']; ?></td>
    <td class="first-cell"><?php echo htmlspecialchars($this->_var['item']['name']); ?></td>
    <td><?php echo htmlspecialchars($this->_var['item']['mobile']); ?></td>
	<td>
	<?php if (! $this->_var['item']['is_cancel']): ?>
		<?php if ($this->_var['item']['seller_name']): ?>
		<?php echo htmlspecialchars($this->_var['item']['seller_name']); ?>
		<?php else: ?>
		<form method="POST" action="seller_reserve.php?act=submit_seller" style="margin-bottom:0">
		<input name="id" type="hidden" value="<?php echo $this->_var['item']['reserve_id']; ?>">
		<select name="seller_id">
			<option value=""></option>
			<?php $_from = $this->_var['seller_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'seller');if (count($_from)):
    foreach ($_from AS $this->_var['seller']):
?>
			<option value="<?php echo $this->_var['seller']['seller_id']; ?>"><?php echo $this->_var['seller']['seller_name']; ?></option>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</select>
		<input type ="submit" value="提交">
		</form>
		<?php endif; ?>
	<?php endif; ?>
	</td>
    <td><?php echo htmlspecialchars($this->_var['item']['goods_name']); ?></td>
    <td><?php echo $this->_var['item']['store_name']; ?></td>
	<?php if ($this->_var['seller_id'] == 1): ?>
		<td>
		<?php if ($this->_var['item']['year']): ?>
			<?php echo $this->_var['item']['year']; ?>年<?php echo $this->_var['item']['month']; ?>月<?php echo $this->_var['item']['day']; ?>日<?php echo $this->_var['item']['hour']; ?>时<?php echo $this->_var['item']['minute']; ?>分
		<?php else: ?>
			未确定预约时间
		<?php endif; ?>
		</td>
		<td>
		<?php if ($this->_var['item']['is_cancel']): ?>
		已取消
		<?php else: ?>
			<?php if ($this->_var['item']['is_come']): ?>
			已面谈
			<?php else: ?>
			未面谈
			<?php endif; ?>
		<?php endif; ?>
		</td>
	<?php else: ?>
	<form action="seller_reserve.php?act=submit_time" method = "POST"style="margin-bottom:0" id="form_<?php echo $this->_var['item']['reserve_id']; ?>">
		<td>
			<?php if ($this->_var['item']['year']): ?>
				<input name="id" type="hidden" value="<?php echo $this->_var['item']['reserve_id']; ?>">
				<div id="fix_time_<?php echo $this->_var['item']['reserve_id']; ?>">
				<?php if (! $this->_var['item']['is_cancel']): ?>
					<?php echo $this->_var['item']['year']; ?>年<?php echo $this->_var['item']['month']; ?>月<?php echo $this->_var['item']['day']; ?>日<?php echo $this->_var['item']['hour']; ?>时<?php echo $this->_var['item']['minute']; ?>分
					<input type="button" value="修改" onclick="modifier_time(<?php echo $this->_var['item']['reserve_id']; ?>)">
				<?php endif; ?>
				</div>
				<div style="display:none" id="modifier_time_<?php echo $this->_var['item']['reserve_id']; ?>">
					<input name="id" type="hidden" value="<?php echo $this->_var['item']['reserve_id']; ?>">
					<?php if (! $this->_var['item']['is_cancel']): ?>
					<select name="year">
						<option value=""></option>
					<?php $_from = $this->_var['year']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_year');if (count($_from)):
    foreach ($_from AS $this->_var['item_year']):
?>
						<option value="<?php echo $this->_var['item_year']; ?>" <?php if ($this->_var['item_year'] == $this->_var['item']['year']): ?>selected<?php endif; ?>><?php echo $this->_var['item_year']; ?></option>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>
					<select name="month">
						<option value=""></option>
					<?php $_from = $this->_var['month']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_month');if (count($_from)):
    foreach ($_from AS $this->_var['item_month']):
?>
						<option value="<?php echo $this->_var['item_month']; ?>" <?php if ($this->_var['item_month'] == $this->_var['item']['month']): ?>selected<?php endif; ?>><?php echo $this->_var['item_month']; ?></option>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>
					<select name="day">
						<option value=""></option>
					<?php $_from = $this->_var['day']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_day');if (count($_from)):
    foreach ($_from AS $this->_var['item_day']):
?>
						<option value="<?php echo $this->_var['item_day']; ?>" <?php if ($this->_var['item_day'] == $this->_var['item']['day']): ?>selected<?php endif; ?>><?php echo $this->_var['item_day']; ?></option>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>
					<input type="text" name="hour" style="width:30px" value="<?php echo $this->_var['item']['hour']; ?>">时 
					<input type="text" name="minute" style="width:30px" value="<?php echo $this->_var['item']['minute']; ?>">分
					<input type="submit" name="time" value="提交">
					<?php endif; ?>
				</div>
			<?php else: ?>
				<input name="id" type="hidden" value="<?php echo $this->_var['item']['reserve_id']; ?>">
				<?php if (! $this->_var['item']['is_cancel']): ?>
				<select name="year">
					<option value=""></option>
				<?php $_from = $this->_var['year']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_year');if (count($_from)):
    foreach ($_from AS $this->_var['item_year']):
?>
					<option value="<?php echo $this->_var['item_year']; ?>" <?php if ($this->_var['item_year'] == $this->_var['item']['year']): ?>selected<?php endif; ?>><?php echo $this->_var['item_year']; ?></option>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
				<select name="month">
					<option value=""></option>
				<?php $_from = $this->_var['month']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_month');if (count($_from)):
    foreach ($_from AS $this->_var['item_month']):
?>
					<option value="<?php echo $this->_var['item_month']; ?>" <?php if ($this->_var['item_month'] == $this->_var['item']['month']): ?>selected<?php endif; ?>><?php echo $this->_var['item_month']; ?></option>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
				<select name="day">
					<option value=""></option>
				<?php $_from = $this->_var['day']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_day');if (count($_from)):
    foreach ($_from AS $this->_var['item_day']):
?>
					<option value="<?php echo $this->_var['item_day']; ?>" <?php if ($this->_var['item_day'] == $this->_var['item']['day']): ?>selected<?php endif; ?>><?php echo $this->_var['item_day']; ?></option>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
				<input type="text" name="hour" style="width:30px" value="<?php echo $this->_var['item']['hour']; ?>">时 
				<input type="text" name="minute" style="width:30px" value="<?php echo $this->_var['item']['minute']; ?>">分
				<input type="submit" name="time" value="提交">
				<?php endif; ?>
			<?php endif; ?>
		</td>
		<td>
		<?php if (! $this->_var['item']['is_cancel']): ?>
		<?php if ($this->_var['item']['is_come']): ?>
			已面谈
		<?php else: ?>
			<input type="button" value="已面谈" onclick="if(confirm('确认已经与客户进行面谈？该操作将不可取消。')){
			document.getElementById('come_<?php echo $this->_var['item']['reserve_id']; ?>').value='1';
			document.getElementById('form_<?php echo $this->_var['item']['reserve_id']; ?>').submit();}else{
			document.getElementById('come_<?php echo $this->_var['item']['reserve_id']; ?>').value='0'}">
			<input type="hidden" id="come_<?php echo $this->_var['item']['reserve_id']; ?>" name="come" value = "0">
		<?php endif; ?>
		&nbsp;&nbsp;
		<?php endif; ?>
		<?php if (! $this->_var['item']['is_come']): ?>
			<?php if ($this->_var['item']['is_cancel']): ?>
				已取消
			<?php else: ?>
				<input type="button" value="取消" onclick="if(confirm('确认要取消该客户的预约？')){
				document.getElementById('cancel_<?php echo $this->_var['item']['reserve_id']; ?>').value='1';
				document.getElementById('form_<?php echo $this->_var['item']['reserve_id']; ?>').submit();}else{
				document.getElementById('cancel_<?php echo $this->_var['item']['reserve_id']; ?>').value='0'}">
				<input type="hidden" id="cancel_<?php echo $this->_var['item']['reserve_id']; ?>" name="cancel" value = "0">
			<?php endif; ?>
		<?php endif; ?>
		</td>
	</form>
	<?php endif; ?>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="8"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

</table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end users list -->



<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>