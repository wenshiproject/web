<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Usermg extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array(
		));
		parent::before();

	}
	
	public function action_list(){

	}
}