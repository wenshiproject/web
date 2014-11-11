<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Common extends Controller{
	/**
	 * @var  View  page template
	 */
	public $template = 'admin';
	public $no_view_actions = array();
	
	/**
	 * content view, alias $this->template->content_view
	 * 
	 * @var View
	 */
	public $view = '';

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;
	
	/**
	 * 登陆的玩家信息
	 * 
	 * @var array
	 */
	private $_user = NULL;
	protected $server_id = NULL;
	protected $region_id = NULL;
	
	public function before()
	{
		if (self::isNeedView())
		{
			$content_view = $this->template.'/'.$this->request->controller().'/'.$this->request->action();
			if ($this->auto_render === TRUE)
			{
				if (Kohana::find_file('views',$this->template.'/'.$this->request->controller().'/template'))
				{
					// 如果控制器视图有自己的页面框架模板，则优先使用
					if($this->request->action() != 'exchange_gift' && $this->request->action() != 'exchange_rs' && $this->request->action() != 'login'){
						$this->template = View::factory($this->template.'/template');
					}else{
						$this->template = View::factory($this->template.'/'.$this->request->controller().'/template');
					}
				} else {
					//如果没有，这默认使用上一级的页面框架模板
					$this->template = View::factory($this->template.'/template');
				}
				$this->template->content_view = $this->view = View::factory($content_view);
				//服务器信息
				$this->template->ip_address = $this->get_ip_address();
				$this->template->title = '考拉运维管理后台';
				$this->template->styles = array();
				$this->template->scripts = array();
				$menus = Kohana::$config->load('common')->menu;
			}
			self::auth();
			$this->template->menu = $menus;
		}
		parent::before();
	}
	/**
	 *  带'_noview'后缀的action不需要视图文件
	 */
	private function isNeedView()
	{
		if (strpos($this->request->action(),'_noview') !==false) return false;
		if (in_array($this->request->action(), $this->no_view_actions)) return false;
		return true;
	}
	
	public function auth()
	{
		if ($this->request->uri() == 'admin/user/login') return;//不需要验证
		if($this->request->controller() == 'interface') return;
//		if ($this->request->controller() == '')return;
		$user = Auth_Admin::instance()->get_user();
		if($user = Auth_Admin::instance()->get_user())
		{
			if (self::isNeedView())
			{
				$this->template->controller = $this->request->controller();
				$this->template->action = $this->request->action();
			}
			$this->_user = $user;
			return;
		}
		$this->request->redirect('/admin/user/login');
	}
	
	
	/**
	 * 获取当前登陆用户信息
	 * @return array
	 */
	protected function get_current_user($key)
	{
		return $this->_user[$key];
	}
	
	public function after()
	{
		if ($this->auto_render === TRUE && self::isNeedView())
		{
			// Get the media route
			$media = Route::get('media');
			// Add styles
			$this->template->styles = array_merge(array(
				$media->uri(array('file' => 'admin/css/style.css'))  => 'screen',
				$media->uri(array('file' => 'admin/css/jqx.base.css'))  => 'screen',
			),$this->template->styles);

			// Add scripts
			$this->template->scripts = array_merge(array(
				$media->uri(array('file' => 'admin/js/jquery-1.7.2.min.js')),
				$media->uri(array('file' => 'admin/js/jqxcore.js')),
				$media->uri(array('file' => 'admin/js/jqxdata.js')),
				$media->uri(array('file' => 'admin/js/jqxchart.js')),
				$media->uri(array('file' => 'admin/js/jquery.validate.js')),
				$media->uri(array('file' => 'admin/js/jquery.metadata.js')),
				$media->uri(array('file' => 'admin/js/form.js'))
			),$this->template->scripts);

			$this->response->body($this->template->render());
		}

		return parent::after();
	}
	
	protected function add_script($file)
	{
		$media = Route::get('media');
		$this->template->scripts = array_merge(
			$this->template->scripts,
			array(
				$media->uri(array('file' => $file)),
			)
		);
		
	}
	
	protected function show_msg($msg='',$url='',$top=FALSE){
		header('Content-Type:text/html; charset=utf-8');
		echo "<script type='text/javascript'>";
		if($msg){
			echo sprintf("%salert('%s');",$top ? 'top.':'',$msg);
		}else{
			echo sprintf("%salert('提交成功');",$top ? 'top.' : '');
		}
		echo sprintf("window.%slocation.href='%s'",$top ? 'top.' : '', $url ? $url : Request::$initial->referrer());
		echo '</script>';
		exit();
	}
	protected function register_no_view_action($actions)
	{
		if (empty($actions)) return null;
		$this->no_view_actions = array_merge($this->no_view_actions,$actions);
	}
	
	/**
	 * 创建client
	 * */
	public function create_client($type = NULL){
		$client = array();
		if(empty($type) || $type == 'c_id'){
			$client['client_id'] = time().rand(10000, 99999).'0'; 
		}
		
		if(empty($type) || $type == 'c_secret'){
			$client['client_secret'] = md5(rand(10000, 99999)); 
		}
		if(empty($type) || $type == 's_secret'){
			$client['server_secret'] = md5(time().rand(10000, 99999).'0'); 
		}
		return $client;
	}

	/**
	 * 获取分页设置
	 * @param  $pageSize
	 * @param  $totalSize
	 * @param  $views
	 */
	protected function get_page_view($pageSize='10',$totalSize='50',$views='pagination/floating'){
		$config = array(
			'current_page' => array('source' => 'query_string', 'key' => 'page'),
			'total_items' => $totalSize,
			'items_per_page' => $pageSize,
			'view' => $views,
			'auto_hide' => TRUE,
			'first_page_in_url' => FALSE,
		);
		return Pagination::factory($config);
	}
	
	private function get_ip_address() {
		$ip = Common_Helper::get_client_ip();
		return Common_Helper::convertip($ip); 
	}
} // End Welcome
