<?php defined('SYSPATH') or die('No direct access allowed.');

class Common_Helper{
	
	static function randCode($length = 5, $type = 0) {
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } elseif ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $string[rand(0, $count)];
    }
    return $code;
 }
	
	static public function get_ip_address_by_api($ip)
	{
		$iplist = array('210.21.68.158', '202.173.234.1', '121.9.213.171');
		if(in_array($ip, $iplist)) return '内部账号';
		return self::convertip($ip);
	}
	
	static public function HttpRequest($url, $data=array()) {
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
	 * Perform a hmac hash, using the configured method.
	 *
	 * @param   string  string to hash
	 * @return  string
	 */
	static public function hash($str)
	{
		$config = Kohana::$config->load('auth_admin');
		if (! isset($config['hash_key']))
			throw new Kohana_Exception('A valid hash key must be set in your auth config.');

		return hash_hmac($config['hash_method'], $str, $config['hash_key']);
	}
	
	
	static public function get_client_ip(){
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else $ip = "Unknow";
		return $ip;
	}

	static public function get_user_agent(){
		return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}

	// 同理获取访问用户的浏览器的信息
	static public function get_client_os() {
		$Agent = self::get_user_agent();
		$browserplatform = 'Unknown';
		if(!$Agent) return $browserplatform;

		if (preg_match('/win/i',$Agent) && strpos($Agent, '95')) {
			$browserplatform="Windows 95";
		}
		elseif (preg_match('/win 9x/i',$Agent) && strpos($Agent, '4.90')) {
			$browserplatform="Windows ME";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/98/',$Agent)) {
			$browserplatform="Windows 98";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/nt 5.0/i',$Agent)) {
			$browserplatform="Windows 2000";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/nt 5.1/i',$Agent)) {
			$browserplatform="Windows XP";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/nt 6.0/i',$Agent)) {
			$browserplatform="Windows Vista";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/nt 6.1/i',$Agent)) {
			$browserplatform="Windows 7";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/32/',$Agent)) {
			$browserplatform="Windows 32";
		}
		elseif (preg_match('/win/i',$Agent) && preg_match('/nt/i',$Agent)) {
			$browserplatform="Windows NT";
		}elseif (preg_match('/Mac OS/i',$Agent)) {
			$browserplatform="Mac OS";
		}
		elseif (preg_match('/linux/i',$Agent)) {
			$browserplatform="Linux";
		}
		elseif (preg_match('/unix/i',$Agent)) {
			$browserplatform="Unix";
		}
		elseif (preg_match('/sun/i',$Agent) && preg_match('/os/i',$Agent)) {
			$browserplatform="SunOS";
		}
		elseif (preg_match('/ibm/i',$Agent) && preg_match('/os/i',$Agent)) {
			$browserplatform="IBM OS/2";
		}
		elseif (preg_match('/Mac/i',$Agent) && preg_match('/PC/i',$Agent)) {
			$browserplatform="Macintosh";
		}
		elseif (preg_match('/PowerPC/i',$Agent)) {
			$browserplatform="PowerPC";
		}
		elseif (preg_match('/AIX/i',$Agent)) {
			$browserplatform="AIX";
		}
		elseif (preg_match('/HPUX/i',$Agent)) {
			$browserplatform="HPUX";
		}
		elseif (preg_match('/NetBSD/i',$Agent)) {
			$browserplatform="NetBSD";
		}
		elseif (preg_match('/BSD/i',$Agent)) {
			$browserplatform="BSD";
		}
		elseif (preg_match('/OSF1/',$Agent)) {
			$browserplatform="OSF1";
		}
		elseif (preg_match('/IRIX/',$Agent)) {
			$browserplatform="IRIX";
		}
		elseif (preg_match('/FreeBSD/i',$Agent)) {
			$browserplatform="FreeBSD";
		}
		return $browserplatform;
	}

	//===================================
	//
	// 功能：IP地址获取真实地址函数
	// 参数：$ip - IP地址
	// 作者：[Discuz!] (C) Comsenz Inc.
	//
	//===================================
	static public function convertip($ip) {
		//IP数据文件路径
		$dat_path = DOCROOT.'application/config/qqwry.dat';

		//检查IP地址
		//	    if(!preg_match("/^d{1,3}.d{1,3}.d{1,3}.d{1,3}$/", $ip)) {
		//	        return 'IP Address Error';
		//	    }
		//打开IP数据文件
		if(!$fd = @fopen($dat_path, 'rb')){
			return 'Unknown';
		}

		//分解IP进行运算，得出整形数
		$ip = explode('.', $ip);
		$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

		//获取IP数据索引开始和结束位置
		$DataBegin = fread($fd, 4);
		$DataEnd = fread($fd, 4);
		$ipbegin = implode('', unpack('L', $DataBegin));
		if($ipbegin < 0) $ipbegin += pow(2, 32);
		$ipend = implode('', unpack('L', $DataEnd));
		if($ipend < 0) $ipend += pow(2, 32);
		$ipAllNum = ($ipend - $ipbegin) / 7 + 1;

		$BeginNum = 0;
		$EndNum = $ipAllNum;
		$ip1num = 0;
		$ip2num = 0;
		//使用二分查找法从索引记录中搜索匹配的IP记录
		while($ip1num>$ipNum || $ip2num<$ipNum) {
			$Middle= intval(($EndNum + $BeginNum) / 2);

			//偏移指针到索引位置读取4个字节
			fseek($fd, $ipbegin + 7 * $Middle);
			$ipData1 = fread($fd, 4);
			if(strlen($ipData1) < 4) {
				fclose($fd);
				return 'System Error';
			}
			//提取出来的数据转换成长整形，如果数据是负数则加上2的32次幂
			$ip1num = implode('', unpack('L', $ipData1));
			if($ip1num < 0) $ip1num += pow(2, 32);
				
			//提取的长整型数大于我们IP地址则修改结束位置进行下一次循环
			if($ip1num > $ipNum) {
				$EndNum = $Middle;
				continue;
			}

			//取完上一个索引后取下一个索引
			$DataSeek = fread($fd, 3);
			if(strlen($DataSeek) < 3) {
				fclose($fd);
				return 'System Error';
			}
			$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
			fseek($fd, $DataSeek);
			$ipData2 = fread($fd, 4);
			if(strlen($ipData2) < 4) {
				fclose($fd);
				return 'System Error';
			}
			$ip2num = implode('', unpack('L', $ipData2));
			if($ip2num < 0) $ip2num += pow(2, 32);
				
			//没找到提示未知
			if($ip2num < $ipNum) {
				if($Middle == $BeginNum) {
					fclose($fd);
					return 'Unknown';
				}
				$BeginNum = $Middle;
			}
		}

		//下面的代码读晕了，没读明白，有兴趣的慢慢读
		$ipFlag = fread($fd, 1);
		if($ipFlag == chr(1)) {
			$ipSeek = fread($fd, 3);
			if(strlen($ipSeek) < 3) {
				fclose($fd);
				return 'System Error';
			}
			$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
			fseek($fd, $ipSeek);
			$ipFlag = fread($fd, 1);
		}
		$ipAddr1 = '';
		$ipAddr2 = '';
		if($ipFlag == chr(2)) {
			$AddrSeek = fread($fd, 3);
			if(strlen($AddrSeek) < 3) {
				fclose($fd);
				return 'System Error';
			}
			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return 'System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}

			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr2 .= $char;

			$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
			fseek($fd, $AddrSeek);

			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr1 .= $char;
		} else {
			fseek($fd, -1, SEEK_CUR);
			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr1 .= $char;

			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return 'System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}
			while(($char = fread($fd, 1)) != chr(0)){
				$ipAddr2 .= $char;
			}
		}
		fclose($fd);

		//最后做相应的替换操作后返回结果
		if(preg_match('/http/i', $ipAddr2)) {
			$ipAddr2 = '';
		}
		$ipaddr = trim($ipAddr1).trim($ipAddr2);
		$ipaddr = preg_replace('/CZ88.Net/is', '', $ipaddr);
		$ipaddr = preg_replace('/^s*/is', '', $ipaddr);
		$ipaddr = preg_replace('/s*$/is', '', $ipaddr);
		if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
			$ipaddr = 'Unknown';
		}
		
		return iconv("GB2312","UTF-8",$ipaddr);
	}
	
	/**
	 * 获取屏幕分辨率，需要客户端支持
	 * Enter description here ...
	 */
	static public function get_client_screen(){
		return isset($_COOKIE['window_screen']) ? $_COOKIE['window_screen'] : '';
	}
	
	static public function show_msg($msg='',$url='',$top=FALSE){
		header('Content-Type:text/html; charset=utf-8');
		echo "<script type='text/javascript'>";
		if($msg){
			echo sprintf("%salert('%s');",$top ? 'top.':'',$msg);
		}else{
			echo sprintf("%salert('提交成功');",$top ? 'top.' : '');
		}
		echo sprintf("window.%slocation.href='%s'",$top ? 'top.' : '', $url ? $url : Request::$initial->referrer());
		echo '</script>';
		exit();
	}
	
	static public function show_msg_back($msg=''){
		header('Content-Type:text/html; charset=utf-8');
		echo "<script type='text/javascript'>";
		if($msg){
			echo "alert('$msg');";
		}else{
			echo "alert('失败');";
		}
		echo sprintf("window.history.go(-1)");
		echo '</script>';
		exit();
	}
}