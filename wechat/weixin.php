<?php
/**
  * wechat php test
  */

//define your token
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
define("TOKEN", "bernDota2HuangBao123");
$wechatObj = new wechatCallbackapiTest();
if ($_GET["echostr"]){
	$wechatObj->valid();
}else{
	$wechatObj->responseMsg();
}


class wechatCallbackapiTest
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

    public function responseMsg()
    {
		
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;  // ÄÃµ½openid
				$event = $postObj->Event;
				if ($event == "subscribe"){
					$sql = "SELECT * FROM ".$GLOBALS["ecs"]->table("wx_users")." WHERE open_id = '".$fromUsername."'";
					$wx_user = $GLOBALS["db"]->getRow($sql);
					if (!$wx_user){
						$eventKey = $postObj->EventKey;
						$x = explode('qrscene_',$eventKey);
						$parent_id = $x[1]?$x[1]:0;

						$sql = "INSERT INTO ".$GLOBALS["ecs"]->table("wx_users")." (open_id, parent_id) VALUES('".$fromUsername."','".$parent_id."')";
						$GLOBALS["db"]->query($sql);
					}else{
						if ($wx_user["parent_id"] == 0){
							$sql = "UPDATE ".$GLOBALS["ecs"]->table("wx_users")." SET parent_id = ".$parent_id." WHERE open_id = '".$fromUsername."'";
							$GLOBALS["db"]->query($sql);
						}
					}
					exit;
				}
        }else {

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
}

?>
	
	
	
	