<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class slider extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model(array('slider_model'));

        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
        
        $this->arr_dimension = array();
        $this->arr_dimension['display']['width'] = 960;
        $this->arr_dimension['display']['height'] = 525;
        
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
    public function index() {
        //$this->_check_login();

        $session_data = $this->session->userdata('CMS_logged_in');
        $this->stencil->title('Slider Management');        
        $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/slider');
        $this->stencil->paint('slider_list', $data);
    }
    
    function ajax_get_slider() {
        $this->datatables->select('id_banner, banner_name, CONCAT(start_banner," - ",end_banner) AS periode_banner, end_banner, image_banner, link_banner, status_banner',FALSE)
        ->edit_column('status_banner', '$1', 'status_promo(end_banner)')
        ->edit_column('image_banner', '$1', 'FormatImage(image_banner)')
        ->add_column('Actions', Actions('$1'), 'id_banner')	
        ->unset_column('id_banner')
        ->unset_column('end_banner')
        ->from('banner_table');
        echo $this->datatables->generate();
    }
    
    function GetDetail() {

        $id     = $this->input->post('id');
        $data   = $this->slider_model->select_by_id_slider($id);

        echo json_encode(array('data' => $data));

    }
    
    function submit(){
        
        $post           = $this->input->post();
        $id             = $post['id'];
        $bannerName     = $post['name'];
        $periode        = $post['periode_banner'];
        $getDate        = explode(" - ", $periode);
        $startDate      = $getDate[0];
        $endDate        = $getDate[1];
        $linkBanner     = $post['link_banner'];
        if($id){
            $dataDetail     = $this->slider_model->select_by_id_slider($id);
            if(!empty($_FILES['image']['name'])){
                $filename   = $this->upload_image($_FILES['image']);                
            }else{
                $filename   = $dataDetail->filename_image;
            }
        }else{
            $filename 	= $this->upload_image($_FILES['image']);
        }
        
        
        $data = array(

            'banner_name'   => $bannerName,
            'start_banner'  => $startDate,
            'end_banner'    => $endDate,
            'image_banner'  => base_url('/assets/uploads/slider/display/960/525/'. $filename),
            'filename_image'  => $filename,
            'link_banner'   => $linkBanner,
            'status_banner' => 'active',
            'date_create'   => date('Y-m-d')

        );
            
        if($id){
            if(!empty($_FILES['image']['name'])){
        
                $imagefileOriginal  = './assets/uploads/slider/'.$dataDetail->filename_image;
                $imagefile          = './assets/uploads/slider/display/' . $this->arr_dimension['display']['width'] . '/' . $this->arr_dimension['display']['height'] . '/' . $dataDetail->filename_image;
                if (file_exists($imagefileOriginal)) {
                    @unlink($imagefileOriginal);
                    @unlink($imagefile);
                }
            }
            
        $update = $this->general_model->updateData('banner_table', $data, array('id_banner' => $id));
            
        }else{
            $insert = $this->general_model->insertData('banner_table', $data);
        }

        if($update || $insert){
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'gagal'));
        }


    }
    
    public function deleteBanner(){
        $id             = $this->input->post('id');
        $dataDetail     = $this->slider_model->select_by_id_slider($id);
        
        $imagefileOriginal  = './assets/uploads/slider/'.$dataDetail->filename_image;
        $imagefile          = './assets/uploads/slider/display/' . $this->arr_dimension['display']['width'] . '/' . $this->arr_dimension['display']['height'] . '/' . $dataDetail->filename_image;
        if (file_exists($imagefileOriginal)) {
            @unlink($imagefileOriginal);
            @unlink($imagefile);
            $delete_banner = $this->general_model->deleteData('banner_table',array('id_banner' => $id));
            if($delete_banner){
                $alert = 'Data berhasil di hapus';      
                $returnVal = 'success';
            }else{
                $alert = 'Gagal menghapus , silahkan hubungi IT';       
                $returnVal = '';
            }                   
        }
        
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    private function upload_image($image) {
        $config['upload_path'] = './assets/uploads/slider';
        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0775);
        }
        
        $info = pathinfo($image['name']);
        
        $url_title = url_title($info['filename'], '_', TRUE);
        $file_name = generateRandomString(5) . '_' . $url_title . '.' . $info['extension'];
        $config['file_name'] = $file_name;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $this->upload->initialize($config);
        $upload = $this->upload->do_upload('image');
        
        if (!$upload) {
            $invalid = $this->upload->display_errors();
            redirect('admin/slider');
        } else {
            /* First size */
            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = './assets/uploads/slider/'.$file_name;
            $configSize1['create_thumb'] = false;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = $this->arr_dimension['display']['width'];
            $configSize1['height'] = $this->arr_dimension['display']['height'];

            $path1['display'] = './assets/uploads/slider/display';
            if (!is_dir($path1['display'])) {
                mkdir($path1['display'], 0775, true);
            }
            $path2['210'] = './assets/uploads/slider/display/' . $this->arr_dimension['display']['width'];
            if (!is_dir($path2['210'])) {
                mkdir($path2['210'], 0775, true);
            }
            $path3['138'] = './assets/uploads/slider/display/' . $this->arr_dimension['display']['width'] . '/' . $this->arr_dimension['display']['height'];
            if (!is_dir($path3['138'])) {
                mkdir($path3['138'], 0775, true);
            }

            $configSize1['new_image'] = './assets/uploads/slider/display/' . $this->arr_dimension['display']['width'] . '/' . $this->arr_dimension['display']['height'] . '/' . $file_name;
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();
            return $file_name; 
        }
        
    }
}
