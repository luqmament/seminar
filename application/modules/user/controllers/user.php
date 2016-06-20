<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model(array('user_model','front/banner_model'));

        $this->stencil->layout('default');
        $this->stencil->slice('header');
        $this->stencil->slice('sidebar');
    }

    private function _check_login() {
        if ($this->user_model->check_username() === FALSE) {
            redirect('user/login');
        } 
    }
    
    public function index() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['user'] = $session_data['user'];
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);
        $this->stencil->title('Dashboard');
        $this->stencil->js('custom/user_dashboard');
        $this->stencil->paint('user_dashboard', $data);
    }

    public function login() {
        $this->stencil->layout('login');
        $this->stencil->title('Log In');
        $this->stencil->paint('login');
    }
    
    public function proses_login() {
        //$KodeAgent  = $this->input->post('KodeAgent');
        //$UserName   = $this->input->post('UserName');
        $UserEmail  = $this->input->post('UserEmail');
        $password   = encryptPass($this->input->post('password'));
        
        
        $result      = $this->user_model->getUserDetail('', '', $UserEmail, $password);
        if($result){				
            $returnVal = 'success';
            $aleirt = '';
            foreach($result as $row){
                $sessArray = array(
                    'id'            => $row->id,
                    'mg_user_id'    => $row->mg_user_id,
                    'user'          => $row->email,
                    'photo'         => $row->image_user,
                    'tipe_member'   => $row->tipe_member,
                    'status'        => $row->status,
                    'web'           => 'MG'
                );
                $this->session->set_userdata('logged_in', $sessArray);                    
            }
        }else{
                $alert = 'check kembali Email user atau password anda !!!';
                $returnVal = 'failed';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    
    
    public function do_login() {
        $this->form_validation->set_rules('username', 'User Email', 'required|callback_check_user');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_password');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->load->model('user_model');
            $this->user_model->do_login($username, $password);
            redirect('user');
        } else {
            $this->stencil->layout('login');
            $this->stencil->title('Log In');
            $this->stencil->paint('login');
        }
    }

    public function check_user($str) {
        $this->form_validation->set_message('check_user', 'User email is not approved or invalid.');
        if ($this->user_model->check_user($str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_password($str) {
        $this->form_validation->set_message('check_password', 'Password is invalid.');
        $email = $this->input->post('username');
        if (($this->user_model->check_user($email)) && ($this->user_model->check_password($email, $str))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function view_user_transaction_list() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['user'] = $session_data['user'];
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);
        $this->stencil->title('Transaction List');
        $this->stencil->js('custom/user_transaction_list');
        $this->stencil->paint('user_transaction_list', $data);
    }

    public function logout($id = '') {
        $checkProfile = $this->user_model->get_user_by_id($id);
        if($checkProfile){
            if($checkProfile->name == '' || $checkProfile->phone == '' || $checkProfile->area == '' || $checkProfile->birthdate == ''){
                $alert      = "Mohon lengkapi data profile anda";
                $returnVal  = "failed" ;
            }else{
                $this->session->unset_userdata('logged_in');
                $this->session->sess_destroy();
                $alert      = "";
                $returnVal  = "success" ;
            }
        }else{
            $alert      = "gagal logout, silahkan hubungi IT";
            $returnVal  = "failed" ;
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
//    public function logout(){
//	if(!$this->session->unset_userdata('logged_in')){			
//		if(!$this->session->sess_destroy()){
//			$this->returnVal = 'success';
//                        redirect();
//			//$this->m_general->userLog('Logout','Username => '.$this->sessionData['cms_user_name'],$this->sessionData['cms_user_id']);
//		}else{
//			$this->alert = 'Logout gagal, silahkan hubungi IT.';
//			//$this->m_general->errorLog('Logout','Aplikasi tidak bisa menghapus session | Username => '.$this->session->userdata('cms_logged_in')['cms_user_name'],$this->session->userdata('cms_logged_in')['cms_user_id']);
//		}
//	}else{
//		$this->alert = 'Logout gagal, silahkan hubungi IT.';
//		//$this->m_general->errorLog('Logout','Aplikasi tidak bisa melepaskan session | Username => '.$this->session->userdata('cms_logged_in')['cms_user_name'],$this->session->userdata('cms_logged_in')['cms_user_id']);
//	}
//	
//	//echo json_encode((object) array('alertType'=>$this->alertType,'alert'=>$this->alert,'returnVal'=>$this->returnVal));
//    }
    
    public function forgot(){
        $checkSession   = $this->session->userdata('logged_in');
        $date		= date('Y-m-d');
        if(empty($checkSession)){
            $data['banner']		= $this->banner_model->get_banner_slider($date , $date);
            $this->doview('front/lupa_pass', $data); 
        }
        else{
            redirect();
        }
    }
    
    public function reset_pass(){
        $getHashPassword        = MD5(date('Y-m-d H:i:s'));
        $getEmailUser           = $this->input->post('EmailForgotPass');
        
        $checkEmailValidity     = $this->general_model->getDetData('user_table',array('email' => $getEmailUser));
        
        if($checkEmailValidity){
            $dataInsert         = array(
                'email_resetPassword'   => $getEmailUser,
                'hash_resetPassword'    => $getHashPassword,
                'date_resetPassword'    => date('Y-m-d H:i:s'),
                'status_resetPassword'  => '0'
            );
            
            $insertResetPass        = $this->general_model->insertData('tbl_resetPassword',$dataInsert);
            
            $from_email             = 'enquiries@mgfriends.com';
            $from_name              = 'MG Friends Team';
            $subject_email          = 'Lupa Password MG Friends';
            
            $from                   = array('email' => $from_email, 'name' => $from_name);
            $to                     = array($getEmailUser);
            $subject                = $subject_email;
            
            $message = '<html>
                    <head>
                        <title>Reset Password</title>
                    </head>             
                    <body>
                        <div style="width: 68%; margin: 0 16% 0 16%; padding:20px">
                            <p>Hi '.$getEmailUser.',</p>
                            <P>Anda melakukan request reset password untuk mgfriends.com </p>
                            <br/>
                            <P>------------------------ </p>
                            <p>Silahkan klik link di bawah ini untuk melanjutkan proses reset password </p>
                            <p><a href="'.base_url().'user/resetPassUser?Hash='.$getHashPassword.'" target="_BLANK">Reset Password</a> </p>
                            <p>Jika anda tidak melakuan request reset password, abaikan email ini. </p>
                            <br><br><br><p><strong>MG Friends Team</strong></p>
                            <br><img src="'.base_url().'assets/rewards/images/logo-mg-friends-email.png" width="100px" />
                        </div>
                    </body>
                    <html>';
             
            // Sometimes you have to set the new line character for better result
            $this->email->set_newline("\r\n");
            // Set email preferences
            $this->email->from($from['email'], $from['name']);
            $this->email->to($to);
             
            $this->email->subject($subject);
            $this->email->message($message);
            // Ready to send email and check whether the email was successfully sent
             
            if (!$this->email->send()) {
                // Raise error message
                show_error($this->email->print_debugger());
                $notif          = 'ada error email' ;
                $returnVal      = "failed sent email";
                $alert          = 'Password Gagal Direset';
            }else {
                // Show success notification or other things here
                $alert          = 'Reset password berhasil, Silahkan cek email anda dan mengklik link reset password';    
                $returnVal      = "success";
                $notif          = $this->email->print_debugger();
            }
        }else{
            $notif          = 'ada error email' ;
            $returnVal      = "failed sent email";
            $alert          = 'Email tidak terdaftar';
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    public function Confirm_reset_pass(){
        $hashPassword   = $this->input->post('hashPassword');
        $NewPassword    = encryptPass($this->input->post('EmailForgotPassNew'));
        
        $detailUser     = $this->general_model->getDetData('tbl_resetPassword',array('hash_resetPassword' => $hashPassword, 'status_resetPassword' => 0));
        if($detailUser){
            $UpdateNewPassword = $this->general_model->updateData('user_table',array('password' => $NewPassword),array('email' => $detailUser->email_resetPassword));
            $updateResetPassword = $this->general_model->updateData('tbl_resetPassword',array('status_resetPassword' => '1'),array('hash_resetPassword' => $detailUser->hash_resetPassword)); 
            $alert          = 'Password '.$detailUser->email_resetPassword.' Berhasil Direset, silahkan login menggunakan password yang baru';    
            $returnVal      = "success";
        }else{
            $alert          = 'Password '.$detailUser->email_resetPassword.'Gagal Direset, silahkan lakukan kembali';    
            $returnVal      = "failed";
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    public function resetPassUser(){
        $date		= date('Y-m-d');
        $getHash    = $this->input->get('Hash');
        $getDetail  = $this->general_model->getDetData('tbl_resetPassword',array('hash_resetPassword' => $getHash));
        if($getDetail->status_resetPassword == '1'){
            redirect('user/resetPassExpired');
        }
        $data['email']  = $getDetail->email_resetPassword;
        $data['banner']		= $this->banner_model->get_banner_slider($date , $date);
        $this->doview('front/lupa_pass',$data);
    }
    public function resetPassExpired(){
        $data['notif']  =   'Email Verifikasi kadaluarsa';
        $this->doview('front/lupa_pass',$data); 
    }
    
    
    public function proses_register() {
        
        $kode_agent         = $this->input->post('reg_KodeAgent');
        $MG_userID          = $this->input->post('reg_UserName');
        $telp               = $this->input->post('reg_Telp');
        $area               = $this->input->post('reg_Area');
        $email              = $this->input->post('reg_Email');
        $password           = encryptPass($this->input->post('reg_Password'));
        $tipe_member        = 1;
        
        $checkUserNameEmail = $this->user_model->check_reg($MG_userID, $kode_agent, $email);
        if($checkUserNameEmail == 'valid'){
            $checkBox       = $this->input->post('ck_refRegist') ;
            $salesRekomend  = NULL ;
            if(isset($checkBox)){
                $salesRekomend  = $this->input->post('list_sales') ;
                if(!empty($salesRekomend)){
                    $salesRekomend = $this->input->post('list_sales') ;
                }else{
                    $salesRekomend = $this->input->post('email_sales') ;                    
                }
            };
            $dataInsert = array(
                'kode_agent'    => strtoupper($kode_agent),
                'mg_user_id'    => strtolower($MG_userID),
                'phone'         => $telp,
                'area'          => $area,
                'email'         => strtolower($email),
                'password'      => $password,
                'tipe_member'   => $tipe_member,
                'user_date_create' => date('Y-m-d H:i:s'),
                'sales_rekomend' => $salesRekomend
                
            );
            $register_user = $this->general_model->insertData('user_table',$dataInsert);
            $id            = $this->db->insert_id();

            $get_user       = $this->general_model->getDetData('user_table',array('id' => $id));
            $result         = $this->user_model->getUserDetail($get_user->kode_agent, $get_user->mg_user_id, $get_user->email, $get_user->password);
            
            if($result){				
                $returnVal = 'success';
                $alert = '';
                foreach($result as $row){
                    $sessArray = array(
                        'id'            => $row->id,
                        'mg_user_id'    => $row->mg_user_id,
                        'user'          => $row->email,
                        'photo'         => $row->image_user,
                        'tipe_member'   => $row->tipe_member,
                        'web'           => 'MG'
                    );
                    $this->session->set_userdata('logged_in', $sessArray);  

                    $this->email_register($email, $MG_userID);                
                }
            }else{
                    $alert = 'Data gagal';
                    $returnVal = 'failed';
            }
        }else{
            $alert      = $checkUserNameEmail;
            $returnVal  = 'failed';
        }
        
        $getDataUser = $this->session->userdata('logged_in');
        $reg_user   = array(
            'MG_user_id' => $getDataUser['mg_user_id']
        );
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal,'UserData' => $reg_user));
    }
    
    public function check_user_email($str = '') {
        $email  = $this->input->post('email');
    
        //$this->form_validation->set_message('check_user_email', 'The email is already used.');
        $check_user = $this->user_model->check_user_email($email);
        if($check_user){
            $alert      = '';
            $returnVal  = 'success';
        }else{
            $alert      = 'Alamat email sudah terdaftar';
            $returnVal  = 'failed';
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }

    function check_mg_user($str) {
        $agent = $this->input->post('agent');
        $this->form_validation->set_message('check_mg_user', 'The MG User ID is already used in agent.');
        return $this->user_model->check_mg_user($str, $agent);
    }

    function check_trans_user($str) {        
        $this->form_validation->set_message('check_trans_user', 'The Transaction User ID is already used.');
        return $this->user_model->check_trans_user($str);
    }

    function ajax_get_gift() {
        $this->_check_login();
        $this->load->library('Datatables');
        $this->datatables->select('id,filename,name,point,status');
        $this->datatables->from('gift_table');
        $this->datatables->where('status', 'approved');
        echo $this->datatables->generate();
    }

    function ajax_get_pending_gift() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $this->load->library('Datatables');
        $this->datatables->select('id,gift,gift_name');
        $this->datatables->from('ajax_get_pending_gift');
        $this->datatables->where('user_id', $session_data['id']);
        $this->datatables->where('status', 'pending');
        echo $this->datatables->generate();
    }

    function gift_request_list() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['user'] = $session_data['user'];
        $data['id'] = $session_data['id'];
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);

        $textsearch = '';
        $textsearch = $this->input->get('textsearch');

        $this->load->library('pagination');
        $jml = $this->user_model->count_gift($textsearch);
        $config['base_url'] = base_url() . 'user/user/gift_request_list?textsearch=' . $textsearch;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $jml->num_rows();
        $config['per_page'] = '6';
        $config['first_page'] = 'First';
        $config['last_page'] = 'Last';
        $config['next_page'] = '&laquo;';
        $config['prev_page'] = '&raquo;';
        $page = $this->input->get('per_page');
        $this->pagination->initialize($config);
        $data['halaman'] = $this->pagination->create_links();
        $data['gift_data'] = $this->user_model->get_approved_gift_pagination($config['per_page'], $page, $textsearch);

        $this->stencil->title('Request Gift');
        $this->stencil->js('custom/request_gift_list');
        $this->stencil->paint('request_gift_list', $data);
    }

    function gift_redeem() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $gift_id = abs((int) $this->uri->segment(4));
        $user_id = $session_data['id'];
        $data['user'] = $session_data['user'];
        $data['id'] = $user_id;
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);
        $data['gift'] = $this->user_model->get_gift_by_id($gift_id);
        $this->stencil->title('Redeem Gift');
        $this->stencil->paint('redeem_gift', $data);
    }

    function gift_request() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $gift_id = abs((int) $this->uri->segment(4));
        $user_id = $session_data['id'];
        $this->load->model('user_model');
        $this->user_model->do_request_gift($user_id, $gift_id);
        $this->gift_request_list();
    }

    function request_change_agent() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['user'] = $session_data['user'];
        $id = $session_data['id'];
        $user = $this->user_model->get_user_by_id($id);
        $oldagent = $this->user_model->get_agent_by_id($user->agent);
        $data['oldagent'] = $user->agent;
        $data['oldagentname'] = $oldagent->name;
        $data['oldmg_user_id'] = $user->mg_user_id;
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);
        $this->stencil->title('Request Change Agent');
        $this->stencil->js('custom/change_agent_request');
        $this->stencil->paint('change_agent_request', $data);
    }

    function add_change_agent_request() {
        $this->_check_login();
        $this->form_validation->set_rules('newagent', 'New Agent', 'callback_check_new_agent_id');
        $this->form_validation->set_rules('newagentname', 'New Agent', 'required|callback_check_new_agent');
        $this->form_validation->set_rules('newmg_user_id', 'New MG User ID', 'required|callback_check_new_mguserid');
        $session_data = $this->session->userdata('logged_in');
        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $session_data['user'];
            $id = $session_data['id'];
            $this->load->model('user_model');
            $data['agent'] = $this->user_model->get_agent();
            $user = $this->user_model->get_user_by_id($id);
            $oldagent = $this->user_model->get_agent_by_id($user->agent);
            $data['oldagentname'] = $oldagent->name;
            $data['oldagent'] = $user->agent;
            $data['oldmg_user_id'] = $user->mg_user_id;
            $this->load->model('user_model');
            $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);
            $this->stencil->title('Request Change Agent');
            $this->stencil->js('custom/change_agent_request');
            $this->stencil->paint('change_agent_request', $data);
        } else {
            $user_id = $session_data['id'];
            $old_agent = $this->input->post('oldagent');
            $new_agent = $this->input->post('newagent');
            $old_mguserid = $this->input->post('oldmg_user_id');
            $new_mguserid = $this->input->post('newmg_user_id');
            $date_request = date("Y-m-d");
            $status = 'pending';
            $this->load->model('user_model');
            $this->user_model->insert_change_agent_request($user_id, $old_agent, $new_agent, $old_mguserid, $new_mguserid, $date_request, $status);
            $data['user'] = $session_data['user'];
            $this->load->model('user_model');
            $data['user_data'] = $this->user_model->get_user_by_id($session_data['id']);
            $this->stencil->title('Dashboard');
            $this->stencil->js('custom/user_dashboard');
            $this->stencil->paint('user_dashboard', $data);
        }
    }

    public function check_new_agent_id($str) {
        $this->form_validation->set_message('check_new_agent_id', 'Please select new agent from the list.');
        if ($str == '') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_new_agent($str) {
        $this->form_validation->set_message('check_new_agent', 'New agent is not registered.');
        return $this->user_model->check_new_agent($str);
    }

    public function check_new_mguserid($str) {
        $agent = $this->input->post('newagent');
        $this->form_validation->set_message('check_new_mguserid', 'New MG User ID is already used in agent.');
        return $this->user_model->check_new_mguserid($str, $agent);
    }

    //function ajax_get_user_transaction() {
    //    $this->_check_login();
    //    $session_data = $this->session->userdata('logged_in');
    //    $this->load->library('Datatables');
    //    $this->datatables->select('id,user_id,hotel,room,night,fromdate,todate,name');
    //    $this->datatables->from('ajax_get_user_transaction');
    //    $this->datatables->where('user_id', $session_data['id']);
    //    echo $this->datatables->generate();
    //}

    public function get_agent() {
        $term = $this->input->get('term');
        $data = $this->user_model->list_agent($term);
        foreach ($data as $item) {
            $array_data[] = array(
                "id" => $item->kode_agent,
                "label" => $item->name,
                "value" => $item->name
            );
        }
        echo(json_encode($array_data));
    }
    //== Get Kota ==//
    public function get_kota() {
        $term = $this->input->get('term');
        $data = $this->user_model->list_kota($term);
        foreach ($data as $item) {
            $array_data[] = array(
                "id" => $item->kota_id,
                "label" => $item->kota_name,
                "value" => $item->kota_name
            );
        }
        echo(json_encode($array_data));
    }

    public function email_register($to_email, $name){

        $from_email             = 'enquiries@mgfriends.com';
        $from_name              = 'MG Friends Team';
        $subject_email          = 'Registrasi MG Friends';
        
        $from = array('email' => $from_email, 'name' => $from_name);
        $to = array($to_email);
        $to2 = array('sri.salsalita@mgholiday.com');
        $subject = $subject_email;
        
        $message = '<html>
                <head>
                    <title>MG Friends</title>
                </head>             
                <body>
                    <div style="width: 68%; margin: 0 16% 0 16%; padding:20px">
                        <p>Hi '.$name.',</p>
                        <p>Terima kasih sudah tertarik untuk bergabung di MG Friends. Kita akan memproses permintaan kamu & menverifikasi Agent ID yang kamu hubungkan dengan akun MG Friends ini ya</p>
                        <br><br><br><p><strong>MG Friends Team</strong></p>
                        <br><img src="'.base_url().'assets/rewards/images/logo-mg-friends-email.png" width="100px" />
                    </div>
                </body>
                <html>';
         
        // Sometimes you have to set the new line character for better result
        $this->email->set_newline("\r\n");
        // Set email preferences
        $this->email->from($from['email'], $from['name']);
        $this->email->to($to);
         
        $this->email->subject($subject);
        $this->email->message($message);
        // Ready to send email and check whether the email was successfully sent
         
        if (!$this->email->send()) {
            // Raise error message
            show_error($this->email->print_debugger());
            $notif          = 'ada error email' ;
            $returnVal      = "failed sent email";
        }else {
            // Show success notification or other things here
            $alert          = 'Data Berhasil dikirim';    
            $returnVal      = "success";
            $notif          = $this->email->print_debugger();
        } 

        // email to admin bu iit
        $this->email->set_newline("\r\n");
        $this->email->from($from['email'], $from['name']);
        $this->email->to($to2);
         
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();

        // email to admin mgfriends
        $this->email->set_newline("\r\n");
        $this->email->from($from['email'], $from['name']);
        $this->email->to("admin@mgfriends.com");
         
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        
        // email to kami
        $this->email->set_newline("\r\n");
        $this->email->from($from['email'], $from['name']);
        $this->email->to('luqman.hakim@coderscolony.com');
         
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

}
