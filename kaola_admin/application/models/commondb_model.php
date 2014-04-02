<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * 
 */
class Commondb_model Extends CI_Model
{
	private $commondb = null;
	
	public function __construct(){
		parent::__construct();
        $this->commondb = $this->load->database('common', true);
	}
	
	public function get_chat_cnts(array $search){
		$start = strtotime($search['start_date']);
		$end = strtotime($search['end_date']) + 86400;
		$sql = "select DISTINCT(sender_id) from gm_chat_contents where sender_id != 0 and create_at >= '".date('Y-m-d H:i:s',$start)."' and create_at < '".date('Y-m-d H:i:s',$end)."'";
		if(isset($search['name']) && $search['name']){
			$sql .= " AND sender_name = '{$search['name']}'";
		}
		if(isset($search['account']) && $search['account']){
			$sql .= " AND sender_account like '%{$search['account']}'";
		}
		if(isset($search['prefix']) && $search['prefix']){
			$sql .= " AND sender_account like '{$search['prefix']}_%'";
		}
		return $this->commondb->query($sql)->num_rows();
	}
	
	public function get_chat(array $search, $limit = 50, $offset = 0){
		$start = strtotime($search['start_date']);
		$end = strtotime($search['end_date']) + 86400;
		$insql = "select * from gm_chat_contents where sender_id != 0 and create_at >= '".date('Y-m-d H:i:s',$start)."' and create_at < '".date('Y-m-d H:i:s',$end)."'"; 
		if(isset($search['name']) && $search['name']){
			$insql .= " AND sender_name = '{$search['name']}'";
		}
		if(isset($search['account']) && $search['account']){
			$insql .= " AND sender_account like '%{$search['account']}'";
		}
		if(isset($search['prefix']) && $search['prefix']){
			$insql .= " AND sender_account like '{$search['prefix']}_%'";
		}
		$insql .= " order by create_at desc";
		$sql = "select * from ({$insql}) as a group by sender_id order by `create_at` desc limit $limit offset $offset";
		return $this->commondb->query($sql)->result_array();
	}
	
	public function get_chat_by_userid($prefix, $user_id, $server_id, $time = 259200000){
		$where = $time == 259200000 ? " (`sender_id` = {$user_id} OR `receiver_id` = {$user_id}) " : "`sender_id` = {$user_id}";
		if($prefix){
			$where .= " AND  (sender_account like '{$prefix}_%' OR receiver_account like '{$prefix}_%') ";
		}
		$sql = "SELECT * FROM `gm_chat_contents` WHERE  {$where} AND UNIX_TIMESTAMP(`create_at`)+{$time}>UNIX_TIMESTAMP() AND server_id = {$server_id}  ORDER BY `create_at` DESC";
		return  $this->commondb->query($sql)->result_array();
	}
	
}