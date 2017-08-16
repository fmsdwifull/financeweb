<?php echo $this->fetch('library/user_header.lbi'); ?>
<div class="user-register"> 
 <?php if ($this->_var['shop_reg_closed'] == 1): ?>
    <p class="text-center" style="font-size: x-large;"><?php echo $this->_var['lang']['shop_register_closed']; ?></p>

    <?php else: ?>
  <?php if ($this->_var['enabled_sms_signin'] == 1): ?>
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#one" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['mobile_login']; ?></a></li>
    <li><a href="#two" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['emaill_login']; ?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="one">
      <form action="<?php echo url('user/register');?>" method="post" name="formUser" onsubmit="return register2();">
        <input type="hidden" name="flag" id="flag" value="register" />
        <div class="flow-consignee ect-bg-colorf">
          <ul>
            <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['mobile']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_mobile']; ?>" name="mobile" id="mobile_phone" type="text">
                </span></div>
            </li>
			<?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
			<?php if ($this->_var['field']['id'] == 6): ?>
			<li>
        <div class="form-select"> <i class="fa fa-sort"></i>
          <select name="sel_question">
            <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
            
            <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'],'selected'=>$this->_var['field']['passwd_question'])); ?>
          
          </select>
        </div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['passwd_answer']; ?>:</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" name="passwd_answer" type="text" value="<?php echo $this->_var['profile']['passwd_answer']; ?>" />
          </span></div>
      </li>
			<?php else: ?>
			<li <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>>
				<div class="input-text"><b><?php echo $this->_var['field']['reg_field_name']; ?>：</b>
				<span>
					<input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" size="25" class="inputBg"  <?php if ($this->_var['field']['is_need']): ?> style="width:85%;"<?php endif; ?> /><?php if ($this->_var['field']['is_need']): ?><font style="color:#FF0000;float:right"> *</font><?php endif; ?>
                </span></div>
			</li>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <li>
              <div class="input-text code"><b><?php echo $this->_var['lang']['code']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_code']; ?>" name="mobile_code" id="mobile_code" type="text" >
                </span> <a class="pull-right ect-bg" id="zphone" name="sendsms" onClick="sendSms();" type="botton"><?php echo $this->_var['lang']['get_code']; ?></a></div>
            </li>
          </ul>
        </div>
        <p class="ect-checkbox ect-padding-tb ect-margin-tb ect-margin-bottom0 ect-padding-lr">
          <input id="agreement1" name="agreement" type="checkbox" value="1" checked="checked" >
          <label for="agreement1"><?php echo $this->_var['lang']['agreement']; ?><i></i></label>
        </p>
        <div class="ect-padding-lr ect-padding-tb">
          <input name="act" type="hidden" value="act_register" />
          <input name="enabled_sms" type="hidden" value="1" />
          <input type="hidden" name="sms_code" value="<?php echo $this->_var['sms_code']; ?>" id="sms_code" />
          <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
          <button name="Submit" type="submit" class="btn btn-info ect-btn-info ect-colorf ect-bg"><?php echo $this->_var['lang']['register']; ?></button>
        </div>
      </form>
    </div>
    <script type="text/javascript" src="__PUBLIC__/js/sms.js"></script> 
    <?php endif; ?>
    <div class="tab-pane" id="two">
      <form action="<?php echo url('user/register');?>" method="post" name="formUser" class="validforms" >
        <input type="hidden" name="flag" id="flag" value="register" />
        <div class="flow-consignee ect-bg-colorf">
          <ul>
          <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['label_username']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_username']; ?>" name="username" type="text" id="username" datatype="*3-15" errormsg="<?php echo $this->_var['lang']['msg_mast_length']; ?>" />
                </span></div>
            </li>
            <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['email']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_emaill']; ?>" name="email" type="text" id="email" datatype="e" />
                </span></div>
            </li>
            <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['password']; ?>：</b><span>
                <input  placeholder="<?php echo $this->_var['lang']['no_password']; ?>" class="inputBg" name="password" id="password1" type="password" datatype="*6-16">
                <input placeholder="<?php echo $this->_var['lang']['no_password']; ?>" class="inputBg" id="password_text" type="text" style="display:none;">
                </span><i class="glyphicon glyphicon-eye-open" onClick="clickText();"></i></div>
            </li>
			
			<?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
			<?php if ($this->_var['field']['id'] == 6): ?>
			<li>
        <div class="form-select"> <i class="fa fa-sort"></i>
          
		  <select name='sel_question'>
		  	<option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
                  <?php $_from = $this->_var['password_question']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'question');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['question']):
?>
   					 <option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['question']; ?></option>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </select>
        </div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['passwd_answer']; ?>:</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" name="passwd_answer" type="text" value="<?php echo $this->_var['profile']['passwd_answer']; ?>" />
          </span></div>
      </li>
			<?php else: ?>
			<li>
				<div class="input-text"><b><?php echo $this->_var['field']['reg_field_name']; ?>：</b>
				<span>
					<input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" size="25" class="inputBg" <?php if ($this->_var['field']['is_need']): ?> style="width:85%;"<?php endif; ?> /><?php if ($this->_var['field']['is_need']): ?><font style="color:#FF0000;float:right"> *</font><?php endif; ?>
                </span></div>
			</li>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			
             <?php if ($this->_var['enabled_captcha']): ?>
            <li>
              <div class="input-text code"><b><?php echo $this->_var['lang']['code']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_code']; ?>"  name="captcha" id="captcha" type="text" datatype="*" />
                </span><img class="pull-right" src="<?php echo url('public/captcha', array('rand'=>$this->_var['rand']));?>" alt="captcha"  onClick="this.src='<?php echo url('public/captcha');?>&t='+Math.random()" /></div>
            </li>
             <?php endif; ?>
          </ul>
        </div>
        <p class="ect-checkbox ect-padding-tb ect-margin-tb ect-margin-bottom0 ect-padding-lr">
          <input id="agreement" name="agreement" type="checkbox" value="1" checked="checked" />
          <label for="agreement"> <?php echo $this->_var['lang']['agreement']; ?><i></i></label>
        </p>
        <div class="ect-padding-lr ect-padding-tb">
          <input name="act" type="hidden" value="act_register" />
          <input name="enabled_sms" type="hidden" value="0" />
          <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
          <button href="flow_consignee.html" name="Submit" type="submit" class="btn btn-info ect-btn-info ect-colorf ect-bg"><?php echo $this->_var['lang']['next']; ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>
</div>
<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer.lbi'); ?>
<script type="text/javascript">
/*点击更换密码框为文本框*/
function clickText(){
	if($("#password_text").is(":hidden")&&$("#password1").is(":visible")&&!$(".input-text .glyphicon-eye-open").hasClass("glyphicon-eye-close")){
	  	var pwd = $("#password1").val();
       	$("#password1").hide();
       	$("#password_text").val(pwd).show();
		$(".input-text .glyphicon-eye-open").addClass("glyphicon-eye-close");
	}else{
		var pwd_text = $("#password_text").val();
       	$("#password_text").hide();
       	$("#password1").val(pwd_text).show();
		$(".input-text .glyphicon-eye-open").removeClass("glyphicon-eye-close");			
	}
}
function blurText(){
	if($("#password_text").is(":hidden")&&$("#password1").is(":visible")&&!$(".input-text .glyphicon-eye-open").hasClass("glyphicon-eye-close")){
	  	var pwd = $("#password1").val();
       	$("#password_text").val(pwd);
	}else{
		var pwd_text = $("#password_text").val();
       	$("#password1").val(pwd_text);		
	}
}
</script>