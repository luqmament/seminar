<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promo extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('admin_model','app_model'));
        
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

    function index() {
        //$this->_check_login();
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('Promo Point Reward');
        $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/fitur-promo');
        $this->stencil->paint('fitur_promo', $data);
    }
    
    function get_list_promo_reward(){
        $this->datatables->select('id_promo,kategori_promo,nama_promo,point_promo,date_from,date_to')
        ->add_column('Actions', Actions('$1'), 'id_promo') 
        ->unset_column('id_promo') 
        ->from('fitur_promo');
        echo $this->datatables->generate();
    }
    
    function get_kategory(){
        $kategory = $this->input->post('kategory');
        $data['kategori'] = '' ;
        $data['list'] = '' ;
        switch($kategory){
            case 'Country' :
                $data['kategori'] = 'Country' ;
                $data['list'] = $this->app_model->kat_country();
            break;
            
            case 'City' :
                $data['kategori'] = 'City' ;
                $data['list'] = $this->app_model->kat_city();
            break;
            
            case 'Hotel' :
                $data['kategori'] = 'Hotel' ;
                $data['list'] = $this->app_model->kat_hotel();
            break;
        }
        echo json_encode($data);
    }
    
    function i_point_promo(){        
        $data['kategori_promo'] = $this->input->post('jenis_promo');
        $data['nama_promo']     = $this->input->post('nama_promo');
        $data['point_promo']    = $this->input->post('point_promo');
        $data['date_from']      = $this->input->post('from_date');
        $data['date_to']        = $this->input->post('to_date');
        $data['date_create']    = date('Y-m-d H:i:s');
        $data['date_change']    = date('Y-m-d H:i:s');
        
        $insert_promo_reward = $this->app_model->insertData('fitur_promo',$data);
        if($insert_promo_reward){
            echo json_encode(array('status' => 'Succes'));
        }else{
            echo json_encode(array('status' => 'failed')); 
        }
    }

    function e_point_promo(){    

        $id['id_promo']         = $this->input->post('id');   
        $data['kategori_promo'] = $this->input->post('e_jenis_promo');
        $data['nama_promo']     = $this->input->post('e_nama_promo');
        $data['point_promo']    = $this->input->post('e_point_promo');
        $data['date_from']      = $this->input->post('e_from_date');
        $data['date_to']        = $this->input->post('e_to_date');
        $data['date_change']    = date('Y-m-d H:i:s');
        
        $update_promo_reward = $this->app_model->updateData('fitur_promo',$data,$id);
        if($update_promo_reward){
            $alert = 'Data berhasil di update';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal mengubah , silahkan hubungi IT';       
            $returnVal = '';
        }
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }

    function del_promo() {

        $fieldkey['id_promo']   = $this->input->post('id');
        
        $delete_promo = $this->general_model->deleteData('fitur_promo',$fieldkey);
        if($delete_promo){
            $alert = 'Data berhasil di hapus';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';       
            $returnVal = '';
        }
        
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }

    function get_edit() {

        $id['id_promo'] = $this->input->post('id');
        $data           = $this->general_model->getDetData('fitur_promo', $id);

        echo json_encode(array('data' => $data));

    }
    
    //Fitur Promo To Front
    
    function city_promo(){
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $this->stencil->title('City Promo');
        $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/city-promo');
        $this->stencil->paint('city_promo', $data);
    }
    
    function get_list_City_Promo(){
        $this->datatables->select('id_city,City_Name')
        ->add_column('Actions', Actions('$1'), 'id_city')
        ->unset_column('id_city')
        ->where('status', 0)
        ->from('City_Promo');
        echo $this->datatables->generate();
    }
    
    function submit_city(){
        $fieldID = $this->input->post('id');
        if(!empty($fieldID)){
        $id['id_city']          = $this->input->post('id');   
        $data['City_Name']      = strtoupper($this->input->post('name'));
        $data['City_Updated']   = date('Y-m-d');
        
        $updated = $this->app_model->updateData('City_Promo',$data,$id);
            if($updated){
                $alert = 'Data berhasil di Update';      
                $returnVal = 'success';
            }else{
                $alert = 'Gagal mengubah , silahkan hubungi IT';       
                $returnVal = '';
            }            
        }else{
            $data['City_Name']      = strtoupper($this->input->post('name'));
            $data['Date_Created']   = date('Y-m-d');
            
            $insert = $this->general_model->insertData('City_Promo',$data);
            if($insert){
                $alert = 'Data berhasil di tambah';      
                $returnVal = 'success';
            }else{
                $alert = 'Gagal menghapus , silahkan hubungi IT';       
                $returnVal = '';
            }
        }
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    function DetailCityPromo(){
        $id['id_city']     = $this->input->post('id');
        $data   = $this->general_model->getDetData('City_Promo',$id);
        echo json_encode(array('data' => $data));
    }
    
    function del_City() {

        $id['id_city']          = $this->input->post('id');   
        $data['status']         = 1;
        $data['City_Updated']   = date('Y-m-d');
        
        $deleted = $this->app_model->updateData('City_Promo',$data,$id);
        if($deleted){
            $alert = 'Data berhasil di hapus';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal mengubah , silahkan hubungi IT';       
            $returnVal = '';
        }
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }
    
    function list_promo(){
        $session_data = $this->session->userdata('logged_in');
        $data['admin'] = $session_data['admin'];
        $data['city']  = $this->general_model->getAllData('City_Promo');       
        $this->stencil->title('List Promo');
        $this->stencil->js('custom/list-promo');
        $this->stencil->paint('list_promo', $data);
    }
    
    function submit_ListPromo(){
        $fieldID = $this->input->post('id');
        if(!empty($fieldID)){
        $id['id_list_promo']    = $this->input->post('id');   
        $data['hotelName']      = $this->input->post('name');
        $data['cityCode']       = $this->input->post('city');
        $data['pointPromo']     = $this->input->post('point');
        $data['upToDate']       = $this->input->post('UpToDate');
        $data['dateCreate']     = date('Y-m-d');
        
        $updated = $this->app_model->updateData('list_promo_hotel',$data,$id);
            if($updated){
                $alert = 'Data berhasil di Update';      
                $returnVal = 'success';
            }else{
                $alert = 'Gagal mengubah , silahkan hubungi IT';       
                $returnVal = '';
            }            
        }else{
            $data['hotelName']      = $this->input->post('name');
            $data['cityCode']       = $this->input->post('city');
            $data['pointPromo']     = $this->input->post('point');
            $data['upToDate']       = $this->input->post('UpToDate');
            $data['dateCreate']     = date('Y-m-d');
            
            $insert = $this->general_model->insertData('list_promo_hotel',$data);
            if($insert){
                $alert = 'Data berhasil di tambah';      
                $returnVal = 'success';
            }else{
                $alert = 'Gagal menghapus , silahkan hubungi IT';       
                $returnVal = '';
            }
        }
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
    }
    
    function get_list_Promo(){
        $this->datatables->select('lph.id_list_promo, lph.hotelName, cp.City_Name, lph.pointPromo, lph.upToDate',FALSE)
        ->add_column('Actions', Actions('$1'), 'lph.id_list_promo')
        ->edit_column('lph.upToDate', '$1', 'format_date(lph.upToDate)')
        ->unset_column('lph.id_list_promo')	
        ->from('list_promo_hotel AS lph')
        ->join('City_Promo  AS cp','lph.cityCode = cp.id_city');
        echo $this->datatables->generate();
    }
    
    function detail_listPromo(){
        $id['id_list_promo']     = $this->input->post('id');
        $data   = $this->general_model->getDetData('list_promo_hotel',$id);
        echo json_encode(array('data' => $data));
    }
    function del_listPromoHotel() {

        $id['id_list_promo']          = $this->input->post('id');
        
        $deleted = $this->general_model->deleteData('list_promo_hotel',$id);
        if($deleted){
            $alert = 'Data berhasil di hapus';      
            $returnVal = 'success';
        }else{
            $alert = 'Gagal mengubah , silahkan hubungi IT';       
            $returnVal = '';
        }
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }
    
}
