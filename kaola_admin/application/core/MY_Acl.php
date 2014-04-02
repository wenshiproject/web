<?php
class MY_Acl
{
    private $url_model;//所访问的模块，如：music
    private $url_method;//所访问的方法，如：create
    private $url_param;//url所带参数 可能是 1 也可能是 id=1&name=test
    
    public function __construct()
    {
    	$this->CI = & get_instance();
        $url = $_SERVER['REQUEST_URI'];
        $arr = explode('/', $url);
        $parr = explode('?', $url);
        $arr = array_slice($arr, array_search('index.php', $arr) + 1, count($arr));
        $this->url_model = isset($arr[0]) ? $arr[0] : '';
        $this->url_method = isset($arr[1]) ? $arr[1] : 'index';
        $this->url_param = isset($parr[1]) ? $parr[1] : '';
    }
 
    function filter()
    {
    	$user = $_SESSION['_admin'];
        if (empty($user)) {
            $role_name = 'nologin';
        } else {
        	if($user['ismix'] == 0){
        		$role_name = 'mixture';
        	}else{
        		$role_name = 'special';
        	}
        }
        $this->CI->load->config('acl');
        $acl = $this->CI->config->item('acl');
        $role = $acl[$role_name];
        $acl_info = $this->CI->config->item('acl_info');
        if (array_key_exists($this->url_model, $role) && in_array($this->url_method, $role[$this->url_model])) {
            ;
        } else {//无权限，给出提示，跳转url
            redirect('login');
        }
    }
}
