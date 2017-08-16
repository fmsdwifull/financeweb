
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- 商品搜索 -->

<!-- 商品列表 -->
  <!-- start fuiou list -->
  <div class="list-div" id="listDiv">
<?php endif; ?>
<table cellpadding="3" cellspacing="1">
  <tr>
    <th align="center">编号</th>
    <th align="center">业务员</th>
	<th align="center">权限</th>
    <th align="center">职位</th>
    <th align="center">操作</th>
  </tr>
  <?php $_from = $this->_var['seller_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'seller');if (count($_from)):
    foreach ($_from AS $this->_var['seller']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['seller']['seller_id']; ?></td>
    <td align="center"><?php echo $this->_var['seller']['seller_name']; ?></td>
    <td align="center"><?php if ($this->_var['seller']['admin_id']): ?>√<?php else: ?>×<?php endif; ?></td>
    <td align="center"><?php echo $this->_var['seller']['job']; ?></td>
    <td align="center"><a href="seller_list.php?act=edit&id=<?php echo $this->_var['seller']['seller_id']; ?>">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="if(confirm('是否删除此条记录')){window.location.href='seller_list.php?act=del&id=<?php echo $this->_var['seller']['seller_id']; ?>';}else{return false;}">删除</a></td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<!-- end fuiou list -->

<?php if ($this->_var['full_page']): ?>
</div>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>