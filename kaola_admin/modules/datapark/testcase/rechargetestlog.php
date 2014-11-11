<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'rechargesylog.php';
 $log_userlogin = Rechargesylog::getInstance();
 $logdata = array(
				'count'=>8,		//总用户数
				'eventTime'=>8	//统计时间
			);
 $log_userlogin->write($logdata);
?>
