<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gift extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->model('gift_model');

        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');

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

    function input() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Input Gift');
        $this->stencil->paint('input_gift', $data);
    }

    function submit(){
        $id             = $this->input->post('id');
        $type           = $this->input->post('type');
        $name           = $this->input->post('name');
        $value          = $this->input->post('value');
        $point          = $this->input->post('point');
        $description    = $this->input->post('description');
        $hImage         = $this->input->post('hImage');        
            
        $data = array(

            'type'          => $type,
            'name'          => $name,
            'value'         => $value,
            //'voucher'       => $voucher,
            'point'         => $point,
            'description'   => $description,
            'status_gift'   => '1'

        );

            //upload image
            $folder_upload  = './assets/uploads/gift/';
            $url_path = base_url().'assets/uploads/gift/';
            if (!is_dir($folder_upload)) {
                @mkdir($folder_upload, 0777);
            }
            
            $config['upload_path']      = $folder_upload;
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $new_name                   = 'gift_'.date('ymdhis');
            $config['file_name']        = $new_name;            
            $this->upload->initialize($config);
            //$file_image     =  $this->upload->do_upload('image');
            
            if(!empty($_FILES['image']['name']) && isset($_FILES['image']['name'])){
                if(! $this->upload->do_upload('image')){
                    $data['error'] = $this->upload->display_errors();
                    die($data['error']); 
                }
            }
            
            //$u_image = $this->upload->do_upload('image');

            if(!empty($_FILES['image']['name']) && isset($_FILES['image']['name'])){
                $image = array('image' => $this->upload->data());
                $data['pict_name'] = $url_path.$image['image']['file_name'];
            }
            
        if($id){
            $update = $this->general_model->updateData('gift_table', $data, array('id' => $id));
        }else{
            $insert = $this->general_model->insertData('gift_table', $data);
        }

        if($update || $insert){
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'gagal'));
        }


    }

    function insert() {
        $this->_check_login();
        if (empty($_FILES['file_upload']['name'])) {
            $this->form_validation->set_rules('file_upload', 'File', 'required');
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('point', 'Point', 'required|numeric');
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        if ($this->form_validation->run() == TRUE) {
            $config['upload_path'] = "./gift/";
            $config['allowed_types'] = 'gif|jpg|png|JPEG';
            $config['file_name'] = url_title($this->input->post('file_upload'));

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file_upload')) {
                echo $this->upload->display_errors();
            } else {
                $filename = $this->upload->file_name;
                $this->load->model('gift_model');
                $name = $this->input->post('name');
                $point = $this->input->post('point');
                $description = $this->input->post('description');
                $this->gift_model->do_insert($filename, $name, $point, $description);
//                    $this->filepage();
            }
            $this->stencil->title('Gift List');
            $this->stencil->js('custom/gift_list');
            $this->stencil->paint('gift_list', $data);
        } else {
            $this->stencil->title('Input Gift');
            $this->stencil->paint('input_gift', $data);
        }
    }

    function ajax_get_gift() {
        $url = base_url().'assets/uploads/gift/';
        $this->datatables->select('gt.id,gt.pict_name,gt.name,gc.category_name,gt.value,gt.point')
             ->add_column('Actions', Actions('$1'), 'gt.id')
             ->edit_column('gt.pict_name', '$1', 'FormatImage(gt.pict_name)')
             ->unset_column('gt.id')
             ->from('gift_table gt')
             ->join('gift_category gc', 'gt.type = gc.id')
             ->where('gt.status_gift', '1');

        echo $this->datatables->generate();
    }

    function list_gift() {

        //$this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $data['category'] = $this->gift_model->get_category_gift();
        $this->stencil->title('Gift List');
        $this->stencil->js('custom/gift_list');
        $this->stencil->paint('gift_list', $data); 
    }

    function edit() {

        $id     = $this->input->post('id');
        $data   = $this->gift_model->select_by_id_gift($id);

        echo json_encode(array('data' => $data));

    }

    function update() {
        $this->_check_login();
        $this->load->model('gift_model');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('point', 'Point', 'required|numeric');
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $id = abs((int)$this->input->post('id'));
        if ($this->form_validation->run() == TRUE) {
            $filename = '';
            if ($this->input->post('file_upload') != '') {
                $path = "./gift/";
                $this->load->helper("file");
                $row = $this->gift_model->select_by_id_gift($id);
                $path = $path . $row->filename;
                delete_files($path);
                unlink($path);

                $config['upload_path'] = "./gift/";
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['file_name'] = url_title($this->input->post('file_upload'));

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('file_upload')) {
                    echo $this->upload->display_errors();
                } else {
                    $filename = $this->upload->file_name;
                }
            }

            $this->load->model('gift_model');
            $name = $this->input->post('name');
            $point = $this->input->post('point');
            $description = $this->input->post('description');
            $this->gift_model->update_gift($id, $filename, $name, $point, $description);
            $this->stencil->title('Gift List');
            $this->stencil->js('custom/gift_list');
            $this->stencil->paint('gift_list', $data);
        } else {
            $data['gift'] = $this->gift_model->select_by_id_gift($id);
            $this->stencil->title('Edit Gift');
            $this->stencil->paint('edit_gift', $data);
        }
    }

    public function delete() {
        $this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $id = abs((int)$this->input->get('id'));
        $this->load->model('gift_model');
//                $path="./gift/";
//                $this->load->helper("file"); 
//                $row=$this->gift_model->select_by_id_gift($id);
//                $path=$path.$row->filename;
//                delete_files($path);
//                unlink($path);
        $this->gift_model->delete_gift($id);
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Gift List');
        $this->stencil->js('custom/gift_list');
        $this->stencil->paint('gift_list', $data);
    }

    function del_gift() {

        $fieldkey['id']   = $this->input->post('id');
        
        $delete_gift = $this->general_model->deleteData('gift_table',$fieldkey);
        if($delete_gift){
            $alert = 'Data berhasil di hapus';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';       
            $returnVal = '';
        }
        
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }
    

}
