<link href="themes/ecmoban_jumei/qq/images/qq.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>







<div id="Top" style="padding-bottom:2px;font-size:12px">
	<div class="tops"></div>
    <div class=" block header_bg" style="margin-bottom:0px;">
        
        <div class="top_nav_header">
            <div class="top_nav">
                <script type="text/javascript">
                    //初始化主菜单
                    function sw_nav(obj,tag){
                        var DisSub = document.getElementById("DisSub_"+obj);
                        var HandleLI= document.getElementById("HandleLI_"+obj);
                        if(tag==1){
                            DisSub.style.display = "block";
                        }else{
                            DisSub.style.display = "none";
                        }
                    }
                </script>
                <div class="block">
                	<div class="f_l left_login">
                    	<font id="ECS_MEMBERZONE" > 客服电话：<span style="color: #e34949;font-size: 16px;">400-820-7259</span></font>
                    </div>
			    
                	<div class="f_l left_login" style="float:right">
                    	<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
                    	<font id="ECS_MEMBERZONE" ><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </font>
                    </div>

                    <div class="header_r">
                
                     <?php if ($this->_var['navigator_list']['top']): ?>
                        <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
                               <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a>
                                <?php if (! ($this->_foreach['nav_top_list']['iteration'] == $this->_foreach['nav_top_list']['total'])): ?>
                                <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                     
                    </div>
                </div>
            </div>
        </div>
        <div class="clear_f"></div>
        <div class="block" style="padding-top:5px">
            <a>
				<img src="themes/ecmoban_jumei/images/logo.png" style="float:left;width:150px"/>
				<div style="float:left;vertical-align:middle;font-size:15px;font-family:微软雅黑;margin-top:23px;margin-left:5px">
					<p>
						与国家共命运&nbsp;&nbsp;&nbsp;与地方共发展
					</p>
					<p>
						中国政信投资影响力平台
					</p>
				</div>

			</a>
			<ul style="padding-top: 35px;float: left;list-style: none;margin-left:50px;">
				<li style="margin-left: 0;float: left;position: relative;">
					<a href="index.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">首页</a>
				</li>
				<li style="margin-left: 30px;float: left;position: relative;">
					<a href="category-5-0-0-0.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">理财频道</a>
				</li>
				<li style="margin-left: 30px;float: left;position: relative;">
					<a href="guangjin.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">备案机构</a>
				</li>
				<li style="margin-left: 30px;float: left;position: relative;">
					<a href="transfer.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">转让专区</a>
				</li>
				<li style="margin-left: 30px;float: left;position: relative;">
					<a href="store.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">线下门店</a>
				</li>	
				<li style="margin-left: 30px;float: left;position: relative;">
					<a href="user.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">账户资产</a>
				</li>
				<li style="margin-left: 30px;float: left;position: relative;">
					<a href="about_us-36.html" style="font-size: 16px;color: #333;display: inline-block;height: 35px;line-height: 35px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">关于我们</a>
					
				</li>
			</ul>
 				<div class="clearfix"></div>           

        </div>
    </div>
</div>





<div style="clear:both"></div>
 

 

 


