<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Order extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array(
		));
		parent::before();

	}
	
	public function action_list(){
		$ordermodel = new Model_Admin_Order_Ordermodel();
		$total = $ordermodel->get_count_orders(-1, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id']);
		$pagination = $this->get_page_view(50,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $ordermodel->get_all_orders(-1, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id'], $limit, $offset);
		$addressmodel = new Model_Admin_Address_Addressmodel();
		$this->view->addressinfo = $addressmodel->get_all_address();
		$this->view->order_status = Kohana::$config->load('config')->order_status;
		$this->view->rs = $rs;
		$this->view->get = $_GET;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_check(){
		$ordermodel = new Model_Admin_Order_Ordermodel();
		$total = $ordermodel->get_count_orders(2, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id']);
		$pagination = $this->get_page_view(50,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $ordermodel->get_all_orders(2, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id'], $limit, $offset);
		$this->view->order_status = Kohana::$config->load('config')->order_status;
		$addressmodel = new Model_Admin_Address_Addressmodel();
		$this->view->addressinfo = $addressmodel->get_all_address();
		$this->view->rs = $rs;
		$this->view->get = $_GET;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_noncheck(){
		$ordermodel = new Model_Admin_Order_Ordermodel();
		$total = $ordermodel->get_count_orders(1, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id']);
		$pagination = $this->get_page_view(50,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $ordermodel->get_all_orders(1, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id'], $limit, $offset);
		$this->view->order_status = Kohana::$config->load('config')->order_status;
		$addressmodel = new Model_Admin_Address_Addressmodel();
		$this->view->addressinfo = $addressmodel->get_all_address();
		$this->view->rs = $rs;
		$this->view->get = $_GET;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_verified(){
		$ordermodel = new Model_Admin_Order_Ordermodel();
		$total = $ordermodel->get_count_orders(0, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id']);
		$pagination = $this->get_page_view(50,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $ordermodel->get_all_orders(0, $_GET['phone'], $_GET['order_id'], $_GET['game_id'], $_GET['gift_id'], $limit, $offset);
		$this->view->order_status = Kohana::$config->load('config')->order_status;
		$addressmodel = new Model_Admin_Address_Addressmodel();
		$this->view->addressinfo = $addressmodel->get_all_address();
		$this->view->rs = $rs;
		$this->view->get = $_GET;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
}