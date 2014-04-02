<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * GM控制器
 *
 */
class Gm extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('server_model');
        $this->load->model('operator_model');
        $this->load->model('database_model');
        $this->load->model('commondb_model');
        $this->load->model('game_model');
    }
    
    public function index()
    {
        $this->helper->redirect(array('gm/gmreply'));
    }

	/**
	 * 
	 * 神界MM
	 */
    public function gmreply(){
        $this->load->config('pagination', true);
    	$_admin = $this->session->userdata('_admin');
    	$servers =  $this->server_model->get_servers($_admin['opid']);
        $pagination = $this->config->item('pagination');
        $param = array();
        $search = array();
        $param['opid'] = $_admin['opid'];
       	if($this->input->get()){
       		$page_query = $search = $this->input->get();
       		
       	}else{
       		$page_query = array();
       	}
       	if(!isset($search['start_date'])){
       		$search['start_date'] = date('Y-m-d', strtotime('-1day'));
       	}
    	if(!isset($search['end_date'])){
       		$search['end_date'] = date('Y-m-d');
       	}
       	$opparam['id'] = $_admin['opid'];
	    $opertorinfo = $this->operator_model->findByAttributes($opparam);
	    $search['prefix'] = $opertorinfo['prefix'] ? $opertorinfo['prefix'] : null;
        $total = $this->commondb_model->get_chat_cnts($search);
        $data = array();
        if($total > 0) {
            $page = intval($this->input->get($pagination['query_string_segment']));
            $page < 1 && $page = 1;
            $pages = ceil($total / $pagination['per_page']);
            $page > $pages && $page = $pages;
            $data = $this->commondb_model->get_chat($search, $pagination['per_page'], ($page - 1)*$pagination['per_page']);
            if($search['prefix']){
	            foreach ($data as $key => $val){
	            	$index = strpos($val['sender_account'], '_');
					$uid = substr($val['sender_account'], $index+1);
			        $data[$key]['sender_account'] = $uid;
	            }
            }
        }
        if(isset($page_query[$pagination['query_string_segment']])) {
            unset($page_query[$pagination['query_string_segment']]);
        }
        $pagination['base_url'] = create_url('gm/gmreply', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $this->load->view('gm/gmreply', array(
                'pagination' => $this->pagination->create_links(),
                'data' => $data,
                'search' => $search,
        ));
    }
    
    /**
     * 
     * 神界MM聊天
     */
    public function chat(){
    	$this->load->config('pagination', true);
    	$pagination = $this->config->item('pagination');
    	$_admin = $this->session->userdata('_admin');
    	$search = $this->input->get();
    	$servers =  $this->server_model->get_union_servers($_admin['opid']);
		$unionservers = $this->server_model->get_servers($_admin['opid']);
		$config = array();
		foreach ($unionservers as $server){
			if($server['server_id'] == 's'.$search['serverid']){
				if($server['status'] == 3){
					foreach ($servers as $val){
						if($val['id'] == $server['union_server']){
//							var_dump($val);
							$config = $val;
							break;
						}
					}
				}else{
					$config = $server;
				}
				break;
			}
		}
//		var_dump($config);exit;
		if($config){
			$opparam['id'] = $_admin['opid'];
		    $opertorinfo = $this->operator_model->findByAttributes($opparam);
		    $prefix = $opertorinfo['prefix'] ? $opertorinfo['prefix'] : null;
			$sparam = array();
       		$sparam['server_id'] = $config['id'];
       		$sparam['type'] = 'normal';
			$databaseinfo = $this->database_model->findByAttributes($sparam);
			$this->game_model->setdb($databaseinfo);
			$userinfo = $this->game_model->get_player_by_id($search['id'], $prefix);
			if($userinfo){
				if(isset($search['op']) && $search['op'] == 'getmsg'){
					$rs = $this->commondb_model->get_chat_by_userid($prefix, $search['id'], 10);
					if($rs){
						echo json_encode(array('code'=>1,'msg'=>$rs));
						exit;
					}else{
						echo json_encode(array('code'=>1));
						exit;
					}
				}elseif(isset($search['op']) &&$search['op'] == 'sendmsg'){
					$content = $this->input->get('content');;
					$this->http->setUri($config);
					$rs = $this->http->gm_reply($search['id'], $content);
					if(strtolower($rs) == 'ok'){
						echo json_encode(array('code'=>1));
						exit;
					}else{
						echo json_encode(array('code'=>0));
						exit;
					}
				}else{
					$rs = $this->commondb_model->get_chat_by_userid($prefix, $search['id'], $search['serverid']);
					$this->load->library('pagination');
			        $this->pagination->initialize($pagination);
					if($prefix){
			            	$index = strpos($userinfo[0]['account'], '_');
							$uid = substr($userinfo[0]['account'], $index+1);
		            }
			        $this->load->view('gm/chat', array(
			                'pagination' => $this->pagination->create_links(),
			                'title' => '账号：'.$uid.'-'.$userinfo[0]['name'] . '-' . '[' .$config['server_id'] . ']' .$config['server_name'],
			                'search' => $search,
			                'rs' => $rs,
			        ));
				}
			}else{
				if($search['op']){
					echo json_encode(array('code'=>0));
					exit;
				}else{
					echo '<script>alert("error1");window.opener=null;window.open("","_self");window.close();</script>';
					exit;
				}
			}
		}else{
			if($search['op']){
				echo json_encode(array('code'=>0));
				exit;
			}else{
				echo '<script>alert("error2");window.opener=null;window.open("","_self");window.close();</script>';
				exit;
			}
		}
    }
}