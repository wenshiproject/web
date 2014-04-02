<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Stat控制器
 *
 */
class Stat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('stat_model');
        $this->load->model('server_model');
        $this->load->model('operator_model');
        $this->load->model('game_model');
        $this->load->model('database_model');
    }

    /**
     * Stat 首页
     */
    public function index()
    {
        $this->helper->redirect(array('stat/lists'));
    }
    
    /**
     * 
     * 玩家列表
     */
    public function playerlist()
    {
    	$this->load->config('pagination', true);
    	$pagination = $this->config->item('pagination');
    	$_admin = $this->session->userdata('_admin');
		$servers =  $this->server_model->get_union_servers($_admin['opid']);
		$page_query = array();
		$total = 0;
		$data = array();
		$search = array();
    	if($this->input->get()){
       		$page_query = $search = $this->input->get();
	       	$sparam = array();
	       	$sparam['server_id'] = $search['id'];
	       	$sparam['type'] = 'normal';
			$databaseinfo = $this->database_model->findByAttributes($sparam);
			unset($sparam);
			$this->game_model->setdb($databaseinfo);
			$param = array();
			$playername = '';
			$account = '';
    		if(isset($search['playername']) && $search['playername']){
	        	$playername = $search['playername'];
	        }
	        
    		if(isset($search['account']) && $search['account']){
	        	$account = $search['account'];
	        }
	        
	        $opparam['id'] = $_admin['opid'];
	        $opertorinfo = $this->operator_model->findByAttributes($opparam);
	        $prefix = $opertorinfo['prefix'] ? $opertorinfo['prefix'] : null;
			$total = $this->game_model->get_player_cnt($playername, $account, $prefix);
	        if($total > 0) {
	            $page = intval($this->input->get($pagination['query_string_segment']));
	            $page < 1 && $page = 1;
	            $pages = ceil($total / $pagination['per_page']);
	            $page > $pages && $page = $pages;
	            $data = $this->game_model->get_player($playername, $account, $prefix, $pagination['per_page'], ($page - 1)*$pagination['per_page']);
	        }
	        if($prefix){
		        foreach ($data as $key => $val){
		        	$index = strpos($val['account'], '_');
					$uid = substr($val['account'], $index+1);
		        	$data[$key]['account'] = $uid;
		        }
	        }
	        if(isset($page_query[$pagination['query_string_segment']])) {
	            unset($page_query[$pagination['query_string_segment']]);
	        }
    	}
        $pagination['base_url'] = create_url('stat/playerlist', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('stat/playerlist', array(
        		'pagination' => $this->pagination->create_links(),
        		'servers' => $servers,
        		'data' => $data,
       			'search' => $search,
       			'opid' => $_admin['opid'],
        		'carrers' => array(
						1 => '御剑',
						2 => '逍遥',
						3 => '幻羽',
						4 => '法尊',
						5 => '破军',
						6 => '新手',
					),
        ));
    }
    
    /**
     * 
     * 等级分布
     */
    public function level(){
   		$this->load->config('pagination', true);
    	$pagination = $this->config->item('pagination');
    	$_admin = $this->session->userdata('_admin');
		$servers =  $this->server_model->get_union_servers($_admin['opid']);
		$total = 0;
		$data = array();
    	if($this->input->get()){
       		$page_query = $search = $this->input->get();
	       	$sparam = array();
	       	$sparam['server_id'] = $search['id'];
	       	$sparam['type'] = 'normal';
			$databaseinfo = $this->database_model->findByAttributes($sparam);
			unset($sparam);
			$this->game_model->setdb($databaseinfo);
			$data = $this->game_model->get_level_distribution($search);
			if($data){
				foreach ($data as $key => $val){
					$total += $val['level_cnts'];
				}
			}
       	}else{
       		$page_query = array();
       		$search['start_date'] = date('Y-m').'-01';
        	$search['end_date'] = date('Y-m-d');
        	$search['serverid'] = 0;
       	}
        $pagination['base_url'] = create_url('stat/level', $page_query);
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('stat/level', array(
        		'pagination' => $this->pagination->create_links(),
        		'servers' => $servers,
        		'data' => $data,
        		'total' => $total,
       			'search' => $search,
       			'opid' => $_admin['opid'],
        ));
    }
    
    /**
     * 
     * 职业分布
     */
    public function carror(){
    	$this->load->config('pagination', true);
    	$pagination = $this->config->item('pagination');
    	$_admin = $this->session->userdata('_admin');
		$servers =  $this->server_model->get_union_servers($_admin['opid']);
		$total = 0;
		$data = array();
    	if($this->input->get()){
       		$page_query = $search = $this->input->get();
	       	$sparam = array();
	       	$sparam['server_id'] = $search['id'];
	       	$sparam['type'] = 'normal';
			$databaseinfo = $this->database_model->findByAttributes($sparam);
			unset($sparam);
			$this->game_model->setdb($databaseinfo);
			$data = $this->game_model->get_level_professional($search);
			if($data){
				foreach ($data as $key => $val){
					$total += $val['cnts'];
				}
			}
       	}else{
       		$page_query = array();
       		$search['start_date'] = date('Y-m').'-01';
        	$search['end_date'] = date('Y-m-d');
        	$search['serverid'] = 0;
       	}
        $pagination['base_url'] = create_url('stat/carror', $page_query);
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('stat/carror', array(
        		'pagination' => $this->pagination->create_links(),
        		'servers' => $servers,
        		'data' => $data,
        		'total' => $total,
       			'search' => $search,
       			'opid' => $_admin['opid'],
        		'carrers' => array(
						1 => '御剑',
						2 => '逍遥',
						3 => '幻羽',
						4 => '法尊',
						5 => '破军',
						6 => '新手',
					),
        ));
    }
    
    /**
     * 
     * 充值排行
     */
    public function payrank()
    {
   		$this->load->config('pagination', true);
    	$pagination = $this->config->item('pagination');
    	$_admin = $this->session->userdata('_admin');
    	$servers =  $this->server_model->get_servers($_admin['opid']);
		$page_query = array();
		$total = 0;
		$data = array();
		$search = array();
    	if($this->input->get()){
       		$page_query = $search = $this->input->get();
	       $sparam = array();
	       	$sparam['server_id'] = $search['id'];
	       	foreach ($servers as $key => $val){
	       		if($val['id'] == $search['id']){
	       			$serverinfo = $val;
	       			if($val['status'] == 3){
	       				$sparam['server_id'] = $val['union_server'];
	       			}
	       			break;
	       		}
	       	}
	       	$sparam['type'] = 'normal';
			$databaseinfo = $this->database_model->findByAttributes($sparam);
			unset($sparam);
			$this->game_model->setdb($databaseinfo);
	        $server_id = substr($serverinfo['server_id'], 1);
	        $opparam['id'] = $_admin['opid'];
	        $opertorinfo = $this->operator_model->findByAttributes($opparam);
	        $prefix = $opertorinfo['prefix'] ? $opertorinfo['prefix'] : null;
			$total = $this->game_model->get_payrank_cnt($server_id, $prefix);
	        if($total > 0) {
	            $sortby = NULL;
	            $page = intval($this->input->get($pagination['query_string_segment']));
	            $page < 1 && $page = 1;
	            $pages = ceil($total / $pagination['per_page']);
	            $page > $pages && $page = $pages;
	            $data = $this->game_model->get_payrank($server_id, $prefix, $pagination['per_page'], ($page - 1)*$pagination['per_page'], $sortby);
	        }
    		if($prefix){
		        foreach ($data as $key => $val){
		        	$index = strpos($val['uid'], '_');
					$uid = substr($val['uid'], $index+1);
		        	$data[$key]['uid'] = $uid;
		        }
	        }
	        if(isset($page_query[$pagination['query_string_segment']])) {
	            unset($page_query[$pagination['query_string_segment']]);
	        }
    	}
        $pagination['base_url'] = create_url('stat/payrank', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('stat/payrank', array(
        		'pagination' => $this->pagination->create_links(),
        		'servers' => $servers,
        		'data' => $data,
       			'search' => $search,
       			'opid' => $_admin['opid'],
        ));
    }

    /**
     * 列表页面
     */
    public function lists()
    {
    	$this->load->config('pagination', true);
    	$_admin = $this->session->userdata('_admin');
    	$servers =  $this->server_model->get_servers($_admin['opid']);
        $pagination = $this->config->item('pagination');
        $param = array();
        $param['opid'] = $_admin['opid'];
       	if($this->input->get()){
       		$page_query = $search = $this->input->get();
       		if($search['id']){
       			foreach ($servers as $key => $val){
		       		if($val['id'] == $search['id']){
		       			$serverinfo = $val;
		       			break;
		       		}
		       	}
		       	$server_id = substr($serverinfo['server_id'], 1);
		        $param['serverid'] = $server_id;
       		}
       	}else{
       		$page_query = array();
       		$search['start_date'] = date('Y-m').'-01';
        	$search['end_date'] = date('Y-m-d');
        	$search['serverid'] = 0;
       	}
        if(isset($search['start_date']) && $search['start_date'] != '') {
            $param['stattime >='] = $search['start_date'];
        }
   	 	if(isset($search['end_date']) && $search['end_date'] != '') {
            $param['stattime <='] = $search['end_date'];
        }
        $allstattime = $this->stat_model->countAll($param);
        $total = count($allstattime);
        $data = array();
        if($total > 0) {
            $sortby = NULL;
            if(isset($search['sortby']) && in_array($search['sortby'], array_keys($this->stat_model->attributes()))) {
                $sortby = $search['sortby'];
                $sort_type = isset($search['asc']) && $search['asc'] ? 'ASC' : 'DESC';
                $sortby .= ' ' . $sort_type;
            }else{
            	$sortby = 'stattime DESC,serverid ASC';
            }
            $page = intval($this->input->get($pagination['query_string_segment']));
            $page < 1 && $page = 1;
            $pages = ceil($total / $pagination['per_page']);
            $page > $pages && $page = $pages;
            $data = $this->stat_model->sumAll($param, $pagination['per_page'], ($page - 1)*$pagination['per_page'], $sortby);
        }
        if(isset($page_query[$pagination['query_string_segment']])) {
            unset($page_query[$pagination['query_string_segment']]);
        }
        $pagination['base_url'] = create_url('stat/lists', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('stat/list', array(
                'pagination' => $this->pagination->create_links(),
                'data' => $data,
        		'servers' => $servers,
                'search' => $search,
                'column' => $this->stat_model->attributes(),
        		'opid' => $_admin['opid'],
        ));
    }
}
/* End of file stat.php */
/* Location: ./application/models/stat.php */