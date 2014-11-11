<?php

class Model_Admin_Address_Addressmodel extends Model_Base
{
	protected  $table = 'ws_address';
	
	public function get_address($user_id){
		return  DB::select()
				->from($this->table)
				->where('user_id','=',$user_id)
				->execute()
				->as_array();
	}
	
	public function update_default($user_id, $data){
		return DB::update($this->table)->set($data)->where('user_id', '=', $user_id)->execute();
	}
	
	public function get_all_address(){
		return  DB::select()
				->from($this->table)
				->execute()
				->as_array('id');
	}
	
}