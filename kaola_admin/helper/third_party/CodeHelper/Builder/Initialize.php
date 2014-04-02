<?php
/**
 * 初始化设置
 * 
 */
class CH_Builder_Initialize extends CH_Builder_Abstract
{
    /**
     * 初始化
     */
    public function handle()
    {
        $this->handleBaseView();
        $this->handleHelpers();
        $this->handleLibraries();
        $this->handleCore();
        $this->handleBaseView();
        $this->handleErrors();
        $this->handleConfig();
        $this->handleThirdParty();
        $this->handleControllers();
    }

    /**
     * 初始化错误文件夹
     */
    public function handleErrors()
    {
        $file = array(
                'errors/error_404' => 'error_404.php',
                'errors/error_db' => 'error_db.php',
                'errors/error_general' => 'error_general.php',
                'errors/error_php' => 'error_php.php',
        );
        $CH_Config = new CH_Config();

        $data = array();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'error'), $data);
        }
    }

    /**
     * 初始化配置目录
     */
    public function handleConfig()
    {
        $file = array(
                'config/autoload' => 'autoload.php',
                'config/config' => 'config.php',
                'config/constants' => 'constants.php',
                'config/doctypes' => 'doctypes.php',
                'config/foreign_chars' => 'foreign_chars.php',
                'config/hooks' => 'hooks.php',
                'config/migration' => 'migration.php',
                'config/mimes' => 'mimes.php',
                'config/pagination' => 'pagination.php',
                'config/profiler' => 'profiler.php',
                'config/routes' => 'routes.php',
                'config/smileys' => 'smileys.php',
                'config/user_agents' => 'user_agents.php',
        );
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'twig') {
            $file['config/Twig'] = 'twig.php';
        }
        
        $data = array();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'config'), $data);
        }
        if (! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))    {
            if (! file_exists($file_path = APPPATH.'config/database.php'))    {
                $file_path = false;
            }
        }
        if($file_path) {
            CH_Template::copyFile($file_path, $CH_Config->getInitFile('database.php', 'config'));
        }
    }

    /**
     * 初始化登录控制器
     */
    public function handleControllers()
    {
        $file = array(
            'controllers/login' => 'login.php',
            'controllers/verify_code' => 'verify_code.php',
        );
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $render = '$this->load->view';
        } else {
            $render = '$this->view->render';
        }
        $data = array(
            'tpl_type' => $CH_Config->getTplType(),
            'render' => $render,
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'controller'), $data);
        }
    }

    /**
     * 初始化基本视图目录
     */
    public function handleBaseView()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $file = array(
                    'views/'.$CH_Config->getTplType().'/base/header' => 'base/header'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/sidebar' => 'base/sidebar'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/footer' => 'base/footer'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/msg' => 'base/msg'.$CH_Config->getTplExt(),
            );
        } elseif($CH_Config->getTplType() == 'twig') {
            $file = array(
                    'views/'.$CH_Config->getTplType().'/base/base' => 'base/base'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/main' => 'base/main'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/menu' => 'base/menu'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/msg' => 'base/msg'.$CH_Config->getTplExt(),
            );
        }
        $file['views/'.$CH_Config->getTplType().'/admin/login'] = 'admin/login'.$CH_Config->getTplExt();
        $data = array(
                'project_name' => $CH_Config->getProjectName(),
                'menus' => CH_Runtime::menu(),
        );
        $CH_Config = new CH_Config();
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getInitFile($val, 'view'), $data);
        }
    }

    /**
     * 初始化core目录
     */
    public function handleCore()
    {
        $file = array(
                'core/MY_Controller' => 'MY_Controller.php',
                'core/MY_Model' => 'MY_Model.php',
        );
        $CH_Config = new CH_Config();
        $data = array(
                'tpl_type' => $CH_Config->getTplType(),
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'core'), $data);
        }
    }

    /**
     * 初始化helper目录
     */
    public function handleHelpers()
    {
        $file = array(
                'helpers/MY_url_helper' => 'MY_url_helper.php',
                'helpers/app_helper' => 'app_helper.php'
        );
        $data = array();
        $CH_Config = new CH_Config();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'helper'), $data);
        }
    }

    /**
     * 初始化类库
     */
    public function handleLibraries()
    {
        $file = array(
                'libraries/MY_Helper' => 'MY_Helper.php',
                'libraries/MY_Pagination' => 'MY_Pagination.php',
                'libraries/MY_Session' => 'MY_Session.php',
                'libraries/Captcha' => 'Captcha.php'
        );
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() != 'php') {
            $file['libraries/Twig'] = 'Twig.php';
        }
        $data = array(
                'tpl_type' => $CH_Config->getTplType(),
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'library'), $data);
        }
    }

    /**
     * 初始化第三方目录
     */
    public function handleThirdParty()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'twig' && ! file_exists($CH_Config->getProjectPath().'/third_party/Twig')) {
            $CH_Template = new CH_Template();
            $CH_Template->copyFolder(APPPATH.'third_party/Twig', $CH_Config->getProjectPath().'/third_party/Twig');
        }
    }

    /**
     * 项目运行中更新操作
     */
    public function update()
    {
        $this->updateMenu();
        $this->updateRoute();
    }

    /**
     * 更新菜单
     */
    public function updateMenu()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $file = array(
                    'views/'.$CH_Config->getTplType().'/base/sidebar' => 'base/sidebar'.$CH_Config->getTplExt(),
            );
        } elseif($CH_Config->getTplType() == 'twig') {
            $file = array(
                    'views/'.$CH_Config->getTplType().'/base/menu' => 'base/menu'.$CH_Config->getTplExt(),
            );
        }
        $data = array(
                'project_name' => $CH_Config->getProjectName(),
                'menus' => CH_Runtime::menu(),
        );
        $CH_Config = new CH_Config();
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getInitFile($val, 'view'), $data);
        }
    }

    /**
     * 更新路由入口
     */
    public function updateRoute()
    {
        $file = array(
                'config/routes' => 'routes.php',
        );
        $menu = CH_Runtime::menu();
        foreach($menu as $db => $tables) {
            foreach($tables as $key => $val) {
                $default_controller = $key;
                break;
            }
        }
        if(! isset($default_controller) || empty($default_controller)) {
            $default_controller = 'welcome';
        }
        $data = array(
                'default_controller' => $default_controller,
        );
        $CH_Config = new CH_Config();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'config'), $data);
        }
    }
}