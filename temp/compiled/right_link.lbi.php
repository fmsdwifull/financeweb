



<div onmouseout="noshow()" style="position:fixed;top:280px;right:0px;z-index:100;width:180px;height:230px;"></div>

<div style="position:fixed;top:300px;right:0px;z-index:100;font-size:10px;">

	<div style="float:left;margin-top:3px;color:white;">
		<a href="http://jq.qq.com/?_wv=1027&k=2Fu76dw" style="color:white;">
			<div id="b_1" style="background:red;width:100px;height:80px;padding-top:10px;display:none;">
				<div style="border:1px solid white;text-align:center;height:20px;line-height:20px;border-radius:5px;width:70px;margin:0 auto;">QQ客服</div>
				<div style="text-align:center;margin-top:15px;">理财客户群</div>
				<div style="text-align:center;margin-top:5px;">516257883</div>
			</div>
		</a>
		<div id="b_2" style="background:red;width:100px;height:130px;margin-top:43px;display:none;">
			<div style="padding:5px;">
				<img style="width:90px;" src="themes/ecmoban_jumei/images/wc_code.png"/>
			</div>
			<div style="text-align:center;">政金网公众号</div>
		</div>
		<div onclick="document.getElementById('cover').style.display='';document.getElementById('calculator').style.display='';document.getElementById('calculator_amount').value=document.getElementById('buy_number').value;" id="b_3" style="background:red;width:100px;height:40px;line-height:40px;text-align:center;cursor:pointer;margin-top:86px;display:none;">
			计算机
		</div>
		<div id="b_4" style="background:red;width:100px;height:40px;line-height:40px;text-align:center;margin-top:129px;cursor:pointer;display:none;">
			返回顶部
		</div>
	</div>
	
	<div style="float:right;" class="right_link">
		<div id="bt_1" onmouseover="show_block(1)">
			<img style="" src="themes/ecmoban_jumei/images/QQ.png"/>
		</div>
		<div id="bt_2" onmouseover="show_block(2)">
			<img style="" src="themes/ecmoban_jumei/images/wechat.png"/>
		</div>
		
		<div id="bt_3" onclick="document.getElementById('cover').style.display='';document.getElementById('calculator').style.display='';document.getElementById('calculator_amount').value=document.getElementById('buy_number').value;" onmouseover="show_block(3)">
			<img style="" src="themes/ecmoban_jumei/images/calculator.png"/>
		</div>
		<div id="bt_4" onmouseover="show_block(4)">
			<img style="" src="themes/ecmoban_jumei/images/backtop.png"/>
		</div>
	</div>
</div>





<div style="position:fixed;width:500px;height:410px;top:230px;left:700px;z-index:300;font-family:微软雅黑;background:gray;display:none;" id="cal_mac">
	<div class="funframe" style="color:blue;padding:30px 0 10px 0;">
        <ul class="rslist">
		  <li style="margin-left:100px;"> <span class="n_text">投资期限：</span>
			<input name="date_limit" id="date_limit" type="text" title="投资期限" value="1">
			<label style="margin-left:16px;">
			<input style="width:20px;" type="radio" name="date_type" id="date_1" value="1" checked="checked">
				月
			</label>
			<label style="margin-left:20px;">
			<input style="width:20px;" type="radio" name="date_type" id="date_2" value="2">
				日
			</label>
		  </li>
          <li style="margin-left:100px;margin-top:20px;"> 
			<span class="n_text">投资利率：</span>
            <input name="rate" id="rate" type="text" value="22">
				%
            <label>
            <input style="width:20px;" type="radio" name="rate_type" class="rate_type" value="1" checked="checked">
				年利率
			</label>
          </li>
          
          <li style="margin-left:100px;margin-top:20px;"> 
			<span class="n_text">投资金额：</span>
            <input name="amount" id="amount" type="text" value="10000" title="金额">
            元 
		  </li>
          
          
        </ul>
    </div>
	<div style="color:blue;width:200px;float:left;margin-left:100px;">
	  <div onclick="calbx()" style="text-align: center;width:80px;height:30px;line-height:30px;border:1px solid black;float:left">
			计算
	  </div>
	  
	  <div id="result" style="color:blue;height:30px;line-height:30px;text-align:center;margin-left:16px;;width:80px;height:30px;border:1px solid black;float:left">
	  
	  </div>
	</div>
	
	<div onclick=" document.getElementById('cal_mac').style.display='none' " style="color:blue;width:80px;border:1px solid black;border-radius:10px;height:30px;line-height:30px;text-align:center;float:left;margin-left:20px;">
		关闭计算器
	</div>
