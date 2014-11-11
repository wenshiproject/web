<?php defined('SYSPATH') or die('No direct script access.');

class Controller_OAuth2_Endpoints extends Controller {

	public function action_index()
	{
		var_dump($_GET);
		echo "<hr/>";
		var_dump($this->request->query());
		exit('hi');
	}

	public function action_test()
	{
		//		$oauth = new OAuth2();
		//		$oauth->verifyAccessToken();
		//		$access_token = $oauth->get_access_token();
		//		$session = Session::instance(null,$access_token);
		//		$result = Auth_Api::instance()->get_user();
		//		Debug::ph(session_id());
		//		Debug::ph($session);
	}

	/**
	 * 联盟下载激活数采集
	 */
	private function union_activity_count_listener()
	{
		//$this->save_union_data_to_session();
		$ip = $this->get_client_ip();
		$agent = $this->get_user_agent();
		$game_id = $this->get_game_id();
		$channel_id = $this->get_channel_id();
		$device_id = $this->get_device_id();

		if ($device_id === "actived")
		{
			return ;
		}
		
		//		Debug::file_put_contents($device_id);
		$config = Kohana::$config->load("api_config");
		$request = $config['uniondcs_domain']."/a.php?ip={$ip}&gid={$game_id}&cid={$channel_id}&did={$device_id}";
		$request .= "&".$this->union_get_datapark_params();;//数据中心埋点参数
		$request .= "&agent={$agent}";
		self::get_https_content($request);//此处到后面出现瓶颈时，可以优化成走其它通道，如socket,log,cache...
	}
	/**
	 * 渠道游戏首登数采集
	 */
	private function union_channel_login_count_listener($uid,$username,$suid)
	{
		$game_id = $this->get_game_id();
		$cacheName=$username."_".$game_id;
		$cache = Cache::instance();
		if (!$cache->get($cacheName))
		{
			//发送请求
			$ip = $this->get_client_ip();
			$agent = $this->get_user_agent();
			$channel_id = $this->get_channel_id();
			$config = Kohana::$config->load("api_config");
			$request = $config['uniondcs_domain']."/l.php?ip={$ip}&gid={$game_id}&cid={$channel_id}&uid={$uid}&username={$username}";
			$request .= "&".$this->union_get_datapark_params($suid);;//数据中心埋点参数
			$request .= "&agent={$agent}";
			self::get_https_content($request);//此处到后面出现瓶颈时，可以优化成走其它通道，如socket,log,cache...

			$tomorrow =  mktime(0, 0, 0, date("n"), date("d")+1, date("Y"))-time();
			$cache->set($cacheName,1,$tomorrow);
		}
			
	}
	/**
	 * 联盟渠道注册数采集
	 */
	private function union_channel_register_count_listener($uid,$username,$suid)
	{
		$ip = $this->get_client_ip();
		$agent = $this->get_user_agent();
		$game_id = $this->get_game_id();
		$channel_id = $this->get_channel_id();
		$config = Kohana::$config->load("api_config");
		$request = $config['uniondcs_domain']."/r.php?ip={$ip}&gid={$game_id}&cid={$channel_id}&uid={$uid}&username={$username}";
		$request .= "&".$this->union_get_datapark_params($suid);;//数据中心埋点参数
		$request .= "&agent={$agent}";
		self::get_https_content($request);//此处到后面出现瓶颈时，可以优化成走其它通道，如socket,log,cache...
	}

	private function get_game_id()
	{
		$session = Session::instance();
		return $session->get('union_client_id',0);
	}

	private function get_channel_id()
	{
		$session = Session::instance();
		$channel_id = $session->get('union_channel_id',0);
		return (int)str_replace('channel_', '', $channel_id); // 去掉channel_前缀
	}
	/**
	 * 获取设备的ID
	 * @return device_id
	 */
	private function get_device_id()
	{
		$session = Session::instance();
		return $session->get('union_device_id',0);
	}

	private function save_union_data_to_session()
	{
		$session = Session::instance();
		$client_id = isset($_REQUEST['client_id'])? $_REQUEST['client_id'] : 0;
		$channel_id = isset($_REQUEST['channel_id'])? $_REQUEST['channel_id'] : 0;
		$device_id = isset($_REQUEST['device_id'])? $_REQUEST['device_id'] : 0;
		$session->set('union_client_id',$client_id);
		$session->set('union_channel_id',$channel_id);
		$session->set('union_device_id',$device_id);
	}

	/**
	 * 游戏参数保存
	 */
	private function save_game_params_to_session(){
		$session = Session::instance();
		$need_bind   = isset($_REQUEST['need_bind']) ? (int)$_REQUEST['need_bind'] : 0;//是否需要绑定
		$bind_user = isset($_REQUEST['game_user']) ? $_REQUEST['game_user'] : 0;//需要绑定游戏帐号
		$session->set('game_need_bind',$need_bind);
		$session->set('game_bind_user',$bind_user);
	}

