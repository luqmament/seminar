<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');

        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
    }
    
    //public function index() {
    //    //$this->_check_login();
    //
    //    $session_data = $this->session->userdata('CMS_logged_in');
    //    $data['admin'] = $session_data['admin'];
    //    $data['reg_count'] = $this->admin_model->count_user_reg();
    //    $this->stencil->title('Dashboard');
    //    $this->stencil->paint('admin_dashboard', $data);
    //}

    public function index() {
        $this->stencil->layout('login');
        $this->stencil->title('Log In');
        $this->stencil->paint('login');
    }

    public function do_login() {
        $this->form_validation->set_rules('username', 'User ID', 'required|callback_check_user');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_password');
        if ($this->form_validation->run($this) == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->load->model('admin_model');
            $this->admin_model->do_login($username, $password);
            redirect('admin');
        } else {
            $this->stencil->layout('login');
            $this->stencil->title('Log In');
            $this->stencil->paint('login');
        }
    }
    
    function check_user($str) {
        $this->form_validation->set_message('check_user', 'Username is invalid.');
        if ($this->admin_model->check_user($str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function check_password($str) {
        $this->form_validation->set_message('check_password', 'Password is invalid.');
        $user = $this->input->post('username');
        if (($this->admin_model->check_user($user))&&($this->admin_model->check_password($user,$str))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
