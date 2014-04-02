<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * op_admin模型
 * 
 */
class Database_model Extends MY_Model
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
        return 'database';
    }

}
