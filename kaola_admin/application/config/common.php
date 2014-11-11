<?php
/**
 * 注意！
 * 这个数组的各项的ID,不能重复
 * 注意！！！ 新加的功能菜单项ID必须用新的，旧的菜单项的ID不能改
 **/
return array(
	'menu' => array(
		'gift' => array(
			'name' => '奖品管理',
			'items' => array(
				'added' => array('id' => 101,'name' => '上架奖品','show' => 1),
				'stock' => array('id' => 102,'name' => '未上架奖品', 'show'=>1),
				'add' => array('id' => 103,'name' => '添加奖品', 'show'=>1),
				'down' => array('id' => 104,'name' => '下架奖品', 'show'=>1),
			),
		),
		
		'supplier' => array(
			'name' => '供应商管理',
			'items' => array(
				'check_list' => array('id' => 201,'name' => '已审核供应商', 'show'=>1),
				'noncheck' => array('id' => 202,'name' => '未审核供应商', 'show'=>1),
				'add' => array('id' => 203,'name' => '添加供应商', 'show'=>1),
			),
		),
		
		'order' => array(
			'name' => '订单管理',
			'items' => array(
				'list' => array('id' => 301,'name' => '所有订单', 'show'=>1),
				'check' => array('id' => 302,'name' => '已审核订单', 'show'=>1),
				'noncheck' => array('id' => 303,'name' => '未审核订单', 'show'=>1),
				'verified' => array('id' => 304,'name' => '未验证订单', 'show'=>1),
			),
		),
		
		'game' => array(
			'name' => '游戏管理',
			'items' => array(
				'list' => array('id' => 401,'name' => '游戏列表', 'show'=>1),
				'add' => array('id' => 402,'name' => '提交游戏', 'show'=>1),
			),
		),
		
		'wish' => array(
			'name' => '许愿清单',
			'items' => array(
				'list' => array('id' => 501,'name' => '许愿列表', 'show'=>1),
				'add' => array('id' => 502,'name' => '添加信息', 'show'=>1),
			),
		),
		
		'sysmsg' => array(
			'name' => '系统消息-大礼包',
			'items' => array(
				'push' => array('id' => 601,'name' => '已推送信息', 'show'=>1),
				'unpush' => array('id' => 601,'name' => '未推送信息', 'show'=>1),
				'add' => array('id' => 602,'name' => '添加系统信息', 'show'=>1),
			),
		),

		'usermg' => array(
			'name' => '玩家管理',
			'items' => array(
				'list' => array('id' => 701,'name' => '玩家列表', 'show'=>1),
			),
		),
		
		'company' => array(
			'name' => '开发商管理',
			'items' => array(
				'list' => array('id' => 801,'name' => '已审核开发商', 'show'=>1),
				'uncheck' => array('id'=> 803, 'name' => '未审核开发商', 'show'=>1),
				'add' => array('id' => 802,'name' => '添加开发商', 'show'=>1),
			),
		),
	)
);