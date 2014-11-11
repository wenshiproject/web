<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'orderpaysylog.php';
 $log_userlogin = Orderpaysylog::getInstance();
 $logdata = array(
				'eventId'=>4,		//事件id
				'ip'=>4,			//ip
				'did'=>4,			//设备id
				'appVersion'=>4,	//应用（游戏）版本号
				'sdkVersion'=>4,	//sdk版本号
				'uid'=>4,			//用户唯一标识
				'nickname'=>4,		//用户昵称
				'channelId'=>4,		//渠道id
				'gameId'=>4,		//游戏唯一标识
				'areaId'=>4,		//分区唯一标识
				'serverId'=>4,		//服务器唯一标识
				'os'=>4,			//操作系统
				'device'=>4,		//设备名称
				'screen'=>4,		//屏幕分辨率
				'mno'=>4,			//移动网络运营商
				'nm'=>4,			//联网方式
				'eventTime'=>4,		//日志事件时间
				'orderId'=>4,		//手游平台交易流水号
				'orderIdOfGame'=>4,	//游戏方流水号
				'goodsId'=>4,		//商品ID（如金币的ID为1）
				'goodsCount'=>4,	//商品数量（如金币数量）
				'before'=>4,		//充值前账号余额
				'rmbCount'=>4,		//充值金额(元)
				'after'=>4,			//充值后账号余额
				'payType'=>4		//充值方式
			);
 $log_userlogin->write($logdata);
?>
