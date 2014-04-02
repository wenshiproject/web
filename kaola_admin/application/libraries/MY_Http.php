<?php
class MY_Http
{
	/**
	 * 
	 * 接口地址
	 * @var string
	 */
	public $uri;
	
	/**
	 * 
	 * 验证key
	 * @var string
	 */
	private $key = 'Gf%$5E^(HS*I^&2F1AO';
  	
  	public function setUri($config){
  		if($config){
			$this->uri = 'http://'.$config['server_host'].':'.$config['server_port'];  			
  		}else{
  			return FALSE;
  		}
  	}
  	
  	/**
  	 * 
  	 * 获取验证串
  	 * @param string $signstr
  	 */
	private function get_sign($signstr){
  		return substr(md5($signstr.$this->key), -12, 12);
  	}
  	
  	
	public function httpRequest($url, $data=array()) {
        $ch = curl_init();
        if (is_array($data) && $data) {
        	$formdata = http_build_query($data);
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        return curl_exec($ch);
 	}
  	
  	
  	/**
  	 * 
  	 * 交互获取交互数据
  	 * @param string $action
  	 * @param string $data
  	 */
  	private function call_result($action, $data){
  		$url = $this->uri.'/'.$action.'?';
	  	foreach ($data as $key => $val){
	  		$url .= '&' . $key . '=' . urlencode($val);
	  	}
//	  	var_dump(htmlspecialchars($url)).'<br>';exit;
  		return $this->httpRequest($url);
  	}
  	
  	/**
  	 * 
  	 * 拉黑玩家
  	 * @param int $id
  	 * @param int $time
  	 */
  	public function block($id, $time){
  		$timestamp = $_SERVER['REQUEST_TIME'];
  		$signstr = $id.$time.$timestamp;
  		$sign = $this->get_sign($signstr);
  		$data = array(
  			'id' => $id,
  			'time' => $time,
  			'timestamp' => $timestamp,
  			'sign' => $sign,
  		);
  		return $this->call_recond('block', $data);
  	}
  	
  	/**
  	 * 
  	 * 解封玩家
  	 * @param int $id
  	 */
	public function unblock($id){
  		$timestamp = $_SERVER['REQUEST_TIME'];
  		$signstr = $id.$timestamp;
  		$sign = $this->get_sign($signstr);
  		$data = array(
  			'id' => $id,
  			'timestamp' => $timestamp,
  			'sign' => $sign,
  		);
  		return $this->call_recond('unblock', $data);
  	}
  	
  	/**
  	 * 
  	 * 清除玩家在线状态
  	 * @param int $id
  	 */
	public function clear_status($id){
  		$timestamp = $_SERVER['REQUEST_TIME'];
  		$signstr = $id.$timestamp;
  		$sign = $this->get_sign($signstr);
  		$data = array(
  			'id' => $id,
  			'timestamp' => $timestamp,
  			'sign' => $sign,
  		);
  		return $this->call_recond('clear_status', $data);
  	}
  	
  	
  	/**
  	 * 
  	 * 查询在线
  	 */
  	public function online(){
  		return $this->call_result('online', array());
  	}
  	
  	
  	/**
  	 * 
  	 * GM消息回复
  	 * @param int $id
  	 * @param string $contents
  	 */
  	public function gm_reply($id, $contents){
  		$timestamp = $_SERVER['REQUEST_TIME'];
  		$signstr = $id.$contents.$timestamp;
  		$sign = $this->get_sign($signstr);
  		$data = array(
  			'id' => $id,
  			'contents' => $contents,
  			'timestamp' => $timestamp,
  			'sign' => $sign,
  		);
  		return $this->call_result('gm_reply', $data);
  	}
}
