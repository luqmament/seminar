<?php

class admin_model extends CI_Model {

    function __construct() {
        
    }

    /* Menampilkan posting */

    function do_login($username, $password) {
//        $query = $this->db->query('select * from user_table where user="'.$user.'" and password="'.md5($password).'"');
        $this->db->select('*');
        $this->db->where('username', $username);
        $this->db->where('password', encryptPass($password));
        $query = $this->db->get('admin_table');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $item) {
                $cms['id']          = $item->id;
                $cms['username']    = $item->username;
                $cms['web']         = 'CMS-MG' ;
            }
            //$sess_array = array('admin' => $username, 'id' => $id, 'password' => $password, 'web' => 'MG');
            $this->session->set_userdata('CMS_logged_in', $cms);
        }
    }
    
    function check_user($user) {
        $this->db->select('*');
        $this->db->where('username', $user);
        $query = $this->db->get('admin_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function check_password($user, $password) {
        $this->db->select('*');
        $this->db->where('username', $user);
        $this->db->where('password', encryptPass($password));
        $query = $this->db->get('admin_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function count_user_reg() {
        $this->db->select('*');
        $this->db->from('user_table ut');
        $this->db->join('agent_table at','ut.kode_agent = at.kode_agent');
        $this->db->where('ut.status', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function count_Reedem_Gift() {
        $this->db->select('hu.gift_id');
        $this->db->from('gift_table gt');
        $this->db->join('history_user hu', 'gt.id = hu.gift_id');
        $this->db->where('hu.status', 'pending');
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->num_rows();
        }else{
            return false;
        }
    }
    
    function count_Change_Agent(){
        $this->db->select('ca.id');
        $this->db->from('change_agent_table ca');
        $this->db->join('user_table ut', 'ca.user_id = ut.id');
        $this->db->join('agent_table ate', 'ca.old_agent = ate.kode_agent','left');
        $this->db->join('agent_table at2', 'ca.new_agent = at2.kode_agent','left');
        $this->db->where('ca.status', 'pending');
        $this->db->group_by('ca.id');
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->num_rows();
        }else{
            return false;
        }
    }

    //function check_username() {
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    $username = '';
    //    $password = '';
    //    $web = '';
    //    if ((isset($session_data['admin'])) && (isset($session_data['web']))) {
    //        $username = $session_data['admin'];
    //        $web = $session_data['web'];
    //    }
    //    $this->db->select('*');
    //    $this->db->where('username', $username);
    //    $this->db->where('password', md5($password));
    //    $query = $this->db->get('admin_table');
    //    if (($query->num_rows() > 0) && ($web == 'MG')) {
    //        return true;
    //    } else {
    //        return false;
    //    }
    //}

    function get_not_approved_user() {
        $this->db->select('*');
        $this->db->where('status', 'pending');
        $query = $this->db->get('user_table');
        return $query->result();
    }

    function do_approve($id) {
        $data = array(
            'status' => 'approved',
        );

        $this->db->where('id', $id);
        $this->db->update('user_table', $data);


        $this->email_model->user_approval($id);
    }

    function get_user_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('user_table');
        return $query->row();
    }

    function do_cancel_reg($id) {
        $data = array(
            'status' => 'rejected'
        );

        $this->db->where('id', $id);
        $this->db->update('user_table', $data);
    }

    function do_approve_gift_request($id) {
        $data = array(
            'status' => 'approved'
        );

        $this->db->where('id', $id);
        $this->db->update('history_user', $data);
    }

    function do_cancel_gift_request($id, $id_admin) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('history_user');
        $user_id = $query->row()->user_id;
        $gift_id = $query->row()->gift_id;

        $this->db->select('*');
        $this->db->where('id', $user_id);
        $query = $this->db->get('user_table');
        $point = $query->row()->point;

        $this->db->select('*');
        $this->db->where('id', $gift_id);
        $query = $this->db->get('gift_table');
        $gift_point = $query->row()->point;
        $point = $point + $gift_point;

        $data_user = array(
            'point' => $point
        );
        $this->db->where('id', $user_id);
        $this->db->update('user_table', $data_user);

        $dataReqGift = array(
            'status'        => 'deleted',
            'last_point'    => ($point - $gift_point),
            'in_point'      => $gift_point,
            'out_point'     => null,
            'current_point' => $point,
            'date_approve' => date('Y-m-d H:i:s'),
            'id_admin_approve' => $id_admin
        );

        $this->db->where('id', $id);
        $cancel_request = $this->db->update('history_user', $dataReqGift);
        
        if($cancel_request){
            return true ;
        }else{
            return false ;
        }
    }

    function do_approve_change_agent($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('change_agent_table');
        $user_id = $query->row()->user_id;
        $new_agent = $query->row()->new_agent;
        $new_mguserid = $query->row()->new_mguserid;

        $data = array(
            'kode_agent' => $new_agent,
            'mg_user_id' => $new_mguserid
        );
        $this->db->where('id', $user_id);
        $this->db->update('user_table', $data);

        $data = array(
            'status' => 'approved',
            'date_updated' => date("Y-m-d")
        );
        $this->db->where('id', $id);
        $query = $this->db->update('change_agent_table', $data);
        if($query){
            return true ;
        }else{
            return false ;
        }
    }

    function do_reject_change_agent($id) {
        $data = array(
            'status' => 'rejected',
            'date_updated' => date("Y-m-d")
        );
        $this->db->where('id', $id);
        $query = $this->db->update('change_agent_table', $data);
        if($query){
            return true ;
        }else{
            return false ;
        }
    }

    function do_update_user($id, $name, $address, $city, $phone, $id_number, $birthdate, $genre, $agent, $email, $mg_user_id) {
        $data = array(
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'phone' => $phone,
            'id_number' => $id_number,
            'birthdate' => $birthdate,
            'genre' => $genre,
            'agent' => $agent,
            'email' => $email,
            'mg_user_id' => $mg_user_id
        );
        $this->db->where('id', $id);
        $this->db->update('user_table', $data);
    }

    function do_delete_user($id) {
        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('id', $id);
        $this->db->update('user_table', $data);
    }

    function check_agent($agent) {
        $this->db->select('*');
        $this->db->where('name', $agent);
        $query = $this->db->get('agent_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function check_user_email($id, $email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_mg_user($id, $mg_user_id, $agent) {
        $this->db->select('*');
        $this->db->where('mg_user_id', $mg_user_id);
        $this->db->where('agent', $agent);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function getSelectDataUser($id){
        $this->db->select('ut.*,at.id as id_agent_name,at.name as agent_name, at.email as email_agent');
        $this->db->from('user_table ut');
        $this->db->join('agent_table at', 'ut.kode_agent = at.kode_agent');
        $this->db->where('ut.id', $id);
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
        return false;
        }
	
    }

    public function getDetailReqGift($id){
        $this->db->select('rgt.id as id_req_gift,ut.id as id_user,gt.id as id_gift,ut.user_id,ut.mg_user_id,ut.name as nama_user, ut.nama_bank, ut.no_rekening, ut.atas_nama_bank, gt.name as nama_gift, gt.pict_name, gt.type, gt.value, at.name as agent_name,rgt.date_create as tgl_klaim');
        $this->db->from('history_user rgt');
        $this->db->join('user_table ut', 'rgt.user_id = ut.id');
        $this->db->join('agent_table at', 'ut.kode_agent = at.kode_agent');
        $this->db->join('gift_table gt', 'rgt.gift_id = gt.id');
        $this->db->where('rgt.id', $id);
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
        return false;
        }
	
    }
    
    function getDetData($table,$id){
        $this->db->from($table);
        $this->db->where($id);
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }
    
    function getDetData_User($id)
    {
        $key    = array(
            'ut.status'     => 1
            ,'ut.id'         => $id
            //,'ut.user_date_approved >=' => '2015-08-01'
            //,'ut.user_date_approved <=' => '2015-08-15'
        );
        $this->db->select('ut.name, ut.email, ut.city, ut.area, ut.point, ut.kode_agent, at.name as agent_name, ut.mg_user_id, DATE_FORMAT(ut.user_date_create,"%d %M %Y") AS date_created, DATE_FORMAT(ut.user_date_approved,"%d %M %Y") AS date_approved, ut.sales_rekomend', FALSE);
        $this->db->from('user_table ut');
        $this->db->join('agent_table at', 'ut.kode_agent = at.kode_agent');
        $this->db->where($key);
        $this->db->order_by("ut.user_date_create", "asc");
        $query =  $this->db->get();
        
        if($query->num_rows() > 0){
            return $query->row();
        }else{
           return false;
        }
    }
    
    function get_area(){
	$this->db->order_by("name_area", "asc");
        $query = $this->db->get('mgf_area');
        return $query->result();
    }
}
