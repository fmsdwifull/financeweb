<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<script type="text/javascript" src="themes/ecmoban_jumei/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="themes/ecmoban_jumei/js/jquery.json.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>


</head>
<body style="font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;background-color: #ecedee;font-size: 16px;">
<object classid="CLSID:76A64158-CB41-11D1-8B02-00600806D9B6" id="locator" style="display:none;visibility:hidden"></object>
<object classid="CLSID:75718C9A-F029-11d1-A1AC-00C04FB6C223" id="foo" style="display:none;visibility:hidden"></object>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="block block1">


<?php if ($this->_var['action'] == 'login'): ?>

<form name="formLogin" action="user.html" method="post" onSubmit="return userLogin()" id="login_form">
<input type="hidden" name="macAddress" >
<input type="hidden" name="ipAddress">
<input type="hidden" name="hostName">
	<div style="margin-bottom: 60px;margin-top: 60px;">
		<div style="position: relative;height: 445px;width: 1100px;margin-left: auto;margin-right: auto;">
			<img src="themes/ecmoban_jumei/images/login_banner.jpg">
			<div style="position: absolute;right: 0;top: 0;padding: 30px 40px;width: 303px;background-color: #fff;border: 1px solid #e0e0e0;">
				<div class="clearfix">
					<span style="color: #888;font-size: 24px;float: left;">登录</span>
					<span style="margin-top: 10px;float: right;">
						没有帐号？ 
						<a href="user-register.html" style="color: #1155a2;text-decoration: none;">现在注册</a>
					</span>
				</div>
				<div style="display: table;margin-top: 20px;width: 100%;">
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							帐 号：
						</div>
						<div style="padding-top: 15px;padding-bottom: 15px;position: relative;display: table-cell;vertical-align: middle;">
							<input type="text" name="username" placeholder="请输入手机号码或用户名" value="" style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;">
						</div>
					</div>
					<div style="display: table-row;margin-top:50px;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							密 码：
						</div>
						<div style="padding-top: 15px;padding-bottom: 15px;position: relative;display: table-cell;vertical-align: middle;">
							<input type="password" name="password" placeholder="请输入密码" value="" style="width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;">
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							业务员编号：
						</div>
						<div style="padding-top: 15px;padding-bottom: 15px;position: relative;display: table-cell;vertical-align: middle;">
							<input type="password" name="seller_no" placeholder="选填" value="" style="width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;">
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 10px;padding-bottom: 5px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
						</div>
						<div style="padding-top: 10px;padding-bottom: 5px;position: relative;display: table-cell;vertical-align: middle;">
							<label style="float: left;">
								<input type="checkbox" value="1" name="remember" id="remember" checked>记住密码
							</label>
							<a href="user-get_password.html" style="color: #888;float: right;">忘记密码？</a>
						</div>
					</div>
				</div>
				<input type="hidden" name="act" value="act_login" />
				<input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
				<button style="background: #f52020;height: 46px;line-height: 46px;font-size: 16px;margin-top: 20px;width: 100%;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" onclick="document.getElementById('login_form').submit()">立即登录</button>
				<div style="width: 100%;height: auto;line-height: 1.5;font-size: 13px;color: #666;text-align: center;background: #fff;position: static;left: 0;vertical-align: middle;border-top: none;top: 15px;margin-top: 20px;bottom: 0;z-index: 190;">
					<a href="index.html" style="color: #333;text-decoration: none;line-height: 1.5;font-size: 13px;">
						<span style="margin-right: 5px;">
							<img src="themes/ecmoban_jumei/images/ico-shield.png" style="position: relative;top: 3px;">
						</span>
						<span style="color: #333;line-height: 1.5;font-size: 13px;">账户安全由人保财险承保</span>
					</a>
				</div>
			</div>
		</div>
	
	</div>
</form>
</div>

<?php endif; ?>



    <?php if ($this->_var['action'] == 'register'): ?>
    <?php if ($this->_var['shop_reg_closed'] == 1): ?>
    <div class="usBox">
      <div class="usBox_2 clearfix">
        <div class="f1 f5" align="center"><?php echo $this->_var['lang']['shop_register_closed']; ?></div>
      </div>
    </div>
    <?php else: ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