	public function action_authorize()
	{
		$oauth = new Oauth2();
		$session = Session::instance();
		$conf = Kohana::$config->load('api_config');
		$redirect_uri =urlencode($conf['api_domain']."/oauth2/authorize");
		$custom_css = urlencode($conf['api_domain']."/media/css/login.css");
		$app_id = "test";
		$app_secret = "testSecret";
		$code   = $this->request->query("code");
		$expire = time()+3600;
		$secure  =false;
		if($code == NULL) {
			$client_id = $this->request->query("client_id");
			$session->set('auth_params', $oauth->getAuthorizeParams());
			$state = md5(uniqid(rand(), TRUE));
			$session->set('state', $state);

			$this->save_union_data_to_session();
			$this->save_game_params_to_session();//一键注册
				
			$this->save_datapark_params_to_session();//数据中心埋点参数

			//$device_id = $this->get_device_id();
			//			Debug::file_put_contents($device_id);
			// 广告联盟下载激活数埋点
			self::union_activity_count_listener();

			$dialog_url = "https://ptlogin.4399.com/oauth2/authorize.do?client_id=". $app_id."&redirect_uri=" . $redirect_uri."&response_type=code&state=" . $state .'&css='.$custom_css;
			if($client_id == '1347416220820420'){//异界的打印log
				Debug::file_put_contents(var_export($_GET,true));
				Debug::file_put_contents($dialog_url);
			}
			$this->request->redirect($dialog_url);
			exit;
		}
		if($this->request->query("state") == $session->get('state')) {
			$token_url = "https://ptlogin.4399.com/oauth2/token.do?". "client_id=" . $app_id."&redirect_uri=" .$redirect_uri."&client_secret=" . $app_secret."&code=" . $code."&grant_type=authorization_code";
			$response = self::get_https_content($token_url);
			if ($response=='')
			{
				echo "erro:connet to https://ptlogin.4399.com fail.when token";
				exit;
			}
			$params = json_decode($response);
			if(empty($params) || !is_object($params)){
				echo "erro:connet to https://ptlogin.4399.com fail.when token json";
				exit;
			}
			$get_info="https://ptlogin.4399.com/oauth2/resource.do?access_token=".$params->access_token."&uid=".$params->uid."&client_id=".$app_id ."&method=getInfo";
			$response_get_info = self::get_https_content($get_info);
			if ($response_get_info=='')
			{
				echo "erro:connet to https://ptlogin.4399.com fail,when get_info";
				exit;
			}
			$user = json_decode($response_get_info);
			if(empty($user) || !is_object($user)){
				echo "erro:connet to https://ptlogin.4399.com fail.when get_info user";
				exit;
			}
			if($user->result->username){				
				$channel_id = $this->get_channel_id();//获取渠道ID
				if (!$channel_id)
				{
					$ip = $this->get_client_ip();
					$config = Kohana::$config->load("api_config");
					$request = $config['uniondcs_domain']."/get_channel_id_by_ip.php?ip=".$ip;
					$channel_id=self::get_https_content($request);
				}
				$user_info= array(
//					'suid'=>$sy_user_info['suid'],
					'user_name'=>$user->result->username,
		     		'user_id'=>$user->result->uid,
		     		'bindedphone'=>$user->result->bindedphone,
		     		'email'=>$user->result->email,
				    'addtime'=>$_SERVER['REQUEST_TIME'],
				);
				
				//查询是否有用户
				$query = DB::query(Database::SELECT, "SELECT * FROM o_4399_user WHERE user_name = :user_name");
				$query->param(':user_name', $user_info['user_name']);
				$result = $query->execute('otg')->current();
				if(empty($result)){ // 如果是4399过来的新用户
					//入库
					if($session->get('game_need_bind')){//从绑定过来的，不分配帐号
						$bind_user = $session->get('game_bind_user');
						$game_user = $this->get_game_user_by_user_name($bind_user, $this->get_game_id());
						if(!empty($game_user['bind_account'])){
							$auth_params = $session->get('auth_params');
							$auth_params['result']['query']['error_code'] = 251;
							$oauth->finishClientAuthorization(false, $auth_params);
							exit;
						}
						$user_info['suid'] = $game_user['suid'];//直接用游戏内suid
					}else{
						$sy_user_info = $this->genarate_sy_user('sydid', $channel_id);//先在手游用户总表生成帐号
						if(!$sy_user_info){
							echo "erro:cannot genarate sy_user,db error";
							exit;
						}
						$user_info['suid'] = $sy_user_info['suid'];
					}					
					$this->save_4399_user($user_info,$channel_id);
					if(!$session->get('game_need_bind')){
						//联盟渠道注册数统计接口
						$this->union_channel_register_count_listener($user_info['user_id'],$user_info['user_name'],$user_info['suid']);
						$this->datapark_register_listener($user_info['suid']);//数据中心注册埋点	
					}							
				}else{
					$user_info['suid'] = $result['suid'];	
				}				
				Auth_Api::instance()->complete_login($user_info);//完成登录动作

				if(!$session->get('game_need_bind')){
					//联盟游戏首登数统计接口,做一个缓存,key="user_name"_"gameid"
					$this->union_channel_login_count_listener($user_info['user_id'],$user_info['user_name'],$user_info['suid']);
				}
				$this->datapark_login_listener($user_info['suid']);//数据中心登录埋点
					
				$session->delete('state');
					
				$output_game_username = $user_info['user_name'];//游戏内的用户ID
				$output_game_suid = $user_info['suid'];//游戏内的suid
				$output_bind_4399user = '';
				if($session->get('game_need_bind')){//需要进行绑定
					$bind_user = $session->get('game_bind_user');
					$game_user = $this->get_game_user_by_user_name($bind_user, $this->get_game_id());
					if(!empty($game_user['bind_account'])){
						$auth_params = $session->get('auth_params');
						$auth_params['result']['query']['error_code'] = 251;
						$oauth->finishClientAuthorization(false, $auth_params);
						exit;
					}
					$game_user = $this->get_game_user_by_bind_account($user_info['user_name'], $this->get_game_id());
					if($game_user){
						$auth_params = $session->get('auth_params');
						$auth_params['result']['query']['error_code'] = 251;
						$oauth->finishClientAuthorization(false, $auth_params);
						exit;
					}
					
					//更新绑定帐号
					$this->update_game_user($bind_user,$user_info['user_name'],$this->get_game_id());
					$output_game_username = $bind_user;
					$output_bind_4399user = $user_info['user_name'];
				}else{//非绑定进入
					//查询是否有绑定到游戏用户表
					$game_user = $this->get_game_user_by_bind_account($user_info['user_name'], $this->get_game_id());
					if(!$game_user){
						//保存当前4399帐号信息到游戏用户表
						$data = array(
							'suid'=>$user_info['suid'],
							'uid'=>$user_info['user_id'],
							'user_name'=>$user_info['user_name'],
							'addtime'=>$_SERVER['REQUEST_TIME'],
							'last_login_time'=>$_SERVER['REQUEST_TIME'],
							'bind_account'=>$user_info['user_name'],
							'channel_id'=>$channel_id,
						);
						$this->save_game_user($data,$this->get_game_id());
					}else{
						//返回游戏用户ID
						$output_game_username = $game_user['user_name'];
						$output_game_suid = $game_user['suid'];
					}
				}
				//针对快速注册修改
				$auth_params = $session->get('auth_params');
				$auth_params['result']['query']['username'] = $output_game_username;
				$auth_params['result']['query']['suid'] = $output_game_suid;
				if($session->get('game_need_bind') && $output_bind_4399user){
					$auth_params['result']['query']['bind_account'] = $output_bind_4399user;
				}

				$oauth->finishClientAuthorization(true, $auth_params);
				exit;
			}
		}else{
			echo "erro";
			exit;
		}
	}

