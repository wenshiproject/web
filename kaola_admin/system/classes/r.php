<?php defined('SYSPATH') or die('No direct script access.');

class R {
	
	/**
	 *  获取数字类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function numeric($key,$default=0)
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		if (is_array($result))
		{
			foreach($result as $k=>$v){
            	$result[$k]=call_user_func(__METHOD__,'-----',$v);
            }
			return $result;
		}else{
			if (is_numeric($result))
			{
				return $result;
			}else {
				return 0;
			}
		}
	}
	
	/**
	 *  获取简单字符串类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function string($key,$default='')
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		if (is_array($result))
		{
			foreach($result as $k=>$v){
            	$result[$k]=call_user_func(__METHOD__,'-----',$v);
            }
			return $result;
		}else{
			$result = urldecode($result);
			$result = str_replace('+', '＋', $result); // 把半角的加号替换成全角的加号
			$result = strip_tags($result);
			$result = htmlspecialchars($result,ENT_QUOTES);
			$result = nl2br($result);
			return $result;
		}
	}

	/**
	 *  获取简单字符串类型的参数，非安全过滤，使用前必须找技术负责人做安全评估。
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function string_not_safe($key,$default='')
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		return $result;
	}
	
	/**
	 *  获取json类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function json($key,$default='{}')
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		if (is_array($result))
		{
			foreach($result as $k=>$v){
            	$result[$k]=call_user_func(__METHOD__,'-----',$v);
            }
			return $result;
		}else{
			$result = urldecode($result);
			$result = str_replace('+', '＋', $result); // 把半角的加号替换成全角的加号
			$result = strip_tags($result);
	//		$result = htmlspecialchars($result,ENT_QUOTES);
			$result = nl2br($result);
			return $result;
		}
	}
	
	/**
	 *  获取富文本类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function html($key,$default='')
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		if (is_array($result))
		{
			foreach($result as $k=>$v){
            	$result[$k]=call_user_func(__METHOD__,'-----',$v);
            }
			return $result;
		}else{
			return Kohana_Htmlpurifier::getInstance()->purify($result);
		}
	}

}