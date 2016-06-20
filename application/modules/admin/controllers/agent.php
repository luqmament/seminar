<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agent extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->model('agent_model');
        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
        $this->load->library('file_excel');
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        if(empty($CMS_Session['username'])){
            redirect('admin/login');
        }
    }

    private function _check_login() {
        if ($this->admin_model->check_username() === FALSE) {
            redirect('admin/login');
        }
    }

    function index() {
        //$this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Agent');
        $this->stencil->js('custom/agent_list');
        $this->stencil->paint('agent_list', $data);
    }

    function input() {
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Input Agent');
        $this->stencil->paint('input_agent', $data);
    }

    function insert() {
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->form_validation->set_rules('name', 'Name', 'required|callback_check_agent_name');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_agent_email');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $this->load->model('agent_model');
        if($this->form_validation->run() == TRUE){
            $this->agent_model->do_insert($name, $email);
            $this->stencil->title('Agent');
            $this->stencil->js('custom/agent_list');
            $this->stencil->paint('agent_list', $data);
        }else{
            $this->stencil->title('Input Agent');
            $this->stencil->paint('input_agent', $data);            
        }
    }
    
    function get(){
        $id = $this->input->post('id');
        $get_detail['data'] = $this->general_model->getDetData('agent_table',array('id' => $id));
        echo json_encode($get_detail);
    }
    function agent_proses(){
        $agentName   =   $this->input->post('nameAgent');
        $emailAgent  =   $this->input->post('emailAgent');
        
        $checkAgentName     = $this->check_agent_name($agentName);
        $checkEmailAgent    = $this->check_agent_email($emailAgent);
        $messageAgentName   = '';
        $messageAgentEmail  = '';
        if(!$checkEmailAgent){
            $messageAgentEmail = 'Email terpakai' ;
        }
        if(!$checkAgentName){
            $messageAgentName   = 'Nama terpakai';
        }
        
        $alert = '' ;
        if($messageAgentEmail == '' && $messageAgentName == ''){
            $dataInsert = array(
                'name'      => $agentName,
                'email'     => $emailAgent,
                'status'    => 'approved'
            );
            
            $insertAgent    = $this->general_model->insertData('agent_table',$dataInsert);
            
            if($insertAgent){
                $alert = 'Agent Berhasil di tambahkan' ;
                $returnVal = 'success';
            }else{
                $alert = 'Agent Gagal di tambahkan' ;
                $returnVal = '';
            }
        }
        
        echo json_encode(array('alert' => $alert, 'messageEmail' => $messageAgentEmail, 'messageName' => $messageAgentName, 'returnVal' => $returnVal));
    }
    
    public function agent_Updateproses(){
        $id             = $this->input->post('id');
        $updateName     = $this->input->post('nameAgent');
        $updateEmail    = $this->input->post('emailAgent');
        
        $checkData      = $this->general_model->getDetData('agent_table',array('id' => $id));
        
        $checkAgentName     = $this->check_agent_name($updateName);
        $checkEmailAgent    = $this->check_agent_email($updateEmail);
        $messageAgentName   = '';
        $messageAgentEmail  = '';
        if(!$checkEmailAgent){
            $messageAgentEmail = 'Email terpakai' ;
        }
        if(!$checkAgentName){
            $messageAgentName   = 'Nama terpakai';
        }
        
        $alert = '' ;
        if($messageAgentEmail == '' && $messageAgentName == ''){
            $dataUpdate = array(
                'name'      => $updateName,
                'email'     => $updateEmail,
                'status'    => 'approved'
            );
            
            $updateAgent    = $this->general_model->updateData('agent_table',$dataUpdate,array('id' => $id));
            
            if($updateAgent){
                $alert = 'Agent Berhasil di Ubah' ;
                $returnVal = 'success';
            }else{
                $alert = 'Agent Gagal di Ubah' ;
                $returnVal = '';
            }
        }
        echo json_encode(array('alert' => $alert, 'messageEmail' => $messageAgentEmail, 'messageName' => $messageAgentName, 'returnVal' => $returnVal));
  
    }
    
    public function delete_agent(){
        $id = $this->input->post('id') ;
        
        $deleted = array(
            'status' => 'deleted'
        );
        
        $delete_agent = $this->general_model->updateData('agent_table',$deleted,array('id' => $id));
        
        if($delete_agent){
               $alert = 'Agent Berhasil di Hapus' ;
               $returnVal = 'success';
        }else{
            $alert = 'Agent Gagal di hapus' ;
            $returnVal = '';
        }
        echo json_encode(array('alert' => $alert, 'returnVal' => $returnVal));
    }
    
    
    private function check_agent_name($str) {
        $this->load->model('admin/agent_model');
        $this->form_validation->set_message('check_agent_name', 'The name is already used.');
        return $this->agent_model->check_agent_name($str);
    }

    private function check_agent_email($str) {
        $this->load->model('admin/agent_model');
        $this->form_validation->set_message('check_agent_email', 'The email is already used.');
        return $this->agent_model->check_agent_email($str);
    }

    function edit() {
        $session_data = $this->session->userdata('CMS_logged_in');
        $id = abs((int)$this->input->get('id'));
        $this->load->model('agent_model');
        $data['agent'] = $this->agent_model->get_agent_by_id($id);
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Edit Agent');
        $this->stencil->paint('edit_agent', $data);
    }

    function update() {
        $this->load->model('agent_model');
        $this->form_validation->set_rules('name', 'New Agent', 'required|callback_check_agent_name');
        $this->form_validation->set_rules('email', 'New MG User ID', 'required|callback_check_agent_email');
        $session_data = $this->session->userdata('CMS_logged_in');
        if ($this->form_validation->run() == TRUE) {
            $id = abs((int)$this->input->post('id'));
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $this->agent_model->do_update($id, $name, $email);
            $data['admin'] = $session_data['admin'];
            $this->stencil->title('Agent');
            $this->stencil->js('custom/agent_list');
            $this->stencil->paint('agent_list', $data);
        }else{
            $id = abs((int)$this->input->post('id'));
            $data['agent'] = $this->agent_model->get_agent_by_id($id);
            $data['admin'] = $session_data['admin'];
            $this->stencil->title('Edit Agent');
            $this->stencil->paint('edit_agent', $data);
        }
    }

    function delete() {
        $session_data = $this->session->userdata('CMS_logged_in');
        $id = abs((int)$this->input->get('id'));
        $this->load->model('agent_model');
        $this->agent_model->do_delete($id);
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Agent');
        $this->stencil->js('custom/agent_list');
        $this->stencil->paint('agent_list', $data);
    }

    function ajax_get_agent() {
        $this->datatables->select('id, kode_agent,name,phone,email');
        //$this->datatables->add_column('Actions', Actions('$1'), 'id');
        $this->datatables->unset_column('id');        
        $this->datatables->where('status', 'open');
        $this->datatables->from('agent_table');
        echo $this->datatables->generate();
    }
    
    function load_xml(){
        $doc = new DOMDocument();
        $doc->load('./assets/data_agent/agent-add.xml' );//xml file loading here
        $datas = $doc->getElementsByTagName( "Row" );
        
        $jmlh_insert[] = 0;
        $jmlh_NonInsert[] = 0;
        
        //looping data agent
        foreach( $datas as $key=>$data ){
        //Nama Agent
        $names = $data->getElementsByTagName( "Data" );
        $agent_name = $names->item(0)->nodeValue;        
        //Kode Agent
        $kodes = $data->getElementsByTagName( "Data" );
        $kode_agent = $kodes->item(1)->nodeValue;
        //PS code
        $PSkodes = $data->getElementsByTagName( "Data" );
        $PSkode_agent = $PSkodes->item(2)->nodeValue;
        //City
        $city = $data->getElementsByTagName( "Data" );
        $city = $city->item(3)->nodeValue;
        //Country
        $country = $data->getElementsByTagName( "Data" );
        $country = $country->item(4)->nodeValue;
        if(!empty($kode_agent)){
            $check_kodeAgent    = $this->agent_model->checkKodeAgent($kode_agent);
            if($check_kodeAgent){
                $dataInsert[] = array(
                    'name'          => $agent_name,
                    'kode_agent'    => $kode_agent,
                    'customer_code' => $PSkode_agent,
                    'city'          => $city,
                    'country'       => $country
                );
                //$insertAgent_table  = $this->general_model->insertData('agent_table',$dataInsert);
                $jmlh_insert[] = $key ;
            }else{
                $jmlh_NonInsert[] = $key ;
            }
        }
        
        }
        //echo '<pre>',print_r($dataInsert),'</pre>';
        
        echo json_encode(array('Insert' => (count($jmlh_insert)-1), 'Non Insert' => (count($jmlh_NonInsert)-1)));
    }
    public function agent_excel(){
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Agent file');
        //$this->stencil->js('custom/agent_file');
        $this->stencil->paint('agent_file', $data);
    }
    
    
    public function file_excel(){
        //echo '<pre>',print_r($_FILES),'</pre>';die();
        $folder_upload      = './assets/uploads/agent/';
        $check_file_exist   = $folder_upload.$_FILES['file']['name'];
        $url_path           = base_url().'assets/uploads/agent/';
        
        //Create Folder Jika tidak ada
        if (!is_dir($folder_upload)) {
            @mkdir($folder_upload, 0775);
        }
        
        //Check file jika pernah di upload 
        if(file_exists($check_file_exist)){
            $status     = "failed";
            $returnVal  = $_FILES['file']['name'].' '.'Sudah pernah di upload' ;
            $terdapatKodeAgentInsert = $tidakterdapatKodeAgent = 0;
        }else{
            
            $config['upload_path']      = $folder_upload;
            $config['allowed_types']    = 'xls|xlsx';
            $config['max_size']         = '50000';
            
            $this->upload->initialize($config);
            
            if(! $this->upload->do_upload('file')){
                $data['error'] = $this->upload->display_errors();
                die('Upload error : '.$data['error']); 
            }else{
                
                $data_file = array('upload_data' => $this->upload->data());
                //echo '<pre>',print_r($data_file),'</pre>';
                //exit;
            }
            //Insert to tbl_fileExcel_history
             $dataInsert     = array(
                'fileName'      => $data_file['upload_data']['full_path'],
                'file_type'     => $data_file['upload_data']['file_type'],
                'file_path'     => $data_file['upload_data']['file_path'],
                'full_path'     => $data_file['upload_data']['full_path'],
                'file_size'     => $data_file['upload_data']['file_size'],
                'date_create'   => date('Y-m-d H:i:s')
            ) ;
            
            $insert     = $this->general_model->insertData('tbl_fileExcel_history',$dataInsert);
            
            $folder_upload_excel  = $data_file['upload_data']['full_path'];
            
            
            try {
                $objPHPExcel = $this->file_excel->load($folder_upload_excel);
            }catch(Exception $e) {
                die('Error loading file "'.pathinfo($folder_upload_excel,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $arrayCount = count($allDataInSheet); // Here get total count of row in that Excel sheet
            $no = 1 ;
            
            $terdapatKodeAgentInsert = $tidakterdapatKodeAgent = 0;
            
            $agentKodes = array();
            for($i=3;$i<$arrayCount;$i++){
                $agentKodes[] = trim($allDataInSheet[$i]["B"]);
            }
            
            $rows = $this->db
                ->select('kode_agent')
                ->where_in('kode_agent',$agentKodes)
                ->get('agent_table')->result_array();
            $agentKodes = array();
            foreach($rows as $row){
                $agentKodes[] = $row['kode_agent'];
            }
            
            
            $rows = array();
            for($i=3;$i<$arrayCount;$i++){
                $agentName  = trim($allDataInSheet[$i]["A"]);
                $agentKode  = trim($allDataInSheet[$i]["B"]);
                $address    = trim($allDataInSheet[$i]["D"]);
                $telp       = trim($allDataInSheet[$i]["E"]);
                $email      = trim($allDataInSheet[$i]["F"]);
                $city       = trim($allDataInSheet[$i]["G"]);
                $country    = trim($allDataInSheet[$i]["H"]);
                                
                if(!empty($agentKode) && array_search($agentKode,$agentKodes) === FALSE){
                    $rows[]   = array(
                            'name'          => $agentName,
                            'kode_agent'    => $agentKode,
                            'address'       => $address,
                            'phone'         => $telp,
                            'email'         => $email,
                            'city'          => $city,
                            'country'       => $country                        
                        );
                    ++$terdapatKodeAgentInsert;
                }else{
                    ++$tidakterdapatKodeAgent;
                }
                $no++;                
            }
            if(!empty($rows)){
                $insert = $this->db->insert_batch('agent_table',$rows);
                if($insert){
                    $status     = "success" ;
                    $returnVal  = "Berhasil Ditambahkan" ;
                }
            }
            $status     = "pernah" ;
            $returnVal  = "Sudah Pernah Ditambahkan" ;
            unset($rows);
            
            
        }
        echo json_encode(array(
                'Insert'        => $terdapatKodeAgentInsert,
                'Non_Insert'    => $tidakterdapatKodeAgent,
                'status'         => $status,
                'returnVal'     => $returnVal
                
        ));
        exit;    
        
    }
    
    function not_Agents (){
        echo '<pre>',print_r($this->config->item('not_agents','agents'));
    }
}