	private function get_https_content($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		return curl_exec($ch);
	}

	/**
	 * 待删除的方法
	 * @deprecated
	 */
	public function action_authorize2()
	{
		$view = View::factory('oauth2/authorize');

		$oauth = new OAuth2();

		if ($_POST) {
			$oauth->finishClientAuthorization($_POST["accept"] == "Yep", $_POST);
		}

		$view->auth_params = $oauth->getAuthorizeParams();
		$this->response->body($view->render());
	}

	public function action_token()
	{
		if ($_POST)
		{
			$oauth = new OAuth2();
			$oauth->grantAccessToken();
			exit;
		} else {
			$view = View::factory('oauth2/token');
			$this->response->body($view->render());
		}
	}

	public function action_logout()
	{
		Auth_Api::instance()->logout();
		$redirect_uri   = $this->request->query("redirect_uri");
		$this->request->redirect($redirect_uri);
		exit;
	}

	/**
	 * 快速登录入口
	 */
	public function action_quick_login(){
		$client_id = isset($_REQUEST['client_id'])? $_REQUEST['client_id'] : 0;
		$did = isset($_REQUEST['did'])? $_REQUEST['did'] : 0;//设备ID
		$sign = isset($_REQUEST['sign'])? $_REQUEST['sign'] : '';
		
		if(!$client_id || !$did){
			echo json_encode(array('error_code'=>102,'error'=>'param miss'));
			exit;
		}
		$this->save_union_data_to_session();//广告联盟埋点参数
		$this->save_datapark_params_to_session();//数据中心埋点参数
		$this->union_activity_count_listener();// 广告联盟下载激活数埋点
		$channel_id = $this->get_channel_id();
		//根据设备ID验证签名
		//		if ($sign != 'vktestsign')
		//		{
		//		}
		if(!$this->check_login_sign($sign,$client_id,$did)){
			echo json_encode(array('error_code'=>103,'error'=>'sign not match'));
			exit;
		}
		$oauth = new Oauth2();
		//根据设备ID查询用户总表是否有suid
		$suid=$this->get_sy_uid($did);
		if(!$suid){//没有查找到用户id，刚自动动生成并登录
			$user_db = $this->genarate_sy_user($did,$channel_id);//生成用户并保存
			if(!$user_db){
				echo json_encode(array('error_code'=>105,'error'=>'cannot genarate sy_user, db error'));
				exit;
			}
			$this->save_game_user($user_db,$client_id);//保存用户到游戏用户总表
				
			$tokenArray = $oauth->createAccessToken($client_id, NULL,$user_db['user_name'],$user_db['suid']);
			$data = array(
				'suid'=>$user_db['suid'],
				'username'=>$user_db['user_name'],
				'timestamp'=>$user_db['addtime'],
				'signStr'=>$this->get_sign_string($user_db['user_name'],$user_db['addtime'],$client_id),
				'access_token'=>$tokenArray['access_token'],
				'expires_in'=>$tokenArray['expires_in'],
				'autoStr'=>$oauth->encodeAccessTokenToSDK($tokenArray['access_token']),
			);
			//联盟渠道注册数统计接口
			$this->union_channel_register_count_listener($user_db['suid'],$user_db['user_name'],$user_db['suid']);
				
			//数据后台：用户注册、登录埋点
			$this->datapark_register_listener($user_db['suid']);
		}else{
			//获取游戏数据表是否有绑定关系
			$game_user = $this->get_game_user($suid, $client_id);
			$timestamp = $_SERVER['REQUEST_TIME'];
			if(!$game_user){
				$user_data = array(
					'suid'=>$suid,
					'uid'=>$suid,
					'user_name'=>'sy'.$suid,//用户名
				//					'device_id'=>$did,
					'addtime'=>$timestamp,
					'last_login_time'=>$timestamp,
					'channel_id'=>$channel_id,
				);
					
				$this->save_game_user($user_data,$client_id);//保存用户到游戏用户总表
				unset($user_data);
			}else if($game_user && $game_user['bind_account']){
				echo json_encode(array('error_code'=>104,'error'=>'device has bind,need login'));//有绑定的情况，跳到登录框
				exit;
			}
			$this->update_game_user_login_time('sy'.$suid, $client_id);//更新用户登录时间
				
			$tokenArray = $oauth->createAccessToken($client_id, NULL,'sy'.$suid,$suid);
				
			//根据用户id处理登录
			$data = array(
				'suid'=>$suid,
				'username'=>'sy'.$suid,
				'timestamp'=>$timestamp,
				'signStr'=>$this->get_sign_string('sy'.$suid,$timestamp,$client_id),
				'access_token'=>$tokenArray['access_token'],
				'expires_in'=>$tokenArray['expires_in'],
				'autoStr'=>$oauth->encodeAccessTokenToSDK($tokenArray['access_token']),
			);
		}
		$this->union_channel_login_count_listener($data['suid'],$data['username'],$data['suid']);//联盟首登埋点
		$this->datapark_login_listener($data['suid']);//数据中心登录埋点

		$user_info= array(
			'suid'=>$suid,
			'user_name'=>'sy'.$suid,
			'addtime'=>$_SERVER['REQUEST_TIME'],
		);					
		Auth_Api::instance()->complete_login($user_info);//完成登录动作
		
		echo json_encode($data);
		exit;
	}

	/**
	 * 判断帐号绑定接口
	 */
	public function action_check_bind(){
		$client_id = isset($_REQUEST['client_id'])? (int)$_REQUEST['client_id'] : 0;
		$channel_id = isset($_REQUEST['channel_id'])? (int)$_REQUEST['channel_id'] : 0;
		$user_name = isset($_REQUEST['game_user'])? $_REQUEST['game_user'] : '';

		if(!$user_name){
			echo json_encode(array('error_code'=>111,'error'=>'no username'));
			exit;
		}
		//查询游戏用户绑定表
		$user_info = $this->get_game_user_by_user_name($user_name,$client_id);
		if(!$user_info){
			echo json_encode(array('error_code'=>112,'error'=>'username no correct'));
			exit;
		}
		if($user_info && $user_info['bind_account']){
			$data = array(
				'bind_account'=>$user_info['bind_account'],
			);
		}else{
			$data = array(
				'bind_account'=>'',
			);
		}
		echo json_encode($data);
		exit;
	}

	/**
	 * 生成用户并保存(旧方法)
	 * @param unknown_type $device_id
	 */
	private function genarate_sy_user_old($device_id,$channel_id){
		$sy_uid = $this->genarate_sy_uid();
		$data = array(
			'uid'=>$sy_uid,
			'user_name'=>'sy'.$sy_uid,//用户名
			'device_id'=>$device_id,
			'addtime'=>$_SERVER['REQUEST_TIME'],
			'last_login_time'=>$_SERVER['REQUEST_TIME'],
			'channel_id'=>$channel_id,
		);
		$this->save_sy_user($data);
		return $data;
	}

