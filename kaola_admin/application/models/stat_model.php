<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 联运统计数据表模型
 * 
 */
class Stat_model Extends MY_Model
{
    /**
     * 主键
     */
    public function primaryKey()
    {
        return 'stattime';
    }

    /**
     * 表名称
     */
    public function tableName()
    {
        return 'op_stat';
    }

    /**
     * 字段
     */
    public function attributes()
    {
        return array(
            'prefix' => '联运简称',
            'serverid' => '联运服ID',
            'stattime' => '统计日期',
            'role' => '创角总数',
            'login' => '活跃数',
            'money' => '充值金额',
            'payuser' => '充值人数',
            'paynum' => '充值次数',
            'day1keep' => '次日留存数',
            'day7keep' => '7日留存数',
            'day15keep' => '15日留存数',
            'daymkeep' => '月留存数',
            'uptime' => '更新时间',
        );
    }
    
    public function countAll($where = array()){
    	return $this->mydb->from($this->tableName())->where($where)->distinct()->select('stattime')->get()->result_array();
    }
    
	public function sumAll($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
        $this->mydb->from($this->tableName())->where($where)->group_by('stattime');
        if($sort !== NULL) {
            $this->mydb->order_by($sort);
        }
        if($limit > 0) {
            $this->mydb->limit($limit, $offset);
        }
        $query = $this->mydb->select('stattime')
        				->select_sum('role','role')
        				->select_sum('login','login')
        				->select_sum('money','money')
        				->select_sum('payuser','payuser')
        				->select_sum('paynum','paynum')
        				->select_sum('day1keep','day1keep')
        				->select_sum('day7keep','day7keep')
        				->select_sum('day15keep','day15keep')
        				->select_sum('daymkeep','daymkeep')
        				->get();
        return $query->result_array();
    }
}

/* End of file stat_model.php */
/* Location: ./application/models/stat_model.php */