<?php
/**
  * wechat php test
  */

//define your token
define('IN_ECS', true);


require(dirname(__FILE__) . '/wx_at.php');

//print_r($res);

$access_token = $res;

$data = 
'{
    "industry_id1":"1",
    "industry_id2":"2"
}';

$tmpInfo = set_indas($data,$access_token);

print_r($tmpInfo);

function set_indas($data,$access_token){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=".$access_token);
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
	return $tmpInfo;

}

?>
	
	
	
	