<?php
/**
 * 视图生成器
 *
 */
class CH_Builder_View extends CH_Builder_Abstract
{
    /**
     * 处理类
     * 
     * @param CH_Entity $Entity
     * @param string $controller_name 控制器名称
     * @return boolean
     */
    public function handle(CH_Entity $Entity, $controller_name)
    {
        $controller_name = strtolower($controller_name);
        
        $CH_Config = new CH_Config();

        $file = array(
                'views/'.$CH_Config->getTplType().'/crud/detail' => $controller_name.'/detail'.$CH_Config->getTplExt(),
                'views/'.$CH_Config->getTplType().'/crud/list' => $controller_name.'/list'.$CH_Config->getTplExt(),
                'views/'.$CH_Config->getTplType().'/crud/form' => $controller_name.'/form'.$CH_Config->getTplExt(),
        );

        $data = array(
                'entity' => $Entity,
                'controller_name' => $controller_name,
        );
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getBuilderFile($val, 'view'), $data);
        }
        return true;
    }
}