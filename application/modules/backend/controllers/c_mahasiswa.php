<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_mahasiswa extends MY_Controller {
    protected $sessionData; 
    function __construct(){
	parent::__construct();
	$this->load->model(array('m_mahasiswa'));
	$this->load->library('file_excel');
	$this->sessionData = $this->session->userdata('CMS_logged_in');
	if(!$this->sessionData){
	//    if($this->uri->segment(1) == 'dashboard'){ 
	//	$this->result = true;
	//    }
	//    if($this->result){
	//	redirect('dashboard');
	//    }else{
	//	redirect('backend/c_login');
	//    }
	    redirect('backend/c_login');
	}
    }
	
    public function index(){
        //pagination settings
        $data['listMahasiswa']   = array();
        $config['base_url'] 	= site_url('backend/c_mahasiswa/index');
        $config['total_rows'] 	= $this->db->count_all('mahasiswa');
        $config['per_page'] 	= "10";
        $config["uri_segment"] 	= 4;
        $choice 				= $config["total_rows"] / $config["per_page"];
        $config["num_links"] 	= floor($choice);
        
        //config for bootstrap pagination class integration
        $config['full_tag_open']	= '<ul class="pagination">';
        $config['full_tag_close']	= '</ul>';
        $config['first_link'] 		= false;
        $config['last_link'] 		= false;
        $config['first_tag_open'] 	= '<li>';
        $config['first_tag_close'] 	= '</li>';
        $config['prev_link'] 		= '&laquo';
        $config['prev_tag_open'] 	= '<li class="prev">';
        $config['prev_tag_close'] 	= '</li>';
        $config['next_link'] 		= '&raquo';
        $config['next_tag_open'] 	= '<li>';
        $config['next_tag_close'] 	= '</li>';
        $config['last_tag_open'] 	= '<li>';
        $config['last_tag_close'] 	= '</li>';
        $config['cur_tag_open'] 	= '<li class="active"><a href="#">';
        $config['cur_tag_close'] 	= '</a></li>';
        $config['num_tag_open'] 	= '<li>';
        $config['num_tag_close'] 	= '</li>';
        
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        //call the model function to get the Mahasiswa data
		$data['start'] 			= $this->uri->segment(4, 0);
        $data['listMahasiswa'] 	= $this->m_mahasiswa->list_dataMahasiswa($config["per_page"],$data['page']);
        //echo $this->db->last_query();
		$data['pagination'] = $this->pagination->create_links();
		//echo '<pre>',print_r($data);die();
        $this->doview('list_mahasiswa_b', $data);
    }
            
    public function v_fakultas($id = ''){
        $data               	= array();
        $data['getDetail']  	= array();
		$data['type_form']	= 'add' ;
        if(!empty($id)){
            $detail	= $this->m_fakultas->detailFakultas($id);
            $data['getDetail']  = $detail ;
	    $data['type_form']	= 'edit' ;
        }
        $this->doview('v_fakultas', $data);
    
    }
    public function submit_fakultas(){
	$data   = array();
	$post 	= $this->input->post();
	$id 	= $post['id'];
	if(!isset($id)){
	    $this->form_validation->set_rules('nama_fakultas', 'Name', 'required');
	}else{
	    $this->form_validation->set_rules('nama_fakultas', 'Name', 'required');
	}
        
	
	if ($this->form_validation->run() == FALSE)
	{
	    if(!isset($id)){
			$this->doview('v_fakultas', $data);
	    }
	}
	else
	{
	    $nama_fakultas		= trim(strtoupper($post['nama_fakultas']));
	    $status_fakultas 	= $post['status_fakultas'];
	    
	    if(isset($id))
	    {
	    	$whereKondisi		= ($status_fakultas == 1) ? 1 : 2 ;
			$checkFakultas 		= $this->m_fakultas->check_fakultas($nama_fakultas, $whereKondisi);
			if($checkFakultas){
			    $this->session->set_flashdata('infoCheckFakultas', 'Maaf nama fakultas sudah di gunakan');
			    redirect('fakultas');
			    exit;
			}else{
			    $data = array(
			    'nama_fakultas'		=> $nama_fakultas,
			    'status_fakultas'	=> $status_fakultas,
				'date_update' 		=> date('Y-m-d H:i:s')	
			    );
			}		
	    }else{
			$checkFakultas 		= $this->m_fakultas->check_fakultas($nama_fakultas);
			if($checkFakultas){
			    $this->session->set_flashdata('infoCheckFakultas', 'Maaf nama fakultas sudah di gunakan');
			    redirect('fakultas');
			    exit;
			}else{
			    $data = array(
				'nama_fakultas'	=> $nama_fakultas,
				'date_create' 	=> date('Y-m-d H:i:s')
			    );	
			}			
	    }
	    if(isset($id)){
			$key = array('id_fakultas' => $id) ;
			$res = $this->m_fakultas->UpdateFakultas('fakultas',$data, $key);
	    }else{
			$res = $this->m_fakultas->InsertFakultas('fakultas',$data);
	    }
	    
	    if ($res){
			if(isset($id)){
				$this->session->set_flashdata('infoFakultas', 'Data Berhasil Di Ubah');
			}else{
				$this->session->set_flashdata('infoFakultas', 'Data Berhasil Di Tambah');
			}
			redirect('fakultas');			
	    } else{
			echo "<h2>INsert Data Gagal</h2>";            
	    }
	}
	
    }
    public function do_delete($id = ''){
	$id 	= $this->input->post('id');
	$data 	= array('status_fakultas'	=> 2);	
    $where 	= array ('id_fakultas' 		=> $id);
	
	$delete_user = $this->m_fakultas->UpdateFakultas('fakultas',$data, $where);
        if($delete_user){
            $alert = 'Data Berhasil Di Hapus';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
            
    }

    public function upg_mahasiswa(){
        //echo '<pre>',print_r($_FILES),'</pre>';die();
        $folder_upload      = './assets/uploads/mahasiswa/';
        $check_file_exist   = $folder_upload.$_FILES['file']['name'];
        $url_path           = base_url().'assets/uploads/mahasiswa/';
        
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
            $this->load->library('upload', $config);
            //$this->upload->initialize($config);
            
            if(! $this->upload->do_upload('file')){
                $data['error'] = $this->upload->display_errors();
                die('Upload error : '.$data['error']); 
            }else{
                
                $data_file = array('upload_data' => $this->upload->data());
                //echo '<pre>',print_r($data_file),'</pre>';die();
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
            
            //$insert     = $this->general_model->insertData('tbl_fileExcel_history',$dataInsert);
            
            $folder_upload_excel  = $data_file['upload_data']['full_path'];
            
            
            try {
                $objPHPExcel = $this->file_excel->load($folder_upload_excel);
            }catch(Exception $e) {
                die('Error loading file "'.pathinfo($folder_upload_excel,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            echo '<pre>',print_r($allDataInSheet);
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
}
?>
