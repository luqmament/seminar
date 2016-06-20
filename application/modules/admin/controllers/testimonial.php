<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->model('testimonial_model');

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


    function ajax_get_testimonial() {
        $this->datatables->select('id_testimonial, testimonial_name, testimonial_lokasi,testimonial_publish')
             ->add_column('Actions', Actions('$1'), 'id_testimonial')
             ->edit_column('testimonial_publish', '$1', 'option_checkbox(id_testimonial, testimonial_publish)')
             ->unset_column('id_testimonial')
             ->from('tbl_testimonial');

        echo $this->datatables->generate();
    }

    function list_testimonial() {

        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Testimonial');
        $this->stencil->js('custom/testimonial');
        $this->stencil->paint('testimonial', $data); 
    }

    function submit(){       
        //upload image
        //$image_testimonial = null ;
        $folder_upload  = './assets/uploads/testimonial/';
        $url_path = base_url().'assets/uploads/testimonial/';
        if (!is_dir($folder_upload)) {
            @mkdir($folder_upload, 0777);
        }
        
        $config['upload_path']      = $folder_upload;
        $config['allowed_types']    = 'gif|jpg|png|jpeg';
        $new_name                   = 'testimonial_'.date('ymdhis');
        $config['file_name']        = $new_name;            
        $this->upload->initialize($config);
        
        $id                 = $this->input->post('id');
        $name               = $this->input->post('name_testimonial');
        $lokasi             = $this->input->post('lokasi_testimonial');
        $desk               = $this->input->post('desk_testimonial');
        
        $data = array(

            'testimonial_name'          => $name,
            'testimonial_lokasi'        => $lokasi,
            'testimonial_deskripsi'     => $desk
        );
        
         if(!empty($_FILES['image']['name']) && isset($_FILES['image']['name'])){
            if(! $this->upload->do_upload('image')){
                $data['error'] = $this->upload->display_errors();
                die($data['error']); 
            }
            else{
                $image = array('image' => $this->upload->data());
                $image_testimonial = $url_path.$image['image']['file_name'];
                $data['testimonial_path']   =  $image_testimonial ;
                $data['testimonial_image']  =  $image['image']['file_name'];
            }
        }
        if($id){
            $update = $this->general_model->updateData('tbl_testimonial', $data, array('id_testimonial' => $id));
        }else{
            $insert = $this->general_model->insertData('tbl_testimonial', $data);
        }
        
        if($update || $insert){
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'gagal'));
        }


    }

    function get_list_area(){
        $data['list_area']  = $this->general_model->getAllData('mgf_area');
        echo json_encode(array('data' => $data));
    }

    function edit() {

        $id     = $this->input->post('id');
        $data['testimonial']        = $this->general_model->getDetData('tbl_testimonial',array('id_testimonial' => $id));
        $data['list_area']          = $this->general_model->getAllData('mgf_area');
        echo json_encode(array('data' => $data));

    }

    function del_testimonial() {

        $fieldkey['id_testimonial']   = $this->input->post('id');
        $path   = './assets/uploads/testimonial/';
        $this->load->helper("file"); 
        $row    = $this->general_model->getDetData('tbl_testimonial',$fieldkey);
        $path   = $path.$row->testimonial_image;
        delete_files($path);
        unlink($path);
        $delete_testimonial = $this->general_model->deleteData('tbl_testimonial',$fieldkey);
        if($delete_testimonial){
            $alert = 'Data berhasil di hapus';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';       
            $returnVal = '';
        }
        
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }

    function checkbox_testimonial(){

        $id     = $this->input->post('id');
        $chk    = $this->input->post('chk');
        $status = "publish";

        if($chk == 0 ){
            $status = "unpublish";
        }
        $this->general_model->updateData('tbl_testimonial', array('testimonial_publish' => $chk), array('id_testimonial' => $id));
        echo json_encode(array('status' => $status));
        
    }

}
