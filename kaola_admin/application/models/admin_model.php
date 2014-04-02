<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * op_admin模型
 * 
 */
class Admin_model Extends MY_Model
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
        return 'op_admin';
    }

    /**
     * 字段
     */
    public function attributes()
    {
        return array(
            'id' => 'id',
            'opid' => '联运ID',
            'username' => '用户名',
            'password' => '密码',
            'status' => 'status',
            'created_ts' => 'created_ts',
            'last_logined_ts' => 'last_logined_ts',
        );
    }
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */