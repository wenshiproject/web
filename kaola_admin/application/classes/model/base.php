<?php
class Model_Base extends Model_Database
{
   protected $table;
   
   /**
    * 增加记录
    * 
    * @param array $insert_data 数据
    * @return 
    */
	public function add($insert_data) {
		return DB::insert($this->table, array_keys($insert_data))
			->values(array_values($insert_data))
			->execute();
	}//end method add
	
	/**
	 * 根据id更新
	 * 
	 * @param array $update_data 更新的内容
	 * @param int $id 自增id
	 * @return 
	 */
	public function update($id, $update_data) {
		return DB::update($this->table)
			->set($update_data)
			->where('id', '=', $id)
			->execute();
	}//end method update
	
	/**
	 * 给某个字段自增
	 * 
	 * @param int $id id
	 * @param string $increase_columns 自增字段
	 * @param int $num 自增数量
	 * @return 
	 */
	public function increase($id, $increase_columns, $num) {
		$num = (int)$num;
		return DB::update($this->table)
			->set(array($increase_columns=>DB::expr("`$increase_columns`+ $num")))
			->where('id', '=', $id)
			->execute();
	}//end method increase
	
	/**
	 * 
	 * 删除记录
	 */
	public function delete($id) {
		return DB::delete($this->table)
			->where('id', '=', $id)
			->execute();
	}//end method delete
	
	/**
	 * 判断是否存在
	 * 
	 * @param string $column 字段名
	 * @param int $column_value 字段值
	 * @return 
	 */
	public function is_exist($column, $column_value) {
		return DB::select(DB::expr('COUNT(1) AS N'))
			->from($this->table)
			->where($column, '=', $column_value)
			->execute()
			->get('N');
	}//end method is_exist
	
	/**
	 * 根据id获取一条记录
	 * 
	 * @param int $id id
	 * @return array
	 */
	public function get_row($id) {
		return DB::select()
			->from($this->table)
			->where('id', '=', $id)
			->execute()
			->current();
	}//end method get_row
	
	/**
	 * 获取全部记录
	 * @return array
	 */
	public function get_all() {
		return DB::select()
			->from($this->table)
			->execute()
			->as_array();
	}//end method get_all
	
	/**
	 * 获取全部记录
	 * @return array
	 */
	public function get_all_map() {
		return Common_Helper::get_map_by_id($this->get_all());
	}//end method get_all
	
	/**
	 * 根据id数组获取数据
	 * 
	 * @param array $ids id数组
	 * @return
	 *  array(
	 *    id1=>array(), 
	 *    id2=>array(),  
	 *    ...
	 *  )
	 */
	public function get_map_by_ids($ids) {
		$info = DB::select()
			->from($this->table)
			->where('id', 'in', $ids)
			->execute()
			->as_array();
		return Common_Helper::get_map_by_id($info);
	}//end method get_map_by_ids
	

	/**
	 * 获取第一条数据
	 * 
	 */
	public function get_first_one() {
   		return DB::select()
   			->from($this->table)
   			->order_by('id', 'desc')
   			->limit()
   			->execute()
   			->current();
	}//end method get_first_one
	
	public function get_count(){
		return DB::select(array('count("id")', 'count'))
			->from($this->table)
			->execute()
			->current();
	}
}