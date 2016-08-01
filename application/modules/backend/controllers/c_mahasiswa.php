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
        /*$search 				= $this->input->get('search_mahasiswa');*/
        //echo $search;die();
        $session_searchMahasiswa = $this->session->userdata('pencarian_mahasiswa');
        if(isset($session_searchMahasiswa)){
        	$this->session->unset_userdata('pencarian_mahasiswa');
        }
        $data['listMahasiswa']   = array();
       /* if(isset($search)){
        	$config['base_url'] 	= site_url('backend/c_mahasiswa/index/search_mahasiswa='.$search);	
        }else{
        	$config['base_url'] 	= site_url('backend/c_mahasiswa/index');	
        }*/
        //$config['base_url'] 	= site_url('backend/c_mahasiswa/index');	

        // get search string
        //$search = ($this->input->post("search_mahasiswa"))? $this->input->post("search_mahasiswa") : "NIL";

        //$search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("backend/c_mahasiswa/index/");



        $config['total_rows'] 	= $this->m_mahasiswa->jumlah_dataMahasiswa($search);
        //echo $config['total_rows'];die();
        $config['per_page'] 	= "20";
        $config["uri_segment"] 	= 4;
        //$choice 				= $config["total_rows"] / $config["per_page"];
        //$config["num_links"] 	= floor($choice);
        $config["num_links"] 	= 10;
        
        //config for bootstrap pagination class integration
        $config['full_tag_open']	= '<ul class="pagination">';
        $config['full_tag_close']	= '</ul>';
        $config['first_link'] 		= FALSE;
        $config['last_link'] 		= FALSE;
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
		
        $data['listMahasiswa'] 	= $this->m_mahasiswa->list_dataMahasiswa($config["per_page"],$data['page'],$search);
        //echo $this->db->last_query();die();
		$data['pagination'] = $this->pagination->create_links();
		//echo '<pre>',print_r($data);die();
        $this->doview('list_mahasiswa_b', $data);
    }

function cari()
{
	$page 	= $this->uri->segment(4);
	//echo $page;die();
    $batas 	= 20;
	if(!$page):
	$offset = 0;
	else:
	$offset = $page;
	endif;

	$search_mahasiswa = "";
	$postkata = $this->input->post('search_mahasiswa');
	if(!empty($postkata))
	{
		$search_mahasiswa = $this->input->post('search_mahasiswa');
		$this->session->set_userdata('pencarian_mahasiswa', $search_mahasiswa);
	}
	else
	{
		$search_mahasiswa = $this->session->userdata('pencarian_mahasiswa');
	}
	//$data['listMahasiswa'] = $this->search_model->cari_dosen($batas,$offset,$data['nama']);
	$data['listMahasiswa'] = $this->m_mahasiswa->list_dataMahasiswa($batas,$offset,$search_mahasiswa);
	//$tot_hal = $this->search_model->tot_hal('ja_mst_dosen','nama_dosen',$data['nama']);

	$config['base_url'] = base_url() . 'backend/c_mahasiswa/cari/';
	$config['total_rows'] = $this->m_mahasiswa->jumlah_dataMahasiswa($search_mahasiswa);
	$config['per_page'] = $batas;
	$config['uri_segment'] = 4;


	//config for bootstrap pagination class integration
    $config['full_tag_open']	= '<ul class="pagination">';
    $config['full_tag_close']	= '</ul>';
    $config['first_link'] 		= FALSE;
    $config['last_link'] 		= FALSE;
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
		
	$data["pagination"] =$this->pagination->create_links();
	$this->doview('list_mahasiswa_b', $data);
       
    //$this->load->view('search/hasil',$data);
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

            
            $arrayCount = count($allDataInSheet); // Here get total count of row in that Excel sheet
            $no = 1 ;
            
            //$terdapatKodeAgentInsert = $tidakterdapatKodeAgent = 0;
            $terdapatNIMInsert = $tidakterdapatNIM = 0;
            
            //$agentKodes = array();
            $NIMS = array();
            for($i=2;$i<$arrayCount;$i++){
                //$agentKodes[] = trim($allDataInSheet[$i]["B"]);
                $NIMS[] = trim($allDataInSheet[$i]["B"]);
            }
            //echo '<pre>',print_r($NIMS);die();
            $rows = $this->db
                ->select('nim_mahasiswa')
                ->where_in('nim_mahasiswa',$NIMS)
                ->get('mahasiswa')->result_array();
            //$agentKodes = array();
            $NIMS = array();
            foreach($rows as $row){
                //$agentKodes[] = $row['kode_agent'];
                $NIMS[] = $row['nim_mahasiswa'];
            }
            
            
            $rows = array();
            for($i=2;$i<$arrayCount;$i++){
                $nama  		= trim($allDataInSheet[$i]["H"]);
                //echo trim($allDataInSheet[$i]["E"]);die();
                switch (trim($allDataInSheet[$i]["E"])) {
                	case "81":
                		$id_jur_fakultas  = 1 ;
                	break;
                	case "83":
                		$id_jur_fakultas  = 2;
                	break;
                }
                $id_jur_fakultas = $id_jur_fakultas;
                $nim_mahasiswa 	= trim($allDataInSheet[$i]["B"]);
                $email 			= trim($allDataInSheet[$i]["I"]);
                $alamat 		= trim($allDataInSheet[$i]["N"]);
                $telp 			= trim($allDataInSheet[$i]["O"]);
                $tipe_mhs 		= trim($allDataInSheet[$i]["K"]);
                $thn_masuk 		= trim($allDataInSheet[$i]["C"]);
                
                switch (trim($allDataInSheet[$i]["D"])) {
                	case "1":
                		$smt_mhs 	= 'ganjil';
                	break;
                	case "2":
                		$smt_mhs  	= 'genap';
                	break;
                }
                $smt_mhs = $smt_mhs ;
                $pass 		= encryptPass(trim($allDataInSheet[$i]["L"]));
                                
                if(!empty($nim_mahasiswa) && array_search($nim_mahasiswa,$NIMS) === FALSE){
                    $rows[]   = array(
                            'nim_mahasiswa' 	=> $nim_mahasiswa,
                            'nama_depan'    	=> $nama,
                            'email_mahasiswa'	=> $email,
                            'alamat_mahasiswa' 	=> $alamat,
                            'telp_mahasiswa'	=> $telp,
                            'tipe_mahasiswa'	=> $tipe_mhs,
                            'tahun_masuk'       => $thn_masuk,                        
                            'semester_mahasiswa'=> $smt_mhs,                        
                            'password_mahasiswa'=> $pass,                        
                            'id_jurusan_fak'	=> $id_jur_fakultas,                        
                            'status_mahasiswa'	=> 1,                        
                            'date_create'		=> date('Y-m-d H:i:s')                         
                        );
                    ++$terdapatNIMInsert;
                }else{
                    ++$tidakterdapatNIM;
                }
                $no++;                
            }
            //echo '<pre>',print_r($rows);die();
            if(!empty($rows)){
                $insert = $this->db->insert_batch('mahasiswa',$rows);
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
                'Insert'        => $terdapatNIMInsert,
                'Non_Insert'    => $tidakterdapatNIM,
                'status'         => $status,
                'returnVal'     => $returnVal
                
        ));
        
    }
}
?>
