<?php

class Model_Admin_Wish_Wishmodel extends Model_Base
{
	protected  $table = 'ws_wish';
	
	
	public function update_wish($id){
		$sql = "update ws_wish set wish_num = wish_num+1,wish_last_time='".date('Y-m-d H:i:s')."' where id=$id";
		DB::query(Database::UPDATE, $sql)->execute();
	}
	
	public function get_show_wish(){
		return DB::select()->from($this->table)->order_by('add_time','desc')->limit(4)->offset(0)->execute()->as_array();
	}
}