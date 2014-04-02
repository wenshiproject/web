<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Log控制器
 *
 */
class Log extends MY_Controller
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
     * Log 首页
     */
    public function index()
    {
        $this->helper->redirect(array('log/lists'));
    }

    public function lists()
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
			$param = array();
	   		$server_id = substr($serverinfo['server_id'], 1);
	    	if(isset($search['orderid']) && $search['orderid'] > 0){
	        	$order_id = $search['orderid'];
	        }
    		if(isset($search['account']) && $search['account'] > 0){
	        	$uid = $search['account'];
	        }
	        $opparam['id'] = $_admin['opid'];
	        $opertorinfo = $this->operator_model->findByAttributes($opparam);
	        $prefix = $opertorinfo['prefix'] ? $opertorinfo['prefix'] : null;
			$total = $this->game_model->get_pay_cnt($server_id, $order_id, $uid, $prefix);
	        if($total > 0) {
	            $page = intval($this->input->get($pagination['query_string_segment']));
	            $page < 1 && $page = 1;
	            $pages = ceil($total / $pagination['per_page']);
	            $page > $pages && $page = $pages;
	            $data = $this->game_model->get_pay_log($server_id, $order_id, $uid, $prefix, $pagination['per_page'], ($page - 1)*$pagination['per_page']);
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
        $pagination['base_url'] = create_url('log/lists', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('log/list', array(
        		'pagination' => $this->pagination->create_links(),
        		'servers' => $servers,
        		'data' => $data,
       			'search' => $search,
       			'opid' => $_admin['opid'],
        ));
    }

}