<?php

class user_model extends CI_Model {

    function __construct() {
        
    }

    /* Menampilkan posting */
    function getUserDetail($kodeAgent,$UserName,$userEmail,$password){
        $this->db->select('ut.*, tm.tipe_member');
        $this->db->from('user_table ut');
        $this->db->join('tipe_member tm', 'ut.tipe_member= tm.id_member', 'left');
        $this->db->where('ut.email', $this->db->escape_str($userEmail));
        $this->db->where('ut.password', $this->db->escape_str($password));
	$this->db->where('ut.status !=', 2);

        if($kodeAgent != ""){
            $this->db->where('ut.kode_agent', $kodeAgent);
        }

        if($username != ""){
            $this->db->where('ut.mg_user_id', $this->db->escape_str($UserName));
        }
        $query = $this->db->get();
		
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    
    function do_login($username, $password) {
//        $query = $this->db->query('select * from user_table where user="'.$user.'" and password="'.md5($password).'"');
        $this->db->select('*');
        $this->db->where('email', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status', 'approved');
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $item) {
                $id = $item->id;
            }
            $sess_array = array('user' => $username, 'id' => $id, 'password' => $password, 'web' => 'MG');
            $this->session->set_userdata('logged_in', $sess_array);
        }
    }

    /*function check_user($email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where('status', 'approved');
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }*/
    function getDetailRekomend($email){
	$this->db->select('ut.id,ut.mg_user_id,ut.user_id,ut.kode_agent,ut.point,tm.point_member');
	$this->db->from('user_table ut');
	$this->db->join('tipe_member tm', 'ut.tipe_member = tm.id_member');
	$this->db->where('ut.email',$email);
	$get = $this->db->get();
	if ($get->num_rows() > 0) {
            return $get->row();
        } else {
            return FALSE;
        }
    }
    
    
    function check_To_password($id, $password) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('password',$password);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /*function check_password($email, $password) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $this->db->where('status', 'approved');
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }*/

    /*function check_username() {
        $session_data = $this->session->userdata('logged_in');
        $username = '';
        $password = '';
        $web = '';
        if ((isset($session_data['user'])) && (isset($session_data['password'])) && (isset($session_data['web']))) {
            $username = $session_data['user'];
            $password = $session_data['password'];
            $web = $session_data['web'];
        }
        $this->db->select('*');
        $this->db->where('email', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status', 'approved');
        $query = $this->db->get('user_table');
        if (($query->num_rows() > 0) && ($web == 'MG')) {
            return true;
        } else {
            return false;
        }
    }*/

    function check_mg_user($mg_user_id, $agent) {
        $this->db->select('*');
        $this->db->where('mg_user_id', $mg_user_id);
        $this->db->where('agent', $agent);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*function check_trans_user($trans_user_id) {
        $this->db->select('*');
        $this->db->where('user_id', $trans_user_id);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }*/

    /*function check_user_email_availability($email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where('status', 'approved');
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }*/

    function check_user_email($email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_new_agent($agent) {
        $this->db->select('*');
        $this->db->where('name', $agent);
        $query = $this->db->get('agent_table');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function check_new_mguserid($mguserid, $kode_agent) {
        $this->db->select('*');
        $this->db->where('kode_agent', $kode_agent);
        $this->db->where('mg_user_id', $mguserid);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_reg($mg_user_id, $kode_agent, $email) {
        $this->db->select('email');
        $this->db->where('mg_user_id', $mg_user_id);
        $this->db->where('kode_agent', $kode_agent);
        $query = $this->db->get('user_table');
        if ($query->num_rows() > 0) {
            return "MG User ID sudah ada";
        } else {
            $this->db->select('email');
            $this->db->where('email', $email);
            $query = $this->db->get('user_table');
            if ($query->num_rows() > 0) {
                return "email sudah terdaftar";
            } else {
                return "valid";
            }
        }
    }

    /*function id_token_generate($email) {
        $row = $this->get_user_by_email($email);
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $string = '';
        for ($i = 0; $i < 39 - strlen($row->id); $i++) {
            $pos = rand(0, strlen($karakter) - 1);
            $string .= $karakter{$pos};
        }
//        $date = date("Y-m-d H:i:s");
//        echo date("Ymd H:i:sa", strtotime($date))."</br>";
//        $d = strtotime("+6 Hours");
//        echo date("Ymd h:i:sa", strtotime("+6 Hours"));
//        exit;
        $data = array(
            'token' => $row->id . "-" . $string,
            'expired' => date("Y-m-d H:i:sa", strtotime("+6 Hours"))
        );
        $this->db->where('id', $row->id);
        $this->db->update('user_table', $data);
        $this->send_link_token_mail($row->id,$row->id . "-" . $string);
    }*/

    function do_reset_user_password($id,$password) {
        $data = array(
            'password' => md5($password),
            'token' => ''
        );
        $this->db->where('id', $row->id);
        $this->db->update('user_table', $data);
    }
    
    /*public function send_link_token_mail($id,$token) {
        $data['token']=$token;
        $data['id']=$id;
        $message = $this->load->view('email/user_token_mail',$data,true);
        $user = $this->user_model->get_user_by_id($id);
        $this->email->from('johankristian0@gmail.com');
        $this->email->to($user->email);
        $this->email->subject('Reset Password');
        $this->email->message($message);
        try {
            $this->email->send();
        } catch (Exception $exc) {
            //Email sent failed
        }
    }*/

    function get_user_by_email($email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get('user_table');
        return $query->row();
    }

    /*function do_reg($name, $address, $city, $phone, $id_number, $birthdate, $genre, $email, $mg_user_id, $password, $agent,$trans_user_id) {
        $data = array(
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'phone' => $phone,
            'id_number' => $id_number,
            'birthdate' => $birthdate,
            'genre' => $genre,
            'email' => $email,
            'mg_user_id' => $mg_user_id,
            'user_id' => $trans_user_id,
            'password' => md5($password),
            'status' => 'pending',
            'agent' => $agent
        );
        $this->db->insert('user_table', $data);
    }*/

    function get_user() {
        $this->db->select('*');
        $query = $this->db->get('user_table');
        return $query->result();
    }

    function get_user_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user_table');
        return $query->row();
        //return $query->result();
    }
    
    function get_userDetail($id) {
        $this->db->select('ut.*,at.id as id_agent, at.name as nama_agent, at.email as email_agent, tm.tipe_member as nama_tipe_member');
        $this->db->from('user_table ut');
        $this->db->join('agent_table at', 'ut.kode_agent= at.kode_agent', 'left');
        $this->db->join('tipe_member tm', 'ut.tipe_member= tm.id_member');
        $this->db->where('ut.id', $id);
        $query = $this->db->get();
        return $query->row();
        //return $query->result();
    }

    function get_agent_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('agent_table');
        return $query->row();
    }

    /*function do_request_gift($user_id, $gift_id) {
        $this->db->select('*');
        $this->db->where('id', $user_id);
        $query = $this->db->get('user_table');
        $point = $query->row()->point;
        $this->db->select('*');
        $this->db->where('id', $gift_id);
        $query = $this->db->get('gift_table');
        $gift_point = $query->row()->point;
        if ($point > $gift_point) {
            $point = $point - $gift_point;
            $data = array(
                'point' => $point
            );
            $this->db->where('id', $user_id);
            $this->db->update('user_table', $data);
            $data = array(
                'user_id' => $user_id,
                'gift_id' => $gift_id,
                'status' => 'pending'
            );
            $this->db->insert('history_user', $data);
            return 1;
        } else {
            return 0;
        }
    }*/

    public function count_gift($textsearch) {
        if ($textsearch != '') {
            $this->db->where("(name LIKE '%" . addslashes($textsearch) . "%' OR point LIKE '%" . addslashes($textsearch) . "%')", NULL);
        }
        $this->db->where('status', 'approved');
        return $this->db->get('gift_table');
    }

    function insert_change_agent_request($user_id, $old_agent, $new_agent, $old_mguserid, $new_mguserid, $date_request, $status) {
        $data = array(
            'user_id' => $user_id,
            'old_agent' => $old_agent,
            'new_agent' => $new_agent,
            'old_mguserid' => $old_mguserid,
            'new_mguserid' => $new_mguserid,
            'date_request' => $date_request,
            'status' => $status,
            'date_updated' => null
        );
        $this->db->insert('change_agent_table', $data);
    }

    function get_agent() {
        $this->db->select('*');
        $this->db->where('status', 'approved');
        $query = $this->db->get('agent_table');
        return $query->result();
    }

    function get_gift() {
        $this->db->select('*');
        $this->db->where('status', 'approved');
        $query = $this->db->get('gift_table');
        return $query->result();
    }

    public function get_approved_gift_pagination($num, $offset, $textsearch) {
        if ($textsearch != '') {
            $this->db->where("(name LIKE '%" . addslashes($textsearch) . "%' OR point LIKE '%" . addslashes($textsearch) . "%')", NULL);
        }
        $this->db->where('status', 'approved');
        $data = $this->db->get('gift_table', $num, $offset);
        return $data->result();
    }

    function get_gift_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('gift_table');
        return $query->row();
    }

    function list_agent($term) {
        $this->db->select('*');
        $this->db->like("name", $term);
        $this->db->order_by("name", "asc");
        //$this->db->where("status", "approved");
        $query = $this->db->get('agent_table');
        return $query->result();
    }
    
    
    //== Get LIst KOta ==//
    function list_kota($term) {
        $this->db->select('*');
        $this->db->like("kota_name", $term);
        $this->db->order_by("kota_name", "asc");
        //$this->db->where("status", "approved");
        $query = $this->db->get('mgf_kota');
        return $query->result();
    }
    function updateData($table,$data,$field_key)
    {
        $query = $this->db->update($table,$data,$field_key);
        if($query){
                return true ;
        }else
                return false ;
    }
    
    function getDetDataEmail($table, $newEmail, $oldEmail){
        $this->db->from($table);
        $this->db->where('email', $newEmail);
        $this->db->where('email !=', $oldEmail);
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
