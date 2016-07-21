<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_seminar extends MY_Controller {
    protected $sessionData; 
    function __construct(){
	parent::__construct();
	$this->load->model(array('m_seminar'));
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

		$this->arr_dimension_poster = array();
        $this->arr_dimension_poster['display']['width'] = 250;
        $this->arr_dimension_poster['display']['height'] = 400;

        $this->arr_dimension_sertifikat = array();
        $this->arr_dimension_sertifikat['display']['width'] = 400;
        $this->arr_dimension_sertifikat['display']['height'] = 150;
    }
	
    public function index(){
        //pagination settings
        $data['listFakultas']   = array();
        $config['base_url'] 	= site_url('backend/c_seminar/index');
        $config['total_rows'] 	= $this->db->count_all('seminar');
        $config['per_page'] 	= "2";
        $config["uri_segment"] 	= 4;
        $choice 				= $config["total_rows"] / $config["per_page"];
        $config["num_links"] 	= floor($choice);
        //$config['use_page_numbers']  = TRUE;
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
        
        //call the model function to get the department data
		$data['start'] 			= $this->uri->segment(4, 0);
        $data['listSeminar'] 	= $this->m_seminar->list_dataSeminar($config["per_page"],$data['page']);
        foreach ($data['listSeminar'] as $key => $value) {
            $data['listSeminar'][$key]['list_peserta'] = $this->m_seminar->list_PesertaSeminar($value['id_seminar']);
        }
		$data['pagination'] = $this->pagination->create_links();
        $this->doview('list_seminar', $data);
    }
            
    public function v_seminar($id = ''){
        $data               	= array();
        $data['getDetail']  	= array();
        $data['listfakultas'] 	= $this->m_seminar->getAllDataFakultas();
        foreach ($data['listfakultas'] as $key => $value) {
        	$data['listfakultas'][$key]['listjurusan']	= $this->m_seminar->getAllDataJurusan($value['id_fakultas']);
        }
		$data['type_form']		= 'add' ;
        if(!empty($id)){
            $detail	= $this->m_jurusan_fak->detailJurusanFakultas($id);
            $data['getDetail']  = $detail ;
	    	$data['type_form']	= 'edit' ;
        }

        //echo '<pre>',print_r($data);
        $this->doview('v_seminar', $data);
    
    }
    public function listPeserta($id_seminar = ''){
        $data                   = array();
        $data['list_peserta'] = $this->m_seminar->list_PesertaSeminar($id_seminar);

        //echo '<pre>',print_r($data);die();
        $this->doview('list_PesertaSeminar', $data);
    
    }

    public function submit_seminar(){
	$data   = array();
	$data['listfakultas'] 	= $this->m_seminar->getAllDataFakultas();
    foreach ($data['listfakultas'] as $key => $value) {
    	$data['listfakultas'][$key]['listjurusan']	= $this->m_seminar->getAllDataJurusan($value['id_fakultas']);
    }
	$post 	= $this->input->post();
	//echo '<pre>',print_r($post);die();
	$id 	= $post['id'];
	if(!isset($id)){
	    $this->form_validation->set_rules('tema_seminar', 'Tema Fakultas', 'required');
	    $this->form_validation->set_rules('jadwal_seminar', 'Jadwal Seminar', 'required');
	    $this->form_validation->set_rules('pembicara_seminar', 'Pembicara Seminar', 'required');
	    $this->form_validation->set_rules('tempat_seminar', 'Tempat Seminar', 'required');
	    $this->form_validation->set_rules('kuota_seminar', 'Kuota Seminar', 'required');
	    $this->form_validation->set_rules('kelas_seminar', 'Kelas Seminar', 'required');
	    $this->form_validation->set_rules('semester_seminar', 'Semester Seminar', 'required');
	    //$this->form_validation->set_rules('nama_jurusan', 'Jurusan Seminar', 'required');
	    //$this->form_validation->set_rules('poster_seminar', 'Poster Seminar', 'required');
	    //$this->form_validation->set_rules('sertifikat_seminar', 'Poster Seminar', 'required');
	}else{
		$this->form_validation->set_rules('tema_seminar', 'Tema Fakultas', 'required');
	    $this->form_validation->set_rules('jadwal_seminar', 'Jadwal Seminar', 'required');
	    $this->form_validation->set_rules('pembicara_seminar', 'Pembicara Seminar', 'required');
	    $this->form_validation->set_rules('tempat_seminar', 'Tempat Seminar', 'required');
	    $this->form_validation->set_rules('kuota_seminar', 'Kuota Seminar', 'required');
	    $this->form_validation->set_rules('kelas_seminar', 'Kelas Seminar', 'required');
	    $this->form_validation->set_rules('semester_seminar', 'Semester Seminar', 'required');
	    //$this->form_validation->set_rules('nama_jurusan', 'Jurusan Seminar', 'required');
	    //$this->form_validation->set_rules('poster_seminar', 'Poster Seminar', 'required');
	    //$this->form_validation->set_rules('sertifikat_seminar', 'Poster Seminar', 'required');
	}
        
	
	if ($this->form_validation->run() == FALSE)
	{
	    if(!isset($id)){
			$this->doview('v_seminar', $data);
	    }
	}
	else
	{
	    $tema_seminar				= trim(strtoupper($post['tema_seminar']));
	    $jadwal_seminar				= $post['jadwal_seminar'];/*
	    $originalDate 				= $jadwal_seminar ;
		$newDate 					= date("Y-m-d H:i:s", strtotime($originalDate));
        $jadwal_seminar             = date_create($post['jadwal_seminar']);
        $jadwal_seminar             = date_format($jadwal_seminar,"Y-m-d H:i:s");*/
	    $pembicara_seminar			= trim(strtoupper($post['pembicara_seminar']));
	    $tempat_seminar				= trim(strtoupper($post['tempat_seminar']));
	    $kuota_seminar				= trim(strtoupper($post['kuota_seminar']));
	    $sisa_kuota					= trim(strtoupper($post['kuota_seminar']));
	    $untuk_kelas				= $post['kelas_seminar'];
		foreach ($untuk_kelas as $key => $value) {
	   		$untuk_kelas		.= $value.','; 
	   	}
	   	$untuk_kelas			= rtrim(trim($untuk_kelas,"Array"),",") ;
		
	    $semester_seminar			= $post['semester_seminar'];
	   	foreach ($semester_seminar as $key => $value) {
	   		$semester_seminar		.= $value.','; 
	   	}
        $arr_semester_seminar = explode(",", $semester_seminar);
	   	if (in_array('Arrayall', $arr_semester_seminar)) {
            $semester_seminar           = 'all' ;
        }else{
            $semester_seminar           = rtrim(trim($semester_seminar,"Array"),",") ;    
        }
        

	    /*$jurusan_seminar			= $post['nama_jurusan'];
	    foreach ($jurusan_seminar as $key => $value) {
	   		$jurusan_seminar		.= $value.','; 
	   	}
	   	$jurusan_seminar			= rtrim(trim($jurusan_seminar,"Array"),",") ;*/

	    //$poster_seminar				= $_FILES['poster_seminar'];
	    $poster_seminar      		= base_url('/assets/uploads/poster_seminar/display/250/400/no-photo.png');
        if(!empty($_FILES['poster_seminar']['name'])){
            $filename_poster  		= $this->upload_image_poster($_FILES['poster_seminar']);
            $poster_seminar 		= base_url('/assets/uploads/poster_seminar/display/250/400/'.$filename_poster);
        }


	    $sertifikat_seminar			= base_url('/assets/uploads/sertifikat_seminar/display/400/150/no-photo.png');
	    if(!empty($_FILES['sertifikat_seminar']['name'])){
            $filename_sertifikat  	= $this->upload_image_sertifikat($_FILES['sertifikat_seminar']);
            $sertifikat_seminar 	= base_url('/assets/uploads/sertifikat_seminar/display/400/150/'.$filename_sertifikat);
        }


	    if(isset($id))
	    {
	    	$whereKondisi			= ($status_jurusan_fakultas == 1) ? 1 : 2 ;
			$checkJurFakultas 		= $this->m_jurusan_fak->check_jurusan_fakultas($nama_jurusan_fak, $whereKondisi);
			if($checkJurFakultas){
			    $this->session->set_flashdata('infoCheckJurusanFakultas', 'Maaf nama jurusan fakultas sudah di gunakan');
			    redirect('jurusan-fak');
			    exit;
			}else{
			    $data = array(
			    'nama_jurusan'		=> $nama_jurusan_fak,
			    'id_fakultas'		=> $id_fakultas,
			    'status_jurusan'	=> $status_jurusan_fakultas,
				'date_update' 		=> date('Y-m-d H:i:s')	
			    );
			}		
	    }else{
			$data_seminar = array(
				'tema_seminar'			=> $tema_seminar,
			    'jadwal_seminar'		=> $jadwal_seminar,
				'pembicara_seminar' 	=> $pembicara_seminar,
				'tempat_seminar' 		=> $tempat_seminar,
				'kuota_seminar' 		=> $kuota_seminar,
				'sisa_kuota' 			=> $kuota_seminar,
				'untuk_kelas' 			=> $untuk_kelas,
				'semester_seminar' 		=> $semester_seminar,
				//'jurusan_seminar' 		=> $jurusan_seminar,
				'poster_seminar' 		=> $poster_seminar,
				'sertifikat_seminar' 	=> $sertifikat_seminar,
				'create_date_seminar' 	=> date('Y-m-d H:i:s')
		    );
            //echo '<pre>',print_r($data_seminar);die();
	    }
	    if(isset($id)){
			$key = array('id_jurusan_fakultas' => $id) ;
			$res = $this->m_jurusan_fak->UpdateJurusanFakultas('jurusan_fakultas',$data, $key);
	    }else{
			$res = $this->m_seminar->InsertSeminar('seminar',$data_seminar);
			$seminar_id = $this->db->insert_id();
			//echo $seminar_id;die();
			// Generate TIcket (Ticket manual)
            $this->m_seminar->manual_ticket($seminar_id, $kuota_seminar, $this->input->post());
	    }
	    
	    if ($res){
			if(isset($id)){
				$this->session->set_flashdata('infoSeminar', 'Data Berhasil Di Ubah');
			}else{
				$this->session->set_flashdata('infoSeminar', 'Data Berhasil Di Tambah');
			}
			redirect('seminar-admin');			
	    } else{
			echo "<h2>INsert Data Gagal</h2>";            
	    }
	}
	
    }
    public function do_delete($id = ''){
	$id 	= $this->input->post('id');
	$data 	= array('status_jurusan'	=> 2);	
    $where 	= array ('id_jurusan_fakultas' 		=> $id);
	
	$delete_jurusan_fakultas = $this->m_jurusan_fak->UpdateJurusanFakultas('jurusan_fakultas',$data, $where);
        if($delete_jurusan_fakultas){
            $alert = 'Data Berhasil Di Hapus';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal , silahkan hubungi IT';		
            $returnVal = '';
        }
        
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
            
    }


    private function upload_image_poster($image) {
        $data                   = array();
        $config['upload_path'] = FCPATH.'assets/uploads/poster_seminar';
        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path']);
        }
        
        $info = pathinfo($image['name']);
        
        $url_title = url_title($info['filename'], '_', TRUE);
        $file_name = generateRandomString(10) . '.' . $info['extension'];
        $config['file_name'] = $file_name;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);
        $upload = $this->upload->do_upload('poster_seminar');
        
        if (!$upload) {
            $invalid = $this->upload->display_errors();
            $this->session->set_flashdata('infoErrorsPhoto', $invalid);
            $this->frview('v_seminar',$data);
        } else {
            /* First size */
            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = FCPATH.'assets/uploads/poster_seminar/'.$file_name;
            $configSize1['create_thumb'] = false;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = $this->arr_dimension_poster['display']['width'];
            $configSize1['height'] = $this->arr_dimension_poster['display']['height'];

            $path1['display'] = FCPATH.'assets/uploads/poster_seminar/display';
            if (!is_dir($path1['display'])) {
                mkdir($path1['display'], 0775, true);
            }
            $path2['250'] = FCPATH.'assets/uploads/poster_seminar/display/' . $this->arr_dimension_poster['display']['width'];
            if (!is_dir($path2['250'])) {
                mkdir($path2['250'], 0775, true);
            }
            $path3['400'] = FCPATH.'assets/uploads/poster_seminar/display/' . $this->arr_dimension_poster['display']['width'] . '/' . $this->arr_dimension_poster['display']['height'];
            if (!is_dir($path3['400'])) {
                mkdir($path3['400'], 0775, true);
            }

            $configSize1['new_image'] = FCPATH.'assets/uploads/poster_seminar/display/' . $this->arr_dimension_poster['display']['width'] . '/' . $this->arr_dimension_poster['display']['height'] . '/' . $file_name;
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();
            return $file_name; 
        }
        
    }

    private function upload_image_sertifikat($image) {
        $data                   = array();
        $config['upload_path'] = FCPATH.'assets/uploads/sertifikat_seminar';
        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path']);
        }
        
        $info = pathinfo($image['name']);
        
        $url_title = url_title($info['filename'], '_', TRUE);
        $file_name = generateRandomString(10) . '.' . $info['extension'];
        $config['file_name'] = $file_name;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        //$this->load->library('upload', $config);
        $this->upload->initialize($config);
        $upload = $this->upload->do_upload('sertifikat_seminar');
        
        if (!$upload) {
            $invalid = $this->upload->display_errors();

            $this->session->set_flashdata('infoErrorsPhoto', $invalid);
            $this->frview('v_seminar',$data);
        } else {
            /* First size */
            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = FCPATH.'assets/uploads/sertifikat_seminar/'.$file_name;
            $configSize1['create_thumb'] = false;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = $this->arr_dimension_sertifikat['display']['width'];
            $configSize1['height'] = $this->arr_dimension_sertifikat['display']['height'];

            $path1['display'] = FCPATH.'assets/uploads/sertifikat_seminar/display';
            if (!is_dir($path1['display'])) {
                mkdir($path1['display'], 0775, true);
            }
            $path2['400'] = FCPATH.'assets/uploads/sertifikat_seminar/display/' . $this->arr_dimension_sertifikat['display']['width'];
            if (!is_dir($path2['400'])) {
                mkdir($path2['400'], 0775, true);
            }
            $path3['150'] = FCPATH.'assets/uploads/sertifikat_seminar/display/' . $this->arr_dimension_sertifikat['display']['width'] . '/' . $this->arr_dimension_sertifikat['display']['height'];
            if (!is_dir($path3['150'])) {
                mkdir($path3['150'], 0775, true);
            }

            $configSize1['new_image'] = FCPATH.'assets/uploads/sertifikat_seminar/display/' . $this->arr_dimension_sertifikat['display']['width'] . '/' . $this->arr_dimension_sertifikat['display']['height'] . '/' . $file_name;
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();
            return $file_name; 
        }
        
    }
    function change_kehadiran_peserta_seminar(){
        $id     = $this->input->post('id');
        $chk    = $this->input->post('chk');
        $status = "";

        switch ($chk) {
            case 1 :
                $this->general_model->updateData('order', array('used_sertifikat' => $chk), array('id_order' => $id));
                $status = "success";
            break;
            
            case 0 :
                $this->general_model->updateData('order', array('used_sertifikat' => $chk), array('id_order' => $id));
                $status = "failed";
            break;
        }
        echo json_encode(array('status' => $status));
        
    }

}
?>
