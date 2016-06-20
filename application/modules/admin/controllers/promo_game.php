<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promo_game extends MY_Controller {
    private $status_promo ;
    function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('admin_model','app_model','promogame_model'));
        
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
        $this->stencil->title('Promo Game');
        $this->stencil->css('daterangepicker/daterangepicker-bs3');
        $this->stencil->js('plugins/daterangepicker/daterangepicker');
        $this->stencil->js('custom/promo-game');
        $this->stencil->paint('V_promo_game', $data);
    }
    
    function detail_promo_game() {
        //$this->_check_login();
        $today = date('Y-m-d');
        $session_data               = $this->session->userdata('logged_in');
        $data['admin']              = $session_data['admin'];
        $data['list_promo_game']    = $this->promogame_model->GetAllPromoGame($today);
        $data['listCity']           = $this->app_model->kat_city();
        $this->stencil->title('Detail Promo Game');
        $this->stencil->js('custom/detail-promo-game');
        //echo '<pre>',print_r($data);die();
        $this->stencil->paint('v_detail_promo_game', $data);
        
    } 
    
    function get_list_promo_game(){
        $this->datatables->select('id_promogame,nama_promogame,start_promogame,end_promogame, status_promogame')
        ->edit_column('status_promogame', '$1', 'status_promo(end_promogame)')
        ->add_column('Actions', Actions('$1'), 'id_promogame')
        ->unset_column('id_promogame') 
        ->from('promo_game');
        echo $this->datatables->generate();
    }
    function get_list_detail_promo_game(){
        $this->datatables->select('pdg.id_detailgame, pdg.city_gamedetail,pg.nama_promogame,pg.start_promogame,pg.end_promogame, pg.status_promogame',FALSE)
        ->edit_column('pg.status_promogame', '$1', 'status_promo(pg.end_promogame)')
        //->edit_column('user_date_create', '$1', 'format_date(user_date_create)')
        ->add_column('Actions', Actions('$1'), 'pdg.id_detailgame')	
        ->unset_column('pdg.id_detailgame')
        ->from('promogame_detail AS pdg')
        ->join('promo_game  AS pg','pdg.id_promogame = pg.id_promogame');
        //->where('ut.status', '1');
        echo $this->datatables->generate();
    }
    
    function submit(){
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        $id             = $this->input->post('id');
        $periode        = $this->input->post('periodeGame');
        $getDate        = explode(" - ", $periode);
        $start_date     = $getDate[0];
        $end_date       = $getDate[1];
        $GameName       = $this->input->post('name');
        $dataCreateOrUpdateCreate = (($id) ? 'update_create': 'date_create');
        $data = array(

            'nama_promogame'    => $GameName,
            'start_promogame'   => $start_date,
            'end_promogame'     => $end_date,
            'id_admin'          => $CMS_Session['id'],
            'status_promogame'  => 1

        );
        $data[$dataCreateOrUpdateCreate] =  date('Y-m-d H:i:s');
        //echo '<pre>',print_r($data);die();
        if($id){
            $update = $this->general_model->updateData('promo_game', $data, array('id_promogame' => $id));
        }else{
            $insert = $this->general_model->insertData('promo_game', $data);
        }

        if($update || $insert){
            $alert = ($update) ? 'Data Berhasil di Update' : 'Data Berhasil di Simpan' ;
            echo json_encode(array('status' => 'success', 'alert' => $alert));
        }else{
            $alert = ($update) ? 'Data Gagal di Update' : 'Data Gagal di Simpan' ;
            echo json_encode(array('status' => 'gagal', 'alert' => $alert));
        }


    }
    
    function submit_detailGame(){
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        $id             = $this->input->post('id');
        $cityGameDetail = $this->input->post('CityPromoGame');
        $idPromoGame    = $this->input->post('KatPromoGame');
        $dataCreateOrUpdateCreate = (($id) ? 'update_create': 'date_create');
        $data = array(

            'city_gamedetail'   => $cityGameDetail,
            'id_promogame'      => $idPromoGame,
            'id_admin'          => $CMS_Session['id']

        );
        $data[$dataCreateOrUpdateCreate] =  date('Y-m-d H:i:s');
        //echo '<pre>',print_r($data);die();
        if($id){
            $update = $this->general_model->updateData('promogame_detail', $data, array('id_detailgame' => $id));
        }else{
            $insert = $this->general_model->insertData('promogame_detail', $data);
        }

        if($update || $insert){
            $alert = ($update) ? 'Data Berhasil di Update' : 'Data Berhasil di Simpan' ;
            echo json_encode(array('status' => 'success', 'alert' => $alert));
        }else{
            $alert = ($update) ? 'Data Gagal di Update' : 'Data Gagal di Simpan' ;
            echo json_encode(array('status' => 'gagal', 'alert' => $alert));
        }
    }
    

    function get_edit() {

        $id['id_promogame'] = $this->input->post('id');
        $data           = $this->general_model->getDetData('promo_game', $id);

        echo json_encode(array('data' => $data));

    }
    
    function get_edit_detail() {

        $id['id_detailgame'] = $this->input->post('id');
        $data           = $this->general_model->getDetData('promogame_detail', $id);

        echo json_encode(array('data' => $data));

    }
    
    function del_promo() {

        $fieldkey['id_promogame']   = $this->input->post('id');
        
        $delete_promo = $this->general_model->deleteData('promo_game',$fieldkey);
        if($delete_promo){
            $fieldkeyDetail['id_promogame']   = $this->input->post('id');
            $delete_promoDetail = $this->general_model->deleteData('promogame_detail',$fieldkeyDetail);
            if($delete_promoDetail){
                $alert = 'Data berhasil di hapus';      
                $returnVal = 'success';
            }else{
                $alert = 'Gagal menghapus , silahkan hubungi IT';       
                $returnVal = '';
            }            
        }else{
            $alert = 'Gagal menghapus , silahkan hubungi IT';       
            $returnVal = '';
        }
        
        echo json_encode(array('alert'=>$alert,'returnVal'=>$returnVal));
        
    }
    
}