</div>

<div style="position:fixed;top:0;left:0;height:100%;width:100%;background-color:black;opacity:0.7;z-index:9;display:none" id="cover"></div>
<div style="left: 435px;top: 170px;display: block;opacity: 1;position: fixed;width: 522px;box-sizing: border-box;border-radius: 3px;background-color: #fff;z-index: 10;display:none" id="calculator">

	<button style="float: right;font-size: 21px;font-weight: bold;color: #627689;text-shadow: 0 1px 0 #ffffff;padding: 0;border: 0;-webkit-appearance: none;width: 35px;height: 35px;line-height: 35px;text-align: center;margin-top: 10px;margin-right: 10px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;" onclick="document.getElementById('cover').style.display='none';document.getElementById('calculator').style.display='none'" class="box_shadow6">
		×
	</button>	<div style="height: 56px;line-height: 56px;font-size: 18px;font-weight: normal;color: #d01a0b;padding-left: 30px;">
		投资计算器
	</div>

	<div style="padding: 30px;">
		<dl style="font-size: 14px;">
			<dt style="height: 50px;line-height: 30px;float: left;width: 104px;text-align: right;position: relative;">
				投资产品：
			</dt>
			<dd style="height: 50px;line-height: 30px;padding-left: 122px;position: relative;">
				<?php echo $this->_var['goods']['goods_name']; ?>
			</dd>
			<div class="clearfix"></div>
			<dt style="float: left;width: 104px;line-height: 40px;text-align: right;">
				投入金额：
			</dt>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<input type="text" style="width: 240px;height: 40px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="total" value="" id="calculator_amount">   元
			</dd>
			<div class="clearfix"></div>
			<dt style="float: left;width: 104px;line-height: 40px;text-align: right;position: relative;">
				投入时长：
			</dt>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<input type="text" style="width: 240px;height: 40px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="days" value="<?php echo $this->_var['goods']['goods_period']; ?>" id="calculator_period">   天
			</dd>
			<div class="clearfix"></div>
			<dt style="float: left;width: 104px;line-height: 40px;text-align: right;position: relative;">
				年化利率：
			</dt>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<input type="text" style="width: 240px;height: 40px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;padding: 12px;line-height: 20px;outline: none;" name="rate" value="<?php echo $this->_var['goods']['goods_interest_rate']; ?>" id="calculator_interest_rate">   %
			</dd>
			<div class="clearfix"></div>
			
			<script>
				function calculate(){
					document.getElementById('calculator_earn').innerHTML=
					(document.getElementById('calculator_amount').value * document.getElementById('calculator_interest_rate').value*document.getElementById('calculator_period').value/36500).toFixed(2);
					
					document.getElementById('calculator_total').innerHTML=parseFloat((document.getElementById('calculator_amount').value*document.getElementById('calculator_interest_rate').value*document.getElementById('calculator_period').value/36500).toFixed(2))+parseFloat(document.getElementById('calculator_amount').value);
				}
			</script>
			<dd style="padding-left: 122px;height: 60px;line-height: 40px;position: relative;">
				<button style="width: 114px;height: 45px;font-size: 14px;color: #fff;border: none;border-radius: 3px;padding-left: 35px;padding-right: 35px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;margin: 0;padding: 0;background:#6AB2E7" onclick="calculate()" class="box_shadow7">
					计算
				</button>
			</dd>
		</dl>
		<h4 style="position: relative;height: 60px;line-height: 60px;font-size: 18px;font-weight: normal;color: #d01a0b;">
			<span style="background-color: #fff;padding-right: 10px;display: inline-block;position: relative;">
				计算结果
			</span>
		</h4>
		<dl style="font-size: 14px;">
			<dt style="height: 33px;float: left;width: 104px;line-height: 40px;text-align: right;position: relative;">
				到期收益：
			</dt>
			<dd style="height: 20px;padding-left: 10px;line-height: 20px;position: relative;">
				到期收款合计 
				<em style="color: #e34949;line-height: 40px;" id="calculator_total">0</em>
				 元
			</dd>
			<dd style="height: 20px;padding-left: 10px;line-height: 20px;position: relative;">
				收益收入共 
				 <em style="color: #e34949;line-height: 40px;" id="calculator_earn">0</em>
				  元
			</dd>
		</dl>
	</div>