	/**
	 * 生成用户并保存
	 * @param $device_id
	 * @param $channel_id
	 */
	private function genarate_sy_user($device_id,$channel_id){
		//先入库获取自增ID，再更新用户名
		$data = array(
			'user_name'=>'syuser',
			'device_id'=>$device_id,
			'channel_id'=>$channel_id,
			'addtime'=>$_SERVER['REQUEST_TIME'],
			'last_login_time'=>$_SERVER['REQUEST_TIME'],
		);
		$uid = $this->save_sy_user_info($data);
		if(!$uid){//如果不能获取
			$uid = $this->save_sy_user_info($data);
			if(!$uid){
				return array();
			}
		}
		$uid = $uid[0];		
		$user_name = 'sy'.$uid;
		$query = DB::query(Database::UPDATE, "UPDATE o_users SET `user_name`=:user_name WHERE suid=:suid");
		$query->param(':user_name', $user_name);
		$query->param(':suid', $uid);
		$query->execute('otg');
			
		$data['suid']= $uid;
		$data['uid'] = $uid;
		$data['user_name']=$user_name;
		return $data;
	}

	/**
	 * 保存手游用户
	 * @param unknown_type $data
	 */
	private function save_sy_user_info($data){
		$query = DB::query(Database::INSERT, "INSERT INTO o_users SET `user_name`=:user_name,`did`=:did,`addtime`=:addtime,`channel_id`=:channel_id");
		$query->param(':user_name', $data['user_name']);
		$query->param(':did', $data['device_id']);
		$query->param(':addtime', $data['addtime']);
		$query->param(':channel_id', $data['channel_id']);
		return $query->execute('otg');
	}
	
	/**
	 * 保存用户数据
	 * @param unknown_type $data
	 */
	private function save_sy_user($data){
		$query = DB::query(Database::INSERT, "INSERT INTO o_sy_user SET `uid`=:uid,`user_name`=:user_name,`device_id`=:device_id,`addtime`=:addtime,`last_login_time`=:last_login_time,`channel_id`=:channel_id");
		$query->param(':uid', $data['uid']);
		$query->param(':user_name', $data['user_name']);
		$query->param(':device_id', $data['device_id']);
		$query->param(':addtime', $data['addtime']);
		$query->param(':last_login_time', $data['last_login_time']);
		$query->param(':channel_id', $data['channel_id']);
		return $query->execute('otg');
	}

	/**
	 * 保存游戏用户数据
	 * @param unknown_type $data
	 * @param unknown_type $client_id
	 */
	private function save_game_user($data,$client_id){
		$tbl = $this->get_game_short_name($client_id);
		if(!$tbl) return false;

		$query = DB::query(Database::INSERT, "INSERT INTO o_game_user_".$tbl." SET `suid`=:suid,`uid`=:uid,`user_name`=:user_name,`bind_account`=:bind_account,`addtime`=:addtime,`last_login_time`=:last_login_time,`channel_id`=:channel_id,`server_id`=:server_id");
		$query->param(':suid', $data['suid']);
		$query->param(':uid', $data['uid']);
		$query->param(':user_name', $data['user_name']);
		$query->param(':bind_account', isset($data['bind_account']) ? $data['bind_account'] : '0');
		$query->param(':addtime', $data['addtime']);
		$query->param(':last_login_time', $data['last_login_time']);
		$query->param(':channel_id', $data['channel_id']);
		$query->param(':server_id', 1);
		return $query->execute('otg');
	}

	/**
	 * 检查快速登录的签名
	 * @param unknown_type $sign
	 * @param unknown_type $check_data
	 */
	private function check_login_sign($sign,$client_id,$device_id){
		$query = DB::query(Database::SELECT, "SELECT client_secret FROM api_clients WHERE client_id=:client_id");
		$query->param(':client_id', $client_id);
		$client_info = $query->execute()->current();

		$check_sign = md5($device_id.$client_info['client_secret']);
		return $check_sign == $sign ? true : false;
	}
	/**
	 * 生成手游帐号
	 */
	private function genarate_sy_uid(){
		//查询最大自增id
		$begin = '120815';
		$query = DB::query(Database::SELECT, "SELECT MAX(uid) as id FROM o_sy_user LIMIT 1");
		$rs = $query->execute('otg')->current();
		if(!$rs || $rs['id'] <= $begin){
			$query = DB::query(Database::SELECT, "SELECT count(*) as c FROM o_sy_user");
			$count = $query->execute('otg')->current();
			$uid = $begin+$count['c']+1;
		}else{
			$uid = $rs['id']+1;
		}
		return $uid;
	}

