<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/CodeHelper/Autoloader.php';

/**
 * 生成器模块
 * @author Administrator
 *
 */
class Welcome extends MY_Controller
{
    /**
     * CH初始化
     */
    public function __construct()
    {
        parent::__construct();
        CH_Autoloader::register();
    }

    public function index()
    {
        $this->setting();
    }

    /**
     * 初始化设置
     */
    public function setting()
    {
        $this->view->render('welcome/setting', array(
                'project' => CH_Runtime::getProject(),
                'errors' => CH_Runtime::detection(),
        ));
    }

    /**
     * 处理初始化设置
     */
    public function setting_helper()
    {
        $project_name = $this->input->post('project_name', TRUE);
        $tpl_type = $this->input->post('tpl_type', TRUE);
    
        if(empty($project_name)) {
            echo '请填写项目名称';exit;
        }
        if(! in_array($tpl_type, array('php', 'twig'))) {
            echo '请选择模版';exit;
        }
        $data = array(
            'project_name' => $project_name,
            'tpl_type' => $tpl_type,
        );
        CH_Runtime::setProject($data);
        CH_Runtime::initialize();
        echo '初始化完毕';
    }

    /**
     * 控制器
     */
    public function controller()
    {
        $this->view->render('welcome/controller');
    }

    /**
     * 生成控制器
     */
    public function controller_helper()
    {
        $this->load->database();
        if($this->db->conn_id === false) {
            echo '数据库链接失败';exit;
        }
        $table_name = isset($_POST['table']) ? trim($_POST['table']) : NULL;
        $model_name = isset($_POST['model']) ? trim($_POST['model']) : NULL;
        $controller_name = isset($_POST['controller']) ? trim($_POST['controller']) : NULL;
    
        if(empty($table_name) || $table_name == "*") {
            $model_name = NULL;
            $controller_name = NULL;
        }
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->controller($table_name, $controller_name, $model_name);
            echo '控制器视图生成完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 模型
     */
    public function model()
    {
        $this->view->render('welcome/model');
    }

    /**
     * 生成模型
     */
    public function model_helper()
    {
        $this->load->database();
        if($this->db->conn_id === false) {
            echo '数据库链接失败';exit;
        }
        $table_name = isset($_POST['table']) ? trim($_POST['table']) : NULL;
        $model_name = isset($_POST['model']) ? trim($_POST['model']) : NULL;
        
        if(empty($table_name) || $table_name == "*") {
            $model_name = NULL;
        }
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->model($table_name, $model_name);
            echo '模型生成完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */