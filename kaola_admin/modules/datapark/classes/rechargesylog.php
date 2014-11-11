<?php defined('SYSPATH') or die('No direct script access.');
include_once 'sylogbase.php';
/**
 * 综合业务数据后台
 * 总用户数变化日志类
 */

class Rechargesylog extends Sylogbase {
	private static $_instance = null;

	public function __construct()
	{
		parent::__construct('recharge.log');  //shell脚本切割方式
	}

	public function getDefinition()
	{
		return array(
			'count',		//总用户数
			'eventTime'	//统计时间
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
