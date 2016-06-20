<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gift_option extends MY_Controller {

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

    function list_gift_option() {

        //$this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $data['category'] = $this->gift_model->get_category_gift();
        $this->stencil->title('Gift List Option');
        $this->stencil->js('custom/gift_list_option');
        $this->stencil->paint('gift_list_option', $data); 

    }

    function ajax_get_gift($id) {

        /*$chkGift = "ok";

        $url = base_url().'assets/uploads/gift/';*/
        $this->datatables->select('id,pict_name,name,value,point,gift_home, type')
             //->add_column('Actions', gift_option_checkbox('$1'), 'id')
             //->add_column('Actions', '$1', $chkGift)
             ->edit_column('pict_name', '$1', 'FormatImage(pict_name)')
             ->edit_column('gift_home', '$1', 'gift_option_checkbox(id, gift_home, type)')
             ->unset_column('id')
             ->unset_column('type')
             ->from('gift_table')
             ->where('status_gift', '1')
             ->where('type', $id);

        echo $this->datatables->generate();
    }

    function get_category_gift(){

        $category = $this->gift_model->get_category_gift();

        echo json_encode(array('category' => $category));

    }

    function change_gift(){

        $id     = $this->input->post('id');
        $chk    = $this->input->post('chk');
        $type   = $this->input->post('type');
        $status = "";

        if($chk == 0 ){
            $this->general_model->updateData('gift_table', array('gift_home' => $chk), array('id' => $id));
            $status = 1;
        }

        $sumData = $this->general_model->sumData('gift_table', 'gift_home', array('type' => $type, 'gift_home' => '1'));

        if($sumData->num >= 3){
            $status = 0;
        }else{
            $this->general_model->updateData('gift_table', array('gift_home' => $chk), array('id' => $id));
            $status = 1;
        }

        echo json_encode(array('status' => $status));
        
    }


}
