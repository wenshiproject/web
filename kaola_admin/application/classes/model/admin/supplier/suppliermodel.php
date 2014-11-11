<?php
class Model_Admin_Supplier_Suppliermodel extends Model_Base
{
	protected  $table = 'ws_supplier';
	
	public function get_supplier($status=1, $limit = 0, $offset =0){
		$select =  DB::select()->from($this->table)->where('status', '=', $status);
		if($limit){
			$select->limit($limit)->offset($offset);
		}
		return $select->order_by('add_time','DESC')->execute()->as_array();
	}
	
	public function get_supplier_cnt($status=1){
		return DB::select(array('COUNT("id")','cnt'))->from($this->table)->where('status', '=', $status)->execute()->get('cnt');
	}
}