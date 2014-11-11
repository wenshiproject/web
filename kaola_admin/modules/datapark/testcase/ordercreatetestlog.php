<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'ordercreatesylog.php';
 $log_userlogin = Ordercreatesylog::getInstance();
 $logdata = array(
				'eventId'=>3,		//事件id
				'ip'=>3,			//ip
				'did'=>3,			//设备id
				'appVersion'=>3,	//应用（游戏）版本号
				'sdkVersion'=>3,	//sdk版本号
				'uid'=>3,			//用户唯一标识
				'nickname'=>3,		//用户昵称
				'channelId'=>3,		//渠道id
				'gameId'=>3,		//游戏唯一标识
				'areaId'=>3,		//分区唯一标识
				'serverId'=>3,		//服务器唯一标识
				'os'=>3,			//操作系统
				'device'=>3,		//设备名称
				'screen'=>3,		//屏幕分辨率
				'mno'=>3,			//移动网络运营商
				'nm'=>3,			//联网方式
				'eventTime'=>3,		//日志事件时间
				'orderId'=>3,		//手游平台交易流水号
				'orderIdOfGame'=>3,	//游戏方流水号
				'goodsId'=>3,		//商品ID（如金币的ID为1）
				'goodsCount'=>3,	//商品数量（如金币数量）
				'before'=>3,		//充值前账号余额
				'rmbCount'=>3,		//充值金额(元)
				'after'=>3,			//充值后账号余额
				'payType'=>3		//充值方式
			);
 $log_userlogin->write($logdata);
?>
