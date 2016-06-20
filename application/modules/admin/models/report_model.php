<?php

class Report_model extends CI_Model {
    
function data_ReportUserList(){
    $key    = array(
        'ut.status !='    => 0
    );
    $this->db->select('ut.name, ut.email, ut.city, ut.area, ut.point, ut.kode_agent, ut.status, at.name as agent_name, ut.mg_user_id, ut.nama_bank, ut.no_rekening, DATE_FORMAT(ut.user_date_create,"%d %M %Y") AS date_created, DATE_FORMAT(ut.user_date_approved,"%d %M %Y") AS date_approved, ut.sales_rekomend', FALSE);
    $this->db->from('user_table ut');
    $this->db->join('agent_table at', 'ut.kode_agent = at.kode_agent');
    $this->db->where($key);
    $this->db->order_by("ut.user_date_create", "asc");
    $query =  $this->db->get();
    
    if($query->num_rows() > 0){
        return $query;
    }else{
       return false;
    }
}
    
function data_ReportHistory($startDate = '', $endDate = ''){
        $this->db->select('hu.*,ut.name,ut.address,ut.kode_agent,at.name as agent_name,ut.mg_user_id,ut.email,adt.username,gt.name as gift_name, gt.value, gt.point');
        $this->db->from('history_user hu');
        $this->db->join('user_table ut', 'hu.user_id = ut.id');
        $this->db->join('gift_table gt', 'hu.gift_id = gt.id', 'Left');
        $this->db->join('admin_table adt', 'hu.id_admin_approve = adt.id', 'Left');
        $this->db->join('agent_table at', 'ut.kode_agent = at.kode_agent');
        $this->db->where('ut.status',1);
        if(!empty($startDate) && !empty($endDate)){
            $this->db->where('hu.date_create >=', $startDate);
            $this->db->where('hu.date_create <=', $endDate);
        }
        $this->db->order_by("hu.date_create", "asc");
        $query =  $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
           return false;
        }
    }
