<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Interface extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array('list_wish','wish','order','gift','list_exchange','list_collect','sysmsg','index','register','login','game','collect','list_address','address','exchange','search',
		'get_gift', 'order', 'exchange_rs'));
		parent::before();
	}
	
	public function action_exchange_gift(){
		$gift_id = r::numeric('gift_id');
		$game_id = r::numeric('game_id');
		$type = r::numeric('type');
		$width = intval(r::numeric('width', 200));
		$height = intval(r::numeric('height', 100));
		if($gift_id && $game_id){
			$giftmodel = new Model_Admin_Gift_Giftmodel();
			$giftinfo = $giftmodel->get_row($gift_id);
			if($giftinfo['image_path']){
				$qiniumodel = new Model_Api_Qiniumodel();
				$giftinfo['broadcast_img_path'] = $qiniumodel->make_url($giftinfo['broadcast_img'], $width, $height);
			}
			$this->view->rs = $giftinfo;
			$this->view->game_id = $gift_id;
			$this->view->gift_id = $game_id;
			$this->view->type = $type;
		}else{
			exit;
		}
	}
	
	public function action_exchange_rs(){
		$phone = r::string('phone');
		$game_id = r::string('game_id');
		$gift_id = r::string('gift_id');
		if(!$phone){
			$rs = 0;
		}
		if(!$game_id){
			$rs = 0;
		}
		if(!$gift_id){
			$rs = 0;
		}
		if($_POST['phone'] && $_POST['gift_id'] && $_POST['gift_id'] ){
			$ordermodel = new Model_Admin_Order_Ordermodel();
			$orderinfo = $ordermodel->get_order($phone, $game_id, $gift_id);
			$captcha = Common_Helper::randCode(12);
			if($orderinfo){
				if($orderinfo['status'] >= 1){
					$rs = 2;
				}
				$data = array(
					'captcha' => $captcha,	
					'order_time' => date('Y-m-d H:i:s'),
				);
				$ordermodel->update($orderinfo['id'], $data);
			}else{
				$order_id = date('YmdHis').Common_Helper::randCode(5,1);
				$data = array(
				'id' => $order_id,
				'user_id' => $phone,
				'game_id' => $game_id,
				'captcha' => $captcha,	
				'gift_id' => $gift_id,
				'order_time' => date('Y-m-d H:i:s'),
			);
			$ordermodel->add($data);
			}
			$messagemodel = new Model_Api_Messagemodel();
			$msg = '兑奖验证码'.$captcha.'请从 http://www.kaolagift.com/dl 下载安装考拉有礼兑奖。';
			$sendrs = $messagemodel->send($phone, $msg);
			if($sendrs){
				$rs = 1;
			}
		}
		echo $rs;
		exit;
	}
	
	public function action_list_wish(){
		$wishmodel = new Model_Admin_Wish_Wishmodel();
		$wishs = $wishmodel->get_show_wish();
		$rs = array();
		$qiniumodel = new Model_Api_Qiniumodel();
		if($wishs){
			foreach ($wishs as $key => $val){
				$rs[$key]['id'] = $val['id'];
				$rs[$key]['title'] = $val['title'];
				$rs[$key]['content'] = $val['content'];
				$rs[$key]['image'] = $val['image'];
				if($val['image']){
					$images = explode(',', $val['image']);
					$info = $qiniumodel->get_image_info($images[0]);
					$info_arr = json_decode($info, true);
					if($info_arr){
						$rs[$key]['width'] = $info_arr['width'];
						$rs[$key]['height'] = $info_arr['height'];;
					}
				}
				$rs[$key]['number'] = $val['wish_num'];
			}
		}
		echo json_encode($rs);
		exit;
	}
	
	public function action_wish(){
		$id = r::numeric('id');
		if($id){
			$wishmodel = new Model_Admin_Wish_Wishmodel();
			$wishmodel->update_wish($id);
			$rs = array('code'=>1, 'msg' => '成功');
			echo json_encode($rs);
			exit;
		}
	}
	
	public function action_register(){
		$step = r::numeric('step');
		$usermgmodel = new Model_Admin_Usermg_Usermgmodel();
		switch ($step){ 
			case 1:
				$phone = r::string('phone');
				if(!phone){
					$rs = array('code'=>0, 'msg' => '请输入手机号码');
					echo json_encode($rs);
					exit;
				}
				$user = $usermgmodel->get_row($phone);
				if($user && $user['passwd']){
					$rs = array('code'=>2, 'msg' => '号码已注册');
					echo json_encode($rs);
					exit;
				}
				$code = Common_Helper::randCode(6, 1);
				$msgmodel = new Model_Api_Messagemodel();
				$msg = $code . '验证码。请勿泄露。';
				if($user){
					$update_data = array(
						'code' => $code,
					);
					$usermgmodel->update($phone, $update_data);
				}else{
					$data = array(
						'id' => $phone,
						'code' => $code,
					);
					$usermgmodel->add($data);
				}
				$msgmodel->send($phone, $msg);
				$rs = array('code'=>1, 'msg' => '成功');
				echo json_encode($rs);
				break;
			case 2:
				$phone = r::string('phone');
				$code = r::string('code');
				$user = $usermgmodel->get_user($phone, $code);
				if($user){
					$rs = array('code'=>1, 'msg' => '验证成功');
				}else{
					$rs = array('code'=>0, 'msg' => '验证失败');
				}
				echo json_encode($rs);
				break;
			case 3:
				$phone = r::string('phone');
				$code = r::string('code');
				$passwd = r::string('passwd');
				$user = $usermgmodel->get_user($phone, $code);
				if($user){
					$data = array(
						'passwd' => md5($passwd),
						'reg_time' => date('Y-m-d H:i:s'),
					);
					$usermgmodel->update($user['id'], $data);
					$rs = array('code'=>1, 'msg' => '成功','phone' => $user['id']);
					echo json_encode($rs);
				}else{
					$rs = array('code'=>0, 'msg' => '错误');
				}
				break;
			case 4:
				$phone = r::string('phone');
				$user = $usermgmodel->get_row($phone);
				if($user){
					$pwd = Common_Helper::randCode(6, 1);
					$data = array(
							'passwd' => md5($pwd),
					);
					$usermgmodel->update($user['id'], $data);
					$msgmodel = new Model_Api_Messagemodel();
					$msg = '重置后密码为' .$code .'。请勿泄露。';
					$msgmodel->send($phone, $msg);
					$rs = array('code'=>1, 'msg' => '成功');
				}else{
					$rs = array('code'=>0, 'msg' => '账号不存在');
				}
			default:
				$rs = array('code'=>0, 'msg' => '错误');
				echo json_encode($rs);
		}
		exit;
	}
	
	public function action_login(){
		$phone = r::string('phone');
		$passwd = r::string('passwd');
		$usermgmodel = new Model_Admin_Usermg_Usermgmodel();
		$user = $usermgmodel->get_row($phone);
		if($user){
			if($user['passwd'] == md5($passwd)){
				$data = array('last_login_time'=>date('Y-m-d H:i:s'));
				$usermgmodel->update($phone, $data);
				$rs = array('code'=>1, 'msg' => '成功','phone' => $phone);
				echo json_encode($rs);
				exit;
			}else{
				$rs = array('code'=>0, 'msg' => '错误');
				echo json_encode($rs);
				exit;
			}
		}else{
			$ordermodel = new Model_Admin_Order_Ordermodel();
			$order_user = $ordermodel->get_user_order($phone, $passwd);
			if($order_user){
				$pwd = Common_Helper::randCode(6);
				$data = array(
						'id' => $phone,
						'code' => $passwd,
				);
				if($usermgmodel->add($data)){
					$rs = array('code'=>2, 'msg' => '验证成功');
					echo json_encode($rs);
					exit;
				}
			}
		}
		$rs = array('code'=>0, 'msg' => '错误');
		echo json_encode($rs);
		exit;
	}
	
	public function action_index(){
		$page = R::numeric('page');
		if($page <= 0){
			$rs = array('code' => 0, 'msg' => '参数page有误');
			echo json_encode($rs);
			exit;
		}
		$size = R::numeric('size');
		if($size <= 0){
			$rs = array('code' => 0, 'msg' => '参数size有误');
			echo json_encode($rs);
			exit;
		}
		$user_id = r::numeric('phone');
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$rs = $giftmodel->get_push_gift();
		$qiniumodel = new Model_Api_Qiniumodel();
		$collectrs= array();
		$exchanges = array();
		if($user_id){
			$collectmodel = new Model_Admin_Collect_Collectmodel();
			$collectrs = $collectmodel->get_collect($user_id);
			$ordermodel = new Model_Admin_Order_Ordermodel();
			$exchanges = $ordermodel->get_orders($user_id);
		}
		$return = array();
		if($rs){
			foreach ($rs as $key => $val){
				$return[$key]['gift_id'] = $val['id'];
				$return[$key]['gift_name'] = $val['name'];
				$return[$key]['num'] = $val['number']-$val['order_num'];
				$return[$key]['cond'] = $val['game_cond'];
				$return[$key]['desc'] = $val['desc'];
				$return[$key]['image'] = $val['image_path'];
				$return[$key]['image_width'] = $val['image_width'];
				$return[$key]['image_height'] = $val['image_height'];;
				$return[$key]['game_id'] = $val['game_id'];
				$return[$key]['exchange_num'] = $val['order_num'];
				$return[$key]['is_exchange'] = isset($exchanges[$val['id']]) && $exchanges[$val['id']] ? 1:0 ;
				$return[$key]['is_collect'] = isset($collectrs[$val['id']]) && $collectrs[$val['id']] ? 1:0 ;
			}
		}
		echo json_encode($return);
		exit;
	}
	
	public function action_game(){
		$page = r::numeric('page');
		if($page <= 0){
			$rs = array('code' => 0, 'msg' => '参数page有误');
			echo json_encode($rs);
		}
		$size=R::numeric('size');
		if($size <= 0){
			$rs = array('code' => 0, 'msg' => '参数size有误');
			echo json_encode($rs);
		}
		$gamemodel = new Model_Admin_Game_Gamemodel();
		$games = $gamemodel->get_all();
		$qiniumodel = new Model_Api_Qiniumodel();
		$rs = array();
		foreach ($games as $key => $val){
			$rs[$key]['game_id'] = $val['id'];
			$rs[$key]['game_name'] = $val['name'];
			$rs[$key]['game_info'] = $val['desc'];
			$rs[$key]['game_image'] = $val['image_path'];
			if($val['image_path']){
				$images = explode(',', $val['image_path']);
				$info = $qiniumodel->get_image_info($images[0]);
				$info_arr = json_decode($info, true);
				if($info_arr){
					$rs[$key]['image_width'] = $info_arr['width'];
					$rs[$key]['image_height'] = $info_arr['height'];;
				}
			}
		}
		echo json_encode($rs);
		exit;
	}
	
	public function action_collect(){
		$step = r::numeric('step', 1);
		$gift_id = r::numeric('gift_id');
		$user_id = r::numeric('phone');
		$data = array(
			'gift_id' => $gift_id,
			'user_id' => $user_id,
			'add_time' => date('Y-m-d H:i:s'),
		);
		$collectmodel = new Model_Admin_Collect_Collectmodel();
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$gifts = $collectmodel->get_collect($user_id);
		if($gifts[$gift_id] && $step == 2){
			if($collectmodel->del_collect($user_id, $gift_id)){
				$rs = array('code'=>1, 'msg' => '成功');
				$giftmodel->update_collect($gift_id, '-1');
			}else{
				$rs = array('code'=>0, 'msg' => '失败');
			}
		}else if(!$gifts[$gift_id] && $step == 1){
			if($collectmodel->add($data)){
				$rs = array('code'=>1, 'msg' => '成功');
				$giftmodel->update_collect($gift_id, '+1');
			}else{
				$rs = array('code'=>0, 'msg' => '失败');
			}
		}else{
			$rs = array('code'=>0, 'msg' => '失败');
		}
		echo json_encode($rs);
		exit;
	}
	
	public function action_list_collect(){
		$user_id = r::numeric('phone');
		$collectmodel = new Model_Admin_Collect_Collectmodel();
		$rs = $collectmodel->get_collect_gift($user_id);
		$exchanges = array();
		if($user_id){
			$ordermodel = new Model_Admin_Order_Ordermodel();
			$exchanges = $ordermodel->get_orders($user_id);
		}
		$qiniumodel = new Model_Api_Qiniumodel();
		$return = array();
		if($rs){
			foreach ($rs as $key => $val){
				$return[$key]['gift_id'] = $val['id'];
				$return[$key]['gift_name'] = $val['name'];
				$return[$key]['num'] = $val['number']-$val['order_num'];
				$return[$key]['cond'] = $val['game_cond'];
				$return[$key]['desc'] = $val['desc'];
				$return[$key]['image'] = $val['image_path'];
				if($val['image_path']){
					$images = explode(',', $val['image_path']);
					$info = $qiniumodel->get_image_info($images[0]);
					$info_arr = json_decode($info, true);
					if($info_arr){
						$return[$key]['image_width'] = $info_arr['width'];
						$return[$key]['image_height'] = $info_arr['height'];;
					}
				}
				$return[$key]['game_id'] = $val['game_id'];
				$return[$key]['exchange_num'] = $val['order_num'];
				$return[$key]['is_exchange'] = isset($exchanges[$val['id']]) && $exchanges[$val['id']] ? 1:0 ;
				$return[$key]['is_collect'] = 1;
			}
		}
		echo json_encode($return);
		exit;
	}
	
	public function action_list_address(){
		$user_id = r::numeric('phone');
		$addressmodel = new Model_Admin_Address_Addressmodel();
		$rs = $addressmodel->get_address($user_id);
		$return = array();
		if($rs){
			//只有1个地址的时候，判断为默认地址
			$cnt = count($rs);
			foreach ($rs as $key => $val){
				$return[$key]['address_id'] = $val['id'];
				$return[$key]['name'] = $val['name'];
				$return[$key]['address'] = $val['address'];
				$return[$key]['code'] = $val['code'];
				$return[$key]['address_phone'] = $val['phone'];
				$return[$key]['default'] = $cnt == 1  ? 1 : $val['defalut'];
			}
			echo json_encode($return);
		}
		exit;
	}
	
	public function action_address(){
		$type = r::numeric('type');
		$address_id = r::numeric('address_id');
		$name = r::string('name');
		$address = r::string('address');
		$code = r::numeric('code');
		$phone = r::numeric('address_phone');
		$user_id = r::numeric('phone');
		$addressmodel = new Model_Admin_Address_Addressmodel();
		switch ($type) {
			case 1:
				$data = array(
					'user_id' => $user_id,
					'name' => $name,
					'address' => $address,
					'code' => $code,
					'phone' => $phone,
					'add_time' => date('Y-m-d H:i:s'),
				);
				$addressmodel->add($data);
			break;
			case 2:
				$data = array(
					'name' => $name,
					'address' => $address,
					'code' => $code,
					'phone' => $phone,
					'add_time' => date('Y-m-d H:i:s'),
				);
				$addressmodel->update($address_id, $data);
			;
			break;
			case 3:
				$addressmodel->delete($address_id);
			break;
			case 4:
				$data1 = array(
					'default' => 0,
				);
				$addressmodel->update_default($user_id, $data1);
				$data2 = array(
					'default' => 1,
				);
				$addressmodel->update($address_id, $data2);
				
		} 
		$rs = array('code'=>1, 'msg' => '成功');
		echo json_encode($rs);
		exit;
	}
	
	public function action_exchange(){
		$step = r::numeric('step');
		$user_id = r::numeric('phone');
		$code = r::string('code');
		$address_id = r::numeric('address_id');
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$gift = $giftmodel->get_order_gift($user_id, $code);
		$qiniumodel = new Model_Api_Qiniumodel();
		if($gift){
			switch ($step) {
				case  1:
					$collectrs= array();
					if($user_id){
						$collectmodel = new Model_Admin_Collect_Collectmodel();
						$collectrs = $collectmodel->get_collect($user_id);
					}
					$rs = array();
					$rs['gift_id'] = $gift['id'];
					$rs['gift_name'] = $gift['name'];
					$rs['num'] = $gift['number']-$gift['order_num'];
					$rs['cond'] = $gift['game_cond'];
					$rs['desc'] = $gift['desc'];
					$rs['image'] = $gift['image_path'];
					if($gift['image_path']){
						$images = explode(',', $gift['image_path']);
						$info = $qiniumodel->get_image_info($images[0]);
						$info_arr = json_decode($info, true);
						if($info_arr){
							$rs['image_width'] = $info_arr['width'];
							$rs['image_height'] = $info_arr['height'];;
						}
					}
					$rs['game_id'] = $gift['game_id'];
					$rs['exchange_num'] = $gift['order_num'];
					$rs['is_exchange'] = 0 ;
					$rs['is_collect'] = isset($collectrs[$gift['id']]) && $collectrs[$gift['id']] ? 1:0;
					break;
				case 2:
					$ordermodel = new Model_Admin_Order_Ordermodel();
					$data = array(
						'address_id' => $address_id,
						'finish_time' => date('Y-m-d H:i:s'),
						'status' => 1,
					);
					$ordermodel->update($gift['order_id'], $data);
					$giftmodel->update_order($gift['id']);
					$rs = array('code'=>1, 'msg' => '成功');
					break;
				default:
					$rs = array('code'=>0, 'msg' => '错误');
					break;
			}
		}
		echo json_encode($rs);
		exit;
	}
	
	public function action_list_exchange(){
		$user_id = r::numeric('phone');
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$rs = $giftmodel->get_order_gifts($user_id);
		$collectrs = array();
		if($user_id){
			$collectmodel = new Model_Admin_Collect_Collectmodel();
			$collectrs = $collectmodel->get_collect($user_id);
		}
		$return = array();
		$qiniumodel = new Model_Api_Qiniumodel();
		if($rs){
			foreach ($rs as $key => $val){
				$return[$key]['gift_id'] = $val['id'];
				$return[$key]['gift_name'] = $val['name'];
				$return[$key]['num'] = $val['number']-$val['order_num'];
				$return[$key]['cond'] = $val['game_cond'];
				$return[$key]['desc'] = $val['desc'];
				$return[$key]['image'] = $val['image_path'];
				if($val['image_path']){
					$images = explode(',', $val['image_path']);
					$info = $qiniumodel->get_image_info($images[0]);
					$info_arr = json_decode($info, true);
					if($info_arr){
						$return[$key]['image_width'] = $info_arr['width'];
						$return[$key]['image_height'] = $info_arr['height'];;
					}
				}
				$return[$key]['game_id'] = $val['game_id'];
				$return[$key]['exchange_num'] = $val['order_num'];
				$return[$key]['is_exchange'] = 1;
				$return[$key]['is_collect'] = isset($collectrs[$val['id']]) && $collectrs[$val['id']] ? 1:0 ;
			}
		}
		echo json_encode($return);
		exit;
	}
	
	public function action_search(){
		$name = r::string('word');
		$user_id = r::string('phone');
		if($name){
			$giftmodel = new Model_Admin_Gift_Giftmodel();
			$rs = $giftmodel->get_gift(1, $name);
			$collectrs= array();
			$exchanges = array();
			if($user_id){
				$collectmodel = new Model_Admin_Collect_Collectmodel();
				$collectrs = $collectmodel->get_collect($user_id);
				$ordermodel = new Model_Admin_Order_Ordermodel();
				$exchanges = $ordermodel->get_orders($user_id);
			}
			$return = array();
			$qiniumodel = new Model_Api_Qiniumodel();
			if($rs){
				foreach ($rs as $key => $val){
					$return[$key]['gift_id'] = $val['id'];
					$return[$key]['gift_name'] = $val['name'];
					$return[$key]['num'] = $val['number']-$val['order_num'];
					$return[$key]['cond'] = $val['game_cond'];
					$return[$key]['desc'] = $val['desc'];
					$return[$key]['image'] = $val['image_path'];
					if($val['image_path']){
						$images = explode(',', $val['image_path']);
						$info = $qiniumodel->get_image_info($images[0]);
						$info_arr = json_decode($info, true);
						if($info_arr){
							$return[$key]['image_width'] = $info_arr['width'];
							$return[$key]['image_height'] = $info_arr['height'];;
						}
					}
					$return[$key]['game_id'] = $val['game_id'];
					$return[$key]['exchange_num'] = $val['order_num'];
					$return[$key]['is_exchange'] = isset($exchanges[$val['id']]) && $exchanges[$val['id']] ? 1:0 ;
					$return[$key]['is_collect'] = isset($collectrs[$val['id']]) && $collectrs[$val['id']] ? 1:0 ;
				}
			}
			echo json_encode($return);
			}
		exit;
	}
	
	public function action_sysmsg(){
		$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
		$rs = $sysmsgmodel->get_sysmsg(1);
		$return = array();
		$qiniumodel = new Model_Api_Qiniumodel();
		if($rs){
			foreach ($rs as $key => $val){
				$return[$key]['title'] = $val['title'];
				$return[$key]['desc'] = $val['content'];
				$return[$key]['image'] = $val['image_path'];
				if($val['image_path']){
					$images = explode(',', $val['image_path']);
					$info = $qiniumodel->get_image_info($images[0]);
					$info_arr = json_decode($info, true);
					if($info_arr){
						$return[$key]['image_width'] = $info_arr['width'];
						$return[$key]['image_height'] = $info_arr['height'];;
					}
				}
			}
		}
		echo json_encode($return);
		exit;
	}
	
	//游戏获取对于的奖品
	public function action_get_gift(){
		$game_id = r::numeric('game_id');
		$rs = array();
		if($game_id){
			$giftmodel = new Model_Admin_Gift_Giftmodel();
			$gifts = $giftmodel->get_game_gift($game_id);
			if($gifts){
				foreach ($gifts as $key => $val){
					$rs[$key]['gift_id'] = $val['id'];
					$rs[$key]['gift_name'] = $val['name'];
					$rs[$key]['gift_cond'] = $val['game_cond'];
					$rs[$key]['gift_desc'] = $val['desc'];
					$rs[$key]['gift_num'] = $val['number'];
					$rs[$key]['gift_price'] = $val['price'];
				}
			}
		}else{
			$rs = array('code'=>0, 'msg' => '错误');
		}
		echo json_encode($rs);
		exit;
	}
	
	//用户在游戏中满足获奖条件，游戏方产生兑奖订单
	public function action_order(){
		$phone = r::string('phone');
		$game_id = r::string('game_id');
		$gift_id = r::string('gift_id');
		if(!$phone){
			$rs = array('code'=>0, 'msg' => '错误');
			echo json_encode($rs);
			exit;
		}
		if(!$game_id){
			$rs = array('code'=>0, 'msg' => '错误');
			echo json_encode($rs);
			exit;
		}
		if(!$gift_id){
			$rs = array('code'=>0, 'msg' => '错误');
			echo json_encode($rs);
			exit;
		}
		$ordermodel = new Model_Admin_Order_Ordermodel();
		$orderinfo = $ordermodel->get_order($phone, $game_id, $gift_id);
		$captcha = Common_Helper::randCode(12);
		if($orderinfo){
			if($orderinfo['status'] >= 1){
				$rs = array('code'=>1, 'msg' => '成功');
				echo json_encode($rs);
				exit;
			}
			$data = array(
				'captcha' => $captcha,	
				'order_time' => date('Y-m-d H:i:s'),
			);
			$ordermodel->update($orderinfo['id'], $data);
		}else{
			$order_id = date('YmdHis').Common_Helper::randCode(5,1);
			$data = array(
				'id' => $order_id,
				'user_id' => $phone,
				'game_id' => $game_id,
				'captcha' => $captcha,	
				'gift_id' => $gift_id,
				'order_time' => date('Y-m-d H:i:s'),
			);
			$ordermodel->add($data);
		}
		$messagemodel = new Model_Api_Messagemodel();
		$msg = '兑奖验证码'.$captcha.'请从 http://www.kaolagift.com/dl 下载安装考拉有礼兑奖。';
		$sendrs = $messagemodel->send($phone, $msg);
		if($sendrs){
			$rs = array('code'=>1, 'msg' => '成功');
			echo json_encode($rs);
			exit;
		}
		$rs = array('code'=>0, 'msg' => '错误');
		echo json_encode($rs);
		exit;
	}
	
}