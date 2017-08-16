<?php
class AospClient{
	
	
	private $apiAddress;
	private $partnerKey;
	private $secret;
	
	function AospClient($apiAddress,$partnerKey,$secret){
		$this->apiAddress=$apiAddress;
		$this->partnerKey=$partnerKey;
		$this->secret=$secret;
	}
	
	
	function save($aospRequest){
		$apiHost="/save";
		$aospResponse=$this->createHttpPostAll($this->apiAddress,$apiHost,$this->partnerKey,$this->secret,$aospRequest);
		return $aospResponse;
	}
	function send($url,$param,$method='POST'){
		$apiAddress=$this->apiAddress;
		$partnerKey=$this->partnerKey;
		$aospResponse=new AospResponse();
		$ContentType="application/x-www-form-urlencoded";
		$ch = curl_init();
		$date=date('Ymdhis',time());
		
		$common     = array('action' => $url, 'reqtime' => $date);
		$request    = array('common' => $common, 'content' =>  array ($param));
		$arrbody    = array('request' => $request);
		$body       = json_encode($arrbody);
		$reqlength=strlen($body);
		$header = array (
			"Content-Type:$ContentType",
			"reqtime:$date",
			"reqlength:$reqlength",
			"partnerKey:$partnerKey",
			"sdkversion:php_1.0.0"
		);
		 $postParams= http_build_query( $param);
		//请求不同
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		if($method=="POST"){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postParams);
		}else if($method=="GET"){
			$url+="?"+$postParams;
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch); 
		$curl_errno = curl_errno($ch);
		$curl_error=curl_error($ch); 
    	curl_close($ch);
    	if($curl_errno>0){
    		$aospResponse->setMsg("系统维护中");
				$aospResponse->setCode(-1);
    	}else {
    		  $data_content = json_decode($data,true);
    		      $aospResponse->setMsg($data_content['msg']);
				  $aospResponse->setCode($data_content['code']);
				  $aospResponse->setData($data_content['data']);
    	}
    	return $aospResponse;
	}
	function createHttpPostAll($apiAddress,$apiHost,$partnerKey,$secret,$aospRequest) {
		
		$aospResponse=new AospResponse();
		$data = ""; 
		$boundary = substr(md5(time()),8,16);
		$bussinsesData = $aospRequest->getData();
		$reqdata = json_encode($bussinsesData);
		$md5 = md5($reqdata);
		$aospRequest->setMd5($md5);
		$content_array=(array)$aospRequest;
		$contents = json_encode($content_array);
		$aospFiles = $aospRequest->getList();
		if($aospFiles==null){
	   		$data .= "\r\n{$contents}\r\n";  
			$ContentType="application/json;charset=utf-8";
		}else{
			$data .= "--{$boundary}\r\n";  
	   		$data .= "Content-Disposition: form-data; name=\"content\"\r\n";  
	    	$data .= "\r\n{$contents}\r\n";  
	    	$data .= "--{$boundary}\r\n";  
	    	$ContentType="multipart/form-data; charset=utf-8;boundary=".$boundary;
	    	foreach ($aospFiles as $aospFile) {
	    		
				if ($aospFile->getFile() != null) {
					$file = $aospFile->getFile();
					
				} else {
					if ($aospFile->getFileFullPath() != null) {
						$file=$aospFile->getFileFullPath();		
					}
				}
				$filename = basename($file); 
				if(file_exists(iconv('UTF-8','gbk',$file))){
					$length=filesize($file);
					$suffix=substr(strrchr($file, '.'), 1); //文件类型  
					$fileNameFAosp=urlencode($aospFile->getFileName().".".$suffix);
					if($aospFile->getEncryptionAlgorithm()!=null){
						$fileNameFAosp=$fileNameFAosp."_"."encryptionAlgorithm".$aospFile->getEncryptionAlgorithm();
					}
					$filestring = @file_get_contents(iconv('UTF-8','gbk',$file)); 
					//$fileMd5=md5($filestring);
					$data .= "--{$boundary}\r\n";
					$data .= "Content-Disposition: form-data; name=\"$fileNameFAosp\"; filename=\"$filename\"\r\n";
					$data .= "Content-Type: $suffix\r\n";  
					$data .= "\r\n$filestring\r\n"; 
				}else{
					$filename = $aospFile->getFileName();
					$handle = fopen ($file, "rb"); 
					$contents = ""; 
					$length=filesize($file);
					$filestring = stream_get_contents($handle); 
					$data .= "--{$boundary}\r\n";
					$data .= "Content-Disposition: form-data; name=\"$filename\"; filename=\"$filename\"\r\n";
					$data .= "Content-Type: $suffix\r\n";  
					$data .= "\r\n$filestring\r\n"; 
					fclose($handle); 
					if($contents=""){
						print_r("222222222");
						$aospResponse->setMsg("保全附件".$filename."不存在,请选择正确的附件");
						$aospResponse->setCode(110065);
						return $aospResponse;
					}
				}
			}
			$data .= "\r\n--{$boundary}--\r\n"; 
		}
		$url=$apiAddress.$apiHost;
		$ch = curl_init();
		$date=date('Ymdhis',time());
		$header = array (
			"Content-Type:$ContentType",
			"reqtime:$date",
			"reqlength:$length",
			"partnerKey:$partnerKey",
			"sdkversion:php_1.0.0"
		);
		curl_setopt($ch, CURLOPT_URL, $url);     
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  //设置头信息的地方  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   		curl_setopt($ch, CURLOPT_HEADER, false);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//
   		curl_setopt($ch, CURLOPT_POST, 1);
   		curl_setopt($ch,CURLOPT_NOSIGNAL,1);//注意，毫秒超时一定要设置这个 
		curl_setopt($ch,CURLOPT_TIMEOUT_MS,60000);//超时毫秒，cURL7.16.2中被加入。从PHP5.2.3起可使用 
		$data = curl_exec($ch); 
		$curl_errno = curl_errno($ch);
		$curl_error=curl_error($ch); 
    	curl_close($ch);
    	if($curl_errno>0){
    		$aospResponse->setMsg("系统维护中");
			$aospResponse->setCode(100010);
    	}else {
    		  $data_content = json_decode($data,true);
    		  $aospResponse->setMsg($data_content['msg']);
				  $aospResponse->setCode($data_content['code']);
				  $aospResponse->setData($data_content['data']);
    	}
    	return $aospResponse;
	}
}



