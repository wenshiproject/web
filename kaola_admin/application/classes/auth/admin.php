<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 后台验证类
 */
class Auth_Admin{

	// Auth instances
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Auth_Api
	 */
	public static function instance()
	{
		if ( ! isset(self::$_instance))
		{
			// Load the configuration for this type
			$config = Kohana::$config->load('auth_admin');

			// Create a new session instance
			self::$_instance = new self($config);
			
		}

		return self::$_instance;
	}

	protected $_session;

	protected $_config;
	
	protected $game_config;

	/**
	 * Loads Session and configuration options.
	 *
	 * @return  void
	 */
	public function __construct($config = array())
	{
		// Save the config in the object
		$this->_config = $config;

		$this->_session = Session::instance($this->_config['session_type']);
		
	}

	public function password($username)
	{
		
	}

	public function check_password($password)
	{
		
	}

	/**
	 * Gets the currently logged in user from the session.
	 * Returns NULL if no user is currently logged in.
	 *
	 * @return  mixed
	 */
	public function get_user($default = NULL)
	{
		return $this->_session->get($this->_config['session_key'], $default);
	}

	/**
	 * 登陆逻辑
	 *
	 * @param   string   username to log in
	 * @param   string   password to check against
	 * @param   boolean  enable autologin
	 * @return  boolean
	 */
	public function login($user_name, $password, $remember = FALSE)
	{
		if (empty($password)) return FALSE;
		if (Common_Helper::hash("admin"."kaola") != Common_Helper::hash($user_name.$password)) return FALSE;
		$session = $user_name;
        return $this->complete_login($session);
	}

	/**
	 * Log out a user by removing the related session variables.
	 *
	 * @param   boolean  completely destroy the session
	 * @param   boolean  remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		if ($destroy === TRUE)
		{
			// Destroy the session completely
			$this->_session->destroy();
		}
		else
		{
			// Remove the user from the session
			$this->_session->delete($this->_config['session_key']);

			// Regenerate session_id
			$this->_session->regenerate();
		}

		// Double check
		return ! $this->logged_in();
	}

	/**
	 * Check if there is an active session. Optionally allows checking for a
	 * specific role.
	 *
	 * @param   string   role name
	 * @return  mixed
	 */
	public function logged_in($role = NULL)
	{
		return ($this->get_user() !== NULL);
	}

	/**
	 * Perform a hmac hash, using the configured method.
	 *
	 * @param   string  string to hash
	 * @return  string
	 */
//	public function hash($str)
//	{
//		if ( ! $this->_config['hash_key'])
//			throw new Kohana_Exception('A valid hash key must be set in your auth config.');
//
//		return hash_hmac($this->_config['hash_method'], $str, $this->_config['hash_key']);
//	}

	public function complete_login($user)
	{
		// Regenerate session_id 这里不重新生成sessionid,因为已使用access token作为 sessionid
		$this->_session->regenerate();
		
		// Store username in session
		$this->_session->set($this->_config['session_key'], $user);
		
		return TRUE;
	}

	public function set_yanz_session($yanz) {
		$this->_session->set('gamecenter_yanzema', $yanz);
	}
	
	public function get_yanz() {
		return $this->_session->get('gamecenter_yanzema');
	}
	
	public function set_region_id($id) {
		$user = $this->get_user();
		$user['last_region'] = $id;
		$this->_session->set($this->_config['session_key'], $user);
		$pairs['login_ip'] = Common_Helper::get_client_ip();
		$model = new Model_Admin_Admin_Adminmodel();
		$update_data['last_region'] = $user['last_region'];
		$model->update_admin_by_id($user['id'], $update_data);
	}
	
	public function get_region_id() {
		$user = $this->get_user();
		return $user['last_region'];
	}
	
	public function set_server_id($serverid){
		$user = $this->get_user();
		$user['last_server'] = $serverid;
		$this->_session->set($this->_config['session_key'], $user);
		$pairs['login_ip'] = Common_Helper::get_client_ip();
		$model = new Model_Admin_Admin_Adminmodel();
		$update_data['last_server'] = $user['last_server'];
		$model->update_admin_by_id($user['id'], $update_data);
	}
	
	public function get_server_id(){
		$user = $this->get_user();
		return $user['last_server'];
	}
	
	public function sid(){
		return $this->_session->id();
	}
} // End Auth
