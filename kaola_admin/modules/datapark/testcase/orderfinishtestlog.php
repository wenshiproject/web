<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'orderfinishsylog.php';
 $log_userlogin = Orderfinishsylog::getInstance();
 $logdata = array(
				'eventId'=>6,			//事件id
				'ip'=>6,				//ip
				'did'=>6,				//设备id
				'appVersion'=>6,		//应用（游戏）版本号
				'sdkVersion'=>6,		//sdk版本号
				'uid'=>6,				//用户唯一标识
				'nickname'=>6,			//用户昵称
				'channelId'=>6,			//渠道id
				'gameId'=>6,			//游戏唯一标识
				'areaId'=>6,			//分区唯一标识
				'serverId'=>6,			//服务器唯一标识
				'os'=>6,				//操作系统
				'device'=>6,			//设备名称
				'screen'=>6,			//屏幕分辨率
				'mno'=>6,				//移动网络运营商
				'nm'=>6,				//联网方式
				'eventTime'=>6,			//日志事件时间
				'orderId'=>6,			//手游平台交易流水号
				'orderIdOfGame'=>6,		//游戏方流水号
				'goodsId'=>6,			//商品ID（如金币的ID为1）
				'goodsCount'=>6,		//商品数量（如金币数量）
				'before'=>6,			//充值前账号余额
				'rmbCount'=>6,			//充值金额(元)
				'after'=>6,				//充值后账号余额
				'payType'=>6,			//充值方式
				'status'=>6,			//通知状态
				'url'=>6				//通知url=>6,带完整参数
			);
 $log_userlogin->write($logdata);
?>
