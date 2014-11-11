<?php defined('SYSPATH') or die('No direct script access.');
include_once 'sylogbase.php';
/**
 * 综合业务数据后台
 * 在线时长日志类
 */

class Onlinetimesylog extends Sylogbase {
	private static $_instance = null;

	public function __construct()
	{
		parent::__construct('onlinetime.log');  //shell脚本切割方式
	}

	public function getDefinition()
	{
		return array(
			'test'
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
