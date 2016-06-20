<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class transaction extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->model('down_model');

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
        //$this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $this->load->model('transaction_model');
//        $data['user'] = $this->transaction_model->get_approved_user();
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Input Transaction');
        $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/input_transaction');
        $this->stencil->paint('input_transaction', $data);
    }

    function list_transaction() {
        //$this->_check_login();
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Transaction List');
        $this->stencil->js('custom/transaction_list');
        $this->stencil->paint('transaction_list', $data);
    }

    function ajax_get_transaction() {
        $this->datatables->select('user_id,kode_agent,hotel,city,country,room,night,roomnight,point_promo, GroupLineNo, fromdate,todate,web_Invoice'); 
        $this->datatables->edit_column('GroupLineNo', '$1', 'total_point(roomnight,point_promo)');
        $this->datatables->edit_column('point_promo', '$1', 'point(roomnight,point_promo)');
        $this->datatables->from('transaction_table');
        echo $this->datatables->generate();
    }
    
    function ajax_get_sales() {
        $this->datatables->select('id_sales, kode_sales, name_sales, area_sales')
             ->add_column('Actions', Actions('$1'), 'id_sales')
             ->unset_column('id_sales')
             ->from('mgf_sales');

        echo $this->datatables->generate();
    }

    function insert() {
        $this->form_validation->set_rules('username', 'User', 'required');
        $this->form_validation->set_rules('hotel', 'Hotel', 'required');
        $this->form_validation->set_rules('reservation', 'Date Range', 'required');
        $session_data = $this->session->userdata('CMS_logged_in');
        $data['admin'] = $session_data['username'];
        if ($this->form_validation->run() == TRUE) {
            $user = $this->input->post('user');
            $hotel = $this->input->post('hotel');
            $room = $this->input->post('room');
            $night = $this->input->post('night');
            $from = date("Ymd", strtotime(substr($this->input->post('reservation'), 0, 10)));
            $to = date("Ymd", strtotime(substr($this->input->post('reservation'), 13, 10)));
            $this->load->model('transaction_model');
            $this->transaction_model->do_insert($user, $hotel, $room, $night, $from, $to);
            $this->stencil->title('Transaction List');
            $this->stencil->js('custom/transaction_list');
            $this->stencil->paint('transaction_list', $data);
        } else {
            $this->stencil->title('Input Transaction');
            $this->stencil->css('daterangepicker/daterangepicker-bs3');
            $this->stencil->js('plugins/daterangepicker/daterangepicker');
            $this->stencil->js('custom/input_transaction');
            $this->stencil->paint('input_transaction', $data);
        }
    }

    function show_user() {
        //$this->_check_login();
        $this->stencil->layout('php_default');
        $this->stencil->js('custom/user');

        $this->stencil->paint('user', $data);
    }

    function ajax_get_user() {
        //$this->_check_login();
        $this->load->library('Datatables');
        $this->datatables->select('id,user_id,mg_user_id,name,address,city,phone,id_number,birthdate,genre,email,status,kode_agent,point');
        $this->datatables->from('user_table');
        $this->datatables->where('status', '1');
        $this->datatables->where('mg_user_id !=', '');
        echo $this->datatables->generate();
    }

}
