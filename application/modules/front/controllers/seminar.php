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
        //check ketentuan ticket

        $detail_seminar     = $this->m_seminar->getDetData('seminar',array('id_seminar' => $id_seminar));
        $detail_mahasiswa   = $this->m_seminar->getDetData('mahasiswa',array('id_mahasiswa' => $id_mahasiswa));



        $tahun_masuk    = $detail_mahasiswa->tahun_masuk ;
        $now            = date('Y');
        $bulan          = date('m');
        $intervalThn    = $now - $tahun_masuk + 1;

        if($detail_mahasiswa->semester_mahasiswa == 'ganjil'){
            if(($bulan - 2) <= 6){
                $intervalThn = ($intervalThn * 2 ) - 2;
            }else{
                $intervalThn = ($intervalThn * 2 ) - 1;
            }                                       
        }else{
            if(($bulan - 2) <= 6){
                $intervalThn = ($intervalThn * 2 ) - 2;
            }else{
                $intervalThn = ($intervalThn * 2 ) - 1;
            }
        }

        // check mahasiswa daftar seminar;
        $checkOrderSeminar = $this->m_seminar->getDetData('order', array('id_mahasiswa' => $id_mahasiswa, 'id_seminar' => $id_seminar));
        $arr_seminar = explode(",", $detail_seminar->semester_seminar);
        if($checkOrderSeminar){
            echo json_encode(array('status' => 'error', 'alert' => 'Maaf , anda pernah mengikuti seminar berikut'));
        }else{
            switch ($detail_mahasiswa->tipe_mahasiswa) {
                case 1 :
                    if (in_array($intervalThn, $arr_seminar)) {
                        $id_ticket = $this->m_seminar->getDataKey('ticket_manual', array('id_seminar' => $id_seminar, 'consume' => 0), 'id_ticket asc', 1);

                        if($id_ticket){
                            $data = array(
                                    'id_seminar'    => $id_seminar,
                                    'id_mahasiswa'  => $id_mahasiswa,
                                    'id_ticket'     => $id_ticket[0]['id_ticket'],
                                    'create_date'   => date("Y-m-d H:i:s")

                                );

                            if($this->m_seminar->insertData("order", $data)){

                                $this->m_seminar->updateData("ticket_manual", array("consume" => 1), array('id_ticket' => $id_ticket[0]['id_ticket']));
                                $this->m_seminar->updateData("seminar", array("sisa_kuota" => ($detail_seminar->sisa_kuota - 1)), array('id_seminar' => $id_seminar));
                                echo json_encode(array('status' => 'success', 'location' => base_url(), $data));
                            }
                            
                        
                        }else{

                            echo json_encode(array('status' => 'error', 'alert' => 'Maaf ada kesalahan, silahkan check ke bagian IT'));   

                        }
                    }else{
                        echo json_encode(array('status' => 'error', 'alert' => 'Maaf seminar untuk semester '.$detail_seminar->semester_seminar));   
                    }
                break;
                
                default:
                    echo json_encode(array('status' => 'error', 'alert' => 'Validate to paralel'));
                break;
            }
        }

            	
    	
    }
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */