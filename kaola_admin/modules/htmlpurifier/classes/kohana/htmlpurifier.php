<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Htmlpurifier{
	
	private static $_instance = null;
	
	private function __construct(){}
	private function __clone(){}
	
	/**
	 * @return HTMLPurifier
	 */
	public static function getInstance()
	{
		if (self::$_instance != null)
		{
			return self::$_instance;
		}
		
		require_once  Kohana::find_file('vendor','library/HTMLPurifier.auto');
		$config = HTMLPurifier_Config::createDefault();
//		$config->set('Core', 'DefinitionCache', null);// 取消写临时文件
		$config->set('Cache.SerializerPath', APPPATH);//设置临时文件目录
	    $config->set('Core.Encoding', 'utf-8'); // replace with your encoding
	    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
	    self::$_instance = new HTMLPurifier($config);
	    return self::$_instance;
//	    $clean_html = $purifier->purify($dirty_html);
	}
}
