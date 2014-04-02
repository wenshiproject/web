<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 登录模块
 * @author Administrator
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
            $this->load->model('admin_model');
            $username = $this->input->post('username', true);
            $password = $this->input->post('password');
            $admin = $this->admin_model->findByAttributes(array('username' => $username));
            if(empty($admin) || $admin['password'] != generate_passwrod($password, $admin['salt'])) {
                $this->error('用户名或密码错误');
            }
            if($admin['stat'] != 1) {
                $this->error('您的账户已被冻结，请联系管理员');
            }
            $_admin['_admin'] = array(
                'is_login' => true,
                'admin_id' => $admin['admin_id'],
                'nickname' => $admin['nickname'],
            );
            $this->session->set_userdata($_admin);
            $this->session->unset_userdata('_capthcha_code');
            $this->admin_model->updateByPk($admin['admin_id'], array('last_logined_ts' => date("Y-m-d H:i:s")));
            $this->helper->redirect(array(''));
        }
        {{ render|raw }}('admin/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->helper->redirect(array('login'));
    }
{% if tpl_type == 'php' %}
    private function error($msg)
    {
        echo {{ render|raw }}('admin/login', array(
            'message' => $msg,
            'post' => $this->input->post()
        ), true);
        exit;
    }
{% else %}
    private function error($msg)
    {
        {{ render|raw }}('admin/login', array(
            'message' => $msg,
            'post' => $this->input->post()
        ));
        exit;
    }
{% endif %}
}