<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_register extends CI_Model {
	function getDataKey($table, $where){
		$this->db->where($where);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function getDetailMahasiswa($where){
        $this->db->select('m.*, f.*');
        $this->db->from('mahasiswa m');
        $this->db->join('fakultas f', 'm.id_fakultas = f.id_fakultas');
        $this->db->where('m.id_mahasiswa', $where);
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
        	return false;
        }
    }



    function CheckNIM($table, $where){
		$this->db->where($where);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function insertData($table, $data){

    	$query = $this->db->insert($table, $data);

    	if($query){
            return true ;
        }else{
        	return false ;
        }

    }

    function do_login_mahasiswa($nim, $password) {
        $this->db->select('m.*, f.*');
        $this->db->from('mahasiswa m');
        $this->db->join('fakultas f', 'm.id_fakultas = f.id_fakultas');
        $this->db->where('m.nim_mahasiswa', $nim);
        $this->db->where('m.password_mahasiswa', encryptPass($password));
        $query =  $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return false;
        }
    }

    function check_nim($nim) {
        $this->db->select('*');
        $this->db->where('nim_mahasiswa', $nim);
        $query = $this->db->get('mahasiswa');
        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function check_password($nim, $password) {
        $this->db->select('*');
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->where('password_mahasiswa', encryptPass($password));
        $query = $this->db->get('mahasiswa');
        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
}	

?>