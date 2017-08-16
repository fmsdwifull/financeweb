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

</head>
<body style="font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;background-color: #ecedee;font-size: 16px;">


<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/right_link.lbi'); ?>

<div style="width:1000px;margin:0 auto;margin-top:30px;padding-bottom:-18px;">
	<span>
		首页>
	</span>
	<span id="title_2">
		关于我们>
	</span>
	<span id="title_3">
		平台简介
	</span>
</div>
<div style="width:1000px;margin:0 auto;">
	<div style="float:left;width:180px;">
		
		
		<div onclick="showblock(1)" style="margin-top:30px;height:40px;line-height:40px;text-align:center;background:#d01a0b;color:white;cursor:pointer;">
			<span>
				关于我们<span id="symbol_1">∨</span>
			</span>
			<input type="hidden" value="1" id="sy_val_1"/>
		</div>
		<div id="about_us" style="text-align:center;background:white;">
			
			<div id="jk" style="">
				<?php $_from = $this->_var['article_list1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article_list1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list1']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article_list1']['iteration']++;
?>
					<div id="k_<?php echo $this->_var['article']['article_id']; ?>" onclick="showArticle(<?php echo $this->_var['article']['article_id']; ?>)" style="padding:8px 0 8px 0;cursor:pointer;border:1px solid #dcdddd;;line-height: 24px;color:#727171;"><?php echo $this->_var['article']['title']; ?></div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
			</div>
			
		</div>
		
		<div onclick="showblock(2)" style="height:40px;line-height:40px;;text-align:center;background:#d01a0b;color:white;cursor:pointer;margin-top:5px;">
			<span>
				其他<span id="symbol_2">∧</span>
			</span>
			<input type="hidden" value="0" id="sy_val_2"/>
		</div>
		<div id="other" style="text-align:center;display:none;background:white;">
			
			<div id="js" style="">
				<?php $_from = $this->_var['article_list3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article_list3'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list3']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article_list3']['iteration']++;
?>
					<div id="k_<?php echo $this->_var['article']['article_id']; ?>" onclick="showArticle(<?php echo $this->_var['article']['article_id']; ?>)" style="padding:8px 0 8px 0;cursor:pointer;border:1px solid #dcdddd;;line-height: 24px;color:#727171;"><?php echo $this->_var['article']['title']; ?></div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
			</div>
			
		</div>
		
		
	</div>
	
	
	

	<div id="content" style="float:right;width:765px;overflow:auto;">
		<?php echo $this->_var['content']; ?>
	</div>
	<input type="hidden" id="jack" value="<?php echo $this->_var['art_id']; ?>"/>
</div>





<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>

<script type="text/javascript">
    window.onload=function(){
		var flag=document.getElementById("jack").value;
		if(flag){
			//alert(flag);
			document.getElementById("k_"+flag).style.color="red";
			document.getElementById('title_3').innerHTML = document.getElementById("k_"+flag).innerHTML;
		}
		if(flag>43){
			document.getElementById("about_us").style.display="none";
			document.getElementById("symbol_1").innerHTML="∧";
			document.getElementById("sy_val_1").value=0;
			
			document.getElementById("other").style.display="block";
			document.getElementById("symbol_2").innerHTML="∨";
			document.getElementById("sy_val_2").value=1;
		}
		
		
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
	
	function showblock(key){
	
		if(key==1){
			document.getElementById("title_2").innerHTML="关于我们>";
			var flag=document.getElementById("sy_val_1").value;
			if(flag==0){
				document.getElementById("about_us").style.display="block";
				document.getElementById("symbol_1").innerHTML="∨";
				document.getElementById("sy_val_1").value=1;
			}
			if(flag==1){
				document.getElementById("about_us").style.display="none";
				document.getElementById("symbol_1").innerHTML="∧";
				document.getElementById("sy_val_1").value=0;
			}
		}
		
		if(key==2){
			document.getElementById("title_2").innerHTML="其他>";
			var flag=document.getElementById("sy_val_2").value;
			if(flag==0){
				document.getElementById("other").style.display="block";
				document.getElementById("symbol_2").innerHTML="∨";
				document.getElementById("sy_val_2").value=1;
			}
			if(flag==1){
				document.getElementById("other").style.display="none";
				document.getElementById("symbol_2").innerHTML="∧";
				document.getElementById("sy_val_2").value=0;
			}
		}
		
		
		if(key==3){
			document.getElementById("title_2").innerHTML="主要项目>";
			var flag=document.getElementById("sy_val_3").value;
			if(flag==0){
				document.getElementById("main_items").style.display="block";
				document.getElementById("symbol_3").innerHTML="∨";
				document.getElementById("sy_val_3").value=1;
			}
			if(flag==1){
				document.getElementById("main_items").style.display="none";
				document.getElementById("symbol_3").innerHTML="∧";
				document.getElementById("sy_val_3").value=0;
			}
		}
	}
	
	function showArticle(key){
		var obj = document.getElementById("jk").getElementsByTagName("div");
        for (i = 0; i < obj.length; i++) {
            obj[i].style.color = "#727171";
        }
		
		var obj = document.getElementById("js").getElementsByTagName("div");
        for (i = 0; i < obj.length; i++) {
            obj[i].style.color = "#727171";
        }
		
		
		
	
		document.getElementById("k_"+key).style.color="red";
		document.getElementById('title_3').innerHTML = document.getElementById("k_"+key).innerHTML;
		$.ajax({
			url : "http://zhengjinnet.com/about_usArticle.php",
			data:{"article_id":key},
			dataType:"json",
			type:"post",
			success:function(result){
				//alert(result.status);
				document.getElementById("content").innerHTML = result.content;
			}
		});
	}
	
	
	
	
</script>




</html>
