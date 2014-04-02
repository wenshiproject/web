<?php
$config['acl']['nologin'] = array(
	'login' => array('index', 'logout', 'error'),
    'admin' => array('index', 'edit', 'verify', 'verify_edit'),
);

$config['acl']['special'] = array(
 	'login' => array('index', 'logout', 'error'),
	'admin' => array('index', 'edit', 'verify', 'verify_edit'),
	'log' => array('index', 'lists'),
);

$config['acl']['mixture'] = array(
 	'log' => array('index', 'lists'),
);
 
//-------------配置权限不够的提示信息及跳转url------------------//
$config['acl_info']['visitor'] = array(
    'info' => '需要登录以继续',
    'return_url' => 'login'
);
 
$config['acl_info']['more_role'] = array(
    'info' => '需要更高权限以继续',
    'return_url' => 'user/up'
);