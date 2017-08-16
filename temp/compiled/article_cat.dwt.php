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

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body style="font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;font-size: 16px;
background-color: #ecedee;">
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div style="height: 50px;line-height: 50px;font-size: 14px;color: #666;width: 1100px;margin-left: auto;margin-right: auto;">
	<a href="index.html" >政金网</a> > 资讯中心
</div>
<div style="margin-bottom: 20px;width: 1100px;margin-left: auto;margin-right: auto;	">
	<div style="background-color: #fff;border: 1px solid #e1e1e1;border-radius: 2px;">
	
		<div style="height: 50px;background-color: #f8f8f8;">
			<div style="height: 50px;background-color: #f8f8f8;width:670px;margin:0 auto;">
			<?php if ($this->_var['cat_id'] == 20): ?>
				<a href="article_cat-20.html"style="background-color: #fff;border-top:3px #d01e10 solid;border-left: 1px #e1e1e1 solid; border-right:1px #e1e1e1 solid;color: #111;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;padding-left: 25px;padding-right: 25px;font-size: 16px;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">平台动态</a>
			<?php else: ?>
				<a href="article_cat-20.html" style="border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">
					平台动态
				</a>
			<?php endif; ?>
			
			<?php if ($this->_var['cat_id'] == 21): ?>
				<a href="article_cat-21.html"style="background-color: #fff;border-top:3px #d01e10 solid;border-left: 1px #e1e1e1 solid; border-right:1px #e1e1e1 solid;color: #111;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;padding-left: 25px;padding-right: 25px;font-size: 16px;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">产品公告</a>
			<?php else: ?>
				<a href="article_cat-21.html" style="border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">
					产品公告
				</a>
			<?php endif; ?>
			
			<?php if ($this->_var['cat_id'] == 29): ?>
				<a href="article_cat-29.html"style="background-color: #fff;border-top:3px #d01e10 solid;border-left: 1px #e1e1e1 solid; border-right:1px #e1e1e1 solid;color: #111;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;padding-left: 25px;padding-right: 25px;font-size: 16px;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">理财资讯</a>
			<?php else: ?>
				<a href="article_cat-29.html" style="border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">
					理财资讯
				</a>
			<?php endif; ?>
			
			<?php if ($this->_var['cat_id'] == 22): ?>
				<a href="article_cat-22.html"style="background-color: #fff;border-top:3px #d01e10 solid;border-left: 1px #e1e1e1 solid; border-right:1px #e1e1e1 solid;color: #111;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;padding-left: 25px;padding-right: 25px;font-size: 16px;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">行业动态</a>
			<?php else: ?>
				<a href="article_cat-22.html" style="border: 1px solid transparent;position: relative;box-sizing: border-box;height: 52px;line-height: 52px;top: -1px;margin-left: 32px;background-color: transparent;padding-left: 25px;padding-right: 25px;font-size: 16px;color: #666;letter-spacing: 2px;display: inline-block;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">
					行业动态
				</a>
			<?php endif; ?>
			
			</div>
		</div>
		
		<div>
			<ul style="padding: 10px;list-style: none;">
			<?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
				<li style="font-size: 14px;height: 48px;line-height: 48px;border-bottom: 1px dashed #c9c9c9;padding: 0 20px;">
					<a href="<?php echo $this->_var['article']['url']; ?>" style="color: #333;"><?php echo $this->_var['article']['title']; ?></a>
					<span style="color: #888;white-space: nowrap;float: right;font-size: 14px;line-height: 48px;">
						<?php echo $this->_var['article']['add_time']; ?>
					</span>
				</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
			<?php echo $this->fetch('library/pages.lbi'); ?>
		</div>
	</div>
</div>
<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
document.getElementById('cur_url').value = window.location.href;
</script>
</html>
