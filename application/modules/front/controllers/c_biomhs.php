<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_biomhs extends MY_Controller {
    protected $sessionData;    
    function __construct(){
    parent::__construct();
    $this->sessionData = $this->session->userdata('CMS_mahasiswa');
        if(!$this->sessionData){
            redirect(base_url());
        }
    }
    public function index(){
        $data               = array();
	   	$this->frview('v_biomhs',$data);
    }


}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */