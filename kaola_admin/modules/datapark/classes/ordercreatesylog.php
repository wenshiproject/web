<?php defined('SYSPATH') or die('No direct script access.');
include_once 'sylogbase.php';
/**
 * 综合业务数据后台
 * 充值定单日志类
 */

class Ordercreatesylog extends Sylogbase {
	private static $_instance = null;

	public function __construct()
	{
		parent::__construct('ordercreate.log');  //shell脚本切割方式
	}

	public function getDefinition()
	{
		return array(
   			'eventId',        //事件id，绑定事务用                
			'ip',             //192.168.155.255                   
			'did',            //设备id                            
			'appVersion',     //应用（游戏版本号）                
			'sdkVersion',     //sdk版本号                         
			'uid',            //用户唯一标识                      
			'nickname',       //用户昵称                          
			'channelId',      //渠道id                            
			'gameId',         //游戏唯一标识                      
			'areaId',         //分区唯一标识                      
			'serverId',       //服务器唯一标识                    
			'os',             //操作系统：android、iphone         
			'osVersion',      //操作系统版本号                    
			'device',         //设备名称：三星GT-s5830            
			'deviceType',     //设备类型：android，iphoneipad     
			'screen',         //屏幕分辨率                        
			'mno',            //移动网络运营商：中国移动          
			'nm',             //联网方式：3G，WIFI                
			'eventTime',      //日志事件时间戳
        	'orderId',      //手游平台交易流水号
        	'orderIdOfGame',      //游戏方流水号
        	'goodsId',      //商品ID,如金币ID为1
        	'goodsCount',      //商品数量
        	'before',      //充值前账号余额
        	'rmbCount',      //充值金额（元）
        	'after',      //充值后帐号余额
        	'payType',      //充值方式，如1=支付宝        
			'roleLevel',      //游戏角色等级
		);
	}

	/**
	 * 获取单例
	 *
	 * @return Sylogbase
	 */
	public static function getInstance()
	{
		if (self::$_instance instanceof self) {
			return self::$instance;
		}
		return new self();
	}

}
