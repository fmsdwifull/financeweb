<?php echo $this->fetch('library/user_header.lbi'); ?>
<p class="ect-padding-lr ect-margin-tb ect-margin-bottom0"><?php echo $this->_var['lang']['label_get_password']; ?> <?php if ($this->_var['action'] == 'get_password_phone' && $this->_var['enabled_sms_signin'] == 1): ?><?php echo $this->_var['lang']['photo_number']; ?><?php endif; ?> 
  <?php if ($this->_var['action'] == 'get_password_email'): ?><?php echo $this->_var['lang']['email']; ?><?php endif; ?> 
  <?php if ($this->_var['action'] == 'get_password_question'): ?><?php echo $this->_var['lang']['safe_question']; ?><?php endif; ?> <?php echo $this->_var['lang']['reset_password']; ?></p>
<?php if ($this->_var['action'] == 'get_password_phone' && $this->_var['enabled_sms_signin'] == 1): ?>
<form  action="<?php echo url('user/get_password_phone');?>" method="post" name="getPassword" onSubmit="return submitForget();">
<div class="flow-consignee ect-bg-colorf" id="tabBox1-bd">
  <section>    
      <ul>
        <li>
          <div class="input-text"><b><?php echo $this->_var['lang']['mobile']; ?>：</b><span>
          <input placeholder="<?php echo $this->_var['lang']['no_mobile']; ?>" name="mobile" id="mobile_phone" type="text" />
            </span></div>
        </li>
        <li>
          <div class="input-text code"><b><?php echo $this->_var['lang']['code']; ?>：</b><span>
            <input placeholder="<?php echo $this->_var['lang']['no_code']; ?>" name="mobile_code" id="mobile_code" type="text" /></span>
            <a class="pull-right ect-bg" id="zphone" name="sendsms" onclick="sendSms();" type="botton"><?php echo $this->_var['lang']['get_code']; ?></a>
            </div>
        </li>
      </ul>
  </section>
</div>
<div class="ect-padding-lr ect-padding-tb">
<input name="act" type="hidden" value="send_pwd_sms" />
<input type="hidden" name="sms_code" value="<?php echo $this->_var['sms_code']; ?>" id="sms_code" />
<input name="Submit" type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn btn-info ect-btn-info ect-colorf ect-bg" />
</div>
<p class="ect-padding-lr ect-margin-tb text-right ect-margin-bottom0" style="clear:both"><a href="<?php echo url('user/get_password_question');?>" class="f6"><?php echo $this->_var['lang']['get_password_by_question']; ?></a>&nbsp;&nbsp;<a href="<?php echo url('user/get_password_email');?>" class="f6"><?php echo $this->_var['lang']['get_password_by_mail']; ?></a></p>
</form>
<script src="__PUBLIC__/js/sms.js" type="text/javascript"></script> 
<?php endif; ?> 

<?php if ($this->_var['action'] == 'get_password_email'): ?>
<form action="<?php echo url('user/send_pwd_email');?>" method="post" name="getPassword" onsubmit="return submitPwdInfo();">
  <div class="flow-consignee ect-bg-colorf" id="tabBox1-bd">
    <ul>
      <li>
        <div class="input-text"><b><?php echo $this->_var['lang']['username']; ?>：</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['username']; ?>" class="inputBg" name="user_name" type="text" />
          </span></div>
      </li>
      <li>
        <div class="input-text"><b><?php echo $this->_var['lang']['email']; ?>:</b><span>
          <input placeholder="<?php echo $this->_var['lang']['email']; ?>" name="email" type="text" />
          </span></div>
      </li>
      <?php if ($this->_var['enabled_captcha']): ?>
      <li>
        <div class="input-text code"><b><?php echo $this->_var['lang']['comment_captcha']; ?>：</b><span>
          <input placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" type="text" name="captcha"/>
          </span> <img class="pull-right" src="<?php echo url('public/captcha', array('is_login'=>1, 'rand'=>$this->_var['rand']));?>" alt="captcha" onClick="this.src='<?php echo url('public/captcha', array('is_login'=>1));?>&t='+Math.random()" /></div>
      </li>
      <?php endif; ?>
    </ul>
  </div>
  <input name="act" type="hidden" value="send_pwd_email" />
  <div class="ect-padding-lr ect-padding-tb">
    <input name="Submit" type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn btn-info ect-btn-info ect-colorf ect-bg" />
  </div>
</form>
<p class="text-right ect-padding-lr"><a href="<?php echo url('user/get_password_question');?>"><?php echo $this->_var['lang']['get_password_by_question']; ?></a>&nbsp;&nbsp;<?php if ($this->_var['enabled_sms_signin'] == 1): ?><a href="<?php echo url('user/get_password_phone');?>"><?php echo $this->_var['lang']['get_password_by_mobile']; ?></a><?php endif; ?>
  </dd>
</p>
<?php endif; ?> 
<?php if ($this->_var['action'] == 'get_password_question'): ?>
 <form action="<?php echo url('user/get_password_question');?>" method="post" name="getPassword" class="validforms">
  <div class="flow-consignee ect-bg-colorf" id="tabBox1-bd">
    <ul>
      <li>
        <div class="input-text"><b><?php echo $this->_var['lang']['username']; ?>：</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['username']; ?>" name="user_name" type="text" datatype="*" />
          </span></div>
      </li>
      <li>
      <div class="form-select">
          <i class="fa fa-sort"></i>
        <select name='sel_question'>
                  <?php $_from = $this->_var['password_question']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'question');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['question']):
?>
   					 <option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['question']; ?></option>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </select>
                </div>
      </li>
      <li>
      <div class="input-text"><b><?php echo $this->_var['lang']['passwd_answer']; ?>:</b><span>
      	<input placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" name="passwd_answer" type="text" datatype="*"/></span></div>
      </li>
      <?php if ($this->_var['enabled_captcha']): ?>
      <li>
        <div class="input-text code"><b><?php echo $this->_var['lang']['comment_captcha']; ?>：</b><span>
          <input placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" type="text" name="captcha"/>
          </span><img class="pull-right" src="<?php echo url('public/captcha', array('is_login'=>1, 'rand'=>$this->_var['rand']));?>" alt="captcha" onClick="this.src='<?php echo url('public/captcha', array('is_login'=>1));?>&t='+Math.random()" /></div>
      </li>
      <?php endif; ?>
    </ul>
  </div>
  <input name="act" type="hidden" value="send_pwd_email" />
  <div class="ect-padding-lr ect-padding-tb">
    <input name="Submit" type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn btn-info ect-btn-info ect-colorf ect-bg" />
  </div>
</form>
<p class="text-right ect-padding-lr"><a href="<?php echo url('user/get_password_email');?>" class="f6"><?php echo $this->_var['lang']['get_password_by_mail']; ?></a>&nbsp;&nbsp;<?php if ($this->_var['enabled_sms_signin'] == 1): ?><a href="<?php echo url('user/get_password_phone');?>" class="f6"><?php echo $this->_var['lang']['get_password_by_mobile']; ?></a><?php endif; ?>
</p>
<?php endif; ?> 
</div>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?> 
<script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
</baby>
</html>