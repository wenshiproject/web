<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Game extends Controller_Admin_Common {
	
	public function before()
	{
		$this->register_no_view_action(array('delimg'
		));
		parent::before();

	}
	
	public function action_delimg(){
		$id = r::numeric('id');
		$imgkey = r::string('key');
		if($id && $imgkey){
			$gamemodel = new Model_Admin_Game_Gamemodel();
			$rs = $gamemodel->get_row($id);
			if($rs['icon']){
				$img_arr = explode(',', $rs['icon']);
				foreach ($img_arr as $key => $val){
					if($val == $imgkey){
						unset($img_arr[$key]);
					}
				}
				$data = array(
					'icon' => implode(',', $img_arr),
				);
				$gamemodel->update($id, $data);
				echo json_encode(array('msg' => 1));
				exit;
			}
		}
		echo json_encode(array('msg' => 0));
		exit;
	}
	
	public function action_list(){
		$gamemodel = new Model_Admin_Game_Gamemodel();
		$total = $gamemodel->get_count();
		$total = $total['count'];
		$pagination = $this->get_page_view(50,$total);
		$limit = $pagination->items_per_page;
		$offset = $pagination->offset;
		$rs = $gamemodel->get_all();
		$companymodel = new Model_Admin_Company_Companymodel();
		$companys = $companymodel->get_all_company();
		$giftmodel = new Model_Admin_Gift_Giftmodel();
		$qiyunmodel = new Model_Api_Qiniumodel();
		foreach ($rs as $key => $val){
			if($val['icon']){
				$img_arr = explode(',', $val['icon']);
				$rs[$key]['icon'] = $qiyunmodel->make_url($img_arr[0], 200, 100);
			}
			$gg = $giftmodel->get_game_gift($val['id']);
			$ggkey = 3;
			if($gg){
				$ggkey = 2;
				foreach ($gg as $key1 => $val1){
					if($val1['status'] == 1){
						$ggkey = 1;
						break;
					}
				}
			}
			$rs[$key]['game_status'] = $ggkey;
		}
		$this->view->game_status = Kohana::$config->load('config')->game_status;
		$this->view->companys = $companys;
		$this->view->rs = $rs;
		$this->view->pageview = $pagination;
		$this->view->total = $total;
	}
	
	public function action_add(){
		$companymodel = new Model_Admin_Company_Companymodel();
		$companys = $companymodel->get_all();
		if(!$companys){
			Common_Helper::show_msg('请先添加开发商','/admin/company/add');
		}
		if($this->request->post()){
			$name = r::string('name');
			$company = r::string('company');
			$desc = r::string('desc');
			$icon = r::string('icon');
			$down_url = r::string('down_url');
			if(!$name){
				Common_Helper::show_msg_back('请输入名称');
				exit;
			}
			if(!company){
				Common_Helper::show_msg_back('请选择开发商');
				exit;
			}
			if(!$desc){
				Common_Helper::show_msg_back('请输入介绍');
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
				'name' => $name,
				'company_id' => $company,
				'desc' => $desc,
				'icon' => $image_path,
				'key' => Common_Helper::randCode(10),
				'down_url' => $down_url,
				'add_time' => date('Y-m-d H:i:s'),
			);
			$gamemodel = new Model_Admin_Game_Gamemodel();
			$gamemodel->add($data);
			Common_Helper::show_msg('添加成功','/admin/game/list');
		}
		$this->view->companys = $companys;
	}
	
	public function action_edit(){
		$id = r::numeric('id');
		if(!$id){
			Common_Helper::show_msg('ID不存在','/admin/game/list');
			exit;
		}
		$gamemodel = new Model_Admin_Game_Gamemodel();
		$qiyunmodel = new Model_Api_Qiniumodel();
		if($this->request->post()){
			$name = r::string('name');
			$company = r::string('company');
			$desc = r::string('desc');
			$down_url = r::string('down_url');
			$key_arr = array();
			if (!empty($_FILES["image"]["name"]) && is_array($_FILES["image"]['size'])) { //提取文件域内容名称，并判断 
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
			$rs = $gamemodel->get_row($id);
			$img_arr = array();
			if($rs['icon']){
				$img_arr = explode(',', $rs['icon']);
			}
			$total_arr = array_merge($key_arr, $img_arr);
			$image_path = implode(',', $total_arr);
			$data = array(
				'name' => $name,
				'company_id' => $company,
				'desc' => $desc,
				'icon' => $image_path,
				'down_url' => $down_url,
			);
			$gamemodel->update($id, $data);
			Common_Helper::show_msg('编辑成功','/admin/game/list');
			exit;
		}
		$rs = $gamemodel->get_row($id);
		if($rs['icon']){
			$img_arr = explode(',', $rs['icon']);
			unset($rs['icon']);
			foreach ($img_arr as $key => $val){
				$rs['icon'][] = $val;
				$rs['icon_path'][] = $qiyunmodel->make_url($val, 200, 100);
			}
		}
		$companymodel = new Model_Admin_Company_Companymodel();
		$companys = $companymodel->get_all();
		$this->view->companys = $companys;
		$this->view->rs = $rs;
	}
}