<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_seminar extends CI_Model {
    
    function check_jurusan_fakultas($jur_fakultas, $status_jur_fak = '') {
	$this->db->select('*');
	$this->db->where('nama_fakultas', $fakultas);
	if(!empty($status_fak)){
		$this->db->where('status_fakultas', $status_fak);
	}
	$query = $this->db->get('fakultas');
	if ($query->num_rows() > 0) {
	    return TRUE;
	}else{
	    return FALSE;
	}
    }
    
    public function InsertSeminar($tabelName,$data){
		$res = $this->db->insert($tabelName,$data);	
		return $res;    
    }

    function list_dataSeminar($limit, $start){
	    $this->db->select('s.*');
	    $this->db->from('seminar s');
        $this->db->limit($limit , $start);
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
        	return array() ;
        }
    }
    
    function detailJurusanFakultas($idJurusanFakultas){
	$this->db->where('id_jurusan_fakultas', $idJurusanFakultas); 
	$query = $this->db->get('jurusan_fakultas');
	if($query->num_rows() > 0){
		return $query->row();
	}else{
		return false ;
	}
    }
    
    public function UpdateJurusanFakultas($tabelName,$data,$where){
	$res = $this->db->update($tabelName,$data,$where);	
	return $res;			    
    }
    
    function deleteData($table,$key){
	$query = $this->db->delete($table,$key);
	if($query){
	    return true ;
	}else
	    return false ;
    }

	function getAllDataFakultas(){
		$this->db->select('id_fakultas, nama_fakultas');
		$this->db->where('status_fakultas', '1');
        $query = $this->db->get('fakultas');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function getAllDataJurusan($id_fakultas){
		$this->db->where('status_jurusan', '1');
		$this->db->where('id_fakultas', $id_fakultas);
        $query = $this->db->get('jurusan_fakultas');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function manual_ticket($seminar_id = '', $quantity = '', $input = ''){
		$last_voucher_num = $this->db->query("SELECT COUNT(*) AS coupon_num FROM `ticket_manual` WHERE id_seminar = '". $seminar_id ."'");
		$last_voucher = $last_voucher_num->row_array();
		
		$v_num = isset($last_voucher['coupon_num']) ? $last_voucher['coupon_num'] : 0;
		
		for ($i = 0; $i < $quantity; $i++)
		{
			
			$sequenz 			= str_pad($seminar_id,4,'0',STR_PAD_LEFT );
			$ticket_sequenz 	= str_pad($v_num,4,'0',STR_PAD_LEFT );
			
			$data_post = array(
				'serial' 		=> 'SEMINAR'. $sequenz . $ticket_sequenz,
				'secret' 		=> uniqid(),
				'id_seminar' 	=> $seminar_id,
				//'expire_time' 	=> strtotime($input['expired_date']),
				'consume' 		=> 0,
				'created_time' 	=> time(),
			);
			$this->db->insert('ticket_manual', $data_post);
			$v_num++;
		}
	}
	
}	

?>