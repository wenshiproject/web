<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 联运表模型
 * 
 */
class Operator_model Extends MY_Model
{
    /**
     * 主键
     */
    public function primaryKey()
    {
        return 'id';
    }

    /**
     * 表名称
     */
    public function tableName()
    {
        return 'op_operator';
    }

    /**
     * 字段
     */
    public function attributes()
    {
        return array(
            'id' => '联运ID',
            'name' => '联运名称',
            'poid' => '对应平台ID',
            'bkoid' => '对应后端ID',
        	'prefix' => '前缀',
            'packname' => '联运包名',
            'addtime' => '添加时间',
        );
    }
}

/* End of file operator_model.php */
/* Location: ./application/models/operator_model.php */