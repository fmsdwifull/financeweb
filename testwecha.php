<?php
/*
  作者：黄宝
*/

namespace Wechat\ResponseMsg;

//define your token
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

define("TOKEN", "123456abc");
$wechatObj = new wechatCallbackapi();
if ($_GET["echostr"]){
	//微信首次服务器验证
	$wechatObj->valid();
}else{
	//
	wechatCallbackapi::responseMsg();
	
}


class wechatCallbackapi
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	//不写static不会产生严重错误，程序执行，但会产生一个'Strict Standards'的提示！
	public static function responseMsg()
	{
		print_r("123");
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){

			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$msgType = trim($postObj->MsgType);//消息类型
			$event = trim($postObj->Event);//事件类型
			if($msgType=='event'){
				 switch ($event)  
				 {  
					 case "introduct":  
					 $contentStr = 
		"猫咪酱个性DIY服装，  
		我们专业定制个性【班服，情侣装，亲子装等，有长短T恤，卫衣，长短裤】   
		来图印制即可，给你温馨可爱的TA，  
		有事可直接留言微信";  
					 break;  
					   
					 case "2":  
		  
		  
					 $contentStr = "你点击了菜单: ".$object->EventKey;  
					 break;  
					   
					 case "3":  
					 $contentStr = "是傻逼";  
					 break;  
					   
					 default:  
					 $contentStr = "你点击了菜单: ".$object->EventKey;  
					 break;  
				 }
				 
				$textTpl = "<xml>  
					<ToUserName><![CDATA[%s]]></ToUserName>  
					<FromUserName><![CDATA[%s]]></FromUserName>  
					<CreateTime>%s</CreateTime>  
					<MsgType><![CDATA[text]]></MsgType>  
					<Content><![CDATA[%s]]></Content>  
					</xml>";  
				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $contentStr);  
				
				echo $resultStr; 

			}else{
				$textTpl = "<xml>  
					<ToUserName><![CDATA[%s]]></ToUserName>  
					<FromUserName><![CDATA[%s]]></FromUserName>  
					<CreateTime>%s</CreateTime>  
					<MsgType><![CDATA[text]]></MsgType>  
					<Content><![CDATA[%s]]></Content>  
					</xml>";
				$contentStr = 
		"普通文本消息！"; 
				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $contentStr);  
				
				echo $resultStr; 
			}
			
		}
		
	}
	
	
	public static function getUsercumulate(){
		return file_get_contents("https://api.weixin.qq.com/datacube/getusercumulate?access_token=".$access_token);
	}
	
	
	
	
}







?>
	
	
	
	