<?php

class Model_Admin_Collect_Collectmodel extends Model_Base
{
	protected  $table = 'ws_collect';
	
	public function get_collect($user_id){
		return DB::select()->from($this->table)->where('user_id','=', $user_id)->execute()->as_array('gift_id');
	}
	
	public function get_collect_gift($user_id){
		return DB::select('ws_gift.*')
			->from($this->table)
			->join('ws_gift','LEFT')
			->on($this->table.'.gift_id', '=', 'ws_gift.id')
			->where('ws_gift.id', '>', 0)
			->execute()
			->as_array();
	}
	
	public function del_collect($user_id, $gift_id){
		return DB::delete($this->table)->where('user_id', '=', $user_id)->where('gift_id', '=', $gift_id)->execute();
	}
	
}