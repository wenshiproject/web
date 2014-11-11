<?php
include '../datapark.php';
$log=new Onlinetimesylog();
 $logdata = array(
				'test'=>3333
			);
 $log->write($logdata);