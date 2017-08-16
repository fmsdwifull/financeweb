<?php
/**
  * wechat php test
  */

//define your token
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');



$res = getAccessToken('wxb729dd15974bd159','ab6bec7a39583d5169b7ae01a360e465');

print_r($res);


//刷新及存储数据
function checkAccessToken($appid,$appsecret){
        $condition = array('appid'=>$appid,'appsecret'=>$appsecret);
	$access_token_set=M('AccessToken')->where($condition)->find();//获取数据
	if($access_token_set){ 
		//检查是否超时，超时了重新获取
		if($access_token_set['AccessExpires']>time()){
                        //未超时，直接返回access_token
			return $access_token_set['access_token'];
		}else{
                        //已超时，重新获取
			$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
			$json=json_decode(curlGet($url_get));
			$access_token=$json->access_token;
			$AccessExpires=time()+intval($json->expires_in);
			$data['access_token']=$access_token;
			$data['AccessExpires']=$AccessExpires;
			$result = M('AccessToken')->where($condition)->save($data);//更新数据
			if($result){
				return $access_token;
			}else{
				return $access_token;
			}
		}
	}else{
                /*数据库中无$appid,$appsecret对应的记录需要再做处理，如插入到数据库		
		return 0;*/
	}
}



function getAccessToken($appid,$appsecret){ 
	
	$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
	$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
	$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
	$access_token = $result['access_token'];
	
	return $access_token;
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
	
	
	
	