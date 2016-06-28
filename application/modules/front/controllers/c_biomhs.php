<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_biomhs extends MY_Controller {
    protected $sessionData;    
    function __construct(){
    parent::__construct();
    $this->load->model(array('m_register'));
    $this->sessionData = $this->session->userdata('CMS_mahasiswa');
        if(!$this->sessionData){
            redirect(base_url());
        }
        $this->arr_dimension = array();
        $this->arr_dimension['display']['width'] = 100;
        $this->arr_dimension['display']['height'] = 150;
    }
    public function index(){
        $data               = array();
	   	$this->frview('v_biomhs',$data);
    }


    public function update_mahasiswa(){

        $data['mahasiswa'] = $this->m_register->getDetailMahasiswa($this->sessionData['id_mahasiswa']);
        $data['fakultas']   = $this->m_register->getDataKey('fakultas', array('status_fakultas' => 1));
        $this->frview('v_update_data_mhs', $data);
    }

    function submit_update_mhs(){
        
        $data['mahasiswa'] = $this->m_register->getDetailMahasiswa($this->sessionData['id_mahasiswa']);
        $data['fakultas']   = $this->m_register->getDataKey('fakultas', array('status_fakultas' => 1));

        //Check jika terdapat captcha
        if(isset($_POST['g-recaptcha-response'])){
          $captcha = $_POST['g-recaptcha-response'];
        }

        //jika captcha tidak ke isi
        if(!$captcha){
            $this->session->set_flashdata('infoCaptchaRegMhs', 'Please check the the captcha form.');
            $this->frview('v_update_data_mhs',$data);
        }else{
            $secretKey = "6LflpSITAAAAAK3d3r4f5lWfywkzH8fgU-zr9SNu";
            $ip = $_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
            $responseKeys = json_decode($response,true);
            
            if(intval($responseKeys["success"]) !== 1) {
                $this->session->set_flashdata('infoCaptchaRegMhs', 'Please check the the captcha form.');
                $this->frview('v_update_data_mhs',$data);
            } else {
                //$this->form_validation->set_rules('namaDpn', 'First Name', 'required');
                //$this->form_validation->set_rules('NIMmhs', 'NIM', 'required');
                $this->form_validation->set_rules('emailmhs', 'Email', 'required|valid_email');
                //$this->form_validation->set_rules('NIMmhs', 'NIM', 'required');
                //$this->form_validation->set_rules('thn_masuk', 'Year', 'required');
                //$this->form_validation->set_rules('status_smt', 'Stat', 'required');
                //$this->form_validation->set_rules('fakultas', 'Fakultas', 'required');
                //$this->form_validation->set_rules('fakultas', 'Fakultas', 'required');        
                //$this->form_validation->set_rules('password', 'Password', 'required|matches[repassword]');
                //$this->form_validation->set_rules('repassword', 'Retype Password', 'required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->frview('v_update_data_mhs',$data);
                }
                else
                {
                    $post           = $this->input->post();
                    //check to NIM valid ; 
                    $checkNIM       = $this->m_register->checkNIM('mahasiswa', array('nim_mahasiswa' => $post['NIMmhs']));
                    if($checkNIM){
                        $this->session->set_flashdata('infoNIMinvalid', 'Maaf NIM tidak valid / sudah terpakai');
                        $this->frview('v_update_data_mhs',$data);
                    }else{
                        //insert to database ;                    
                        //$namaDpn        = trim($post['namaDpn']) ;
                        //$namaBlkg       = trim($post['namaBlkg']) ;
                        //$NIMmhs         = trim($post['NIMmhs']) ;
                        //$tipe_mahasiswa = trim($post['tipe_mahasiswa']) ;
                        $emailmhs       = trim($post['emailmhs']) ;
                        $alamat_mhs     = trim($post['alamat_mhs']) ;
                        $telp_mhs       = trim($post['telp_mhs']) ;
                        //$thn_masuk      = trim($post['thn_masuk']) ;
                        //$status_smt     = trim($post['status_smt']) ;
                        //$fakultas       = trim($post['fakultas']) ;
                        //$password       = trim(encryptPass($post['password'])) ;
                        $file_name      = base_url('/assets/uploads/mahasiswa/display/100/150/no-photo.png');
                        if(!empty($_FILES['photo_mhs']['name'])){
                            $filename  = $this->upload_image($_FILES['photo_mhs']);
                            $file_name = base_url('/assets/uploads/mahasiswa/display/100/150/'.$filename);
                        }

                        $dataUpdate = array(
                                
                                'email_mahasiswa'       => $emailmhs,
                                'alamat_mahasiswa'      => $alamat_mhs,
                                'telp_mahasiswa'        => $telp_mhs,
                                'photo_mahasiswa'       => $file_name,
                                'date_update'           => date('Y-m-d H:i:s')
                            );

                        //insert to table mahasiswa ;
                        $update_mhs     = $this->m_register->updateData('mahasiswa', $dataUpdate, array("id_mahasiswa" => $this->sessionData['id_mahasiswa']));
                        if($update_mhs){
                            $last_id                = $this->sessionData['id_mahasiswa'];
                            $getLastIdMhs           = $this->m_register->getDetailMahasiswa($last_id);
                            if($getLastIdMhs){
                                //buat session untuk masuk mahasiswa
                                $sessionMHS = array(
                                        'id_mahasiswa'          => $getLastIdMhs['id_mahasiswa'],
                                        'nama_depan'            => $getLastIdMhs['nama_depan'],
                                        'nama_belakang'         => $getLastIdMhs['nama_belakang'],
                                        'nim_mahasiswa'         => $getLastIdMhs['nim_mahasiswa'],
                                        'email_mahasiswa'       => $getLastIdMhs['email_mahasiswa'],
                                        'alamat_mahasiswa'      => $getLastIdMhs['alamat_mahasiswa'],
                                        'telp_mahasiswa'        => $getLastIdMhs['telp_mahasiswa'],
                                        'tahun_masuk'           => $getLastIdMhs['tahun_masuk'],
                                        'semester_mahasiswa'    => $getLastIdMhs['semester_mahasiswa'],
                                        'photo_mahasiswa'       => $getLastIdMhs['photo_mahasiswa'],
                                        'nama_fakultas'         => $getLastIdMhs['nama_fakultas']
                                    );
                                $this->session->set_userdata('CMS_mahasiswa', $sessionMHS);
                                redirect('mahasiswa-dashboard');
                            }else{
                                $this->session->set_flashdata('infoInsertFailed', 'Maaf register anda gagal , silahkan hubungi IT');
                                $this->frview('',$data);
                            }
                            
                        }else{
                            die('gagal');
                            $this->session->set_flashdata('infoInsertFailed', 'Maaf register anda gagal , silahkan hubungi IT');
                            $this->frview('v_update_data_mhs',$data);
                        }
                        
                    }

                    
                }
            }
        }
        
    }
     private function upload_image($image) {
        $data                   = array();
        $config['upload_path'] = FCPATH.'assets/uploads/mahasiswa';
        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0775);
        }
        
        $info = pathinfo($image['name']);
        
        $url_title = url_title($info['filename'], '_', TRUE);
        $file_name = generateRandomString(10) . '.' . $info['extension'];
        $config['file_name'] = $file_name;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);
        $upload = $this->upload->do_upload('photo_mhs');
        
        if (!$upload) {
            $invalid = $this->upload->display_errors();
            $this->session->set_flashdata('infoErrorsPhoto', $invalid);
            $this->frview('v_register_mhs',$data);
        } else {
            /* First size */
            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = FCPATH.'assets/uploads/mahasiswa/'.$file_name;
            $configSize1['create_thumb'] = false;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = $this->arr_dimension['display']['width'];
            $configSize1['height'] = $this->arr_dimension['display']['height'];

            $path1['display'] = FCPATH.'assets/uploads/mahasiswa/display';
            if (!is_dir($path1['display'])) {
                mkdir($path1['display'], 0775);
            }
            $path2['100'] = FCPATH.'assets/uploads/mahasiswa/display/' . $this->arr_dimension['display']['width'];
            if (!is_dir($path2['100'])) {
                mkdir($path2['100'], 0775);
            }
            $path3['150'] = FCPATH.'assets/uploads/mahasiswa/display/' . $this->arr_dimension['display']['width'] . '/' . $this->arr_dimension['display']['height'];
            if (!is_dir($path3['150'])) {
                mkdir($path3['150'], 0775);
            }

            $configSize1['new_image'] = FCPATH.'assets/uploads/mahasiswa/display/' . $this->arr_dimension['display']['width'] . '/' . $this->arr_dimension['display']['height'] . '/' . $file_name;
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();
            return $file_name; 
        }
        
    }
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */