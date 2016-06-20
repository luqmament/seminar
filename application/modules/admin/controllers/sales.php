<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sales extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('admin_model');
        $this->load->model('sales_model');

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


    function ajax_get_sales() {
        $this->datatables->select('id_sales, kode_sales, name_sales, area_sales')
             ->add_column('Actions', Actions('$1'), 'id_sales')
             ->unset_column('id_sales')
             ->from('mgf_sales');

        echo $this->datatables->generate();
    }

    function list_sales() {

        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Sales List');
        $this->stencil->js('custom/sales_list');
        $this->stencil->paint('sales_list', $data); 
    }

    function submit(){

        $id             = $this->input->post('id');
        $kode           = $this->input->post('kode');
        $name           = $this->input->post('name');
        $area           = $this->input->post('area_sales');
        $email          = $this->input->post('emailSales');
            
        $data = array(

            'kode_sales'          => $kode,
            'name_sales'          => $name,
            'area_sales'          => $area,
            'email_sales'         => $email

        );

            
        if($id){
            $update = $this->general_model->updateData('mgf_sales', $data, array('id_sales' => $id));
        }else{
            $insert = $this->general_model->insertData('mgf_sales', $data);
        }

        if($update || $insert){
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'gagal'));
        }


    }

    function get_kode_sales(){
        $data['kode']       = $this->general_model->generate_kode('MGFS', 'mgf_sales', 'kode_sales', 'id_sales');
        $data['list_area']  = $this->general_model->getAllData('mgf_area');
        echo json_encode(array('data' => $data));
    }

    function edit() {

        $id     = $this->input->post('id');
        $data['sales']      = $this->sales_model->select_by_id_sales($id);
        $data['list_area']  = $this->general_model->getAllData('mgf_area');
        echo json_encode(array('data' => $data));

    }

    function del_sales() {

        $fieldkey['id_sales']   = $this->input->post('id');
        
        $delete_sales = $this->general_model->deleteData('mgf_sales',$fieldkey);
        if($delete_sales){
            $alert = 'Data berhasil di hapus';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';       
            $returnVal = '';
        }
        
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }

    public function check_sales_email($str = '') {
        $email  = $this->input->post('email');
        $id     = $this->input->post('id');
    
        $check_user = $this->sales_model->check_sales_email($email, $id);
        if($check_user){
            $alert      = '';
            $returnVal  = 'success';
        }else{
            $alert      = 'Alamat email sudah terdaftar';
            $returnVal  = 'failed';
        }

        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));
    }


}
