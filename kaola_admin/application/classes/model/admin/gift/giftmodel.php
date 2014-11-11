<?php
class Model_Admin_Gift_Giftmodel extends Model_Base
{
	protected  $table = 'ws_gift';
	
	public function update_collect($id, $num){
		$sql = "update ws_gift set favorites = favorites".$num." where id=$id";
		DB::query(Database::UPDATE, $sql)->execute();
	}
	
	public function update_order($id){
		$sql = "update ws_gift set order_num = order_num+1 where id=$id";
		DB::query(Database::UPDATE, $sql)->execute();
	}
	
	public function get_game_gift($game_id){
		return  DB::select()
				->from($this->table)
				->where('status', '=', 1)
				->where('game_id', '=', $game_id)
				->order_by('add_time','DESC')
				->execute()
				->as_array();
	}
	
	public function get_push_gift($limit = 0 , $offset = 0){
		$select =  DB::select()->from($this->table)->where('is_show', '=', 1);
		if($limit){
			$select->limit($limit)->offset($offset);
		}
		return $select->order_by('add_time','DESC')->execute()->as_array();
	}
	
	public function get_gift($status=1,$name = null, $code = null, $limit = 0, $offset =0){
		$select =  DB::select()->from($this->table)->where('status', '=', $status);
		if($name){
			$select->where('name', 'like', '%'.$name.'%');
		}
		if($code){
			$select->where('code', '=', $code);
		}
		if($limit){
			$select->limit($limit)->offset($offset);
		}
		return $select->order_by('add_time','DESC')->execute()->as_array();
	}
	
	public function get_gift_cnt($status=1,$name = null, $code = null){
		$select = DB::select(array('COUNT("id")','cnt'))->from($this->table)->where('status', '=', $status);
		if($name){
			$select->where('name', 'like', '%'.$name.'%');
		}
		if($code){
			$select->where('code', '=', $code);
		}
		return $select->execute()->get('cnt');
	}
	
	public function get_order_gift($user_id,$captcha){
		return DB::select($this->table.'.*', array('ws_order.id','order_id'))
			->from($this->table)
			->join('ws_order','right')
			->on($this->table.'.id','=','ws_order.gift_id')
			->where('captcha','=',$captcha)
			->where('ws_order.user_id','=',$user_id)
			->where('ws_order.status', '=', 0)
			->execute()
			->current();
	}
	
	public function get_order_gifts($user_id){
		return DB::select($this->table.'.*', array('ws_order.id','order_id'))
			->from($this->table)
			->join('ws_order','right')
			->on($this->table.'.id','=','ws_order.gift_id')
			->where('ws_order.user_id','=',$user_id)
			->execute()
			->as_array();
	}
}