	/**
	 * 判断用户总表是否有uid
	 * @param unknown_type $device_id
	 */
	private function get_sy_uid($device_id){
		$query = DB::query(Database::SELECT, "SELECT suid FROM o_users WHERE did=:did");
		$query->param(':did', $device_id);
		$user_info = $query->execute('otg')->current();
		return $user_info ? $user_info['suid'] : array();
	}

	/**
	 * 获取游戏用户总表数据
	 * @param unknown_type $uid
	 */
	private function get_game_user($suid,$client_id){
		$tbl = $this->get_game_short_name($client_id);
		if(!$tbl) return array();

		$query = DB::query(Database::SELECT, "SELECT * FROM o_game_user_".$tbl." WHERE suid=:suid");
		$query->param(':suid', $suid);
		$game_user = $query->execute('otg')->current();
		return $game_user ? $game_user : array();
	}

	/**
	 * 服务器信息
	 */
	protected function get_server_list($game_id,$server_id){
		$conf = Kohana::$config->load('server_config');
		return isset($conf[$game_id][$server_id]) ? $conf[$game_id][$server_id] : array();
	}

	/**
	 * 获取游戏用户的信息，根据绑定ID获取
	 * @param unknown_type $username
	 */
	private function get_game_user_by_bind_account($bind_account,$client_id){
		$tbl = $this->get_game_short_name($client_id);
		if(!$tbl) return array();

		$query = DB::query(Database::SELECT, "SELECT * FROM o_game_user_".$tbl." WHERE bind_account = :bind_account");
		$query->param(':bind_account', $bind_account);
		$user_db = $query->execute('otg')->current();
		return $user_db ? $user_db : array();
	}

	/**
	 * 获取游戏用户信息，根据游戏帐号
	 * @param unknown_type $user_name
	 */
	private function get_game_user_by_user_name($user_name,$client_id){
		$tbl = $this->get_game_short_name($client_id);
		if(!$tbl) return array();

		$query = DB::query(Database::SELECT, "SELECT * FROM o_game_user_".$tbl." WHERE user_name = :user_name");
		$query->param(':user_name', $user_name);
		$user_db = $query->execute('otg')->current();
		return $user_db ? $user_db : array();
	}

	/**
	 * 更新游戏用户表
	 * @param unknown_type $user_name
	 * @param unknown_type $bind_account
	 */
	private function update_game_user($user_name,$bind_account,$client_id){
		$tbl = $this->get_game_short_name($client_id);
		if(!$tbl) return false;

		$query = DB::query(Database::UPDATE, "UPDATE o_game_user_".$tbl." SET `bind_account`=:bind_account,`last_login_time`=:last_login_time WHERE user_name=:user_name");
		$query->param(':bind_account', $bind_account);
		$query->param(':last_login_time', $_SERVER['REQUEST_TIME']);
		$query->param(':user_name', $user_name);
		$query->execute('otg');
	}

	/**
	 * 更新游戏用户登录时间
	 * @param unknown_type $user_name
	 * @param unknown_type $client_id
	 */
	private function update_game_user_login_time($user_name,$client_id){
		$tbl = $this->get_game_short_name($client_id);
		if(!$tbl) return false;

		$query = DB::query(Database::UPDATE, "UPDATE o_game_user_".$tbl." SET `last_login_time`=:last_login_time WHERE user_name=:user_name");
		$query->param(':last_login_time', $_SERVER['REQUEST_TIME']);
		$query->param(':user_name', $user_name);
		$query->execute('otg');
	}

	/**
	 * 获取游戏用户表标识
	 * @param unknown_type $client_id
	 */
	private function get_game_short_name($client_id){
		if(!$client_id) return '';
		$cache = Cache::instance();
		$cache_key = 'game_'.$client_id;
		$short_name = $cache->get($cache_key);
		if (!$short_name)
		{
			$query = DB::query(Database::SELECT, "SELECT short_name FROM o_game WHERE client_id=:client_id");
			$query->param(':client_id', $client_id);
			$game_info = $query->execute('otg')->current();
			if($game_info){
				$short_name = $game_info['short_name'];
				$time = $_SERVER['REQUEST_TIME']+86400;
				$cache->set($cache_key,$short_name,$time);
			}
		}
		return $short_name ? $short_name : '';
	}

