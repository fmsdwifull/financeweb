<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,selectzone.js,colorselector.js')); ?>
<!-- start goods form -->
<div class="tab-div">
    <!-- tab body -->
    <div id="tabbody-div">
      <form enctype="multipart/form-data" action="" method="post" name="theForm" onsubmit="return check();">
        <table width="90%" id="general-table" align="center">  
		  <tr>
		    <td class="label">业务员:</td>
			<td>
				<input type="text" name="seller_name" value="<?php echo $this->_var['seller_list']['seller_name']; ?>" id="seller_name">
			</td>
		  </tr>
		  
		  <tr>
		    <td class="label">账号:</td>
			<td>
				<input type="text" name="seller_no" value="<?php echo $this->_var['seller_list']['seller_no']; ?>" id="seller_no">
			</td>
		  </tr>
		  
		  <tr>
		    <td class="label">Mac地址:</td>
			<td>
				<input type="text" name="seller_mac" value="<?php echo $this->_var['seller_list']['seller_mac']; ?>" id="seller_mac">
			</td>
		  </tr>
		  
		  <!-- 区长 只有region_manger  显示 所属区域-->
		  <tr>
			<td class="label">所属区域:</td>
			<td>
				<select name="region_id" onchange="choose_region(this.value);" id="region_id">
					<option value=''>请选择</option>
					<?php $_from = $this->_var['region_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
					<option value='<?php echo $this->_var['region']['id']; ?>'
					<?php if ($this->_var['seller_list']['region_id']): ?>
						<?php if ($this->_var['region']['id'] == $this->_var['seller_list']['region_id']): ?>selected<?php endif; ?>
					<?php else: ?>				
						<?php if ($this->_var['seller_list']['region_manager'] == $this->_var['region']['id']): ?>selected<?php endif; ?>
					<?php endif; ?>
					>	
					<?php echo $this->_var['region']['region_name']; ?></option>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
			</td>
		  </tr>
		  
		  <?php if ($this->_var['act'] == 'edit'): ?>
			<tr style="display:table-row;" id="region_manager" >
		  <?php else: ?>
		  <tr style="display:none;" id="region_manager" >
		  <?php endif; ?>
		  
			<td class="label">职位:</td>
			<td>
				<input type="radio" value="0" <?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['region_manager'] == 0): ?> checked <?php endif; ?><?php endif; ?>name="region_manager" onclick="document.getElementById('store_id').style.display='table-row'"/> <lable>不是区长</lable>
				<input type="radio" value="<?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['region_id']): ?><?php echo $this->_var['sellel_list']['region_id']; ?><?php else: ?><?php echo $this->_var['seller_list']['region_manager']; ?><?php endif; ?>" <?php if ($this->_var['seller_list']['region_manager']): ?> checked <?php endif; ?><?php else: ?>"<?php endif; ?>name="region_manager" onclick="clear_store();"/> <lable>区长</lable>
			</td>
		  </tr>
		  
		  
			<?php if ($this->_var['act'] == 'edit'): ?>
				<?php if ($this->_var['seller_list']['region_manager'] == 0): ?>
					<tr style="display:table-row;" id="store_id">
				<?php else: ?>
					<tr style="display:none;" id="store_id">
				<?php endif; ?>
			<?php else: ?>
				<tr style="display:none;" id="store_id">
			<?php endif; ?>
			<td class="label">所属店铺:</td>
			<td>
				<select name="store_id" onchange="choose_store(this.value);" id="sto">
					<option value=''>请选择</option>
				</select>
			</td>
		  </tr>
		  
		  
		  
		 <?php if ($this->_var['act'] == 'edit'): ?>
			<?php if ($this->_var['seller_list']['store_manager'] >= 0 && $this->_var['seller_list']['region_manager'] == 0): ?>
				<tr style="display:table-row;" id="store_manager">
			<?php else: ?>
				<tr style="display:none;" id="store_manager">
			<?php endif; ?>
		<?php else: ?>
				<tr style="display:none;" id="store_manager">
		<?php endif; ?>  
			<td class="label">职位:</td>
			<td>
				<input type="radio" value="0" <?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['store_manager'] == 0): ?> checked  <?php endif; ?> <?php endif; ?>name="store_manager"/> <lable>小职员</lable>
				<!-- <input type="radio" value="2" <?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['store_manager'] == 2): ?> checked  <?php endif; ?> <?php endif; ?>name="store_manager"/> <lable>店长</lable> -->
				<input type="radio" value="<?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['store_id']): ?><?php echo $this->_var['sellel_list']['store_id']; ?><?php else: ?><?php echo $this->_var['seller_list']['store_manager']; ?><?php endif; ?>" <?php if ($this->_var['seller_list']['store_manager']): ?> checked <?php endif; ?><?php else: ?>"<?php endif; ?>name="store_manager"/> <lable>店长</lable>

			</td>
		  </tr>
		  
		  <tr>
			<td class="label">接受预约:</td>
			<td>
				<input type="radio" value="1"  <?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['get_reserve'] == 1): ?> checked <?php endif; ?> <?php endif; ?>name="get_reserve"/> <lable>是</lable>
				<input type="radio" value="0"  <?php if ($this->_var['act'] == 'edit'): ?><?php if ($this->_var['seller_list']['get_reserve'] == 0): ?> checked <?php endif; ?> <?php endif; ?>name="get_reserve"/> <lable>否</lable>
			</td>
		  </tr>
		  
		   <tr>
			<td class="label">分配权限:</td>
			<td>
			<select name="admin_id" id="admin_id">
						<option value=''>请选择</option>
						<!-- <?php $_from = $this->_var['admin_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'admin');if (count($_from)):
    foreach ($_from AS $this->_var['admin']):
?> -->
							<option value='<?php echo $this->_var['admin']['user_id']; ?>' <?php if ($this->_var['admin']['user_id'] == $this->_var['seller_list']['admin_id']): ?>selected<?php endif; ?>><?php echo $this->_var['admin']['user_name']; ?></option>
						<!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>-->
				</select>
			</td>
		  </tr>
		  
		  <tr>
			<td class="label">选择富友账号:</td>
			<td>
				<select name="fuiou_account_id" id="fuiou_account_id">
						<option value=''>请选择</option>
						<!-- <?php $_from = $this->_var['fuiou_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'fuiou');if (count($_from)):
    foreach ($_from AS $this->_var['fuiou']):
?> -->
							<option value='<?php echo $this->_var['fuiou']['account_id']; ?>' <?php if ($this->_var['fuiou']['account_id'] == $this->_var['seller_list']['fuiou_account_id']): ?>selected<?php endif; ?>><?php echo $this->_var['fuiou']['account_name']; ?></option>
						<!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>-->
				</select>
			</td>
		  </tr>
		  
        </table>
        <div class="button-div">
          <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
        </div>
		<?php if ($this->_var['act'] == 'add'): ?>
        <input type="hidden" name="act" value="add_seller" />
		<?php elseif ($this->_var['act'] == 'edit'): ?>
		<input type="hidden" name="act" value="edit_seller" />
		 <input type="hidden" name="seller_id" value="<?php echo $_GET['id']; ?>" />
		<?php endif; ?>
      </form>
    </div>
</div>

<script type="text/javascript">

		var store_manager=document.getElementById('store_manager');
		var store_id=document.getElementById('store_id');
		var region_manager=document.getElementById('region_manager');
		var region_id=document.getElementById('region_id');	
		var store=document.getElementsByName('store_manager');
		var st=document.getElementsByName('store_id')[0].options;
		var manager=document.getElementsByName('region_manager');
		var admin_id=document.getElementById('admin_id');
		var fuiou_account_id=document.getElementById('fuiou_account_id');
	 <?php if ($this->_var['act'] == 'edit'): ?>
		window.onload=function(){
				Ajax.call('seller_list.php?act=showStore&id='+region_id.value,'', showStore, 'GET', 'JSON');	
				<?php if ($this->_var['seller_list']['region_manager'] == 0): ?>
					manager[1].value=<?php echo $this->_var['seller_list']['region_id']; ?>;
						<?php if ($this->_var['sellel_list']['store_manager'] == 0 || $this->_var['sellel_list']['store_manager']): ?>
							store[1].value=<?php echo $this->_var['seller_list']['store_id']; ?>;
						<?php endif; ?>
				<?php endif; ?>
				
		}
	<?php endif; ?>	
		function showStore(data){
				
			for(i=1;i<document.getElementsByName('store_id')[0].length+1;i++){
				document.getElementsByName('store_id')[0].remove(i);
			}
	
			for(i=0;i<data['list'].length;i++){	
				var opt = document.createElement ("option");
				opt.value = data['list'][i]['store_id'];
				opt.innerText = data['list'][i]['store_name'];
				<?php if ($this->_var['act'] == 'edit'): ?>
					<?php if ($this->_var['seller_list']['store_manager'] != 0): ?>//店长
					var seller_id=<?php echo $this->_var['seller_list']['store_manager']; ?>;
					if(seller_id == data['list'][i]['store_id']){
						opt.selected=true;
					}
					<?php else: ?>//小职员
					var seller_id=<?php echo $this->_var['seller_list']['store_id']; ?>;
					if(seller_id == data['list'][i]['store_id']){
						opt.selected=true;
					}
					<?php endif; ?>
				<?php endif; ?>
				document.getElementsByName('store_id')[0].appendChild (opt);						
			}
		}
		
		//选择区
		function  choose_region(value){
			
			if(value){
				manager[1].value=value;
				region_manager.style.display='table-row';			
				Ajax.call('seller_list.php?act=showStore&id='+value,'', showStore, 'GET', 'JSON');
				
			}else{
				region_manager.style.display='none';
				manager=document.getElementsByName('region_manager');
				for(i=0;i<manager.length;i++){
				
					if(manager[i].checked){
						manager[i].checked=false;
					}
				}
				clear_store();
			}
		}
		
		//选择店
		function  choose_store(value){
			
			if(value){
				store[1].value=value;
				store_manager.style.display='table-row';
			}else{
				store_manager.style.display='none';
				for(i=0;i<store.length;i++){
				
					if(store[i].checked){
						store[i].checked=false;
					}
				}
			}
		}
		
		//清空店
		function clear_store(){
		
			for(o=1;o<st.length;o++){	
				if(st[o].selected){
					st[0].selected=true;
				}
			}
			
			for(i=0;i<store.length;i++){
				
					if(store[i].checked){
						store[i].checked=false;
					}
				}
			
			if(store_manager.style.display!='none'){
				store_manager.style.display='none';
			}
			
			if(store_id.style.display!='none'){
				store_id.style.display='none';
			}
	
		}
		
		
	function check(){
		var str = document.getElementById('seller_name').value;
		var str1 = document.getElementById('seller_no').value;
		var reg = /\s/g;
		var seller_name= str.replace(reg, "");
		var seller_no= str1.replace(reg, "");
		var get_reserve=document.getElementsByName('get_reserve');
	
		if(seller_name==''){
			alert('请填写业务员姓名');
			return false;
		}
		
		if(seller_no==''){
			alert('请填写账号');
			return false;
		}
		
		if(region_id.value==''){
			alert('请选择所属区域');
			return false;
		}
		if(!manager[0].checked && !manager[1].checked ){
			alert('请选择职位');
			return false;
		}else{	
			if(store_id.style.display=='table-row'){
				if(document.getElementById('sto').value==''){
					alert('请选择店铺地址');
					return false;
				}else{
					if(!store[0].checked && !store[1].checked ){
						alert('请选择店铺职位');
						return false;
					}
				}
			}
		}
		
		if(!get_reserve[0].checked && !get_reserve[1].checked){
			alert('请选择是否接受预约');
			return false;
		}
		
		if(fuiou_account_id.value==''){
			alert('请选择富友支付账号');
			return false;
		}
		if(admin_id.value==''){
			alert('请选择需要的权限');
			return false;
		}
		
		 
		
	}
		
		
		
		
		
</script>