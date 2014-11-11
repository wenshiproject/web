<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'userloginsylog.php';
 $log_userlogin = Userloginsylog::getInstance();
 $ip_arr = array('192.168.51.10','192.168.51.15','192.168.51.18','192.168.51.180');
 $version_arr = array('1.0.1','1.0.2','1.0.3','1.1.1','1.1.2','2.1.0');
 $os_arr = array('android','iphone','windows');
 $device_arr = array('iphone 4s','华为C8650','三星GT-s5830');
 $deviceType_arr = array('android','iphone','ipad');
 $screen_arr = array('400*600','640*960','1536*2048');
 $mno_arr = array('中国移动','中国电信','中国联通');
 for ($i=1; $i<=1000; $i++){
	$rday = rand(0,20);
	$time = strtotime("-{$rday}day");
	$time = ($time - $time%86400) + rand(1,86399);
 	$logdata = array(
			'eventId'=>rand(1,10),			//事件id
			'ip'=>$ip_arr[rand(0,2)],				  //ip
			'did'=>rand(10000,1005464).'ddd',				//设备id
			'appVersion'=>$version_arr[rand(0,5)],		//应用（游戏）版本号
			'sdkVersion'=>$version_arr[rand(0,5)],		//sdk版本号
			'uid'=>rand(8888,20000),				//用户唯一标识
			'nickname'=>'nick_'.rand(8888,88888),			//用户昵称
			'channelId'=>rand(1,20),		//渠道id
			'gameId'=>rand(1,300),			//游戏唯一标识
			'areaId'=>rand(1,30),			//分区唯一标识
			'serverId'=>rand(1,20),			//服务器唯一标识
			'os'=>$os_arr[rand(0,2)],			//操作系统
 			'osVersion'=>$version_arr[rand(0,2)],			//操作系统版本号
			'device'=>$device_arr[rand(0,2)],			//设备名称：三星GT-s5830
 			'deviceType'=>$deviceType_arr[rand(0,2)],			//设备类型：android，iphone,ipad
			'screen'=>$screen_arr[rand(0,2)],			//屏幕分辨率
			'mno'=>$mno_arr[rand(0,2)],				//移动网络运营商：中国移动
			'nm'=>rand(1,2),				//联网方式：3G，WIFI
			'eventTime'=>$time			//日志事件时间
		);
 	$log_userlogin->write($logdata);
 }
?>