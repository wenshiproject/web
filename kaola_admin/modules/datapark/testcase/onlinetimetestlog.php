<?php
 define('SYSPATH','4399'); //代理名称
 include '../classes'.DIRECTORY_SEPARATOR.'onlinetimesylog.php';
 $log_userlogin = Onlinetimesylog::getInstance();
 $logdata = array(
				'test'=>3333
			);
 $log_userlogin->write($logdata);
?>
