<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 验证码
 * Enter description here ...
 * @package package_name
 * @version 2013-1-10
 * @copyright  Copyright 2012-2013
 * @author weifei.pan<panweifei@4399.net>
 */
class Controller_Admin_Yanz extends Controller {

	public function action_index() {
		$code = new Common_Yanz();
		$code->outImg();
	}

} // End Welcome
