<?php
/* Programmer Identification */
/* Nama				: Luqman Hakim */
/* Tanggal Mulai		: Mei 27 2015 */
/* Fungsi File			: Management Email Alert */
/* End Of Programmer Identification */
Class Down_model extends CI_Model
{	
	function __constuct()
	{
		parent::__constuct();  // Call the Model constructor 
		loader::database();    // Connect to current database setting.
	}
	
        //==== Get List Transaction Dummy ==== //
        public function get_ListTransaction($date_from, $date_to){
            $this->db->where('CheckIn >=', $date_from);
            $this->db->where('CheckOut <=', $date_to);
            return $this->db->get('dummy_transaction')->result_array();
            //if($query){
            //        return true ;
            //}else
            //        return false ;
        }
        
        //==== Check Fitur Promo ====//
        function check_promo($dari, $sampai){
	    $this->db->where('DATE_FORMAT(date_from, "%Y-%m-%d") <= ',$sampai);
            $this->db->where('DATE_FORMAT(date_to, "%Y-%m-%d") >= ',$dari);
	    $query = $this->db->get('fitur_promo') ;
	    if($query->num_rows() > 0){
		return $query->result_array();
	    }else{
		return false;
	    }
            
        }
	
	
	
	
	//==== Get nama hotel di list history tranaction ====//
	function getAllDataColumn($column,$table){
	$this->db->select($column);
	$this->db->group_by($column); 
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
        
        //==== Get Country List ====//
        public function kat_country(){
            $this->db->select("CountryName");
            $this->db->group_by("CountryName");
            return $this->db->get('mg_city')->result_array();
        }
        
        //==== Get City List ====//
        public function kat_city(){
            $this->db->select("CityName");
            return $this->db->get('mg_city')->result_array();
        }
        
        //==== Get Hotel List ====//
        public function kat_hotel(){
            $this->db->select("HotelName");
            return $this->db->get('mg_hotel')->result_array();
        }
        
	//==== Check Fitur Promo ====//
        function checkUser($table, $user_id){
            $this->db->where('user_id', $user_id);
            $checkUser = $this->db->get($table)->result_array();
	    if($checkUser){
		return true;
	    }else{
		return false ;
	    }
        }
	
	
	/*=========== Insert To Transaction =============*/
	public function do_insertTransaction($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night, $roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName){
		if($PNR == NULL){
			$PNR  = '-' ;
		}
		$data = array(
			'user_id'		=> $user_id,
			'hotel'			=> $namaHotel,
			'city'			=> $City,
			'country'		=> $Country,
			'room'			=> $room,
			'night'			=> $night,
			'roomnight'		=> $roomnight,
			'point_promo'		=> $point_promo,
			'fromdate'		=> $fromdate,
			'todate'		=> $todate,
			'satlement_date'	=> $satlement_date,
			'web_Invoice'		=> $web_Invoice,
			'kode_agent'		=> $kode_agent,
			'GroupLineNo'		=> $GroupLineNo,
			'PNR'			=> $PNR,
			'PNRNumber' 		=> $PNRNumber,
			'PaxName' 		=> $PaxName,
			'SalesBase' 		=> $SalesBase,
			'VoucherNumber' 	=> $VoucherNumber,
			'InvoiceNumber' 	=> $InvoiceNumber,
			'AgentName'		=> $AgentName,
			'status_transaction'	=> 0
		);
		$insert = $this->db->insert('transaction_table', $data);
		
		if($insert){
			$checkUserAktif = $this->db
					->select('user_date_approved')
					->where('SUBSTRING(mg_user_id, 1, 15) = ', substr($user_id,0,15))
					->where('kode_agent',$kode_agent)
					->where('status',1)
					->get('user_table');
			if($checkUserAktif->num_rows() > 0){
				$date = new DateTime($checkUserAktif->row()->user_date_approved);
				$date_approved 	= $date->modify('-5 day');
				$date_approved	= strtotime($date->format('Y-m-d'));
				$CheckOut	= strtotime($todate);
				if($CheckOut >= $date_approved){
					$this->db->select('*');
					$this->db->where('SUBSTRING(mg_user_id, 1, 15) = ', substr($user_id,0,15));
					$this->db->where('kode_agent', $kode_agent);
					$query 		= $this->db->get('user_table');
					$point 		= $query->row()->point;
					$tipe_member 	= $query->row()->tipe_member;
					
					$this->db->select('*');
					$this->db->where('id_member', $tipe_member);
					$query_tipe 	= $this->db->get('tipe_member');
					$point_member 	= $query_tipe->row()->point_member ;
					
					
					$point = $point + ($point_promo*$point_member);
					
					$data = array(
					       'point' => $point
					    );
					
					$this->db->where('SUBSTRING(mg_user_id, 1, 15) = ', substr($user_id,0,15));
					$this->db->where('kode_agent', $kode_agent);
					$this->db->update('user_table', $data);
				}else{
					return false;
				}
				
			}else{
				return false;
			}	
		}
		
	}
	
	public function countPointTransaction(){
		$this->db->select('ut.id,ut.mg_user_id,ut.user_id,ut.kode_agent,ut.point,tm.point_member');
		$this->db->from('user_table ut');
		$this->db->join('tipe_member tm', 'ut.tipe_member = tm.id_member');
		$this->db->where('ut.status',1);
		$get = $this->db->get()->result_array();
		foreach($get as $row){
			$this->db->select('sum(point_promo) as total');
			$this->db->where('status_transaction', 0);
			$this->db->where('SUBSTRING(user_id, 1, 15) = ', substr($row['mg_user_id'],0,15));
			$this->db->where('kode_agent',$row['kode_agent']);
			$getDataPoint = $this->db->get('transaction_table')->row();
			$dataInsert = array(
				'user_id'	=> $row['id'],
				'status'	=> 'income',
				'last_point'	=> ($row['point'] - ($getDataPoint->total * $row['point_member'])),
				'in_point'	=> ($getDataPoint->total * $row['point_member']),
				'current_point'	=> ($row['point']),
				'date_create'	=> date('Y-m-d H:i:s')
			);
			
			if($getDataPoint->total > 0){
				$insert_history	= $this->db->insert('history_user', $dataInsert);
			}
			
		}
		
		$replace_status_TransactionTable = $this->db->update('transaction_table',array('status_transaction' => 1),array('status_transaction' => 0));
		if($replace_status_TransactionTable){
		    return true ;
		}else{
		    return false ;
		}
	}
		
	//==== Check Fitur Promo Game ====//
        function check_promoGame($dari, $sampai, $today){
        $this->db->select('pg.id_promogame, pg.nama_promogame, pg.start_promogame, pg.end_promogame, pgd.id_detailgame, pgd.city_gamedetail');
        $this->db->from('promo_game pg');
        $this->db->join('promogame_detail pgd','pg.id_promogame = pgd.id_promogame');
        $this->db->where('DATE_FORMAT(pg.end_promogame, "%Y-%m-%d") >= ',$today);
	$this->db->where('pg.start_promogame <=', $dari);
        $this->db->where('pg.end_promogame >=', $sampai);
        $query = $this->db->get();
		if($query->num_rows() > 0){
		    return $query->result_array();
		}else{
		    return false;
		}
        }
	
	//==== Check table agent game ====//
	function checkAgentGame($id_promogame, $kode_agent){
//	$this->db->select('pgd.*, an.*');
//        $this->db->from('agent_game an');
//        $this->db->join('promogame_detail pgd','an.id_promogame = pgd.id_promogame');
//	$this->db->where('an.id_promogame ', $id_promogame);
//	$this->db->where('an.kode_agent ', $kode_agent);
//        $query = $this->db->get();
//	if($query->num_rows() > 0){
//	    return $query->result_array();
//	}else{
//	    return false;
//	}
		
		$this->db->where('id_promogame ', $id_promogame);
		$this->db->where('kode_agent ', $kode_agent);
		$query = $this->db->get('agent_game');
		if($query->num_rows() > 0){
		    return $query->row();
		}else{
		    return false;
		}
	}
}
	
?>