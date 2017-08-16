<!-- $Id: goods_list.htm 17126 2010-04-23 10:30:26Z liuhui $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- 商品搜索 -->

<!-- 商品列表 -->
  <!-- start goods list -->
  <div class="list-div" id="listDiv">
<?php endif; ?>
<table cellpadding="3" cellspacing="1">
  <tr>
    <th align="center">编号</th>
    <th align="center">项目名称</th>
	<th align="center">项目简称</th>
    <th align="center">公司名称</th>
    <th align="center">法人姓名</th>
    <th align="center">注册资金</th>
    <th align="center">操作</th>
  </tr>
  <?php $_from = $this->_var['project_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'project');if (count($_from)):
    foreach ($_from AS $this->_var['project']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['project']['project_id']; ?></td>
    <td align="center"><?php echo htmlspecialchars($this->_var['project']['project_name']); ?></td>
    <td align="center"><?php echo $this->_var['project']['project_short']; ?></td>
    <td align="center"><?php echo $this->_var['project']['owner_name']; ?></td>
    <td align="center"><?php echo $this->_var['project']['owner_faren']; ?></td>
    <td align="center"><?php echo $this->_var['project']['owner_money']; ?></td>
    <td align="center"><a href="project.php?act=edit&project_id=<?php echo $this->_var['project']['project_id']; ?>">编辑</a></td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<!-- end goods list -->

<?php if ($this->_var['full_page']): ?>
</div>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>