<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seminar extends MY_Controller {
    function __construct(){
		parent::__construct();
		$this->load->model(array('m_seminar'));
	
    }
    
    
    public function index(){

    	$data['seminar'] = $this->m_seminar->getDataKey('seminar', array('status_seminar' => 1), 'jadwal_seminar desc');

	   	$this->frview('v_allSeminar',$data);
    }

    public function submit_order(){

    	$id_seminar		= $this->input->post('id_seminar');
    	$id_mahasiswa	= $this->input->post('id_mhs');

    	$id_ticket = $this->m_seminar->getDataKey('ticket_manual', array('id_seminar' => $id_seminar, 'consume' => 0), 'id_ticket asc', 1);

    	if($id_ticket){
    		$data = array(
    				'id_seminar' 	=> $id_seminar,
    				'id_mahasiswa'	=> $id_mahasiswa,
    				'id_ticket' 	=> $id_ticket[0]['id_ticket'],
    				'create_date'	=> date("Y-m-d H:i:s")

    			);

	    	if($this->m_seminar->insertData("order", $data)){

	    		$this->m_seminar->updateData("ticket_manual", array("consume" => 1), array('id_ticket' => $id_ticket[0]['id_ticket']));
	    		echo json_encode(array('status' => 'success', 'location' => base_url(), $data));
	    	}
	    	
    	
    	}else{

    		echo json_encode(array('status' => 'error'));	

    	}
    	
    }
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */