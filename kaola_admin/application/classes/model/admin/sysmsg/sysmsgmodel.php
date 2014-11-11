<?php
class Model_Admin_Sysmsg_Sysmsgmodel extends Model_Base
{
	protected  $table = 'ws_sysmsg';
	
	public function get_sysmsg($status=0,$search = null, $limit = 0, $offset =0){
		$select =  DB::select()->from($this->table)->where('status', '=', $status);
		if($limit){
			$select->limit($limit)->offset($offset);
		}
		if($search && is_array($search)){
			foreach ($search as $key => $val){
				if($val && $key == 'id'){
					$select->where($key, "=", $val);
				}else if($val && $key == 'keyword'){
					$select->and_where_open();
					$select->where('title', "like", '%'.$val.'%');
					$select->or_where('content', "like", '%'.$val.'%');
					$select->and_where_close();
				}
			}
		}
		return $select->order_by('add_time','DESC')->execute()->as_array();
	}
	
	public function get_sysmsg_cnt($status=0,$search = null ){
		$select = DB::select(array('COUNT("id")','cnt'))->from($this->table)->where('status', '=', $status);
		if($search && is_array($search)){
			foreach ($search as $key => $val){
				if($val && $key == 'id'){
					$select->where($key, "=", $val);
				}else if($val && $key == 'keyword'){
					$select->and_where_open();
					$select->where('title', "like", '%'.$val.'%');
					$select->or_where('content', "like", '%'.$val.'%');
					$select->and_where_close();
				}
			}
		}
		return $select->execute()->get('cnt');
	}
	
}