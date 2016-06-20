<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class down extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model(array('admin_model','down_model'));
        
        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        if(empty($CMS_Session['username'])){
            redirect('admin/login');
        }
    }

    function index() {
        //$this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Download Reward');
        $this->stencil->js('custom/fitur-download');
        $this->stencil->paint('fitur_download', $data);
    }
    
    function get_listTransaction(){
        $date_from  = $this->input->post('date_from');
        $date_to    = $this->input->post('date_to');
        
        $get['PointRewardDatas']        = $this->down_model->get_ListTransaction($date_from, $date_to);
        echo json_encode($get);
    }
    

}