	protected function get_client_ip(){
		if(!empty($_SERVER["REMOTE_ADDR"])){
			$cip = $_SERVER["REMOTE_ADDR"];
		}else{
			$cip = "";
		}
		return $cip;
	}

	protected function get_user_agent(){
		return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}

	private function get_sign_string($username,$timestamp,$client_id){
		$key = $this->getServerSecret($client_id);
		return md5($username.'&'.$timestamp.'&'.$key);
	}

	protected function getServerSecret($client_id) {
		$query = DB::query(Database::SELECT, "SELECT server_secret FROM api_clients WHERE client_id = :client_id");
		$query->param(':client_id', $client_id);
		$result = $query->execute()->current();

		return $result["server_secret"];
	}
	 
	/**
	 * 数据中心登录日志埋点
	 */
	private function datapark_login_listener($suid){
		$session = Session::instance();
		if(!$session->get('is_datapark_session_set')){
			throw new Exception('datapark session not set', '439');
		}
		$data = array(
				'eventId'=>0,			//事件id
				'ip'=>$this->get_client_ip(),				//ip
				'did'=>$session->get('datapark_did',0),				//设备id
				'appVersion'=>$session->get('datapark_appVersion'),		//应用（游戏）版本号
				'sdkVersion'=>$session->get('datapark_sdkVersion'),		//sdk版本号
				'uid'=>$suid,				//用户唯一标识
				'nickname'=>'',			//用户昵称
				'channelId'=>$this->get_channel_id(),		//渠道id
				'gameId'=>$this->get_game_id(),			//游戏唯一标识
				'areaId'=>$session->get('datapark_areaId'),			//分区唯一标识
				'serverId'=>$session->get('datapark_serverId'),			//服务器唯一标识
				'os'=>$session->get('datapark_os'),				//操作系统
				'osVersion'=>$session->get('datapark_osVersion'),				//操作系统版本号
				'device'=>$session->get('datapark_device'),			//设备名称
				'deviceType'=>$session->get('datapark_deviceType'),			//设备名称
				'screen'=>$session->get('datapark_screen'),			//屏幕分辨率
				'mno'=>$session->get('datapark_mno'),				//移动网络运营商
				'nm'=>$session->get('datapark_nm'),				//联网方式
				'eventTime'=>$_SERVER['REQUEST_TIME'],			//日志事件时间
				'roleLevel'=>$session->get('datapark_roleLevel',0),
		);
		Userloginsylog::getInstance()->write($data);
	}
	 
	/**
	 * 数据中心注册日志埋点
	 */
	private function datapark_register_listener($suid){
		$session = Session::instance();
		if(!$session->get('is_datapark_session_set')){
			throw new Exception('datapark session not set', '439');
		}
		$data = array(
				'eventId'=>0,			//事件id
				'ip'=>$this->get_client_ip(),				//ip
				'did'=>$session->get('datapark_did',0),				//设备id
				'appVersion'=>$session->get('datapark_appVersion'),		//应用（游戏）版本号
				'sdkVersion'=>$session->get('datapark_sdkVersion'),		//sdk版本号
				'uid'=>$suid,				//用户唯一标识
				'nickname'=>'',			//用户昵称
				'channelId'=>$this->get_channel_id(),		//渠道id
				'gameId'=>$this->get_game_id(),			//游戏唯一标识
				'areaId'=>$session->get('datapark_areaId'),			//分区唯一标识
				'serverId'=>$session->get('datapark_serverId'),			//服务器唯一标识
				'os'=>$session->get('datapark_os'),				//操作系统
				'osVersion'=>$session->get('datapark_osVersion'),				//操作系统版本号
				'device'=>$session->get('datapark_device'),			//设备名称
				'deviceType'=>$session->get('datapark_deviceType'),			//设备名称
				'screen'=>$session->get('datapark_screen'),			//屏幕分辨率
				'mno'=>$session->get('datapark_mno'),				//移动网络运营商
				'nm'=>$session->get('datapark_nm'),				//联网方式
				'eventTime'=>$_SERVER['REQUEST_TIME'],			//日志事件时间
		);
		Userregistersylog::getInstance()->write($data);
	}
	 
