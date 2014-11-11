<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 登录、退出
 */
class Controller_Admin_User extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array(
			'logout',
		));
		parent::before();
	}
	
	public function action_login(){
		$do = empty($_GET['do']) ? "" : $_GET['do'];
		
		if($do == 'login'){
			if(Auth_Admin::instance()->get_yanz() !== strtoupper($_POST['yanz'])) {
				echo "<script language=javascript>alert('验证码不正确');</script>";
				echo "<script language=javascript>history.go(-1);</script>";
			} else {
				if(Auth_Admin::instance()->login($this->request->post('uname'), $this->request->post('passwd'))){
					$this->request->redirect('/admin/home');
				}else{
					$this->show_msg('用户名和密码不匹配，请重新登录');
				}
			}
		}else{
			$this->view->title='开放平台后台>>登录';
		}
	}
	
	public function action_logout(){
		Auth_Admin::instance()->logout();
		$this->request->redirect('/admin/user/login');
	}
	
}

?>