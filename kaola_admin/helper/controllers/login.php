<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 登录模块
 *
 */
class Login extends MY_Controller
{

    public function index()
    {
        if($this->helper->isLogin()) {
            $this->helper->redirect(array(''));
        }
        if($this->input->post()) {
            if($this->session->userdata('_capthcha_code') != strtolower($this->input->post('verify_code', true))) {
                $this->error('验证码错误');
            }
            $username = $this->input->post('username', true);
            $password = $this->input->post('password');
            if($username != 'admin' || $password != '123456') {
                $this->error('用户名或密码错误');
            }
            $_admin['_admin'] = array(
                'is_login' => true,
                'admin_id' => 'admin',
                'nickname' => 'Admin',
            );
            $this->session->set_userdata($_admin);
            $this->session->unset_userdata('_capthcha_code');
            $this->helper->redirect(array(''));
        }
        $this->view->render('admin/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->helper->redirect(array('login'));
    }

    private function error($msg)
    {
        $this->view->render('admin/login', array(
            'message' => $msg,
            'post' => $this->input->post()
        ));
        exit;
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */