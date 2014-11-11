<?php

class Model_Admin_Usermg_Usermgmodel extends Model_Base
{
	protected  $table = 'ws_user';

	public function get_user($phone, $code){
		return DB::select()
				->from($this->table)
				->where('id','=',$phone)
				->where('code','=',$code)
				->execute()
				->current();
	}
}