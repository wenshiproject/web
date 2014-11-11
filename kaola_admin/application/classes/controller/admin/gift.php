<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Gift extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array('op','game_gift','delimg'
		));
		parent::before();

	}
	
	public function action_delimg(){
		$id = r::numeric('id');
		$imgkey = r::string('key');
		if($id && $imgkey){
			$giftmodel = new Model_Admin_Gift_Giftmodel();
			$rs = $giftmodel->get_row($id);
			if($rs['image_path']){
				$img_arr = explode(',', $rs['image_path']);
				foreach ($img_arr as $key => $val){
					if($val == $imgkey){
						unset($img_arr[$key]);
					}
				}
				$data = array(
					'image_path' => implode(',', $img_arr),
				);
				$giftmodel->update($id, $data);
				echo json_encode(array('msg' => 1));
				exit;
			}
		}
		echo json_encode(array('msg' => 0));
		exit;
	}
	
	public function action_game_gift(){
		$game_id = r::numeric('game_id');
		if(!$game_id){
			$rs = array('code'=>0, 'msg' => '请输入手机号码');
			echo json_encode($rs);
			exit;
		}
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$giftrs = $giftmodel->get_game_gift($game_id);
		if($giftrs){
			$rs = array('code'=>1, 'msg' => $giftrs);
			echo json_encode($rs);
			exit;
		}	
	}
	
	public function action_added(){
		$name = r::string('name');
		$code = r::string('code');
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$total = $giftmodel->get_gift_cnt(1, $name, $code);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $giftmodel->get_gift(1, $name, $code, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['image_path']){
				$img_arr = explode(',', $val['image_path']);
				$rs[$key]['image_path'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_stock(){
		$name = r::string('name');
		$code = r::string('code');
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$total = $giftmodel->get_gift_cnt(0, $name, $code);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $giftmodel->get_gift(0, $name, $code, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['image_path']){
				$img_arr = explode(',', $val['image_path']);
				$rs[$key]['image_path'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_add(){
	if($this->request->post()){
			$name = r::string('name');
			$code = r::string('code');
			$num = r::numeric('num');
			$price = r::string('price');
			$desc = r::string('desc');
			$game_id = r::numeric('game_id');
			$game_cond = r::string('game_cond');
			$supplier_id = r::numeric('supplier_id');
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
				$size = getimagesize($_FILES['image']['tmp_name'][0]);
				$image_path = implode(',', $key_arr);
			}
			$broadcast_img = '';
			if(!empty($_FILES["broadcast_img"])){
				$broadcast_img_type = $qiyunmodel->get_type($_FILES["broadcast_img"]["type"]);
				if($broadcast_img_type){
					$broadcast_img = $qiyunmodel->upload($type, $_FILES['broadcast_img']['tmp_name']);
				}
			}
			
			$data = array(
				'name' => $name,
				'code' => $code,
				'number' => $num,
				'price' => $price,
				'desc' => $desc,
				'game_id' => $game_id,
				'game_cond' => $game_cond,
				'supplier_id' => $supplier_id,
				'image_path' => $image_path,
				'image_width' => $size[0]?$size[0]:0,
				'image_height' => $size[1]?$size[1]:0,
				'add_time' => date('Y-m-d H:i:s'),
				'broadcast_img' => $broadcast_img,
			);
			$giftmodel = new Model_Admin_Gift_Giftmodel();
			$giftmodel->add($data);
			Common_Helper::show_msg('添加成功','/admin/gift/add');
			exit;
		}
		$suppliermodel = new Model_Admin_Supplier_Suppliermodel();
		$suppliers = $suppliermodel->get_supplier(1);
		$this->view->suppliers = $suppliers;
	}
	
	public function action_edit(){
		$id = r::string('id');
		if(!id){
			Common_Helper::show_msg_back('请输入ID');
			exit;
		}
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$qiyunmodel = new Model_Api_Qiniumodel(); 
		if($this->request->post()){
			$name = r::string('name');
			$desc = r::string('desc');
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
			if(!empty($_FILES["broadcast_img"])){
				$broadcast_img_type = $qiyunmodel->get_type($_FILES["broadcast_img"]["type"]);
				if($broadcast_img_type){
					$broadcast_img = $qiyunmodel->upload($type, $_FILES['broadcast_img']['tmp_name']);
				}
			}
			$rs = $giftmodel->get_row($id);
			$img_arr = array();
			if($rs['image_path']){
				$img_arr = explode(',', $rs['image_path']);
			}
			$total_arr = array_merge($key_arr, $img_arr);
			$image_path = implode(',', $total_arr);
			$data = array(
				'name' => $name,
				'desc' => $desc,
				'image_path' => $image_path,
			);
			if($broadcast_img){
				$data['broadcast_img'] = $broadcast_img;
			}
			$giftmodel->update($id, $data);
			Common_Helper::show_msg('编辑成功','/admin/gift/edit?id='.$id);
			exit;
		}
		$rs = $giftmodel->get_row($id);
		if($rs['image_path']){
			$img_arr = explode(',', $rs['image_path']);
			unset($rs['image_path']);
			foreach ($img_arr as $key => $val){
				$rs['image_path'][] = $val;
				$rs['image_path_url'][] = $qiyunmodel->make_url($val, 200, 100);
			}
		}
		if($rs['broadcast_img']){
			$rs['broadcast_img_url'] = $qiyunmodel->make_url($rs['broadcast_img'], 200, 100);
		}
		$this->view->rs = $rs;
	}
	
	public function action_down(){
		$name = r::string('name');
		$code = r::string('code');
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$total = $giftmodel->get_gift_cnt(2, $name, $code);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $giftmodel->get_gift(2, $name, $code, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['image_path']){
				$img_arr = explode(',', $val['image_path']);
				$rs[$key]['image_path'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	
	public function action_op(){
		$id = r::numeric('id');
		$op = r::string('op');
		if(!$id){
			echo json_encode(array('msg' => 0));
			exit;
		}
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		if($op == 'del'){
			$data = array(
				'status' => -1,
				'is_show' => 0,
			);
			if($giftmodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
				exit;
			}
		}else if($op == 'added'){
			$data = array(
				'status' => 1,
				'added_time' => date('Y-m-d H:i:s'),
			);
			if($giftmodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
				exit;
			}
		}else if($op == 'down'){
			$data = array(
				'status' => 2,
				'is_show' => 0,
				'down_time' => date('Y-m-d H:i:s'),
			);
			if($giftmodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
				exit;
			}
		}else if($op == 'show'){
			$data = array(
				'is_show' => 1,
			);
			if($giftmodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
				exit;
			}
		}
		echo json_encode(array('msg' => 0));
		exit;
	}
}