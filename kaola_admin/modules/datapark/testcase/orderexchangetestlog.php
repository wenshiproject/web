<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'orderexchangesylog.php';
 $log_userlogin = Orderexchangesylog::getInstance();
 $logdata = array(
				'eventId'=>5,			//事件id
				'ip'=>5,				//ip
				'did'=>5,				//设备id
				'appVersion'=>5,		//应用（游戏）版本号
				'sdkVersion'=>5,		//sdk版本号
				'uid'=>5,				//用户唯一标识
				'nickname'=>5,			//用户昵称
				'channelId'=>5,			//渠道id
				'gameId'=>5,			//游戏唯一标识
				'areaId'=>5,			//分区唯一标识
				'serverId'=>5,			//服务器唯一标识
				'os'=>5,				//操作系统
				'device'=>5,			//设备名称
				'screen'=>5,			//屏幕分辨率
				'mno'=>5,				//移动网络运营商
				'nm'=>5,				//联网方式
				'eventTime'=>5,			//日志事件时间
				'orderId'=>5,			//手游平台交易流水号
				'orderIdOfGame'=>5,		//游戏方流水号
				'goodsId'=>5,			//商品ID（如金币的ID为1）
				'goodsCount'=>5,		//商品数量（如金币数量）
				'before'=>5,			//充值前账号余额
				'rmbCount'=>5,			//充值金额(元)
				'after'=>5,				//充值后账号余额
				'payType'=>5			//充值方式
			);
 $log_userlogin->write($logdata);
?>