class AospResponse{
	 /** 返回信息编号 */
        public $Code ;

        /** 返回信息 */
        public $Msg ;

        /** 日志信息 */
        public $Logno;

        /** 保全开放平台版本号 */
        public $Serversion ;

        public $Data = array();


		public function setData($Data){
			$this->Data=$Data;
		}
		public function getData(){
			return $this->Data;
		}
//        public function AospResponse() {
//            $this->Code = 100000;
//            $this->Msg = "成功";
//        }
        
        public function setCode($Code){
        	$this->Code=$Code;
        }
        public function getCode(){
        	return $this->Code;
        }
        public function setMsg($Msg){
        	$this->Msg=$Msg;
        }
        public function getMsg(){
        	return $this->Msg;
        }
        public function setLogno($Logno){
        	$this->Logno=$Logno;
        }
        public function getLogno(){
        	return $this->Logno;
        }
        public function setServersion($Serversion){
        	$this->Serversion=$Serversion;
        }
        public function getServersion(){
        	return $this->Serversion;
        }
        
}

class AospRequest{
	/** 接入事项Key */
	public $itemKey;
	/** 保全号 */
	public $recordNo;
	/** 流程编号 */
	public $flowNo;
	/** 每页多少条 */
	public $pageSize;
	/** 页码 */
	public $pageNo;
	/** md5码 */
	public $md5;
	/**个人用户*/
	public $clientUser;
	/**企业用户*/
	public $enterprise;
	
