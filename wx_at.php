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

//ˢ�¼��洢����
function checkAccessToken($appid,$appsecret){
	
	
	$where = " WHERE appid = '$appid' AND appsecret = '$appsecret' ";
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table("wx_atk") . $where;
    
	
	
	$access_token_set = $GLOBALS['db']->getRow($sql);//��ȡ����
	//print_r($access_token_set);
	
	if($access_token_set){ 
		//����Ƿ�ʱ����ʱ�����»�ȡ
		//print_r($access_token_set['AccessExpires']);
		if($access_token_set['access_expires']>time()){
            //δ��ʱ��ֱ�ӷ���access_token
			return $access_token_set['access_token'];
		}else{
			//print_r("sx!");
			//�ѳ�ʱ�����»�ȡ,��ʱˢ�£�ˢ�´洢�µ�access_token���������Ҫ�ͻ�������Ӧ����Ϊ
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
		//$access_token�������ݿ���
		if($access_token){
			$map=' appid,appsecret,access_token,access_expires,add_time ';
			$sql="insert into ".$GLOBALS['ecs']->table('wx_atk')." (".$map.") values('$appid','$appsecret','$access_token','$access_expires','$now_time')";
			$res=$GLOBALS['db']->query($sql);
			//����������ֵ���ж�
			if($res){
				return $access_token;
			}
		}
		
	}
}



function getAccessToken($appid,$appsecret){ 
	
	$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
	$res = file_get_contents($token_access_url); //��ȡ�ļ����ݻ��ȡ�������������
	$result = json_decode($res, true); //����һ�� JSON ��ʽ���ַ������Ұ���ת��Ϊ PHP ����
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
	
	
	
	