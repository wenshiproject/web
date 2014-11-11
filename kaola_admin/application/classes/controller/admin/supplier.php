<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Supplier extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array('delete','check',
		));
		parent::before();

	}
	
	public function action_index(){
		
	}
	
	public function action_check_list(){
		$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
		$total = $suppliermodel->get_supplier_cnt(1);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $suppliermodel->get_supplier(1, $limit, $offset);
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_noncheck(){
		$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
		$total = $suppliermodel->get_supplier_cnt(0);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $suppliermodel->get_supplier(0, $limit, $offset);
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_add(){
		if($this->request->post()){
			$name = r::string('name');
			$address = r::string('address');
			$email = r::string('email');
			$phone = r::string('phone');
			$contact = r::string('contact');
			$qq = r::numeric('qq');
			if(!$name){
				Common_Helper::show_msg_back('请输入供应商名称');
				exit;
			}
			if(!$address){
				Common_Helper::show_msg_back('请输入联系地址');
				exit;
			}
			if(!$email){
				Common_Helper::show_msg_back('请输入邮箱');
				exit;
			}
			if(!$phone){
				Common_Helper::show_msg_back('请输入手机号码');
				exit;
			}
			if(!$contact){
				Common_Helper::show_msg_back('请输入联系人');
				exit;
			}
			if(!$qq){
				Common_Helper::show_msg_back('请输入联系QQ');
				exit;
			}
			$data = array(
				'name' => $name,
				'address' => $address,
				'email' => $email,
				'phone' => $phone,
				'contact' => $contact,
				'qq' => $qq,
				'add_time' => date('Y-m-d H:i:s'),
			);
			$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
			$suppliermodel->add($data);
			Common_Helper::show_msg('添加成功','/admin/supplier/check_list');
			exit;
		}
	}
	
	public function action_delete(){
		$id = r::numeric('id');
		if(!$id){
			Common_Helper::show_msg_back('参数有误');
			exit;
		}
		$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
		$data = array(
				'status' => -1,
		);
		$suppliermodel->update($id, $data);
		Common_Helper::show_msg('操作成功','/admin/supplier/check_list');
		exit;
	}
	
	public function action_check(){
		$id = r::numeric('id');
		if(!$id){
			Common_Helper::show_msg_back('参数有误');
			exit;
		}
		$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
		$data = array(
				'status' => 1,
		);
		$suppliermodel->update($id, $data);
		Common_Helper::show_msg('操作成功','/admin/supplier/noncheck');
		exit;
	}
	
	public function action_edit(){
		$id = r::numeric('id');
		if(!$id){
			Common_Helper::show_msg('ID不存在','/admin/supplier/check_list');
			exit;
		}
		$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
		if($this->request->post()){
			$name = r::string('name');
			$address = r::string('address');
			$email = r::string('email');
			$phone = r::string('phone');
			$contact = r::string('contact');
			$qq = r::numeric('qq');
			if(!$name){
				Common_Helper::show_msg_back('请输入供应商名称');
				exit;
			}
			if(!$address){
				Common_Helper::show_msg_back('请输入联系地址');
				exit;
			}
			if(!$email){
				Common_Helper::show_msg_back('请输入邮箱');
				exit;
			}
			if(!$phone){
				Common_Helper::show_msg_back('请输入手机号码');
				exit;
			}
			if(!$contact){
				Common_Helper::show_msg_back('请输入联系人');
				exit;
			}
			if(!$qq){
				Common_Helper::show_msg_back('请输入联系QQ');
				exit;
			}
			$data = array(
				'name' => $name,
				'address' => $address,
				'email' => $email,
				'phone' => $phone,
				'contact' => $contact,
				'qq' => $qq,
				'add_time' => date('Y-m-d H:i:s'),
			);
			$suppliermodel->update($id, $data);
			Common_Helper::show_msg('编辑成功','/admin/supplier/noncheck');
			exit;
		}else{
			$rs = $suppliermodel->get_row($id);
			$this->view->rs = $rs;
		}
	}
}