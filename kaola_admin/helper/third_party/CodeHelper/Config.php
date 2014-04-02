<?php
/**
 * 配置类
 *
 */
class CH_Config
{
    /**
     * 生成文件的地址，可指定多个
     * 
     * @var array
     */
    public $builderPath;

    /**
     * 生成模型的文件夹名
     * 
     * @var string
     */
    public $modelFolder;

    /**
     * 生成控制器的文件夹名
     * 
     * @var string
     */
    public $controllerFolder;

    /**
     * 生成视图的文件夹名
     * 
     * @var string
     */
    public $viewFolder;

    /**
     * 类库目录
     * @var string
     */
    public $libraryFolder;

    /**
     * helper目录
     * @var string
     */
    public $helperFolder;

    /**
     * core目录
     * 
     * @var string
     */
    public $coreFolder;

    /**
     * 错误目录
     * @var string
     */
    public $errorFolder;

    /**
     * 配置文件目录
     * @var string
     */
    public $configFolder;

    /**
     * 生成模版的类型， 可选值 php、twig
     * php为原生模版，twig为twig模版引擎
     * 
     * @var string
     */
    public $tplType;

    /**
     * 项目名称
     * @var string
     */
    public $projectName;

    /**
     * 项目路径
     * @var string
     */
    public $projectPath;

    /**
     * 开启调试会打印调试信息
     * @var boolean
     */
    public $debug;

    public function __construct()
    {
        $this->projectPath = APPPATH.'../application';
        $this->builderPath = array($this->projectPath);
        
        $this->modelFolder = 'models';
        $this->controllerFolder = 'controllers';
        $this->viewFolder = 'views';

        $this->libraryFolder = 'libraries';
        $this->helperFolder = 'helpers';
        $this->coreFolder = 'core';
        $this->errorFolder = 'errors';
        $this->configFolder = 'config';

        $this->debug = true;
        $project = CH_Runtime::getProject();
        $this->tplType = isset($project['tpl_type']) ? $project['tpl_type'] : 'php';
        $this->projectName = isset($project['project_name']) ? $project['project_name'] : '';
    }

    /**
     * 获取生成模版的扩展名
     * 
     * @return string
     */
    public function getTplExt()
    {
        switch ($this->tplType) {
            case 'php' :
                $ext = '.php';
                break;
            default:
                $ext = '.tpl';
                break; 
        }
        return $ext;
    }

    /**
     * 获取项目使用模版类型
     * 
     * @return string
     */
    public function getTplType()
    {
        return $this->tplType;
    }

    /**
     * 获取项目名称
     * 
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * 获取项目路径
     * @return string
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }

    /**
     * 获取初始化文件名
     * 
     * @param string $filename
     * @param string $type
     * @return string
     */
    public function getInitFile($filename, $type)
    {
        $folder_name = $type.'Folder';
        $folder = $this->$folder_name;
        return $this->getProjectPath().'/'.$folder.'/'.$filename;
    }

    /**
     * 获取生成文件的文件夹地址
     * 
     * @param string $type 可选值 model controller view
     * @return array 返回完全地址
     */
    public function getBuilderFolder($type)
    {
        $folder_name = $type.'Folder';
        $folder = $this->$folder_name;
        $path = array();
        foreach($this->builderPath as $val) {
            if(substr($val, -1) == '/') {
                $val = substr($val, 0, -1);
            }
            $path[] = $val.'/'.$folder;
        }
        return $path;
    }

    /**
     * 获取生成文件
     * 
     * @param string $filename
     * @param string $type
     * @return multitype:string
     */
    public function getBuilderFile($filename, $type)
    {
        $path = $this->getBuilderFolder($type);
        $files = array();
        foreach($path as $key => $val) {
            if(substr($val, -1) == '/') {
                $val = substr($val, 0, -1);
            }
            $files[] = $val.'/'.$filename;
        }
        return $files;
    }
}