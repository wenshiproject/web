<?php
require_once("qiniu/io.php");
require_once("qiniu/fop.php");
require_once("qiniu/rs.php");
	
class Model_Api_Qiniumodel extends Model{
	private	$accessKey	= 'ipsHVoXQcXquT-9IxS9wLqZ5fAwn-gSlCCs8bVGN';
	private $secretKey	= 'C0seVXuLTu2aQMzNlVBsyxiB2IUx5aL7OwR-5S8D';
	private $bucket = 'kaolagift';
	private $domain = 'kaolagift.qiniudn.com';
	public function __construct(){
		Qiniu_SetKeys($this->accessKey, $this->secretKey);
	}
	
	public function upload($type, $tmp){
		$hm=floor(microtime()*1000);
		$key=date("YmdHis"). $hm . $type;
		$putPolicy = new Qiniu_RS_PutPolicy($this->bucket);
		$upToken = $putPolicy->Token(null);
		$putExtra = new Qiniu_PutExtra();
		$putExtra->Crc32 = 1;
		list($ret, $err) = Qiniu_PutFile($upToken, $key, $tmp, $putExtra);
		if ($err !== null) {
			return false;
		} else {
			return $key;
		}
	}
	
	public function delete($key){
		$client = new Qiniu_MacHttpClient(null);
		$err = Qiniu_RS_Delete($client, $this->bucket, $key);
		if ($err !== null) {
		    return false;
		} else {
		    return true;
		}
	}
	
	public function get_image_info($key){
		$baseUrl = Qiniu_RS_MakeBaseUrl($this->domain, $key);
		$imgInfo = new Qiniu_ImageInfo;
		$imgInfoUrl = $imgInfo->MakeRequest($baseUrl);
		//对fopUrl 进行签名，生成privateUrl。 公有bucket 此步可以省去。
		$getPolicy = new Qiniu_RS_GetPolicy();
		$imgInfoPrivateUrl = $getPolicy->MakeRequest($imgInfoUrl, null);
		return file_get_contents($imgInfoPrivateUrl);
	}
	
	public function make_url($key, $width = 60, $hight = 120){
		//生成baseUrl
		$baseUrl = Qiniu_RS_MakeBaseUrl($this->domain, $key);
		//生成fopUrl
		$imgView = new Qiniu_ImageView;
		$imgView->Mode = 1;
		$imgView->Width = $width;
		$imgView->Height = $hight;
		$imgViewUrl = $imgView->MakeRequest($baseUrl);
		//对fopUrl 进行签名，生成privateUrl。 公有bucket 此步可以省去。
		$getPolicy = new Qiniu_RS_GetPolicy();
		$imgViewPrivateUrl = $getPolicy->MakeRequest($imgViewUrl, null);
		return $imgViewPrivateUrl;
	}
	
	public function get_type($filetype){
		$type = false;
		if($filetype == 'image/jpeg'){ 
			$type = '.jpg';
		} 
		if ($filetype == 'image/jpg') { 
			$type = '.jpg';
		} 
		if ($filetype == 'image/pjpeg') { 
			$type = '.jpg';
		} 
		if($filetype == 'image/gif'){ 
			$type = '.gif';
		} 
		if($filetype == 'image/png'){ 
			$type = '.png';
		}
		return $type;
	}

}