	/** 要保全的文件列表 */
	public $list =array();
	/** 要保全的非文件类型数据 */
	public $data = array();
	
	public function setData($data){
		$this->data=$data;
	}
	public function getData(){
		return $this->data;
	}
	public function setList($list){
		$this->list=$list;
	}
	public function getList(){
		return $this->list;
	}
	public function  setItemkey($itemKey){
		$this->itemKey=$itemKey;
	}
	public function getItemKey(){
		return $this->itemKey;
	}
	public function setRecordNo($recordNo){
		$this->recordNo=$recordNo;
	}
	public function getRecordNo(){
		return $this->recordNo;
	}
	public function setFlowNo($flowNo){
		$this->flowNo=$flowNo;
	}
	public function getFlowNo(){
		return $this->flowNo;
	}
	public function setPageSize($pageSize){
		$this->pageSize=$pageSize;
	}
	public function getPageSize(){
		return $this->pageSize;
	}
	public function setPageNo($pageNo){
		$this->pageNo=$pageNo;
	}
	public function getPageNo(){
		return $this->pageNo;
	}
	public function setMd5($md5){
		$this->md5=$md5;
	}
	public function getMd5(){
		return $this->md5;
	}
	public function setClientUser($clientUser){
		$this->clientUser=$clientUser;
	}
	public function getClientUser(){
		return $this->clientUser;
	}
	public function setEnterprise($enterprise){
		$this->enterprise=$enterprise;
	}
	public function getEnterprise(){
		return $this->enterprise;
	}
	

	public function addFile($fileFullPath, $fileName) {
		$aospfile = new AospFile($fileFullPath, $fileName);
		array_push($this->list, $aospfile);
		return $this->list;
	}
}

class AospFile {

	/** 附件 */
	public $file;
	/** 附件全路径 */
	public $fileFullPath;
	/** 附件中文名 */
	public $fileName;
	/**加密算法*/
	public $encryptionAlgorithm;

	function AospFile($fileFullPath, $fileName) {
		$this->fileFullPath = $fileFullPath;
		$this->fileName = $fileName;
	}
	

	public function getFileName() {
		return $this->fileName;
	}

	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}

	public function getFile() {
		return $this->file;
	}

	public function setFile($file) {
		$this->file = $file;
	}

	public function getFileFullPath() {
		return $this->fileFullPath;
	}

	public function setFileFullPath($fileFullPath) {
		$this->fileFullPath = $fileFullPath;
	}

	public function getEncryptionAlgorithm() {
		return $this->encryptionAlgorithm;
	}

	public function setEncryptionAlgorithm($encryptionAlgorithm) {
		$this->encryptionAlgorithm = $encryptionAlgorithm;
	}

}


class ClientUser{
	
	public $userIdcard;
	
	public $userMobile;
	
	public $userTruename;

	public function getUserIdcard() {
		return $this->userIdcard;
	}

	public function setUserIdcard($userIdcard) {
		$this->userIdcard = $userIdcard;
	}

	public function getUserMobile() {
		return $this->userMobile;
	}

	public function setUserMobile($userMobile) {
		$this->userMobile = $userMobile;
	}

	public function getUserTruename() {
		return $this->userTruename;
	}

	public function setUserTruename($userTruename) {
		$this->userTruename = $userTruename;
	}
}

class Enterprise{
	public $orgCode;

	public $orgName;

	public $orgEmail;
	
	public function setOrgCode($orgCode){
		$this->orgCode=$orgCode;
	}
	public function getOrgCode(){
		return $this->orgCode;
	}
	public function setOrgName($orgName){
		$this->orgName=$orgName;
	}
	public function getOrgName(){
		return $this->orgName;
	}
	public function setOrgEmail($orgEmail){
		$this->orgEmail=$orgEmail;
	}
	public function getOrgEmail(){
		return $this->orgEmail;
	}
}
?>