</div>




<style>
	.right_link div{
		padding:10px;
		margin-top:3px;
		width:20px;height:20px;
		background:#7a6e6e;
	}
	.right_link img{
		display:block;
		margin:0 auto;
		width:20px;
	}
	.rslist input{
		width:80px;
		text-align:center;
	}
	
	
</style>



<script>



	
	function show_block(key){
		
		document.getElementById("b_1").style.display="none";
		document.getElementById("b_2").style.display="none";
		document.getElementById("b_3").style.display="none";
		document.getElementById("b_4").style.display="none";
		
		
		
		document.getElementById("bt_1").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_2").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_3").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_4").style.backgroundColor="#7a6e6e";
		
		if(key==1){
			document.getElementById("b_1").style.display="";
			document.getElementById("bt_1").style.backgroundColor="red";
		}
		if(key==2){
			document.getElementById("b_2").style.display="";
			document.getElementById("bt_2").style.backgroundColor="red";
		}
		if(key==3){
			document.getElementById("b_3").style.display="";
			document.getElementById("bt_3").style.backgroundColor="red";
		}
		if(key==4){
			document.getElementById("b_4").style.display="";
			document.getElementById("bt_4").style.backgroundColor="red";
		}
		
	}
	
	function noshow(){
		document.getElementById("b_1").style.display="none";
		document.getElementById("b_2").style.display="none";
		document.getElementById("b_3").style.display="none";
		document.getElementById("b_4").style.display="none";
		
		
		
		document.getElementById("bt_1").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_2").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_3").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_4").style.backgroundColor="#7a6e6e";
		
	}
	
	
	
	function calbx(){
		
		var date_str = getDateStr();
		var date_arr = date_str.split(",");
		var res = isLeapYear(date_arr[0]);
		
		
		if(document.getElementById("date_1").checked){
			var date_limit = document.getElementById("date_limit").value;
			var dates = date_limit*30;
		}
		else if(document.getElementById("date_2").checked){
			var dates = document.getElementById("date_limit").value;
		}
		var rate = document.getElementById("rate").value;
		var ratenew = parseInt(rate);
		var date_rate_new = (ratenew/1200)/30;
		//alert(date_rate_new);
		
		
		var amount = parseInt(document.getElementById("amount").value);
		
		dates_new= parseInt(dates);
		
		var result = date_rate_new*amount*dates_new;
		
		resultnew = (amount+result).toFixed(2);
		
		document.getElementById("result").innerHTML = resultnew;
		
	}
	
	function isLeapYear(year){
	
		
		if(year % 4 == 0 && ((year % 100 != 0) || (year % 400 == 0)))
		{
			 return true;
		}
		return false;
	}
	
	
	function getDateStr(){
		var d = new Date(), str = '';
		str += d.getFullYear() + ',';
		str += d.getMonth() + 1 + ',';
		str += d.getDate();
		return str;
	}
	
	
</script>
 

 


