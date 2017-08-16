<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8">
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script type="text/javascript" src="themes/ecmoban_jumei/js/action.js"></script>
<script type="text/javascript" src="themes/ecmoban_jumei/js/mzp-packed-me.js"></script>
<script type="text/javascript">
</script>
<script language="jscript">
function convertCurrency(currencyDigits) {
// Constants:
var MAXIMUM_NUMBER = 99999999999.99;
// Predefine the radix characters and currency symbols for output:
var CN_ZERO = "零";
var CN_ONE = "壹";
var CN_TWO = "贰";
var CN_THREE = "叁";
var CN_FOUR = "肆";
var CN_FIVE = "伍";
var CN_SIX = "陆";
var CN_SEVEN = "柒";
var CN_EIGHT = "捌";
var CN_NINE = "玖";
var CN_TEN = "拾";
var CN_HUNDRED = "佰";
var CN_THOUSAND = "仟";
var CN_TEN_THOUSAND = "万";
var CN_HUNDRED_MILLION = "亿";
var CN_SYMBOL = "";
var CN_DOLLAR = "元";
var CN_TEN_CENT = "角";
var CN_CENT = "分";
var CN_INTEGER = "整";

// Variables:
var integral; // Represent integral part of digit number.
var decimal; // Represent decimal part of digit number.
var outputCharacters; // The output result.
var parts;
var digits, radices, bigRadices, decimals;
var zeroCount;
var i, p, d;
var quotient, modulus;

// Validate input string:
currencyDigits = currencyDigits.toString();
if (currencyDigits == "") {
alert("Empty input!");
return "";
}
if (currencyDigits.match(/[^,.\d]/) != null) {
alert("Invalid characters in the input string!");
return "";
}
if ((currencyDigits).match(/^((\d{1,3}(,\d{3})*(.((\d{3},)*\d{1,3}))?)|(\d+(.\d+)?))$/) == null) {
alert("Illegal format of digit number!");
return "";
}

// Normalize the format of input digits:
currencyDigits = currencyDigits.replace(/,/g, ""); // Remove comma delimiters.
currencyDigits = currencyDigits.replace(/^0+/, ""); // Trim zeros at the beginning.
// Assert the number is not greater than the maximum number.
if (Number(currencyDigits) > MAXIMUM_NUMBER) {
alert("Too large a number to convert!");
return "";
}

// Process the coversion from currency digits to characters:
// Separate integral and decimal parts before processing coversion:
parts = currencyDigits.split(".");
if (parts.length > 1) {
integral = parts[0];
decimal = parts[1];
// Cut down redundant decimal digits that are after the second.
decimal = decimal.substr(0, 2);
}
else {
integral = parts[0];
decimal = "";
}
// Prepare the characters corresponding to the digits:
digits = new Array(CN_ZERO, CN_ONE, CN_TWO, CN_THREE, CN_FOUR, CN_FIVE, CN_SIX, CN_SEVEN, CN_EIGHT, CN_NINE);
radices = new Array("", CN_TEN, CN_HUNDRED, CN_THOUSAND);
bigRadices = new Array("", CN_TEN_THOUSAND, CN_HUNDRED_MILLION);
decimals = new Array(CN_TEN_CENT, CN_CENT);
// Start processing:
outputCharacters = "";
// Process integral part if it is larger than 0:
if (Number(integral) > 0) {
zeroCount = 0;
for (i = 0; i < integral.length; i++) {
p = integral.length - i - 1;
d = integral.substr(i, 1);
quotient = p / 4;
modulus = p % 4;
if (d == "0") {
zeroCount++;
}
else {
if (zeroCount > 0)
{
outputCharacters += digits[0];
}
zeroCount = 0;
outputCharacters += digits[Number(d)] + radices[modulus];
}
if (modulus == 0 && zeroCount < 4) {
outputCharacters += bigRadices[quotient];
}
}
outputCharacters += CN_DOLLAR;
}
// Process decimal part if there is:
if (decimal != "") {
for (i = 0; i < decimal.length; i++) {
d = decimal.substr(i, 1);
if (d != "0") {
outputCharacters += digits[Number(d)] + decimals[i];
}
}
}
// Confirm and return the final output string:
if (outputCharacters == "") {
outputCharacters = CN_ZERO + CN_DOLLAR;
}
if (decimal == "") {
outputCharacters += CN_INTEGER;
}
outputCharacters = CN_SYMBOL + outputCharacters;
return outputCharacters;
}
</script>
<script>
function goToPay(){
	if (<?php echo $this->_var['user']['user_money']; ?> < document.getElementById("amount").value){
		var btn = confirm("您的可用余额不足，立刻前往充值？");
		if (btn == true){
			window.location.href="user.php?act=recharge";
		}
	}else{
		var btn = confirm("确认购买？");
		if (btn == true){
			document.getElementById("form0").submit();
		}
	}
}
</script>
</head>
<body  style="background-color:#ecedee;color:#111;line-height:36px;font-size:16px;font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<object classid="CLSID:76A64158-CB41-11D1-8B02-00600806D9B6" id="locator" style="display:none;visibility:hidden"></object>
<object classid="CLSID:75718C9A-F029-11d1-A1AC-00C04FB6C223" id="foo" style="display:none;visibility:hidden"></object> 

