<?php

header("Content-Type: text/html; charset=UTF-8");
define('IN_ECS', true);
require(dirname(__FILE__) . '/wx_at.php');


$access_token = $res;
print_r($res."</br>");

$data = '{
    "button": [
        {
            "name": "扫码", 
            "sub_button": [
                {
                    "type": "scancode_waitmsg", 
                    "name": "扫码带提示", 
                    "key": "rselfmenu_0_0", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "scancode_push", 
                    "name": "扫码推事件", 
                    "key": "rselfmenu_0_1", 
                    "sub_button": [ ]
                }
            ]
        }, 
        {
            "name": "发图", 
            "sub_button": [
                {
                    "type": "pic_sysphoto", 
                    "name": "系统拍照发图", 
                    "key": "rselfmenu_1_0", 
                   "sub_button": [ ]
                 }, 
                {
                    "type": "pic_photo_or_album", 
                    "name": "拍照或者相册发图", 
                    "key": "rselfmenu_1_1", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "pic_weixin", 
                    "name": "微信相册发图", 
                    "key": "rselfmenu_1_2", 
                    "sub_button": [ ]
                }
            ]
        }, 
        {
            "name": "发送位置", 
            "type": "location_select", 
            "key": "rselfmenu_2_0"
        }
    ]
}';
//$data = utf8_encode($data);
$tmpInfo = createMenu($data,$access_token);
//可怕，例子是2014-12-07，现在是2016-12-07;

$temp = time()-3*24*60*60;
$last_thtoday = date("Y-m-d",$temp);
$temp = time()-1*24*60*60;
$last_ontoday = date("Y-m-d",$temp);


/*
$time_long = '{
    "begin_date": $last_thtoday, 
    "end_date": $last_ontoday
}';
*/

$time_long = array(
	'begin_date'=>$last_thtoday,
	'end_date'=>$last_ontoday
);
$time_long = json_encode($time_long);
//print_r($time_long);

//$res = getUsercumulate($time_long,$access_token);

//print_r($res);

print_r($tmpInfo);


//创建微信菜单
function createMenu($data,$access_token){
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tmpInfo = curl_exec($ch);
	if (curl_errno($ch)) {
	  return curl_error($ch);
	}

	curl_close($ch);
	
	$jsoninfo = json_decode($tmpInfo,true); 
	return $jsoninfo;
	
}

//获取菜单
function getMenu($access_token){
	return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$access_token);
}

//删除菜单
function deleteMenu($access_token){
	return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token);
}



function getUsercumulate($data,$access_token){
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/datacube/getusercumulate?access_token=".$access_token);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tmpInfo = curl_exec($ch);
	if (curl_errno($ch)) {
	  return curl_error($ch);
	}

	curl_close($ch);
	
	$jsoninfo = json_decode($tmpInfo,true); 
	return $jsoninfo;
}








?>
	
	
	
	