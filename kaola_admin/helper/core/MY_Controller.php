<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->helper(array('url', 'string', 'language', 'app'));
        $this->load->library('session');
        $this->load->library('twig', NULL, 'view');
        $this->load->library('MY_Helper', NULL, 'helper');
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */