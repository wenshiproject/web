<?php
class Model_Api_Ordermodel extends Model{
	
	public function get_orders($start_time, $end_time, $server_id, $platform_id){
		return DB::select()
			->from('u_pay_log')
			->where('orderFinishTime', '>=', date('Y-m-d H:i:s', $start_time))
			->where('orderFinishTime', '<', date('Y-m-d H:i:s', $end_time))
			->where('serverId', '=', $server_id)
			->where('pid', '=', $platform_id)
			->where('noticeStatus', '=', 1)
			->execute();
	}
}
