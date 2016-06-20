<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
    function __construct(){
	parent::__construct();
	
    }
    
    
    public function index(){
	   $this->frview('v_home',$data);
    }
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */