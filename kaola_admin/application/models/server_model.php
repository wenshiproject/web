<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 联运服表模型
 * 
 */
class Server_model Extends MY_Model
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
        return 'server';
    }

    /**
     * 字段
     */
    public function attributes()
    {
        return array(
        );
    }
    
	public function get_servers($opid){
        $sql = "select a.* from {$this->tableName()} as a left join op_region as b on a.region_id = b.region_id where status !=2 and opid={$opid} order by CAST(SUBSTRING(server_id, 2) AS SIGNED) DESC";
        return $this->mydb->query($sql)->result_array();
    }
    
	public function get_union_servers($opid){
        $sql = "select a.* from {$this->tableName()} as a left join op_region as b on a.region_id = b.region_id where status !=3 and opid={$opid} order by CAST(SUBSTRING(server_id, 2) AS SIGNED) DESC";
        return $this->mydb->query($sql)->result_array();
    }
    
    public function getserverinfo($where = array()){
    	$this->mydb->select('a.server_id as serverid,b.*')
    			->from($this->tableName().' as a ')
    			->join('database as b ', 'b.server_id = a.id', 'LEFT')
    			->where($where);
        $query = $this->mydb->get();
        return $query->row_array();
    }
    
}

/* End of file server_model.php */
/* Location: ./application/models/server_model.php */