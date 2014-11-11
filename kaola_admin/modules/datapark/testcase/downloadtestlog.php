<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'downloadsylog.php';
 $log_userlogin = Downloadsylog::getInstance();
 $logdata = array(
				'eventId'=>2,		//事件id
				'ip'=>2,			//ip
				'did'=>2,			//设备id
				'appVersion'=>2,	//应用（游戏）版本号
				'sdkVersion'=>2,	//sdk版本号
				'uid'=>2,			//用户唯一标识
				'nickname'=>2,		//用户昵称
				'channelId'=>2,	//渠道id
				'gameId'=>2,		//游戏唯一标识
				'areaId'=>2,		//分区唯一标识
				'serverId'=>2,		//服务器唯一标识
				'os'=>2,			//操作系统
				'device'=>2,		//设备名称
				'screen'=>2,		//屏幕分辨率
				'mno'=>2,			//移动网络运营商
				'nm'=>2,			//联网方式 Networking mode
				'eventTime'=>2	//日志事件时间
			);
 $log_userlogin->write($logdata);
?>