function reportHotelBooking($kodeAgent = '', $mg_userId = ''){
    $this->db->select('tt.*');
    if(!empty($kodeAgent) && !empty($mg_userId)){
        $this->db->where('tt.kode_agent',$kodeAgent);
        $this->db->where('tt.user_id',$mg_userId);
        $this->db->where('tt.todate >=  DATE_SUB(ut.user_date_approved,INTERVAL 5 DAY)');
    }
    $this->db->from('transaction_table tt');
    $this->db->join('user_table ut','tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id');
    $this->db->order_by('tt.todate','desc');
    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result_array();
    }else{
        return false;
    }
}
    
    function getTransaksiBookingUser($from_date,$to_date, $limit = ''){
        $this->db->select('ut.mg_user_id, ut.kode_agent, tt.AgentName, ut.email, ut.city, ut.area, ut.phone, ut.birthdate, ut.genre, sum(tt.point_promo) as jumlah_point');
        $this->db->from('transaction_table tt');
        $this->db->join('user_table ut', 'tt.user_id = ut.mg_user_id and tt.kode_agent = ut.kode_agent','inner');
        $this->db->where('tt.todate >= ',$from_date);
        $this->db->where('tt.todate <= ',$to_date);
        $this->db->where('ut.status', 1);
        $this->db->order_by('jumlah_point','desc');
        if(!empty($limit)){
            $this->db->limit(50);
        }        
        $this->db->group_by('ut.id');
        
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
        
    }
    
    function getTransaksiBookingAgent($from_date,$to_date, $notAgents){
        $this->db->select('at.name, at.kode_agent, at.address, at.phone, at.email, at.city, at.country, sum(tt.point_promo) as jumlah_point');
        $this->db->from('transaction_table tt');
        $this->db->join('agent_table at', 'tt.kode_agent = at.kode_agent','inner');
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
        $this->db->where_not_in('at.kode_agent', $notAgents);
        $this->db->order_by('jumlah_point','desc');
        
        $this->db->limit(25);
        $this->db->group_by('at.id');
        
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
        
    }
    
    function detailTransaksibookings($from_date,$to_date,$kode_agent,$mg_user_id){
        $this->db->where('todate >= ',$from_date);
        $this->db->where('todate <= ',$to_date);
        $this->db->where('kode_agent',$kode_agent);
        $this->db->where('user_id',$mg_user_id);
        $this->db->order_by('todate','asc');
        $this->db->limit(100);
        $query = $this->db->get('transaction_table');
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    
    function detailTransaksibookingsAgent($from_date,$to_date,$kode_agent){
        $this->db->where('todate >= ',$from_date);
        $this->db->where('todate <= ',$to_date);
        $this->db->where('kode_agent',$kode_agent);
        $this->db->order_by('todate','asc');
        $this->db->limit(75);
        $query = $this->db->get('transaction_table');
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    
function report_claimed($tanggalClaimed){
    $this->db->select('hu.id as id_req_Gift, ut.kode_agent, at.name as agent_name, DATE_FORMAT(hu.date_create, "%d %M %Y") as date_claim, ut.mg_user_id, ut.name as username, ut.nama_bank, ut.no_rekening, ut.atas_nama_bank, gt.name as giftname, gt.value, hu.status as status_req', FALSE);
    $this->db->from('history_user hu');
    $this->db->join('user_table ut', 'hu.user_id = ut.id');
    $this->db->join('gift_table gt', 'gt.id = hu.gift_id');
    $this->db->join('agent_table at', 'at.kode_agent = ut.kode_agent');
    $key    = array(
        'hu.status'  => 'approved'
        ,'DATE_FORMAT(hu.date_approve, "%Y-%m-%d") <=' => $tanggalClaimed
        ,'DATE_FORMAT(hu.date_approve, "%Y-%m-%d") >=' => $tanggalClaimed
    );
    $this->db->where($key);
    $query =  $this->db->get();
    
        if($query->num_rows() > 0){
            return $query;
        }else{
           return false;
        }
    }
    
    
function hotel_top($from_date,$to_date, $notAgents, $hotels = ''){
    $this->db->select('tt.hotel, tt.city, tt.country, sum(tt.point_promo) as jumlah');
    $this->db->from('transaction_table tt');
    $this->db->join('agent_table at', 'tt.kode_agent = at.kode_agent','inner');
    $this->db->join('user_table ut', 'tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id','inner');
    $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
    $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
    $this->db->where_not_in('tt.kode_agent', $notAgents);
    if(!empty($hotels) ){
        $this->db->where('tt.hotel',$hotels);
    }
    //$this->db->from('transaction_table tt');
    $this->db->group_by('tt.hotel');
    $this->db->order_by('jumlah','desc');
    $this->db->limit(15);
        $query =  $this->db->get();
    
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
           return false;
        }
    }
    
function HotelsBookingAgent($from_date,$to_date,$hotels, $notAgents){
        $this->db->select('ut.mg_user_id, at.kode_agent, at.name, tt.*, (tt.point_promo / tt.roomnight) as point');
        $this->db->from('transaction_table tt');
        $this->db->join('agent_table at', 'tt.kode_agent = at.kode_agent','inner');
        $this->db->join('user_table ut', 'tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id','inner');
        $this->db->where('tt.hotel', $hotels);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
        $this->db->where_not_in('tt.kode_agent', $notAgents);
        //$this->db->group_by('at.kode_agent');
        $this->db->order_by('at.kode_agent','desc');
        
        //$this->db->limit(25);
        
        
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
        
    }
function HotelsBookingUsers($from_date, $to_date, $hotel, $kode_agent, $NotAgents){
        $this->db->select('ut.mg_user_id, ut.name, ut.email, ut.kode_agent, tt.hotel, tt.room, tt.night, tt.roomnight, tt.point_promo, tt.todate');
        $this->db->from('transaction_table tt');
        $this->db->join('user_table ut', 'tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id','inner');
        $this->db->where('tt.hotel', $hotel);
        $this->db->where('tt.kode_agent', $kode_agent);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
        $this->db->where_not_in('tt.kode_agent', $notAgents);
        //$this->db->group_by('tt.kode_agent');
        $this->db->order_by('tt.todate','desc');
        
        //$this->db->limit(25);
        
        
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }    

function destinasi_top($from_date,$to_date, $notAgents, $citys = '', $katDest){
    $this->db->select('tt.city, tt.country, sum(tt.point_promo) as jumlah, tt.todate');
    $this->db->from('transaction_table tt');
    $this->db->join('agent_table at', 'tt.kode_agent = at.kode_agent','inner');
    $this->db->join('user_table ut', 'tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id','inner');
    $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
    $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
    if(!empty($citys) ){
        $this->db->where('tt.city',$citys);
    }
    $this->db->where_not_in('tt.kode_agent', $notAgents);
    //$this->db->from('transaction_table tt');
    $this->db->group_by('tt.city');
    $this->db->order_by('jumlah','desc');
    $this->db->limit(15);
        $query =  $this->db->get();
    
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
           return false;
        }
    }
function BookingDestinasi($from_date,$to_date, $city, $notAgents, $katDest){
        $this->db->select('ut.mg_user_id, at.kode_agent, at.name, tt.*, (tt.point_promo / tt.roomnight) as point');
        $this->db->from('transaction_table tt');
        $this->db->join('agent_table at', 'tt.kode_agent = at.kode_agent','inner');
        $this->db->join('user_table ut', 'tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id','inner');
        $this->db->where('tt.city', $city);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
        $this->db->where_not_in('tt.kode_agent', $notAgents);
        if($katDest == 'Hotels'){
            $dest = 'tt.hotel' ;
        }else{
            $dest = 'tt.kode_agent' ;
        }
        //$this->db->group_by('tt.kode_agent');
        $this->db->order_by($dest,'desc');
        
        //$this->db->limit(25);
        
        
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    
function DestinasiBookingUsers($from_date, $to_date, $hotel, $kode_agent, $NotAgents){
        $this->db->select('ut.mg_user_id, ut.name, ut.email, ut.kode_agent, tt.*');
        $this->db->from('transaction_table tt');
        $this->db->join('user_table ut', 'tt.kode_agent = ut.kode_agent AND tt.user_id = ut.mg_user_id','inner');
        $this->db->where('tt.hotel', $hotel);
        $this->db->where('tt.kode_agent', $kode_agent);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") >= ',$from_date);
        $this->db->where('DATE_FORMAT(tt.todate, "%Y-%m-%d") <= ',$to_date);
        $this->db->where_not_in('tt.kode_agent', $notAgents);
        //$this->db->group_by('tt.hotel');
        $this->db->order_by('tt.todate','desc');
        
        //$this->db->limit(25);
        
        
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    
function ReportPromoPoint(){
    $this->db->from('fitur_promo');
    $query =  $this->db->get();
    
    if($query->num_rows() > 0){
        return $query->result_array();
    }else{
       return false;
    }

}
    
}

