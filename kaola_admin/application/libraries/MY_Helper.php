<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 应用帮助类，主要实现提示信息、跳转、登录控制等公用模块
 */
class MY_Helper
{
    protected $CodeIgniter;

    public $user;

    public function __construct()
    {
        $this->CodeIgniter = & get_instance();
        $this->user = $this->CodeIgniter->session->userdata('_admin');
        $this->CodeIgniter->load->vars('sys_user', $this->user);
        if(! in_array($this->CodeIgniter->uri->segment(1), array('login', 'verify_code'))) {
            $this->hasLogin();
        }
    }

    /**
     * 提示信息
     * 
     * @param string $msg 提示信息
     * @param string $url 跳转URL
     * @param string $url_title 跳转标题
     */
    public function msg($msg, $url = NULL, $url_title = NULL)
    {
        echo $this->CodeIgniter->load->view('base/msg', array(
            'message' => $msg,
            'url' => $url,
            'url_title' => $url_title,
        ), true);
        exit;
    }

    /**
     * 跳转
     * @param array $route 键0为路由名，之后为参数
     * @param number $http_response_code
     */
    public function redirect($route = '',  $http_response_code = 302)
    {
        if(is_array($route)) {
            $route = create_url($route[0], array_slice($route, 1));
        }
        header("Location: ".$route, TRUE, $http_response_code);
        exit;
    }

    /**
     * 判断用户是否登录
     * @return boolean
     */
    public function isLogin()
    {
        if($this->user['is_login'] === true) {
            return true;
        }
        return false;
    }

    /**
     * 登录检测
     */
    public function hasLogin() {
        if(! $this->isLogin()) {
            $this->redirect(create_url('login', array('url' => urlencode(get_current_url()))));
        }
    }
}

/* End of file MY_Helper.php */
/* Location: ./application/libraries/MY_Helper.php */