<script src="themes/ecmoban_jumei/js/sms.js"></script>
<form action="user.html" method="post" name="formUser" onsubmit="return register2();">
	<input type="hidden" name="flag" id="flag" value="register" />
	<div style="margin-bottom: 60px;margin-top: 30px;">
		<div style="background-color: #fff;border: 1px solid #e0e0e0;width: 1100px;margin-left: auto;margin-right: auto;">
			<div style="height: 700px;width: 350px;padding-bottom: 50px;margin-left: 50px;float: left;">
				<div style="margin-top:48px">
					<p style="position: relative;font-size: 32px;color: #aaa;font-family:黑体;font-weight:bold">
						注册
					</p>
				</div>
				<div style="display: table;width: 100%;margin-top: 40px;">
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 手机号码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="text" style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="mobile" placeholder="请输入手机号码" id="mobile_phone" onchange="checkForm1()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice1">
								请输入正确手机号码。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;padding-right: 28px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;text-align: right;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span> 验证码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="width: 144px;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;float: left;" type="text" placeholder="输入验证码" name="mobile_code" id="mobile_code" onchange="checkForm2()">
							<input style="text-align:center;width: 90px;height: 42px;line-height: 42px;color: #ed8a32;background: #f8eacb;border: 1px solid #f8eacb;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float: right;" id="zphone" name="sendsms" onClick="sendSms();" value="发送验证码">
						</div>
					</div>
					<div style="display: table-row;margin-top:100px;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span>
							 输入密码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="password" type="password" id="password1"  placeholder="8-20位，必须含有字母和数字">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice2">
								请输入8-20位，必须含有字母和数字。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 重复密码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="password" style="width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;	" placeholder="再次输入密码" name="password2" id="password2" onchange="checkForm4()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice3">
								两次密码不一致。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 业务员编号：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="password" style="width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;	" placeholder="业务员编号" name="seller_no" id="seller_no">
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
						</div>
						<div style="display: table-row;padding-top: 5px
						;padding-bottom: 15px;line-height: 1;position: relative;display: table-cell;vertical-align: middle;position: relative;">
							<label style="width:200px">
								<input type="checkbox"  id="check_box" name="agreement" value="1" checked="checked" onclick="checkForm5()">我同意《	<a href="" target="_blank" style="color: #1155a2;text-decoration: none;line-height: 1;">政金网用户协议</a>
									》
							</label>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
						</div>
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;position: relative;	display: table-cell;vertical-align: middle;">
<style>
	.box_shadow{
		background: #f75151;
	}
	.box_shadow:hover{
		background: #f52020;
	}
</style>
							<input style="background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;background: #b6b5b6;;width: 100%;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: default;outline: none;transition: all ease-in-out 0.15s;" name="Submit" type="button" disabled value="立即注册" id="fake_reg">
							<input style="display:none;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;width: 100%;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" name="Submit" type="submit" value="立即注册" id="reg" class="box_shadow">
						</div>
