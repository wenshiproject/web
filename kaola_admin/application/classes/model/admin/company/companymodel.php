<?php
class Model_Admin_Company_Companymodel extends Model_Base
{
	protected  $table = 'ws_company';
	
	public function get_company($status=1,$name, $limit, $offset){
		$select =  DB::select()->from($this->table)->where('status', '=', $status);
		if($name){
			$select->where('name', 'like', '%'.$name.'%');
		}
		return $select->order_by('add_time','DESC')->limit($limit)->offset($offset)->execute()->as_array();
	}
	
	public function get_company_cnt($status=1, $name){
		$select = DB::select(array('COUNT("id")','cnt'))->from($this->table);
		if($name){
			$select->where('name', 'like', '%'.$name.'%');
		}
		return $select->where('status', '=', $status)->execute()->get('cnt');
	}
	
	public function get_all_company(){
		return DB::select()->from($this->table)->execute()->as_array('id');
	}
}