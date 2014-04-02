<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * 
 */
class Game_model Extends CI_Model
{
	private $gamedb = null;
	
	public function __construct(){
		parent::__construct();
	}
	
	public function setdb(array $serverinfo){
		$config['hostname'] = $serverinfo['host'].':'.$serverinfo['port'];
		$config['username'] = $serverinfo['user'];
		$config['password'] = $serverinfo['pwd'];
		$config['database'] = $serverinfo['name'];
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";
		$this->gamedb = $this->load->database($config, TRUE);
	}
	
	public function get_pay_cnt($server_id, $order_id = null, $uid = null, $prefix = null){
		$sql = "select * from log_charge ";
		$where = " where order_status = 'S' and server_id = {$server_id} ";
		if($prefix){
				$prefixArr = explode(',', $prefix);
				$i = 0;
				foreach ($prefixArr as $val){
					if($i ==0){
						$where .= " AND ( uid like '{$val}_%' ";
					}else{
						$str .= " OR uid like '{$val}_%'";
					}
					$i++;
				}
				$where .= " ) ";
		}
		if($order_id){
			$where .= " AND order_id = '{$order_id}' ";
		}
		if($uid){
			if($prefix){
					$prefixArr = explode(',', $prefix);
					$i = 0;
					foreach ($prefixArr as $val){
						if($i ==0){
							$where .= " AND ( uid = '{$val}_{$uid}' ";
						}else{
							$str .= " OR uid = '{$val}_{$uid}'";
						}
						$i++;
					}
					$where .= " ) ";
			}else{
				$where .= " AND uid='{$uid}' ";
			}
		}
		$sql .= $where;
		return $this->gamedb->query($sql)->num_rows();
	}
	
	public function get_pay_log($server_id, $order_id = null, $uid = null, $prefix = null, $limit = 0, $offset = 0)
    {
        $sql = "select * from log_charge ";
		$where = " where order_status = 'S' and server_id = {$server_id} ";
		if($prefix){
				$prefixArr = explode(',', $prefix);
				$i = 0;
				foreach ($prefixArr as $val){
					if($i ==0){
						$where .= " AND ( uid like '{$val}_%' ";
					}else{
						$str .= " OR uid like '{$val}_%'";
					}
					$i++;
				}
				$where .= " ) ";
		}
    	if($order_id){
			$where .= " AND order_id = '{$order_id}' ";
		}
		if($uid){
			if($prefix){
					$prefixArr = explode(',', $prefix);
					$i = 0;
					foreach ($prefixArr as $val){
						if($i ==0){
							$where .= " AND ( uid = '{$val}_{$uid}' ";
						}else{
							$str .= " OR uid = '{$val}_{$uid}'";
						}
						$i++;
					}
					$where .= " ) ";
			}else{
				$where .= " AND uid='{$uid}' ";
			}
		}
		$sql .= $where. " order by charge_time desc limit $limit offset $offset ";
		return $this->gamedb->query($sql)->result_array();
    }
    
    public function get_payrank_cnt($server_id, $prefix = null){
    	$sql = "select DISTINCT(uid) from log_charge ";
		$where = " where order_status = 'S' and server_id = {$server_id} ";
		if($prefix){
				$prefixArr = explode(',', $prefix);
				$i = 0;
				foreach ($prefixArr as $val){
					if($i ==0){
						$where .= " AND ( uid like '{$val}_%' ";
					}else{
						$str .= " OR uid like '{$val}_%'";
					}
					$i++;
				}
				$where .= " ) ";
		}
		$sql .= $where;
		return $this->gamedb->query($sql)->num_rows();
    }
    
