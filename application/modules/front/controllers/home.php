<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
    function __construct(){
		parent::__construct();
		$this->load->model(array('m_seminar'));
	
    }
    
    
    public function index(){

    	$data['seminar'] = $this->m_seminar->getDataKey('seminar', array('status_seminar' => 1), 'jadwal_seminar desc', 3);

	   	$this->frview('v_home',$data);
    }
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */