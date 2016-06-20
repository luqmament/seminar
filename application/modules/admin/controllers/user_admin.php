<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_admin extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->library('upload');
        $this->load->library('excel');

        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        if(empty($CMS_Session['username'])){
            redirect('admin/login');
        }
        //echo '<pre>',print_r($CMS_Session),'</pre>';
        
    }
    
    private function _check_login() {
        if ($this->admin_model->check_username() === FALSE) {
            redirect('admin/login');
        }
    }
    public function index() {
        //$this->_check_login();

        $session_data = $this->session->userdata('CMS_logged_in');
        $data['reg_count'] = $this->admin_model->count_user_reg();
        $data['redeem_count'] = $this->admin_model->count_Reedem_Gift();
        $data['changeAgent_count'] = $this->admin_model->count_Change_Agent();
        $this->stencil->title('Dashboard');
        $this->stencil->paint('admin_dashboard', $data);
    }

    //public function login() {
    //    $this->stencil->layout('login');
    //    $this->stencil->title('Log In');
    //    $this->stencil->paint('login');
    //}

    //public function do_login() {
    //    $this->form_validation->set_rules('username', 'User ID', 'required|callback_check_user');
    //    $this->form_validation->set_rules('password', 'Password', 'required|callback_check_password');
    //    if ($this->form_validation->run() == TRUE) {
    //        $username = $this->input->post('username');
    //        $password = $this->input->post('password');
    //        $this->load->model('admin_model');
    //        $this->admin_model->do_login($username, $password);
    //        redirect('admin');
    //    } else {
    //        $this->stencil->layout('login');
    //        $this->stencil->title('Log In');
    //        $this->stencil->paint('login');
    //    }
    //}
    
    

    public function check_user($str) {
        $this->form_validation->set_message('check_user', 'Username is invalid.');
        if ($this->admin_model->check_user($str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_password($str) {
        $this->form_validation->set_message('check_password', 'Password is invalid.');
        $user = $this->input->post('username');
        if (($this->admin_model->check_user($user))&&($this->admin_model->check_password($user,$str))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout() {
        $this->session->unset_userdata('CMS_logged_in');
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    function approval_reg() {
        //$this->_check_login();

        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Registration Approval');
        $this->stencil->js('custom/approve_registration');
        $this->stencil->paint('approve_registration', $data);
    }

    function ajax_get_not_approved_user() {
        $this->datatables->select('ut.id, ut.kode_agent, at.name as agent_name, ut.mg_user_id, ut.email as email_user,user_date_create',FALSE)
        ->add_column('Actions', Actions('$1'), 'ut.id')
        ->edit_column('user_date_create', '$1', 'format_date(user_date_create)')
        ->unset_column('ut.id')	
        ->from('user_table AS ut')
        ->join('agent_table  AS at','ut.kode_agent = at.kode_agent')
        ->where('ut.status', '0');
        echo $this->datatables->generate();
    }
    
    function ajax_get_approved_user() {
        $this->datatables->select('ut.id, ut.name as name_user,ut.address,ut.city as kota,ut.kode_agent,at.name as agent_name,mg_user_id,ut.email,point,user_date_create,user_date_approved',FALSE)
        ->edit_column('user_date_approved', '$1', 'format_date(user_date_approved)')
        ->edit_column('user_date_create', '$1', 'format_date(user_date_create)')
        ->add_column('Actions', Actions('$1'), 'ut.id')	
        ->unset_column('ut.id')
        ->from('user_table AS ut')
        ->join('agent_table  AS at','ut.kode_agent = at.kode_agent', 'left')
        ->where('ut.status', '1');
        echo $this->datatables->generate();
    }

    function approve() {
        $this->_check_login();

        $session_data = $this->session->userdata('CMS_logged_in');
        $id = abs((int)$this->input->get('id'));
        $this->load->model('admin_model');
        $this->admin_model->do_approve($id);

        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Registration Approval');
        $this->stencil->js('custom/approve_registration');
        $this->stencil->paint('approve_registration', $data);
    }
    
    function aprrove_register(){
        //echo '<pre>',print_r($_POST),'</pre>';die();
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        $fieldkey['id']   = $this->input->post('id');
        $email            = $this->input->post('u_email');
        $mg_user_id       = $this->input->post('u_MG_user_ID');
        $data['status']   = 1 ;
        $data['user_date_approved'] = date('Y-m-d H:i:s');
        $data['approved_by'] = $CMS_Session['id'];
        
        $update_user = $this->general_model->updateData('user_table',$data,$fieldkey);
        if($update_user){
            $alert = 'Confirmation email send to member';		
            $returnVal = 'success';

            $this->email_approve_register($email, $mg_user_id); // to email, nama mg user
        }else{
            $alert = 'Aprrove User Gagal, silahkan hubungi IT';		
            $returnVal = '';
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    function cancel_register() {
        $fieldkey['id']   = $this->input->post('id');
        $data['status']   = 2 ;
        
        $delete_user = $this->general_model->updateData('user_table',$data,$fieldkey);
        if($delete_user){
            $alert = 'Register success to Cancel';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }
    
    function cancel_reg() {
        $this->_check_login();

        $session_data = $this->session->userdata('CMS_logged_in');
        $id = abs((int)$this->input->get('id'));
        $this->admin_model->do_cancel_reg($id);
        $data['admin'] = $session_data['admin'];
        $data['user'] = $this->admin_model->get_not_approved_user();
        $this->stencil->title('Registration Approval');
        $this->stencil->js('custom/approve_registration');
        $this->stencil->paint('approve_registration', $data);
    }

    function ajax_get_gift_request() {
        //$this->_check_login();

        //$this->load->library('Datatables');
        //$this->datatables->select('id,username,giftname,status');
        //$this->datatables->from('ajax_get_gift_request');
        //echo $this->datatables->generate();
        
        //history_user as rgt;
        //gift_table as gt;
        //user_table as ut;
        
        $this->datatables->select('hu.id as id_req_Gift, at.name as agent_name, DATE_FORMAT(hu.date_create, "%d %M %Y") as date_claim, ut.name as username,gt.name as giftname, gt.value, hu.status as status_req',FALSE)
        ->add_column('Actions', Actions('$1'), 'id_req_Gift')	
        //->edit_column('date_claim', '$1', 'date("d-m-Y", strtotime(date_claim))')
        ->unset_column('id_req_Gift')
        ->from('history_user AS hu')
        ->join('user_table  AS ut','hu.user_id = ut.id')
        ->join('gift_table  AS gt','gt.id = hu.gift_id')
        ->join('agent_table AS at','at.kode_agent = ut.kode_agent')
        ->where('hu.status', 'pending');
        echo $this->datatables->generate();
    }

    function approval_gift_request_list() {
        //$this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['username'];
        $this->stencil->title('Gift Request Approval');
        $this->stencil->js('custom/gift_approval_list');
        $this->stencil->paint('gift_approval_list', $data);
    }
    
    function getDetailReqGift(){
        $id     = $this->input->post('id');
        $get = $this->admin_model->getDetailReqGift($id);
        $data['id_gift']        = $get->id_gift;
        $data['id_req_gift']    = $get->id_req_gift;
        $data['id_user']        = $get->id_user;
        $data['mg_user_id']     = $get->mg_user_id;
        $data['agent_name']     = $get->agent_name;
        $data['nama_gift']      = $get->nama_gift;
        $data['pict_name']      = $get->pict_name;
        $data['type']           = $get->type;
        $data['value']          = $get->value;
        $tgl                    = new DateTime($get->tgl_klaim);
        $data['tgl_klaim']      = date_format($tgl, 'd M Y');
        echo json_encode(array('data' => $data));
    }
    
    //function approve_gift_request() {
    //    //$this->_check_login();
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    $id = abs((int)$this->input->get('id'));
    //    $this->load->model('admin_model');
    //    $this->admin_model->do_approve_gift_request($id);
    //    $data['admin'] = $session_data['admin'];
    //    $this->stencil->title('Gift Request Approval');
    //    $this->stencil->js('custom/gift_approval_list');
    //    $this->stencil->paint('gift_approval_list', $data);
    //}
    
    function approve_gift_request() {
        $checkSession   = $this->session->userdata('CMS_logged_in');        
        //$all_data       = $this->input->post('all_value');
        //$object         = json_decode($all_data);
        //echo '<pre>',print_r($object),'</pre>';die();
        $id_admin       = $checkSession['id'];
        $idReqGift      = $this->input->post('idReqGift');
        $idGift         = $this->input->post('idGift');
        $idUser         = $this->input->post('idUser');
        
        $dataUpdateRequest   = array(
            'status'            => 'approved',
            'date_approve'      => date('Y-m-d H:i:s'),
            'id_admin_approve'  => $id_admin,
        );
        
        $updateReqGift = $this->general_model->updateData('history_user',$dataUpdateRequest,array('id' => $idReqGift));
        
        if($updateReqGift){
            $getDetUser             = $this->admin_model->getDetData('user_table',array('id' => $idUser))  ;
            $getDetGift             = $this->admin_model->getDetData('gift_table',array('id' => $idGift))  ;
            $getDetReqGift          = $this->admin_model->getDetData('history_user',array('id' => $idReqGift))  ;
            
            $from_email 	    = 'enquiries@mgfriends.com';
            $from_name	            = 'MG Friends Team';
            $to_email               = $getDetUser->email;
            $subject_email          = 'MG Point Reward';
            //$remarks_user	    = $this->input->post('remarks_user');
            
            $from = array('email' => $from_email, 'name' => $from_name);
            $to = array($to_email);
            $to2 = array('sri.salsalita@mgholiday.com');
            $subject = $subject_email;
            //$date= date_create($this->input->post('DateTravelFrom'));
            $content_message        = '' ;
            switch($getDetGift->type){
                case '1' :
                    $content_message .= '<p><h4>Hi, '.$getDetUser->mg_user_id.'</h4></p>
                                        <p>Kita mau kasi kabar baik nih</p>
                                        <p>Verifikasi data untuk penukaran point kamu buat '.$getDetGift->name.' '.$getDetGift->value.' udah beres. Sekarang kita akan
                                        proses transfer '.$getDetGift->name.' '.$getDetGift->value.' ya.</p>
                                        <p>Kamu bisa cek akun bank kamu 14 hari kerja dari sekarang. Karena kita temen, prosesnya akan lebih
                                        cepet ditunggu ya.</p>
                                        <p>Ayo kumpulin lagi Point rewardnya supaya bisa dituker hadiah yang lain lagi.</p>
                                        <br/><br/><br/>
                                        <p><b>MG Friends Team</b></p>';
                break;
                case '2' :
                    $content_message .= '<p><h4>Hi, '.$getDetUser->mg_user_id.'</h4></p>
                                        <p>Kita mau kasi kabar baik nih</p>
                                        <p>Verifikasi data untuk penukaran point kamu buat '.$getDetGift->name.' udah beres. Sekarang kita akan 
                                        proses pengiriman hotel voucher ke email kamu. Emailnya akan dikirim 10 hari kerja dari sekarang. 
                                        Ditunggu ya…..</p>
                                        <p>Mau ingetin, kalo Voucher hotel berlaku 3 (tiga) bulan dari tanggal permintaan.
                                        Kalau kamu pingin menggunakan voucher hotelnya, bisa email Hotel Voucher dan detail pemesanan 
                                        ke redeem@mgfriends.com.</p>
                                        <p>Waktu mengirim, tolong kasi tenggang waktu 2 minggu sebelum tanggal check-in ya.</p>
                                        <p>Ayo kumpulin lagi Point rewardnya supaya bisa dituker hadiah yang lain lagi.</p>
                                        <br/><br/><br/>
                                        <p><b>MG Friends Team</b></p>';
                break;
                case '3' :
                    $content_message .= '<p><h4>Hi, '.$getDetUser->mg_user_id.'</h4></p>
                                        <p>Kita mau kasi kabar baik nih</p>
                                        <p>Verifikasi data untuk penukaran point kamu buat '.$getDetGift->name.' udah beres. Sekarang kita akan
                                        proses pengiriman Shopping voucher '.$getDetGift->name.' ke alamat kamu via Jasa Pengiriman Kurir. 
                                        Vouchernya akan dikirim 10 hari kerja dari sekarang. Ditunggu ya…..</p>
                                        <p>Mau ingetin untuk berhati-hati menyimpan shopping vouchernya, karena kalau *amit2* hilang, ga 
                                        ada gantinya. Happy shopping ya</p>
                                        <p>Ayo kumpulin lagi Point rewardnya supaya bisa dituker hadiah yang lain lagi.</p>
                                        <br/><br/><br/>
                                        <p><b>MG Friends Team</b></p>';
                break;
            }
            $message = '<html>
                    <head>
                        <title>ltm detail tours</title>
                    </head>			    
                    <body>
                        <h2 align="center">'.$getDetGift->name.'</h2>
                        <div style="width: 68%; margin: 0 16% 0 16%; padding: 20px;">
                            '.$content_message.'
                            <br><img src="'.base_url().'assets/rewards/images/logo-mg-friends-black-email.png" width="100px" />
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
                $returnVal	= "failed sent email";
            }else {
                // Show success notification or other things here
                $alert          = 'Data Request gift Succes to Approve';	
                $returnVal	= "success";
                $notif          = $this->email->print_debugger();
            }


            //email to admin bu iit
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

        }else{
            $alert = 'Gagal Mengupdate profile, silahkan hubungi IT';		
            $returnVal = '';
            $notif     = '' ;
        }        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal, 'notif' => $notif));
    }
    
    //function cancel_gift_request() {
    //    $this->_check_login();
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    $id = abs((int)$this->input->get('id'));
    //    $this->load->model('admin_model');
    //    $this->admin_model->do_cancel_gift_request($id);
    //    $data['admin'] = $session_data['admin'];
    //    $this->stencil->title('Gift Request Approval');
    //    $this->stencil->js('custom/gift_approval_list');
    //    $this->stencil->paint('gift_approval_list', $data);
    //}
    function cancel_gift_request() {
        
        $session_data = $this->session->userdata('CMS_logged_in');
        $id_reqGift =  $this->input->post('id');
        $id_admin   = $session_data['id'];
        $cancel_request_gift = $this->admin_model->do_cancel_gift_request($id_reqGift,$id_admin);
        if($cancel_request_gift){
            $alert = 'Data Request gift success to Cancel';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }

    function ajax_get_not_approved_change_agent() {
        // ut = user_table;
        // ca = change_agent_table;
        // at = change_agent_table;
        $this->datatables->select('ca.id, ut.name as name_user,ate.kode_agent as oldKodeAgent, ate.name as old_NameAgent,at2.kode_agent as newKodeAgent,at2.name as new_NameAgent,ut.mg_user_id as old_mg_UserID,ca.new_mguserid as new_mgUserID',FALSE)
        ->add_column('Actions', Actions('$1'), 'ca.id')	
        ->unset_column('ca.id')
        ->from('change_agent_table AS ca')
        ->join('user_table  AS ut','ca.user_id = ut.id')
        ->join('agent_table  AS ate','ca.old_agent = ate.kode_agent','left')
        ->join('agent_table  AS at2','ca.new_agent = at2.kode_agent','left')
        ->where('ca.status', 'pending')
        ->group_by('ca.id');
        echo $this->datatables->generate();
    }

    function approval_agent_list() {
        //$this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Change Agent Request Approval');
        $this->stencil->js('custom/agent_approval_list');
        $this->stencil->paint('agent_approval_list', $data);
    }

    function approved_user_list() {
        //$this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('User List');
        $this->stencil->js('custom/user_list');
        $this->stencil->paint('user_list', $data);
    }

    //function approve_change_agent() {
    //    //$this->_check_login();
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    $id = abs((int)$this->input->get('id'));
    //    $this->load->model('admin_model');
    //    $this->admin_model->do_approve_change_agent($id);
    //    $data['admin'] = $session_data['admin'];
    //    $this->stencil->title('Change Agent Request Approval');
    //    $this->stencil->js('custom/agent_approval_list');
    //    $this->stencil->paint('agent_approval_list', $data);
    //}
    //
    function approve_change_agent() {
        //$this->_check_login();
        $id     = $this->input->post('id');
        $update = $this->admin_model->do_approve_change_agent($id);
        if($update){
            $alert = 'Data Change Agent User success';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    //function reject_change_agent() {
    //    //$this->_check_login();
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    $id = abs((int)$this->input->get('id'));
    //    $this->load->model('admin_model');
    //    $this->admin_model->do_reject_change_agent($id);
    //    $data['admin'] = $session_data['admin'];
    //    $this->stencil->title('Change Agent Request Approval');
    //    $this->stencil->js('custom/agent_approval_list');
    //    $this->stencil->paint('agent_approval_list', $data);
    //}
    function reject_change_agent() {
        //$this->_check_login();
        $id     = $this->input->post('id');
        $rejected = $this->admin_model->do_reject_change_agent($id);
        if($rejected){
            $alert = 'Data Rejected Agent User success';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    function edit_user() {
        $this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $id = abs((int)$this->input->get('id'));
        $data['admin'] = $session_data['admin'];
        $data['user_data'] = $this->admin_model->get_user_by_id($id);
        $this->load->model('agent_model');
        $data['agent_data'] = $this->agent_model->get_agent_by_id($data['user_data']->agent);
        $this->stencil->title('Edit User Data');
        $this->stencil->js('custom/edit_user_data');
        $this->stencil->paint('edit_user_data', $data);
    }
    
    public function get(){	
	$id	= $this->input->post('id');
	if(empty($id)) {
		$alert = 'ID user hilang, silahkan hubungi IT.';
	}

	if(empty($alert)){
		$result = $this->admin_model->getSelectDataUser($id);
		//echo '<pre>',print_r($result),'</pre>';die();
		if($result){
                    foreach($result as $row){
                        
                        $details['id']		        = $row['id'];
                        $details['getArea']             = $this->admin_model->get_area();
                        $details['mg_user_id']		= $row['mg_user_id'];
                        $details['user_id']	        = $row['user_id'];
                        $details['name']		= $row['name'];
                        $details['address']	        = $row['address'];
                        $details['city']	        = $row['city'];
                        $details['area']	        = $row['area'];
                        $details['phone']	        = $row['phone'];
                        $details['kode_agent']	        = $row['kode_agent'];
                        $details['birthdate'] 		= $row['birthdate'];
                        $details['genre'] 		= $row['genre'];
                        $details['email'] 		= $row['email'];
                        $details['status'] 		= $row['status'];
                        $details['kode_agent'] 		= $row['kode_agent'];
                        $details['point'] 		= $row['point'];
                        $details['tipe_member']		= $row['tipe_member'];
                        $details['agent_name'] 		= $row['agent_name'];
                        $details['image_user']   	= $row['image_user'];
                        $details['profile_update'] 	= $row['profile_update'];
                    }
                    $alert = '';		
                    $returnVal = 'success';
		}else{
			$alert = 'Gagal mengambil data dari database, silahkan hubungi IT.';
		}				
	}
	
	echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal,'details'=>$details));
    }
    
    
    //function update_user() {
    //    $this->_check_login();
    //    $this->form_validation->set_rules('name', 'Name', 'required');
    //    $this->form_validation->set_rules('address', 'Address', 'required');
    //    $this->form_validation->set_rules('city', 'City', 'required');
    //    $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
    //    $this->form_validation->set_rules('id_number', 'ID Number', 'required');
    //    $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
    //    $this->form_validation->set_rules('genre', 'Gender', 'required');
    //    $this->form_validation->set_rules('agent', 'Agent', 'callback_check_agent_id');
    //    $this->form_validation->set_rules('agentname', 'Agent', 'required|callback_check_agent');
    //    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_user_email');
    //    $this->form_validation->set_rules('mg_user_id', 'MG User ID', 'required|callback_check_mg_user');
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    if ($this->form_validation->run() == TRUE) {
    //        $id = abs((int)$this->input->post('id'));
    //        $name = $this->input->post('name');
    //        $address = $this->input->post('address');
    //        $city = $this->input->post('city');
    //        $phone = $this->input->post('phone');
    //        $id_number = $this->input->post('id_number');
    //        $birthdate = date("Ymd", strtotime($this->input->post('birthdate')));
    //        $genre = $this->input->post('genre');
    //        $agent = $this->input->post('agent');
    //        $email = $this->input->post('email');
    //        $mg_user_id = $this->input->post('mg_user_id');
    //    
    //        $this->load->model('admin_model');
    //        $this->admin_model->do_update_user($id, $name, $address, $city, $phone, $id_number, $birthdate, $genre, $agent, $email, $mg_user_id);
    //        $data['admin'] = $session_data['admin'];
    //        $this->stencil->title('User List');
    //        $this->stencil->js('custom/user_list');
    //        $this->stencil->paint('user_list', $data);
    //    } else {
    //        $id = abs((int)$this->input->post('id'));
    //        $data['admin'] = $session_data['admin'];
    //        $data['user_data'] = $this->admin_model->get_user_by_id($id);
    //        $this->load->model('agent_model');
    //        $data['agent_data'] = $this->agent_model->get_agent_by_id($data['user_data']->agent);
    //        $this->stencil->title('Edit User Data');
    //        $this->stencil->js('custom/edit_user_data');
    //        $this->stencil->paint('edit_user_data', $data);
    //    }
    //}
    
    function update_user() {
        //echo '<pre>',print_r($_POST),'</pre>';die();
        $fieldkey['id']   = $this->input->post('id');
        $imageCheck = $_FILES['image_picture']['name'];
	$notif  = true;
        
        if(!empty($imageCheck)){
            $folder_upload = './assets/uploads/profile/';
            $url_path = base_url().'assets/uploads/profile/';
            if (!is_dir($folder_upload)) {
                    @mkdir($folder_upload, 0777);
            }
            
            $config['upload_path'] = $folder_upload;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            //$config['encrypt_name'] = TRUE;
            $new_name = 'profile_'.date('ymdhis');
            $config['file_name'] = $new_name;            
            $this->upload->initialize($config);
            $u_image = $this->upload->do_upload('image_picture');
            if(! $u_image){
                $error = $this->upload->display_errors();
                $notif = false ;
            }else{
                $image = array('profile_image' => $this->upload->data());
                $data['image_user'] = $url_path.$image['profile_image']['file_name'];
                //$notif['image_user'] = 
            }
            
        }
	
        if($notif){
            $data['name']       = $this->input->post('u_name');
            $data['address']    = $this->input->post('u_address');
            $data['city']       = $this->input->post('u_city');
            $data['area']       = $this->input->post('u_area');
            $data['phone']      = $this->input->post('u_phone');
            $data['kode_agent'] = $this->input->post('u_kodeAgent');
            $data['birthdate']  = $this->input->post('u_birthDate');
            $data['genre']      = $this->input->post('gender');
            $data['mg_user_id'] = $this->input->post('u_MG_user_ID');
            $data['tipe_member']= $this->input->post('u_TipeMember');
            $update_user = $this->general_model->updateData('user_table',$data,$fieldkey);
            if($update_user){
                $alert = 'Data profile success to change';		
                $returnVal = 'success';
            }else{
                $alert = 'Gagal Mengupdate profile, silahkan hubungi IT';		
                $returnVal = '';
            }
        }else{
            $alert = 'Data Image Salah';		
            $returnVal = '';
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }

    public function check_agent_id($str) {
        $this->form_validation->set_message('check_agent_id', 'Please select agent from the list.');
        if ($str == '') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_mg_user($str) {
        $agent = abs((int)$this->input->post('agent'));
        $id = abs((int)$this->input->post('id'));
        $this->form_validation->set_message('check_mg_user', 'The MG User ID is already used in agent.');
        return $this->admin_model->check_mg_user($id, $str, $agent);
    }

    public function check_user_email($str) {
        $id = abs((int)$this->input->post('id'));
        $this->form_validation->set_message('check_user_email', 'The email is already used.');
        return $this->admin_model->check_user_email($id, $str);
    }

    public function check_agent($str) {
        $this->form_validation->set_message('check_agent', 'Agent is not registered.');
        return $this->admin_model->check_agent($str);
    }

    function delete_user() {
        $this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $id = abs((int)$this->input->get('id'));
        $this->load->model('admin_model');
        $this->admin_model->do_delete_user($id);
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('User List');
        $this->stencil->js('custom/user_list');
        $this->stencil->paint('user_list', $data);
    }
    
    function del_user() {
        $fieldkey['id']   = $this->input->post('id');
        $data['status']   = 2 ;
        
        $delete_user = $this->general_model->updateData('user_table',$data,$fieldkey);
        if($delete_user){
            $alert = 'Data profile success to Delete';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }
    
    //=============== Management Tipe Member =============== //
    public function tipe_memberList(){
        $session_data   = $this->session->userdata('CMS_logged_in');
        $data['admin']  = $session_data['username'];
        $this->stencil->title('Tipe Member');
        $this->stencil->js('custom/tipe_member_list');
        $this->stencil->paint('tipe_memberList', $data);
    }
    
    function ajax_tipe_member() {
        $var = " RN";
        $this->datatables->select('id_member,tipe_member,minimal_RN,point_member',FALSE)
        ->add_column('Actions', ActionsToTipeMember('$1'), 'id_member')
        ->unset_column('id_member')
        ->edit_column('minimal_RN', '$1 $2', 'number_format(minimal_RN,0,",","."), RN')
        ->from('tipe_member');
        echo $this->datatables->generate();
    }
    
    function getListTipeMember(){
        $id     = $this->input->post('id');
        $get['data'] = $this->general_model->getDetData('tipe_member',array('id_member' => $id));
        echo json_encode($get);
    }
    function tipeMemberProses(){
        
        $id             = $this->input->post('id');
        $tipeMember     = $this->input->post('tipeMember');
        $minimalRN      = str_replace('.','',$this->input->post('minimalRN'));
        $pointMember    = $this->input->post('pointMember');
        
        $dataUpdate     = array(
            'tipe_member'   => strtoupper($tipeMember),
            'minimal_RN'    => $minimalRN,
            'point_member'  => $pointMember,
            'update_date'   => date('Y-m-d H:i:s')
            
        );
        
        $updateTipeMember  = $this->general_model->updateData('tipe_member',$dataUpdate,array('id_member' => $id));
        if($updateTipeMember){
            $alert = 'Data profile success to Change';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }

    public function email_approve_register($to_email, $name){

        $from_email             = 'enquiries@mgfriends.com';
        $from_name              = 'MG Friends Team';
        $subject_email          = 'Selamat Datang di MG Friends';
        
        $from = array('email' => $from_email, 'name' => $from_name);
        $to = array($to_email);
        $to2 = array('sri.salsalita@mgholiday.com');
        $subject = $subject_email;
        
        $message = '<html>
                <head>
                    <title>MG Friends</title>
                </head>             
                <body>
                    
                    <div style="width: 68%; margin: 0 16% 0 16%; padding:20px;">
                        <div>
                            <p>Hi '.$name.',</p>
                            <p>SELAMAT! Kamu sekarang sudah bisa mulai aktif mendapatkan reward otomatis dari setiap pemesanan hotel di mgholiday.com</p>
                            <p>Point reward yang kamu dapet setiap 1 malam adalah 1 point. Point reward ini gak akan hangus selama kamu masih kerja di travel agent yang terdaftar di MG Bedbank.</p>
                            <p>Kamu juga bisa melihat riwayat pemesanan kamu dan berapa point yang didapat di mgfriends.com dengan memasukan email dan kata sandi kamu. Point Reward ini, bisa ditukar hadiah langsung kapan aja kamu mau: ada CASH voucher, ada voucher belanja, ada kamar hotel harga miring juga.</p>
                            <p>Ga perlu malu2 kalau mau bertanya ya. Hubungi kita di (021) 3507 459 atau email ke <u>enquiries@mgfriends.com</u></p>
                            <p>Indahnya berbagi, ayo ajak temen kamu untuk bergabung juga ya biar kita makin banyak teman.</p>

                            <br><br><br><p><strong>MG Friends Team</strong></p>
                            <br><img src="'.base_url().'assets/rewards/images/logo-mg-friends-black-email.png" width="100px" />
                        </div>
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
    }
    
    //==Add Point to User Agent==//
    public function AddPointUser(){
        $agentCode  = $this->input->post('AgentCode');
        $MGuser_id  = $this->input->post('mg_user_id');
        $point      = $this->input->post('point');
        $getAdmin   = $this->session->userdata('CMS_logged_in');
        
        $fieldKey = array(
            'mg_user_id'    => $MGuser_id,
            'kode_agent'    => $agentCode,
            'status'        => 1
        );
        
        $check_availableUser = $this->admin_model->getDetData('user_table',$fieldKey);
        if($check_availableUser){
            $addPoint   = ($check_availableUser->point + $point);
            $updatePointUser = $this->general_model->updateData('user_table', array('point' => $addPoint), $fieldKey);
            if($updatePointUser){
                $dataInsertHistory = array(
                    'user_id'           => $check_availableUser->id,
                    'status'            => 'income',
                    'last_point'        => $check_availableUser->point,
                    'in_point'          => $point,
                    'current_point'     => $addPoint,
                    'date_create'       => date('Y-m-d H:i:s'),
                    'id_admin_approve'  => $getAdmin['id']
                );
                
                $insertHistory  = $this->general_model->insertData('history_user',$dataInsertHistory);
                if($insertHistory){
                    $alert = 'Data point berhasil ditambahkan';		
                    $returnVal = 'success';
                }else{
                    $alert = 'Gagal menghapus , silahkan hubungi IT';		
                    $returnVal = '';
                }
            }else{
                $alert = 'Gagal menghapus , silahkan hubungi IT';		
                $returnVal = '';
            }
        }else{
            $alert = 'Silahkan check kembali agent kode, dan MG user id nya, karena data tidak ada.';		
            $returnVal = '';
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }
}
