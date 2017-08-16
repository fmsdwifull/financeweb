
<?php if ($this->_var['user_info']): ?>

&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">|</span>&nbsp;&nbsp;&nbsp;&nbsp;<a id="user_have" href="user.html" style="font-family:微软雅黑" ><?php echo $this->_var['user_info']['username']; ?></a> |
 <a href="user-logout.html"  style="color:#999;font-family:微软雅黑"><?php echo $this->_var['lang']['user_logout']; ?></a> |
 
  <?php else: ?> 
  
&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">|</span>&nbsp;&nbsp;&nbsp;&nbsp;<a id="user_haveno" href="user.html" style="color:#999;font-family:微软雅黑">登录</a> &nbsp;&nbsp;&nbsp;&nbsp;<a  href="user-register.html" style="color:#999;font-family:微软雅黑">注册</a>
 
 <?php endif; ?>