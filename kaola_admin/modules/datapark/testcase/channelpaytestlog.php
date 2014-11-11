<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'channelpaysylog.php';
 $log_userlogin = Channelpaysylog::getInstance();
 $logdata = array(
				'eventId'=>9,			//事件id
				'ip'=>9,				//ip
				'did'=>9,				//设备id
				'appVersion'=>9,		//应用（游戏）版本号
				'sdkVersion'=>9,		//sdk版本号
				'uid'=>9,				//用户唯一标识
				'nickname'=>9,			//用户昵称
				'channelId'=>9,			//渠道id
				'gameId'=>9,			//游戏唯一标识
				'areaId'=>9,			//分区唯一标识
				'serverId'=>9,			//服务器唯一标识
				'os'=>9,				//操作系统
				'device'=>9,			//设备名称
				'screen'=>9,			//屏幕分辨率
				'mno'=>9,				//移动网络运营商
				'nm'=>9,				//联网方式
				'eventTime'=>9,			//日志事件时间
				'payType'=>9,			//付费类型
				'count'	=>9				//金额
			);
 $log_userlogin->write($logdata);
?>
