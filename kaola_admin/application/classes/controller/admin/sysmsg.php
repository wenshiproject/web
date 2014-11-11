<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Sysmsg extends Controller_Admin_Common {
	
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
			$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
			$rs = $sysmsgmodel->get_row($id);
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
				$sysmsgmodel->update($id, $data);
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
			echo json_encode(array('msg' => 0));
			exit;
		}
		$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
		if($op == 'del'){
			$data = array(
				'status' => -1,
			);
			if($sysmsgmodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
				exit;
			}
		}else if($op == 'push'){
			$data = array(
				'status' => 1,
			);
			if($sysmsgmodel->update($id, $data)){
				echo json_encode(array('msg' => 1));
				exit;
			}
		}
		echo json_encode(array('msg' => 0));
		exit;
	}
	
	public function action_push(){
		$id = r::numeric('id');
		$keyword = r::string('keyword');
		if($id || $keyword){
			$search = array(
			'id' =>$id,
			'keyword' => $keyword,
			);
		}
		$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
		$total = $sysmsgmodel->get_sysmsg_cnt(1,$search);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $sysmsgmodel->get_sysmsg(1,$search, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['image_path']){
				$img_arr = explode(',', $val['image_path']);
				$rs[$key]['image_path'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->search = $search;
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_unpush(){
		$id = r::numeric('id');
		$keyword = r::string('keyword');
		if($id || $keyword){
			$search = array(
			'id' =>$id,
			'keyword' => $keyword,
			);
		}
		$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
		$total = $sysmsgmodel->get_sysmsg_cnt(0, $search);
		$pagination = $this->get_page_view(30,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $sysmsgmodel->get_sysmsg(0,$search, $limit, $offset);
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['image_path']){
				$img_arr = explode(',', $val['image_path']);
				$rs[$key]['image_path'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
		}
		$this->view->search = $search;
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_add(){
		if($this->request->post()){
			$title = r::string('title');
			$content = r::string('content');
			if(!$title){
				Common_Helper::show_msg_back('请输入标题');
				exit;
			}
			if(!$content){
				Common_Helper::show_msg_back('请输入内容');
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
				'title' => $title,
				'content' => $content,
				'add_time' => date('Y-m-d H:i:s'),
				'image_path' => $image_path,
			);
			$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
			$sysmsgmodel->add($data);
		}
	}
	
	public function action_edit(){
		$id = r::string('id');
		if(!id){
			Common_Helper::show_msg_back('请输入ID');
			exit;
		}
		$qiyunmodel = new Model_Api_Qiniumodel();
		$sysmsgmodel = new Model_Admin_Sysmsg_Sysmsgmodel();
		if($this->request->post()){
			$title = r::string('title');
			$content = r::string('content');
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
			$rs = $sysmsgmodel->get_row($id);
			$img_arr = array();
			if($rs['image_path']){
				$img_arr = explode(',', $rs['image_path']);
			}
			$total_arr = array_merge($key_arr, $img_arr);
			$image_path = implode(',', $total_arr);
			$data = array(
				'title' => $title,
				'content' => $content,
				'image_path' => $image_path,
			);
			$sysmsgmodel->update($id, $data);
		}
		$rs = $sysmsgmodel->get_row($id);
		if($rs['image_path']){
			$img_arr = explode(',', $rs['image_path']);
			unset($rs['image_path']);
			foreach ($img_arr as $key => $val){
				$rs['image_path'][] = $qiyunmodel->make_url($val, 200, 100);
			}
			
		}
		$this->view->rs = $rs;
	}
	
}