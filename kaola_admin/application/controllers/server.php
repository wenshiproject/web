<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Server控制器
 *
 */
class server extends MY_Controller
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
     * Server 首页
     */
    public function index()
    {
        $this->helper->redirect(array('server/online'));
    }
	
    /**
     * 
     * 实时在线
     */
    public function online(){
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
	       	foreach ($servers as $key => $val){
	       		if($val['id'] == $search['id']){
	       			$config = $val;
	       		}
	       	}
	       	$this->http->setUri($config);
	       	$ids  = $this->http->online();
	       	if($ids && $ids != '[]'){
	       		$ids = str_replace('[', '', $ids);
	       		$ids = str_replace(']', '', $ids);
		       	$sparam['server_id'] = $search['id'];
		       	$sparam['type'] = 'normal';
				$databaseinfo = $this->database_model->findByAttributes($sparam);
				unset($sparam);
				$this->game_model->setdb($databaseinfo);
				$param = array();
		        $opparam['id'] = $_admin['opid'];
		        $opertorinfo = $this->operator_model->findByAttributes($opparam);
		        $prefix = $opertorinfo['prefix'] ? $opertorinfo['prefix'] : null;
				$total = $this->game_model->get_player_ids_cnt($ids, $prefix);
		        if($total > 0) {
		            $page = intval($this->input->get($pagination['query_string_segment']));
		            $page < 1 && $page = 1;
		            $pages = ceil($total / $pagination['per_page']);
		            $page > $pages && $page = $pages;
		            $data = $this->game_model->get_player_ids($ids, $prefix, $pagination['per_page'], ($page - 1)*$pagination['per_page']);
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
    	}
        $pagination['base_url'] = create_url('server/online', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('server/online', array(
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

}