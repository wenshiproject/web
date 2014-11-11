<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Company extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array('op','delimg'
		));
		parent::before();

	}
	
	public function action_delimg(){
		$id = r::numeric('id');
		$imgkey = r::string('key');
		if($id && $imgkey){
			$companymodel = new Model_Admin_Company_Companymodel();
			$rs = $companymodel->get_row($id);
			if($rs['license_image']){
				$img_arr = explode(',', $rs['license_image']);
				foreach ($img_arr as $key => $val){
					if($val == $imgkey){
						unset($img_arr[$key]);
					}
				}
				$data = array(
					'license_image' => implode(',', $img_arr),
				);
				$companymodel->update($id, $data);
				echo json_encode(array('msg' => 1));
				exit;
			}
		}
		echo json_encode(array('msg' => 0));
		exit;
	}
	
	public function action_op(){
		$id = r::numeric('id');
		$op = r::string('op');
		if(!$id){
			Common_Helper::show_msg('ID不存在','/admin/company/list');
			exit;
		}
		$companymodel = new Model_Admin_Company_Companymodel();
		if($op == 'del'){
			$data = array(
				'status' => -1,
			);
			if($companymodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
			}
		}else if($op == 'check'){
			$data = array(
				'status' => 1,
			);
			if($companymodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
			}
		}
		exit;
	}
	
	public function action_add(){
		if($this->request->post()){
			$email = r::string('email');
			$identity = r::string('identity');
			$name = r::string('name');
			$address = r::string('address');
			$phone = r::string('phone');
			$contact = r::string('contact');
			$qq = r::numeric('qq');
			$identity = r::numeric('identity',1);
			if(!$email){
				Common_Helper::show_msg_back('请输入邮箱');
				exit;
			}
			if(!$name){
				Common_Helper::show_msg_back('请输入供应商名称');
				exit;
			}
			if(!$address){
				Common_Helper::show_msg_back('请输入联系地址');
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
		if (!empty($_FILES["image"]) && is_array($_FILES["image"]['size'])) { //提取文件域内容名称，并判断
				$qiyunmodel = new Model_Api_Qiniumodel();
				$key_arr = array();
				foreach ($_FILES["image"]['size'] as $key => $val){
					if($val > 0){
						$type = $qiyunmodel->get_type($_FILES["image"]["type"][$key]);
						if($type){
							$img_name = $qiyunmodel->upload($type, $_FILES['image']['tmp_name'][$key]);
							if($img_name)$key_arr[] = $img_name;
						}
					}
				} 
				$image_path = implode(',', $key_arr);
			}
			$data = array(
				'email' => $email,
				'name' => $name,
				'address' => $address,
				'phone' => $phone,
				'contact' => $contact,
				'qq' => $qq,
				'identity' => $identity,
				'license_image' => $image_path,
				'add_time' => date('Y-m-d H:i:s'),
			);
			$companymodel = new Model_Admin_Company_Companymodel();
			$companymodel->add($data);
			Common_Helper::show_msg('添加成功','/admin/company/uncheck');
			exit;
		}
		
	}
	
	public function action_list(){
		$name = r::string('name');
		$companymodel = new Model_Admin_Company_Companymodel();
		$total = $companymodel->get_company_cnt(1, $name);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $companymodel->get_company(1,$name, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['license_image']){
				$img_arr = explode(',', $val['license_image']);
				$rs[$key]['license_image'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->search = array('name' => $name);
		$this->view->identity = Kohana::$config->load('config')->identity;
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_uncheck(){
		$name = r::string('name');
		$suppliermodel = new Model_Admin_Company_Companymodel();
		$total = $suppliermodel->get_company_cnt(0, $name);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $suppliermodel->get_company(0, $name, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['license_image']){
				$img_arr = explode(',', $val['license_image']);
				$rs[$key]['license_image'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->search = array('name' => $name);
		$this->view->identity = Kohana::$config->load('config')->identity;
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_edit(){
		$id = r::numeric('id');
		if(!$id){
			Common_Helper::show_msg('ID不存在','/admin/company/list');
			exit;
		}
		$companymodel = new Model_Admin_Company_Companymodel();
		$qiyunmodel = new Model_Api_Qiniumodel();
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
			$key_arr = array();
			if (!empty($_FILES["image"]) && is_array($_FILES["image"]['size'])) { //提取文件域内容名称，并判断 
				foreach ($_FILES["image"]['size'] as $key => $val){
					if($val > 0){
						$type = $qiyunmodel->get_type($_FILES["image"]["type"][$key]);
						if($type){
							$img_name = $qiyunmodel->upload($type, $_FILES['image']['tmp_name'][$key]);
							if($img_name)$key_arr[] = $img_name;
						}
					}
				}
			}
			$rs = $companymodel->get_row($id);
			$img_arr = array();
			if($rs['license_image']){
				$img_arr = explode(',', $rs['license_image']);
			}
			$total_arr = array_merge($key_arr, $img_arr);
			$image_path = implode(',', $total_arr);
			$data = array(
				'name' => $name,
				'address' => $address,
				'email' => $email,
				'phone' => $phone,
				'contact' => $contact,
				'qq' => $qq,
				'license_image' => $image_path,
			);
			$companymodel->update($id, $data);
			Common_Helper::show_msg('编辑成功','/admin/supplier/check_list');
			exit;
		}else{
			$rs = $companymodel->get_row($id);
			if($rs['license_image']){
				$img_arr = explode(',', $rs['license_image']);
				unset($rs['license_image']);
				foreach ($img_arr as $key => $val){
					var_dump($val);
					$rs['license_image'][] = $val;
					$rs['license_image_path'][] = $qiyunmodel->make_url($val, 200, 100);
				}
				
			}
			$this->view->rs = $rs;
		}
	}
	
}