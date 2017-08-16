<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="con">
  <div class="ect-bg">
    <header class="ect-header ect-margin-tb ect-margin-lr text-center icon-write article"><a class="ect-icon ect-icon-home pull-left" href="index.php"></a><span><?php echo $this->_var['lang']['shophelp']; ?></span><a class="ect-icon ect-icon-cate pull-right" href="<?php echo url('article/index');?>"></a></header>
  </div>
  <div class="article-list">
  <form action="<?php echo url('article/art_list');?>" name="search_form" method="post" class="article_search">
    <div class="input-search"> <span>
      <input autocomplete="off" placeholder="<?php echo $this->_var['lang']['art_no_keywords']; ?>"  name="keywords" id="requirement" class="J_SearchInput inputSear" type="text">
      </span>
      <input name="id" type="hidden" value="<?php echo $this->_var['cat_id']; ?>" />
      <input name="cur_url" id="cur_url" type="hidden" value="" />
      <button type="button" disabled="true" class="input-delete J_InputDelete"> <span></span> </button>
      <button type="submit" ><i class="glyphicon glyphicon-search"></i></button>
    </div>
  </form>
  <?php if ($this->_var['article_categories']): ?>
  <div class="nav">
    <ul>
      <?php $_from = $this->_var['article_categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['article_cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_cat']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['article_cat']['iteration']++;
?>
      <li><a href="<?php echo url('article/art_list', array('id'=>$this->_var['cat']['id']));?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></li>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
  </div>
  <?php else: ?>
  <div class="article-list-ol">
    <ol>
      <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['artciles_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['artciles_list']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['artciles_list']['iteration']++;
?>
      <li><a href="<?php echo $this->_var['article']['url']; ?>"> <span class="num"><?php echo $this->_foreach['artciles_list']['iteration']; ?></span><?php echo $this->_var['article']['short_title']; ?>
        </a> </li>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <?php echo $this->fetch('library/pages.lbi'); ?>
    </ol>
  </div>
  <?php endif; ?> 
  </div>
    <footer class="logo"><a href="http://www.ectouch.cn" title="ECTouch官网" target="_blank"><img src="__TPL__/images/copyright.png" width="176" height="60"></a></footer>
</div>
<?php echo $this->fetch('library/search.lbi'); ?>
</body></html>