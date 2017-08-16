<?php
/**
  * wechat php test
  */

//define your token
header("Content-Type: text/html; charset=UTF-8");
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');


$res = checkAccessToken('wxb729dd15974bd159','ab6bec7a39583d5169b7ae01a360e465');
//print_r($res);

//刷新及存储数据
function checkAccessToken($appid,$appsecret){
	
	
	$where = " WHERE appid = '$appid' AND appsecret = '$appsecret' ";
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table("wx_atk") . $where;
    
	
	
	$access_token_set = $GLOBALS['db']->getRow($sql);//获取数据
	//print_r($access_token_set);
	
	if($access_token_set){ 
		//检查是否超时，超时了重新获取
		//print_r($access_token_set['AccessExpires']);
		if($access_token_set['access_expires']>time()){
            //未超时，直接返回access_token
			return $access_token_set['access_token'];
		}else{
			//print_r("sx!");
			//已超时，重新获取,定时刷新，刷新存储新的access_token相关数据需要客户触发相应的行为
			$result = getAccessToken($appid,$appsecret);
			$access_token = $result['access_token'];
			$access_expires = $result['expires_in']+time()-1200;
			$now_time = time();
			//print_r($access_token);
			$set_data = " set appid='$appid' , appsecret='$appsecret' , access_token='$access_token' , access_expires='$access_expires' , add_time='$now_time' ";
			
			$where = " WHERE appid = '$appid' AND appsecret = '$appsecret' ";
			if($access_token){
				$sql="update ".$GLOBALS['ecs']->table('wx_atk').$set_data.$where;
				$res=$GLOBALS['db']->query($sql);
				
				if($res){
					return $access_token;
				}
			}
			
		}
	}else{
		
		$result = getAccessToken($appid,$appsecret);
		$access_token = $result['access_token'];
		$access_expires = $result['expires_in']+time()-1200;
		$now_time = time();
		//print_r($now_time)."</br>";
		//print_r($result['expires_in']);
		//$access_token插入数据库中
		if($access_token){
			$map=' appid,appsecret,access_token,access_expires,add_time ';
			$sql="insert into ".$GLOBALS['ecs']->table('wx_atk')." (".$map.") values('$appid','$appsecret','$access_token','$access_expires','$now_time')";
			$res=$GLOBALS['db']->query($sql);
			//后续，返回值的判断
			if($res){
				return $access_token;
			}
		}
		
	}
}



function getAccessToken($appid,$appsecret){ 
	
	$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
	$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
	$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
	return $result;
}



function curlGet($url){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}

/*	
function getAccessToken($appid,$appsecret){ 
	$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
	$json=$this->json_decode(curlGet($url_get));
	$access_token=$json->access_token;
}	
*/	

?>
	
	
	
	