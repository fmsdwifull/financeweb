<?php if ($this->_var['full_page']): ?>
<!-- $Id: users_list.htm 17053 2010-03-15 06:50:26Z sxc_shop $ -->


<!-- start users list -->
<div class="list-div" id="listDiv">
<?php endif; ?>
<!--用户列表部分-->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="team_reserve.php" method="GET">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    业务员姓名：
	<select name="seller_id">
		<?php $_from = $this->_var['team_members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'member');if (count($_from)):
    foreach ($_from AS $this->_var['member']):
?>
		<option value="<?php echo $this->_var['member']['seller_id']; ?>" <?php if ($this->_var['selected_seller_id'] == $this->_var['member']['seller_id']): ?>selected<?php endif; ?>><?php echo $this->_var['member']['seller_name']; ?></option>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</select>
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
	<input type="button" value="全部" class="button" onclick="window.location.href='team_reserve.php?act=list'"/>
  </form>
  
</div>
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
	<th>状态</th>
  <tr>

  <?php $_from = $this->_var['reserve_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
  <tr  style="<?php if ($this->_var['item']['is_cancel']): ?>color:#ddd<?php endif; ?>">
    <td><?php echo $this->_var['item']['reserve_id']; ?></td>
    <td class="first-cell"><?php echo htmlspecialchars($this->_var['item']['name']); ?></td>
    <td><?php echo htmlspecialchars($this->_var['item']['mobile']); ?></td>
	<td><?php echo htmlspecialchars($this->_var['item']['seller_name']); ?></td>
    <td><?php echo htmlspecialchars($this->_var['item']['goods_name']); ?></td>
    <td><?php echo $this->_var['item']['store_name']; ?></td>
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