    public function get_payrank($server_id, $prefix = null, $limit = 0, $offset = 0){
    	$sql = "select uid,SUM(amount) as money,SUM(gold) as golds from log_charge ";
		$where = " where order_status = 'S' and server_id = {$server_id} ";
		if($prefix){
				$prefixArr = explode(',', $prefix);
				$i = 0;
				foreach ($prefixArr as $val){
					if($i ==0){
						$where .= " AND ( uid like '{$val}_%' ";
					}else{
						$str .= " OR uid like '{$val}_%'";
					}
					$i++;
				}
				$where .= " ) ";
		}
		$sql .= $where. " group by uid order by money desc limit $limit offset $offset";
		return $this->gamedb->query($sql)->result_array();
    }
    
    
    public function get_player_cnt($playername = null, $account = null, $prefix = null){
    	$sql = "select * from player_attribute ";
    	$where = " where 1=1 ";
    	if($prefix){
			$where .= " AND account like '{$prefix}_%' ";
		}
		if($playername){
			$where .= " AND name='".mysql_real_escape_string($playername)."'";
		}
    	if($account){
			$where .= " AND account like '%".mysql_real_escape_string($account)."'";
		}
		$sql .= $where;
//		echo $sql;
		return $this->gamedb->query($sql)->num_rows();
    }
    
    public function get_player_by_id($playerid, $prefix = null){
    	$sql = "select * from player_attribute where id=$playerid ";
    	if($prefix){
			$sql .= " AND account like '{$prefix}_%' ";
		}
		return $this->gamedb->query($sql)->result_array();
    }
    
    public function get_player($playername = null, $account = null, $prefix = null, $limit = 0, $offset = 0){
    	$sql = "select * from player_attribute ";
    	$where = " where 1=1 ";
    	if($prefix){
			$where .= " AND account like '{$prefix}_%' ";
		}
		if($playername){
			$where .= " AND name='".mysql_real_escape_string($playername)."'";
		}
    	if($account){
			$where .= " AND account like '%".mysql_real_escape_string($account)."'";
		}
		$sql .= $where. "  order by create_at desc limit $limit offset $offset";
//		echo $sql;
		return $this->gamedb->query($sql)->result_array();
    }
    
    
    public function get_player_ids_cnt($ids, $prefix = null){
    	$sql = "select * from player_attribute ";
    	$where = " where 1=1 ";
    	if($prefix){
			$where .= " AND account like '{$prefix}_%' ";
		}
		if($ids){
			$where .= " AND id in ({$ids})";
		}
		$sql .= $where;
//		echo $sql;
		return $this->gamedb->query($sql)->num_rows();
    }
    
    public function get_player_ids($ids, $prefix = null, $limit = 0, $offset = 0){
    	$sql = "select * from player_attribute ";
    	$where = " where 1=1 ";
    	if($prefix){
			$where .= " AND account like '{$prefix}_%' ";
		}
    	if($ids){
			$where .= " AND id in ({$ids})";
		}
		$sql .= $where. "  order by create_at desc limit $limit offset $offset";
//		echo $sql;
		return $this->gamedb->query($sql)->result_array();
    }
	
    
	/**
	 * 
	 * 等级分布
	 */
	public function get_level_distribution(array $search){
		$where = '';
		if(isset($search['start_date']) && $search['start_date']){
			$start = strtotime($search['start_date']);
			$end = strtotime($search['end_date'])+24*60*60;
			$where = " AND `create_at` >= '".date('Y-m-d H:i:s',$start)."' AND `create_at` < '".date('Y-m-d H:i:s',$end)."'";
		}
		$sql = "SELECT COUNT(`id`) AS `level_cnts`, `level` FROM `player_attribute` WHERE 1=1 {$where} GROUP BY `level`";
		return $this->gamedb->query($sql)->result_array();
	}
	
	/**
	 * 
	 * 职业分布
	 */
	public function get_level_professional(array $search){
		$where = '';
		if(isset($search['start_date']) && $search['start_date']){
			$start = strtotime($search['start_date']);
			$end = strtotime($search['end_date'])+24*60*60;
			$where = " AND `create_at` >= '".date('Y-m-d H:i:s',$start)."' AND `create_at` < '".date('Y-m-d H:i:s',$end)."'";
		}
		$sql = "SELECT COUNT(`id`) AS `cnts`, `class_id` FROM `player_attribute` WHERE 1=1 {$where} GROUP BY `class_id`";
		return $this->gamedb->query($sql)->result_array();
	}
}