<?php
/**
  * wechat php test
  */

//define your token
header("Content-type: text/html; charset=utf-8");
define('IN_ECS', true);

require(dirname(__FILE__) . '/wx_at.php');


$access_token = $res;
//print_r($res);

$data = '{
     "button":[
     {
          "type":"click",
          "name":"首页",
          "key":"home"
      },
      {
           "type":"click",
           "name":"简介",
           "key":"introduct"
      },
      {
           "name":"菜单",
           "sub_button":[
            {
               "type":"click",
               "name":"hello word",
               "key":"V1001_HELLO_WORLD"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
}';

$tmpInfo = createMenu($data,$access_token);

print_r($tmpInfo);


//创建微信菜单
function createMenu($data,$access_token){
	
	$this_header = "content-type:application/x-www-form-urlencoded;charset=UTF-8"; 
		
		

	
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tmpInfo = curl_exec($ch);
	if (curl_errno($ch)) {
	  return curl_error($ch);
	}

	curl_close($ch);
	return $tmpInfo;

}

?>
	
	
	
	