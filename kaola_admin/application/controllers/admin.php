<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin控制器
 *
 */
class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }

    /**
     * Admin 首页
     */
    public function index()
    {
        $this->helper->redirect(array('admin/edit'));
    }

    /**
     * 编辑页面
     */
    public function edit()
    {
    	$this->load->config('pagination', true);
    	$_admin = $this->session->userdata('_admin');
    	$id  = $_admin['id'];
        $data = $this->admin_model->findByPk($id);
        if(empty($data)) {
            $this->helper->msg('该记录不存在或已被删除');
        }
        $this->load->view('admin/form', array(
                'action' => 'edit',
                'data' => $data,
                'column' => $this->admin_model->attributes(),
        ));
    }

    /**
     * 新增、编辑校验页面
     */
    public function verify()
    {
        if(! ($post = $this->input->post())) {
            $this->helper->redirect(array('admin/edit'));
        }
        $action = $this->input->post('_action');
        $this->load->library('form_validation');
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $flag = $password1 == $password2;
        if(!$flag) {
            $this->helper->msg($this->form_validation->error_string('<span>', '</span><BR>'));
            return false;
        }
        $_admin = $this->session->userdata('_admin');
    	$pk  = $_admin['id'];
        if($pk) {
        	$data['password'] = md5($password1);
            $this->verify_edit($pk, $data);
        } else {
            $this->helper->msg('非法操作');
        }
    }

    /**
     * 处理编辑请求
     */
    private function verify_edit($pk, $data)
    {
        if($this->admin_model->updateByPk($pk, $data)) {
            $this->helper->msg('修改成功', 'login/logout', '重新登录');
        } else {
            $this->helper->msg('修改失败');
        }
    }
}

/* End of file admin.php */
/* Location: ./application/models/admin.php */