<script>
	function checkButton(){
		if (check1()&&check2()&&check3()&&check4()&&check5()
			&&(document.getElementById("mobile_phone").value.length==11)
			&&(isChrOrNum(document.getElementById("password1").value))
			&&(!isNum(document.getElementById("password1").value))
			&&(!isChr(document.getElementById("password1").value))
			&&(document.getElementById("password1").value.length>=8)
			&&(document.getElementById("password1").value.length<=20)
			&&(document.getElementById("password1").value==document.getElementById("password2").value))
		{
			document.getElementById("reg").style.display="";
			document.getElementById("fake_reg").style.display="none";				
		}else{
			document.getElementById("reg").style.display="none";
			document.getElementById("fake_reg").style.display="";		
		}
	}

	function checkForm1(){
		if ((document.getElementById("mobile_phone").value.length==0)
			||(document.getElementById("mobile_phone").value.length==11)){
			document.getElementById("notice1").style.display="none";
		}else{
			document.getElementById("notice1").style.display="";
		}
		checkButton();
	}

	function checkForm2(){
		checkButton();
	}

	function isChrOrNum(c){
		var Regx = /^[A-Za-z0-9]*$/;
		if (Regx.test(c))
		{
			return true;
		}else{
			return false;
		}
	}

	function isNum(c){
		var Regx = /^[0-9]*$/;
		if (Regx.test(c))
		{
			return true;
		}else{
			return false;
		}	
	}
	
	function isChr(c){
		var Regx = /^[A-Za-z]*$/;
		if (Regx.test(c))
		{
			return true;
		}else{
			return false;
		}	
	}
	
	function checkForm3(){		
		if ((isChrOrNum(document.getElementById("password1").value))
			&&(!isNum(document.getElementById("password1").value))
			&&(!isChr(document.getElementById("password1").value))
			&&(document.getElementById("password1").value.length>=8)
			&&(document.getElementById("password1").value.length<=20)){
			document.getElementById("notice2").style.display="none";
		}else{
			document.getElementById("notice2").style.display="";
		}
		if (document.getElementById("password1").value==document.getElementById("password2").value){
			document.getElementById("notice3").style.display="none";
		}else{
			document.getElementById("notice3").style.display="";
		}
		checkButton();
	}

	function checkForm4(){
		if (document.getElementById("password1").value==document.getElementById("password2").value){
			document.getElementById("notice3").style.display="none";
		}else{
			document.getElementById("notice3").style.display="";
		}
		checkButton();
	}

	function checkForm5(){
		checkButton();
	}	
	function check1(){
		if (document.getElementById("mobile_phone").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check2(){
		if (document.getElementById("mobile_code").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check3(){
		if (document.getElementById("password1").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check4(){
		if (document.getElementById("password2").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check5(){
		if (document.getElementById("check_box").checked){
			return true;
		}else{
			return false;
		}
	}
</script>
					</div>
				</div>
				<div style="position: static;border-top: none;background: transparent;width: 100%;height: 31px;line-height: 31px;font-size: 14px;color: #333;text-align: center;left: 0;bottom: 0;z-index: 190;vertical-align: middle;">
					<a href="index.html" style="color: #333;text-decoration: none;line-height: 31px;font-size: 14px;text-align: center;">
						<span style="margin-right: 5px;">
							<img src="themes/ecmoban_jumei/images/ico-shield.png" style="position: relative;top: 3px;">
						</span>
						<span>请前往&nbsp;<a style="color:blue" href="store.html">线下门店</a>&nbsp;进行现场注册，谢谢！</span>
					</a>
				</div>
			</div>
			
			<div style="position: relative;width: 640px;padding-top: 120px;text-align: center;float: right;">
				<img style="width:400px;margin:0 auto" src="themes/ecmoban_jumei/images/login.gif" style="text-align: center;">
			</div>
			
			<div class="clearfix"></div>
		</div>
	</div>
	<input name="act" type="hidden" value="act_register" >
	<input name="enabled_sms" type="hidden" value="1" />
	<input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
</form>
<?php endif; ?>
<?php endif; ?>



    <?php if ($this->_var['action'] == 'get_password'): ?>
<script>
	function checkButton(){
		if (check1()&&check2()&&check3()&&check4()
			&&(document.getElementById("mobile_phone").value.length==11)
			&&(isChrOrNum(document.getElementById("password1").value))
			&&(!isNum(document.getElementById("password1").value))
			&&(!isChr(document.getElementById("password1").value))
			&&(document.getElementById("password1").value.length>=8)
			&&(document.getElementById("password1").value.length<=20)
			&&(document.getElementById("password1").value==document.getElementById("password2").value))
		{
			document.getElementById("reg").style.display="";
			document.getElementById("fake_reg").style.display="none";				
		}else{
			document.getElementById("reg").style.display="none";
			document.getElementById("fake_reg").style.display="";		
		}
	}

	function checkForm1(){
		if ((document.getElementById("mobile_phone").value.length==0)
			||(document.getElementById("mobile_phone").value.length==11)){
			document.getElementById("notice1").style.display="none";
		}else{
			document.getElementById("notice1").style.display="";
		}
		checkButton();
	}

	function checkForm2(){
		checkButton();
	}

	function isChrOrNum(c){
		var Regx = /^[A-Za-z0-9]*$/;
		if (Regx.test(c))
		{
			return true;
		}else{
			return false;
		}
	}

	function isNum(c){
		var Regx = /^[0-9]*$/;
		if (Regx.test(c))
		{
			return true;
		}else{
			return false;
		}	
	}
	
	function isChr(c){
		var Regx = /^[A-Za-z]*$/;
		if (Regx.test(c))
		{
			return true;
		}else{
			return false;
		}	
	}
	
	function checkForm3(){		
		if ((isChrOrNum(document.getElementById("password1").value))
			&&(!isNum(document.getElementById("password1").value))
			&&(!isChr(document.getElementById("password1").value))
			&&(document.getElementById("password1").value.length>=8)
			&&(document.getElementById("password1").value.length<=20)){
			document.getElementById("notice2").style.display="none";
		}else{
			document.getElementById("notice2").style.display="";
		}
		if (document.getElementById("password1").value==document.getElementById("password2").value){
			document.getElementById("notice3").style.display="none";
		}else{
			document.getElementById("notice3").style.display="";
		}
		checkButton();
	}

	function checkForm4(){
		if (document.getElementById("password1").value==document.getElementById("password2").value){
			document.getElementById("notice3").style.display="none";
		}else{
			document.getElementById("notice3").style.display="";
		}
		checkButton();
	}

	function checkForm5(){
		checkButton();
	}	
	function check1(){
		if (document.getElementById("mobile_phone").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check2(){
		if (document.getElementById("mobile_code").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check3(){
		if (document.getElementById("password1").value){
			return true;
		}else{
			return false;
		}
	}
	
	function check4(){
		if (document.getElementById("password2").value){
			return true;
		}else{
			return false;
		}
	}

</script>
<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
<script src="themes/ecmoban_jumei/js/sms.js"></script>
<form action="user.html" method="post" name="formUser" onsubmit="return register2();">
	<input type="hidden" name="flag" id="flag" value="forget" />
	<div style="margin-bottom: 60px;margin-top: 30px;">
		<div style="background-color: #fff;border: 1px solid #e0e0e0;width: 1100px;margin-left: auto;margin-right: auto;">
			<div style="height: 700px;width: 350px;padding-bottom: 50px;margin-left: 50px;float: left;">
				<div style="margin-top:48px">
					<p style="position: relative;font-size: 32px;color: #aaa;font-family:黑体;font-weight:bold">
						找回密码
					</p>
				</div>
				<div style="display: table;width: 100%;margin-top: 40px;">
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 手机号码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="text" style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="mobile" placeholder="请输入手机号码" id="mobile_phone" onchange="checkForm1()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice1">
								请输入正确手机号码。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;text-align: right;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span> 验证码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="width: 149px;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;float: left;" type="text" placeholder="输入验证码" name="mobile_code" id="mobile_code"onchange="checkForm2()">
							<input style="text-align:center;width: 90px;height: 42px;line-height: 42px;color: #ed8a32;background: #f8eacb;border: 1px solid #f8eacb;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;float: right;" id="zphone" name="sendsms" onClick="sendSms();" value="发送验证码">
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;text-align: right;">*</span>
							 新密码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="password" type="password" id="password1" placeholder="8-20位，必须含有字母和数字" onchange="checkForm3()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice2">
								请输入8-20位，必须含有字母和数字。
							</p>
						</div>
					</div>
					<div style="display: table-row;">
						<div style="padding-top: 15px;padding-bottom: 15px;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
							<span style="color: #e34949;white-space: nowrap;">*</span> 重复密码：
						</div>
						<div style="position: relative;line-height: 44px;padding-top: 15px;padding-bottom: 15px;display: table-cell;vertical-align: middle;">
							<input type="password" style="width: 100%;height: 44px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;font-family: 'Microsoft YaHei', 微软雅黑, SimSun, '宋体', Heiti, '黑体';font-size: 14px;	" placeholder="再次输入密码" name="password2" id="password2" onchange="checkForm4()">
							<p style="display:none;color: #f75151;font-size: 12px;position: absolute;bottom: -20px;left: 0;width: 100%;" id="notice3">
								两次密码不一致。
							</p>
						</div>
					</div>

					<div style="display: table-row;">
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;width: 1%;white-space: nowrap;position: relative;display: table-cell;vertical-align: middle;">
						</div>
						<div style="padding-top: 0;padding-bottom: 15px;line-height: 1;position: relative;	display: table-cell;vertical-align: middle;">
<style>
	.box_shadow{
		background: #f75151;
	}
	.box_shadow:hover{
		background: #f52020;
	}
</style>
							<input style="margin-top:20px;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;background: #b6b5b6;;width: 100%;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: default;outline: none;transition: all ease-in-out 0.15s;" name="Submit" type="button" disabled value="重置密码" id="fake_reg">
							<input style="margin-top:20px;display:none;background-image: none;box-shadow: none;height: 40px;line-height: 40px;font-size: 16px;width: 100%;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 50px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" name="Submit" type="submit" value="重置密码" id="reg" class="box_shadow">
						</div>
					</div>
				</div>

			</div>
			<div style="position: relative;width: 640px;padding-top: 180px;text-align: center;float: right;">
		<!--		<img src="themes/ecmoban_jumei/images/register_banner_30.png" style="text-align: center;">-->
			</div>
			
			<div class="clearfix"></div>
		</div>
	</div>
	<input name="act" type="hidden" value="act_get_password_m" >
	<input name="enabled_sms" type="hidden" value="1" />
	<input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
</form>

<?php endif; ?>


    <?php if ($this->_var['action'] == 'qpassword_name'): ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.html" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['get_question_username']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['username']; ?></td>
            <td width="61%"><input name="user_name" type="text" size="30" class="inputBg" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="get_passwd_question" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
	    </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>


    <?php if ($this->_var['action'] == 'get_passwd_question'): ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.html" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['input_answer']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['passwd_question']; ?>：</td>
            <td width="61%"><?php echo $this->_var['passwd_question']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['passwd_answer']; ?>：</td>
            <td><input name="passwd_answer" type="text" size="20" class="inputBg" /></td>
          </tr>          <?php if ($this->_var['enabled_captcha']): ?>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
            <td><input type="text" size="8" name="captcha" class="inputBg" />
            <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
          </tr>
          <?php endif; ?>
          
          <tr>
            <td> </td>
<td><input type="hidden" name="act" value="check_answer" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
	    </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'reset_password'): ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.html" method="post" name="getPassword2" onSubmit="return submitPwd()">
      <br />
      <table width="80%" border="0" align="center">
        <tr>
          <td><?php echo $this->_var['lang']['new_password']; ?></td>
          <td><input name="new_password" type="password" size="25" class="inputBg" /></td>
        </tr>
        <tr>
          <td><?php echo $this->_var['lang']['confirm_password']; ?>:</td>
          <td><input name="confirm_password" type="password" size="25"  class="inputBg"/></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="hidden" name="act" value="act_edit_password" />
            <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
            <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
            <input type="submit" name="submit" value="<?php echo $this->_var['lang']['confirm_submit']; ?>" />
          </td>
        </tr>
      </table>
      <br />
    </form>
  </div>
</div>

<?php endif; ?>

</div>
<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
</script>
</html>
<script language="javascript">
var sMacAddr="";
var sIPAddr="";
var sDNSName="";
var service = locator.ConnectServer();
service.Security_.ImpersonationLevel=3;
service.InstancesOfAsync(foo, 'Win32_NetworkAdapterConfiguration');
</script>
<script FOR="foo" EVENT="OnObjectReady(objObject,objAsyncContext)" LANGUAGE="JScript">
         if(objObject.IPEnabled != null && objObject.IPEnabled != "undefined" && objObject.IPEnabled == true){
                           if(objObject.IPEnabled && objObject.IPAddress(0) !=null && objObject.IPAddress(0) != "undefined")
                                         sIPAddr = objObject.IPAddress(0);
                           if(objObject.MACAddress != null &&objObject.MACAddress != "undefined")
                     sMacAddr = objObject.MACAddress;
                           if(objObject.DNSHostName != null &&objObject.DNSHostName != "undefined")
                                         sDNSName = objObject.DNSHostName;
          }
</script>
<script FOR="foo" EVENT="OnCompleted(hResult,pErrorObject, pAsyncContext)" LANGUAGE="JScript">

formLogin.macAddress.value=sMacAddr;
formLogin.ipAddress.value=sIPAddr;
formLogin.hostName.value=sDNSName;
</script>
