<?php

class Model_Admin_Order_Ordermodel extends Model_Base
{
	protected  $table = 'ws_order';
	
	public function get_all_orders($status, $phone, $order_id, $game_id, $gift_id, $limit, $offset){
		$select = DB::select()->from($this->table);
		if($status >= 0){
			$select->where('status', '=', $status);
		}
		if($phone){
			$select->where('user_id', '=', $phone);
		}
		if($order_id){
			$select->where('id', '=', $order_id);
		}
		if($game_id){
			$select->where('game_id', '=', $game_id);
		}
		if($gift_id){
			$select->where('gift_id', '=', $gift_id);
		}
		if($limit){
			$select->limit($limit)->offset($offset);
		}
		return $select->order_by('order_time','DESC')->execute()->as_array();
	}
	
	public function get_count_orders($status, $phone, $order_id, $game_id, $gift_id){
		$select = DB::select(array('COUNT("id")', 'cnt'))->from($this->table);
		if($status >= 0){
			$select->where('status', '=', $status);
		}
		if($phone){
			$select->where('user_id', '=', $phone);
		}
		if($order_id){
			$select->where('id', '=', $order_id);
		}
		if($game_id){
			$select->where('game_id', '=', $game_id);
		}
		if($gift_id){
			$select->where('gift_id', '=', $gift_id);
		}
		return $select->execute()->get('cnt');
	}
	
	public function get_user_order($phone, $captcha){
		return DB::select()
				->from($this->table)
				->where('user_id', '=', $phone)
				->where('captcha', '=', $captcha)
				->execute()
				->current();
	}
	
	public function get_orders($phone){
		return DB::select()
				->from($this->table)
				->where('user_id', '=', $phone)
				->execute()
				->as_array('gift_id');
	}
	
	public function get_order($phone, $game_id, $gift_id){
		return DB::select()
				->from($this->table)
				->where('user_id', '=', $phone)
				->where('game_id', '=', $game_id)
				->where('gift_id', '=', $gift_id)
				->execute()
				->current();
	}
}