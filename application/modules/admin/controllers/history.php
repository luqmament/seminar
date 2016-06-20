<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class history extends MY_Controller {

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
    
    
    function ajax_get_history() {

        $this->datatables->select('ut.mg_user_id, ut.kode_agent, gt.name, hu.status, hu.last_point, hu.in_point, hu.out_point, hu.current_point, at.username, hu.notes, hu.date_create, hu.date_create AS dateCheckOut, gt.value ',FALSE) 
             //->edit_column('by_checkoutDate', checkoutDateHistory('$1'), 'dateCheckOut')
	     ->edit_column('dateCheckOut', '$1', 'checkoutDateHistory(dateCheckOut)')
	     ->edit_column('gt.name', '$1 $2', 'gt.name, gt.value') 
             ->from('history_user hu')
             ->join('user_table ut', 'ut.id = hu.user_id', 'left')
             ->join('gift_table gt', 'gt.id = hu.gift_id', 'left')
             ->join('admin_table at', 'at.id = hu.id_admin_approve', 'left');

        echo $this->datatables->generate();
    }

    function list_history() {

        //$this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $data['history'] = $this->gift_model->get_category_gift();
        $this->stencil->title('History List');
	 $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/history_user');
        $this->stencil->paint('history_user', $data); 
    }

}