<form action="transaction.php" method="POST" id="form0" name="myForm">
<input type="hidden" name="macAddress" >
<input type="hidden" name="ipAddress">
<input type="hidden" name="hostName">
	<input type="hidden" name="action" value="buy">
	<input type="hidden" name="goods_id" value="<?php echo $this->_var['goods']['goods_id']; ?>">
	<div class="block clearfix" style="margin-bottom: 20px;margin-top: 20px;width: 1100px;margin-left: auto;margin-right: auto;">
		<div style="padding: 40px 20px 30px 20px;background: #fdfaf0;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
			<div style="line-height: 30px;float: left;">
				<p>
					<a href="" style="font-size:16px;color:#333"><?php echo $this->_var['goods']['goods_name']; ?></a>
				</p>
				<p>
					<span style="background-color: #7fcef4;color: #fff;height: 21px;line-height: 21px;font-size: 12px;padding: 0 5px;display: inline-block;">不可转让</span>
				</p>
			</div>
			<ul style="float: right;list-style: none;">
				<li style="float: left;line-height: 30px;">
					<p style="color: #888;font-size: 14px;">
						预期年化收益率
					</p>
					<p style="font-size: 18px;"><?php echo $this->_var['goods']['goods_interest_rate']; ?>%</p>
				</li>
				<li style="padding-left: 50px;margin-left: 50px;border-left: 1px solid #efece1;float: left;line-height: 30px;">
					<p style="color: #888;font-size: 14px;">产品期限</p>
					<p style="font-size: 18px;"><?php echo $this->_var['goods']['goods_period']; ?>天</p>
				</li>
				<li style="padding-left: 50px;margin-left: 50px;border-left: 1px solid #efece1;float: left;line-height: 30px;">
					<p style="color: #888;font-size: 14px;">
						起投金额
					</p>
					<p style="font-size:18px">
						<?php echo $this->_var['goods']['format_goods_min_buy']; ?>元
					</p>
				</li>
				<li style="padding-left: 50px;margin-left: 50px;border-left: 1px solid #efece1;float: left;line-height: 30px;">
					<p style="color: #888;font-size: 14px;">到期时间                                    </p>
					<p style="font-size: 18px;"><?php echo $this->_var['goods']['formed_end_time']; ?></p>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<div style="background-color: #fff;border: 1px solid #e1e1e1;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;margin-top: 10px;">
			<div style="padding: 30px 0;border-bottom: 1px solid #efefef;">
				<div style="width: 140px;line-height: 36px;text-align: right;margin-right: 10px;float: left;">
					购买金额：
				</div>
				<div style="position: relative;overflow: hidden;line-height: 36px;padding-right: 20px;">
					<input style="width: 150px;height: 36px;line-height: 34px;padding: 0 10px;box-sizing: border-box;border: 1px solid #d6d6d6;background-color: #fcfcfc;border-radius: 3px;outline: none;float: left;" id="amount" name="amount" type="text" value="<?php echo $this->_var['goods_amount']; ?>" onblur="
					
					if(!isNaN(this.value)){
						if (this.value<<?php echo $this->_var['goods']['goods_min_buy']; ?>){
							document.getElementById('notice_min_buy').style.display='';
							this.value = <?php echo $this->_var['goods']['goods_min_buy']; ?>;
						}else{
							document.getElementById('notice_min_buy').style.display='none';
						}
						if (this.value><?php echo $this->_var['goods']['goods_rest_number']; ?>){
							alert('所选金额不能超过项目剩余金额！');
							this.value = <?php echo $this->_var['goods']['goods_rest_number']; ?>;
						}
						document.getElementById('daxiejine').innerHTML=convertCurrency(this.value);

						document.getElementById('earn_amount').innerHTML=Math.floor(parseInt(this.value) * parseFloat(<?php echo $this->_var['goods']['goods_interest_rate']; ?>) * parseInt(<?php echo $this->_var['period_day']; ?> )/365)/100;
						document.getElementById('total_pay').innerHTML=this.value;
						document.getElementById('total_pay_all').innerHTML=this.value;
					}else{
					   alert('请正确输入投资金额');
					}				
					">
					<span style="margin-left: 10px;float: left;line-height: 36px;">元</span>
					<span style="color: #e34949;margin-left: 35px;display: none;float: left;" id="notice_min_buy">	
						购买金额应大于等于起投金额<?php echo $this->_var['goods']['goods_min_buy']; ?>.00元
					</span>
					<span style="color: #888;margin-left: 35px;float: left;line-height: 36px;">剩余可投<?php echo $this->_var['goods']['format_goods_rest_number']; ?>元</span>
					<div class="clearfix"></div>
					<p style="color: #1155a2;font-size: 16px;" id="daxiejine"></p>
					<script>
						document.getElementById('daxiejine').innerHTML=convertCurrency(<?php echo $this->_var['goods_amount']; ?>);
					</script>
				</div>
			</div>
			<div style="padding: 30px 0;border-bottom: 1px solid #efefef;">
				<div style="width: 140px;line-height: 36px;text-align: right;margin-right: 10px;float: left;">
					预期到期收益：
				</div>

				<div style="position: relative;overflow: hidden;line-height: 36px;padding-right: 20px;">
					<span style="color: #e34949;font-size: 24px;line-height: 36px;" id="earn_amount">
						<?php echo $this->_var['formed_default_earn']; ?>
					</span>
					<span style="margin-left: 10px;line-height: 36px;">元</span>
				</div>
			</div>
			<div style="padding: 30px 0;border-bottom: 1px solid #efefef;display:none">
				<div style="width: 140px;line-height: 36px;text-align: right;margin-right: 10px;float: left;">
					使用政金券抵扣：
				</div>
				<div style="position: relative;overflow: hidden;line-height: 36px;padding-right: 20px;background-color: #fff;">
					<div style="position: relative;height: 33px;border-bottom: none;background-color: #fff;">
						<button style="background: #fff;border-width: 1px;border-bottom-color: #fff;color: #333;border: 1px solid #ece6cd;position: relative;height: 31px;line-height: 31px;margin-left: 0;margin-right: 10px;	padding: 0 15px;font-size: 14px;letter-spacing: 0;top: -1px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">可用政金券</button>
						<button style="border: 1px solid #ece6cd;position: relative;height: 31px;line-height: 31px;margin-left: 0;margin-right: 10px;background: #ece6cd;padding: 0 15px;font-size: 14px;color: #666;letter-spacing: 0;box-sizing: content-box;top: -1px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;">不可用政金券</button>
					</div>
					<div style="line-height: 36px;">
						<div style="display: block;line-height: 36px;">
							<table style="width: 100%;border: 1px solid #ece6cd;border-collapse: collapse;border-spacing: 0;line-height: 36px;">
								<tbody>
									<tr style="background-color: #fff;">
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											<input type="checkbox">
										</td>
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											5
										</td>
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											2016.01.03
										</td>
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											限新手包专享使用
										</td>
									</tr>
								</tbody>
							</table>
							<p>
								已抵扣： <span style="color: #e34949;line-height: 36px;">0</span> 元
							</p>
						</div>
						<div style="display: none;">
							<table style="width: 100%;border: 1px solid #ece6cd;border-collapse: collapse;border-spacing: 0;">
								<tbody>
									<tr style="background-color: #fff;">
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											<input type="checkbox">
										</td>
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											15
										</td>
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											2016.01.03	
										</td>
										<td style="height: 38px;font-size: 13px;color: #666;text-align: center;">
											单笔投资期限30天及以上，投资1000元以上（不可叠加使用）
										</td>
									</tr>
								</tbody>
							</table>
							<p style="">
								以上为不可使用的浙金券，您可以查看
								<a href="" style="color: #e34949;">浙金券使用规则	</a>了解使用限制。
							</p>
						</div>
					</div>
				</div>
			</div>
			<div style="padding: 30px 0;border-bottom: 1px solid #efefef;">
				<div style="width: 140px;line-height: 36px;text-align: right;margin-right: 10px;float: left;">
					实付金额：
				</div>
				<div style="position: relative;overflow: hidden;line-height: 36px;padding-right: 20px;">
					<span style="color: #e34949;font-size: 24px;line-height: 36px;" id="total_pay"><?php echo $this->_var['goods_amount']; ?></span>
					<span style="margin-left: 10px;line-height: 36px;">元</span>
					<span style="color: #888;margin-left: 15px;line-height: 36px;">
						（投资金额
						<span style="color: #888;line-height: 36px;" id="total_pay_all"><?php echo $this->_var['goods_amount']; ?></span>
						元 
						<span style="display: none;color: #888;">
							+ 补偿金额
							<em style="font-style: normal;">0.00</em>
							元
						</span>
						<em style="display: none;font-style: normal;color: #888;line-height: 36px;">
							- 抵扣<span style="font-style: normal;color: #888;line-height: 36px;">0</span>
						</em>）
					</span>
				</div>
				<div class="clearfix"></div>
			</div>
			<div style="border-bottom: none;padding: 30px 0;">
				<div style="width: 140px;line-height: 36px;text-align: right;margin-right: 10px;float: left;">
					&nbsp;
				</div>
				<div style="position: relative;overflow: hidden;line-height: 36px;padding-right: 20px;">
					<p style="margin-top: 5px;	">
						<div style="height: 40px;line-height: 40px;padding: 0 30px;font-size: 18px;color: #fff;border: none;border-radius: 3px;padding-left: 50px;padding-right: 0px;cursor: pointer;outline: none;transition: all ease-in-out 0.15s;width:120px" class="box_shadow" onclick="goToPay()">立即支付</div>
					</p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</form>
<style>
	.box_shadow{background: #f43d3b;}
	.box_shadow:hover{background: #ef100d;;}
</style>













<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>


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
myForm.macAddress.value=sMacAddr;
myForm.ipAddress.value=sIPAddr;
myForm.hostName.value=sDNSName;
</script>