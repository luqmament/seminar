<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Performance extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->library('upload');
        $this->load->library('excel');

        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        if(empty($CMS_Session['username'])){
            redirect('admin/login');
        }
        
    }
    
    
    function index(){
        $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/performance');
        $this->stencil->title('Report Performance');
        $this->stencil->paint('performance_v');
    }
    
    function tester(){
        $char = 'Imelda@hana.travel' ;
        echo substr ( $char ,1, 15 );
    }
}

?>