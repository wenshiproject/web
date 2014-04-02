<?php
/**
 * CodeHelper 类
 *
 */
class CH_CodeHelper
{
    /**
     * 生成模型
     * 
     * @param string $table_name 表名
     * @param string $model_name 模型名
     * @throws CH_Exception 未找到表名则抛出异常
     * @return boolean true生成成功 false生成失败
     */
    public function model($table_name, $model_name = '')
    {
        $Builder = new CH_Builder_Model();
        $entities = CH_Loader_EntityLoader::load($table_name);
        if(empty($entities)) {
            throw new CH_Exception('读取表结构失败');
        }
        return $Builder->handle($entities, $model_name);
    }

    /**
     * 生成控制器
     * 
     * @param string $table_name 表名
     * @param string $controller_name 控制器名
     * @param string $model_name 模型名
     * @throws CH_Exception 未找到表名则抛出异常
     * @return boolean true生成成功 false生成失败
     */
    public function controller($table_name, $controller_name = '', $model_name = '')
    {
        $Builder = new CH_Builder_Controller();
        $entities = CH_Loader_EntityLoader::load($table_name);
        if(empty($entities)) {
            throw new CH_Exception('读取表结构失败');
        }
        return $Builder->handle($entities, $controller_name, $model_name);
    }
}