	/**
	 * 保存数据中心需要的参数
	 */
	private function save_datapark_params_to_session(){
		$session = Session::instance();
		$appVersion   = isset($_REQUEST['appVersion']) ? $_REQUEST['appVersion'] : 0;//游戏版本号
		$sdkVersion   = isset($_REQUEST['sdkVersion']) ? $_REQUEST['sdkVersion'] : 0;//SDK版本号
		$did       = isset($_REQUEST['did']) ? $_REQUEST['did'] : 0;//游戏编号
		//$gameId       = isset($_REQUEST['gameId']) ? $_REQUEST['gameId'] : 0;//游戏编号
		$areaId       = isset($_REQUEST['areaId']) ? $_REQUEST['areaId'] : 0;//分区编号
		$serverId       = isset($_REQUEST['serverId']) ? $_REQUEST['serverId'] : 0;//服务器编号
		$osId       = isset($_REQUEST['os']) ? $_REQUEST['os'] : 0;//操作系统
		$osVersion  = isset($_REQUEST['osVersion']) ? $_REQUEST['osVersion'] : 0;//操作系统版本号
		$device       = isset($_REQUEST['device']) ? $_REQUEST['device'] : 0;//设备名称
		$deviceType       = isset($_REQUEST['deviceType']) ? $_REQUEST['deviceType'] : 0;//设备名称
		$screen       = isset($_REQUEST['screen']) ? $_REQUEST['screen'] : 0;//屏幕
		$mno_type       = isset($_REQUEST['mno']) ? $_REQUEST['mno'] : 0;//移动网络运营商
		$nm_type       = isset($_REQUEST['nm']) ? $_REQUEST['nm'] : 0;//联网方式
		$roleLevel       = isset($_REQUEST['roleLevel']) ? $_REQUEST['roleLevel'] : 0;//游戏角色等级

		$session->set('is_datapark_session_set',true);
		$session->set('datapark_appVersion',$appVersion);
		$session->set('datapark_sdkVersion',$sdkVersion);
		$session->set('datapark_did',$did);
		//$session->set('datapark_gameId',$gameId);
		$session->set('datapark_areaId',$areaId);
		$session->set('datapark_serverId',$serverId);
		$session->set('datapark_os',$osId);
		$session->set('datapark_osVersion',$osVersion);
		$session->set('datapark_device',$device);
		$session->set('datapark_deviceType',$deviceType);
		$session->set('datapark_screen',$screen);
		$session->set('datapark_mno',$mno_type);
		$session->set('datapark_nm',$nm_type);
		$session->set('datapark_roleLevel',$roleLevel);
	}
	 
	/**
	 * 保存4399用户
	 * @param  $data
	 */
	private function save_4399_user($user_info,$channel_id){
		$query = DB::query(Database::INSERT, "INSERT INTO o_4399_user (suid,uid,user_name,is_off,bindedphone,email,addtime,channel_id) VALUES (:suid,:uid,:user_name,:is_off,:bindedphone,:email,:addtime,:channel_id)");
		$query->param(':suid', $user_info['suid']);
		$query->param(':uid', $user_info['user_id']);
		$query->param(':user_name', $user_info['user_name']);
		$query->param(':is_off', '0');
		$query->param(':bindedphone', $user_info['bindedphone']);
		$query->param(':email', $user_info['email']);
		$query->param(':addtime', $user_info['addtime']);
		$query->param(':channel_id', $channel_id);
		$query->execute('otg');
	}
	
	/**
	 * 联盟获取数据中心埋点参数
	 */
	private function union_get_datapark_params($suid=0)
	{
		//数据中心埋点参数
		$session = Session::instance();
		$data = array(
				'eventId'=>0,			//事件id
		//		'ip'=>'',
				'device_id'=>$session->get('datapark_did'),
				'appVersion'=>$session->get('datapark_appVersion'),		//应用（游戏）版本号
				'sdkVersion'=>$session->get('datapark_sdkVersion'),		//sdk版本号
				'suid'=>$suid,				//用户唯一标识
				'nickname'=>'0',			//用户昵称
		//		'channelId'=>$this->get_channel_id(),		//渠道id
		//		'gameId'=>$this->get_game_id(),			//游戏唯一标识
				'areaId'=>$session->get('datapark_areaId'),			//分区唯一标识
				'serverId'=>$session->get('datapark_serverId'),			//服务器唯一标识
				'os'=>$session->get('datapark_os'),				//操作系统
				'osVersion'=>$session->get('datapark_osVersion'),				//操作系统版本号
				'device'=>$session->get('datapark_device'),			//设备名称
				'deviceType'=>$session->get('datapark_deviceType'),			//设备名称
				'screen'=>$session->get('datapark_screen'),			//屏幕分辨率
				'mno'=>$session->get('datapark_mno'),				//移动网络运营商
				'nm'=>$session->get('datapark_nm'),				//联网方式
				'eventTime'=>$_SERVER['REQUEST_TIME'],			//日志事件时间
				'roleLevel'=>$session->get('datapark_roleLevel',0),
		);
		return http_build_query($data);
	}
	
	/**
	 * 更新4399用户的suid
	 * @param  $data
	 * @param  $user_name
	 */
	private function update_4399_user_info($data,$user_name){
		$query = DB::query(Database::UPDATE, "UPDATE o_4399_user SET `suid`=:suid WHERE user_name=:user_name");
		$query->param(':suid', $data['suid']);
		$query->param(':user_name', $user_name);
		$query->execute('otg');
	}
} // End Welcome
