<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(array('admin_model','down_model'));
        
        
    }
    
    public function check_trans( $tanggal ) {
    	if ( preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$tanggal) ) :
		$GET_DATA = 'http://103.29.4.131:8899/PointReward.svc/SalesByDate/'.$tanggal.'/'.$tanggal.'/prpmwps/67YUhjNM';
		
		$GET_DATA       = file_get_contents($GET_DATA);
		$data_booking   = json_decode($GET_DATA);
	  
	  echo "<style>td { font-family: verdana; font-size: 10pt; padding: 5px; text-align: center; }</style><table border=1>";
	  echo "<tr><td>CheckIn</td><td>CheckOut</td><td>City</td><td>Country</td><td>CurrSalesBiling</td><td>CustomerCode</td><td>CustomerName</td><td>HotelName</td><td>InvoiceDate</td><td>InvoiceNumber</td><td>Night</td><td>PNRNumber</td><td>PaxName</td><td>Quantity</td><td>Room</td><td>SalesBase</td><td>SatlementDate</td><td>UserID</td><td>WebInvoiceNumber</td></tr>";
	  $head = true;
	  foreach( $data_booking->PointRewardDatas as $key => $value ) :
?>
<tr>
<td><?php echo $value->CheckIn; ?></td>
<td><?php echo $value->CheckOut; ?></td>
<td><?php echo $value->City; ?></td>
<td><?php echo $value->Country; ?></td>
<td><?php echo $value->CurrSalesBiling; ?></td>
<td><?php echo $value->CustomerCode; ?></td>
<td><?php echo $value->CustomerName; ?></td>
<td><?php echo $value->HotelName; ?></td>
<td><?php echo $value->InvoiceDate; ?></td>
<td><?php echo $value->InvoiceNumber; ?></td>
<td><?php echo $value->Night; ?></td>
<td><?php echo $value->PNRNumber; ?></td>
<td><?php echo $value->PaxName; ?></td>
<td><?php echo $value->Quantity; ?></td>
<td><?php echo $value->Room; ?></td>
<td><?php echo $value->SalesBase; ?></td>
<td><?php echo $value->SatlementDate; ?></td>
<td><?php echo $value->UserID; ?></td>
<td><?php echo $value->WebInvoiceNumber; ?></td>
</tr>
<?php
				endforeach;
				echo "</table>";
			else :
				die( "Date format must be 'YYYY-MM-DD'
				<br>
				Example use, if you want to check transaction date 1 August 2015 : http://www.mgfriends.com/admin/cron/check_trans/2015-08-01
				
				" );
			
			endif;
	
    }
    
//    public function trans(){
//	@set_time_limit(0);
//	ob_clean();
//	$dateInput	= $this->input->post('date_search');
//	$tanggal 	= date('Y-m-d', strtotime('-5 day'));
//	if($dateInput > $tanggal){
//	    $alert 		= 'Tanggal yang dimasukan lebih dari tanggal di sistem';		
//	    $returnVal 		= 'failed';
//	}else{	
//	    if(!empty($dateInput)){
//		$tanggal	= $dateInput ;
//	    }
//        $GET_DATA 	= 'http://103.29.4.131:8899/PointReward.svc/SalesByDate/'.$tanggal.'/'.$tanggal.'/prpmwps/67YUhjNM';
//    
//        $GET_DATA       = file_get_contents($GET_DATA);
//        $data_booking   = json_decode($GET_DATA);
//        //echo '<pre>',print_r($data_booking),'</pre>';die();
//        $check_promo = $this->down_model->check_promo($tanggal, $tanggal);
//        
//        if($check_promo){
//            foreach($data_booking->PointRewardDatas as $key => $value){
//                $quantity       = $value->Quantity ;
//                $vPoint         = array();
//                $point          = 1 ;
//                $CountryPoint   = array(1);
//                $CityPoint      = array(1);
//                $HotelPoint     = array(1);
//                
//                foreach($check_promo as $promo){
//                    
//                    $point_promo       = $promo['point_promo'];
//                    
//                    if(strtoupper($value->Country) == strtoupper($promo['nama_promo'])){
//                        array_push($CountryPoint, $point_promo);
//                    }
//                    
//                    if(strtoupper($value->City) == strtoupper($promo['nama_promo'])){
//                        array_push($CityPoint, $point_promo);
//                    }
//                    
//                    if(strtoupper($value->HotelName) == strtoupper($promo['nama_promo'])){
//                        array_push($HotelPoint, $point_promo);
//                    }                       
//                }
//                
//                $point          = max(max($CountryPoint), max($CityPoint), max($HotelPoint));
//                $quantityUP     = $quantity * $point ;
//                
//                $user_id        = $value->UserID ;
//                $namaHotel      = $value->HotelName ;
//                $City           = $value->City ;
//                $Country        = $value->Country ;            
//                $room           = $value->Room ;
//                $night          = $value->Night ;
//                $roomnight      = $quantity ;
//                $point_promo    = $quantityUP ;
//                //Convert CheckIn to datetime 
//                $CheckIn        = substr($value->CheckIn, 0, 10);
//                
//                $fromdate       = $CheckIn ;
//                
//                //Convert CheckOut to datetime
//                $CheckOut       = substr($value->CheckOut, 0, 10);
//                
//                $todate         = $CheckOut ;
//                
//                //Convert SatlementDate to datetime 
//                $satlementDate  = substr($value->SatlementDate, 0, 10);
//                
//                $satlement_date = $satlementDate ;
//                
//                $web_Invoice    = $value->WebInvoiceNumber ;
//                $kode_agent     = $value->CustomerCode;
//                $GroupLineNo	= $value->GroupLineNo;
//		$PNR		= $value->PNR;
//		$PNRNumber	= $value->PNRNumber;
//		$PaxName	= $value->PaxName;
//		$SalesBase	= $value->SalesBase;
//		$VoucherNumber	= $value->VoucherNumber;
//		$InvoiceNumber	= $value->InvoiceNumber;
//                $AgentName	= $value->CustomerName;
//		
//                //$insert         = $this->down_model->do_insertTransaction($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night,
//		//$roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName);
//		
//		$insert[]         = array($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night,
//		$roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName);
//            }
//	    echo '<pre>',print_r($insert);die();
//            $count              = $this->down_model->countPointTransaction();
//            if($count){
//                $alert = 'Transaction success to insert';		
//                $returnVal = 'success';
//            }else{
//                $alert = 'Gagal , silahkan hubungi IT';		
//                $returnVal = '';
//            }
//            
//	//menampilkan seluruh hotel dalam tabel transaction hotel booking
//	$hotelListTransaction	= $this->down_model->getAllDataColumn('hotel','transaction_table');
//	
//	//hotel yang terdapat di list hotel history
//	$Hotels = $this->db
//                ->select('name')
//                ->get('list_hotel_di_history')->result_array();
//            
//	$nameHotels = array();
//	foreach($Hotels as $row){
//	    $nameHotels[] = $row['name'];
//	}
//	//END hotel yang terdapat di list hotel history
//	
//	//mencari nama hotel yang belum ada di tabel list hotel history
//	foreach($hotelListTransaction as $hotel){
//	    if(array_search($hotel['hotel'],$nameHotels) === FALSE){
//		$hotelList[]	= array(
//		    'name'	=> $hotel['hotel']				
//		);
//	    }
//	}
//	
//	//Insert Hotel baru yang terdapat di tabel transaction hotel booking ke tabel list hotel history
//	$insertHotel	= $this->db->insert_batch('list_hotel_di_history',$hotelList);
//	    
//        }else{
//            foreach($data_booking->PointRewardDatas as $key => $value){
//                $quantity       = $value->Quantity ;
//                $quantityUP     = ($quantity * 1) ;
//                
//                $user_id        = $value->UserID ;
//                $namaHotel      = $value->HotelName ;
//                $City           = $value->City ;
//                $Country        = $value->Country ;            
//                $room           = $value->Room ;
//                $night          = $value->Night ;
//                $roomnight      = $quantity ;
//                $point_promo    = $quantityUP ;
//                
//                //Convert CheckIn to datetime 
//                $CheckIn            = substr($value->CheckIn, 0, 10);
//                
//                $fromdate           = $CheckIn ;
//                
//                //Convert CheckOut to datetime
//                $CheckOut           = substr($value->CheckOut, 0, 10);
//                
//                $todate             = $CheckOut ;
//                
//                //Convert SatlementDate to datetime 
//                $satlementDate      = substr($value->SatlementDate, 0, 10);
//                
//                $satlement_date     = $satlementDate ;
//                
//                $web_Invoice    = $value->WebInvoiceNumber ;
//                $kode_agent     = $value->CustomerCode;
//		$GroupLineNo	= $value->GroupLineNo;
//		$PNR		= $value->PNR;
//		$PNRNumber	= $value->PNRNumber;
//		$PaxName	= $value->PaxName;
//		$SalesBase	= $value->SalesBase;
//		$VoucherNumber	= $value->VoucherNumber;
//		$InvoiceNumber	= $value->InvoiceNumber;
//		$AgentName	= $value->CustomerName;
//		
//                //$insert[]         = $this->down_model->do_insertTransaction($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night,
//		//$roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName);
//		
//		$insert[]         = array($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night,
//		$roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName);
//                
//            }
//            echo '<pre>',print_r($insert);die();
//            $count              = $this->down_model->countPointTransaction();
//            if($count){
//                $alert = 'Transaction success to insert';		
//                $returnVal = 'success';
//            }else{
//                $alert = 'Gagal , silahkan hubungi IT';		
//                $returnVal = '';
//            }
//            //menampilkan seluruh hotel dalam tabel transaction hotel booking
//	$hotelListTransaction	= $this->down_model->getAllDataColumn('hotel','transaction_table');
//	
//	//hotel yang terdapat di list hotel history
//	$Hotels = $this->db
//                ->select('name')
//                ->get('list_hotel_di_history')->result_array();
//            
//	$nameHotels = array();
//	foreach($Hotels as $row){
//	    $nameHotels[] = $row['name'];
//	}
//	//END hotel yang terdapat di list hotel history
//	
//	//mencari nama hotel yang belum ada di tabel list hotel history
//	foreach($hotelListTransaction as $hotel){
//	    if(array_search($hotel['hotel'],$nameHotels) === FALSE){
//		$hotelList[]	= array(
//		    'name'	=> $hotel['hotel']				
//		);
//	    }
//	}
//	
//	//Insert Hotel baru yang terdapat di tabel transaction hotel booking ke tabel list hotel history
//	$insertHotel	= $this->db->insert_batch('list_hotel_di_history',$hotelList);
//	
//        }}
//	
//	echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal)); 
//        
//    }
        
    public function Agent(){
        $GET_DATA       = 'http://103.29.4.131:8899/PointReward.svc/Customers/prpmwps/67YUhjNM';
        $GET_DATA       = file_get_contents($GET_DATA);
        $data_agent     = json_decode($GET_DATA);
        //echo '<pre>',print_r($data_agent),'</pre>';die();
        
        foreach($data_agent as $key => $value){
            $Address     = $value->Address ;
            $kodeAgent   = $value->CustomerCode ;
            $agentName   = $value->CustomerName ;
            $agentEmail  = $value->Email ;
            $agentPhone  = $value->Phone ;
            $insert[]     = $this->down_model->insertAgent($Address, $kodeAgent, $agentName, $agentEmail, $agentPhone);             
            //echo $this->db->last_query().'<br/><br/>';
        }
        //echo '<pre>',print_r($insert),'</pre>';die();
        if($insert){
            $alert = 'Transaction success to insert';		
            $returnVal = 'success';
        }else{
            $alert = 'Gagal , silahkan hubungi IT';		
            $returnVal = '';
        }
        echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal));   
    }
    
    public function trans(){
	ini_set('memory_limit', '-1');
	ini_set('display_errors', 1);
	ob_clean();
	$dateInput	= $this->input->post('date_search');
	$Today 		= date('Y-m-d', strtotime('-5 day'));
	if($dateInput > $Today){
	    $alert 		= 'Tanggal yang dimasukan lebih dari tanggal di sistem';		
	    $returnVal 		= 'failed';
	}else{
	$tanggal	= $Today ;
	if(!empty($dateInput)){
	    $tanggal	= $dateInput ;
	}
        $GET_DATA 	= 'http://103.29.4.131:8899/PointReward.svc/SalesByDate/'.$tanggal.'/'.$tanggal.'/prpmwps/67YUhjNM';
	$GET_DATA       = file_get_contents($GET_DATA);
        $data_booking   = json_decode($GET_DATA);
	
	
	$tanggalMin10	= date_create($tanggal);
	$tanggalMin10	= date_sub($tanggalMin10, date_interval_create_from_date_string('5 days'));
	$tanggalMin10	= date_format($tanggalMin10, 'Y-m-d');
	
        //echo '<pre>',print_r($data_booking);die();
        $check_promo 		= $this->down_model->check_promo($tanggalMin10, $tanggal);
	//echo $this->db->last_query();
	
	$tanggal_sekarang	= date('Y-m-d');
	//$check_promoGame 	= $this->down_model->check_promoGame($tanggal, $tanggal, $tanggal_sekarang);
	//echo '<pre>',print_r($data_booking->PointRewardDatas);die();
        foreach($data_booking->PointRewardDatas as $key => $value){
	    $quantity       = $value->Quantity ;
	    $vPoint         = array();
	    $point          = 1 ;
	    $CountryPoint   = array(1);
	    $CityPoint      = array(1);
	    $HotelPoint     = array(1);
	    //Convert CheckIn to datetime 
	    $CheckInHotelBooking        	= substr($value->CheckIn, 0, 10);	    
	    $checkInHotel		       	= $CheckInHotelBooking ;
	    
	    //Convert CheckOut to datetime
	    $CheckOutHotelBooking		= substr($value->CheckOut, 0, 10);	    
	    $checkOutHotel         		= $CheckOutHotelBooking ;
	    //fitur promo point
	    $daysfromcut	= '' ;
	    $point  = max(max($CountryPoint), max($CityPoint), max($HotelPoint));
	    $Hasil_point_yang_didapat = $quantity * $point ;
	    if($check_promo){
		//sortir dulu baru foreach lagi
		foreach($check_promo as $promo){
		    if(strtoupper(trim($value->Country, " \t.")) == strtoupper(trim($promo['nama_promo'], " \t.")) || strtoupper(trim($value->City, " \t.")) == strtoupper(trim($promo['nama_promo'], " \t.")) || strtoupper(trim($value->HotelName, " \t.")) == strtoupper(trim($promo['nama_promo'], " \t."))){			
			
			$point_promo	= $promo['point_promo'];
		
			if(strtoupper(trim($value->Country, " \t.")) == strtoupper(trim($promo['nama_promo'], " \t."))){
			    array_push($CountryPoint, $point_promo);
			    
			}
			
			if(strtoupper(trim($value->City, " \t.")) == strtoupper(trim($promo['nama_promo'], " \t."))){
			    array_push($CityPoint, $point_promo);
			}
			
			if(strtoupper(trim($value->HotelName, " \t.")) == strtoupper(trim($promo['nama_promo'], " \t."))){
			    array_push($HotelPoint, $point_promo);
			}
			
			$promodatestart = $promo['date_from'] ;
			$promodateEnd 	= $promo['date_to'] ;
			if(strtotime($checkOutHotel) >= strtotime($promodateEnd)){
			    if(strtotime($promodatestart) >= strtotime($checkInHotel)){
				$datediff = strtotime($checkOutHotel) - strtotime($promodatestart);
				$daysfromcut = floor($datediff/(60*60*24));
			    }elseif(strtotime($promodateEnd) <= strtotime($checkInHotel)){
				$datediff = strtotime($checkOutHotel) - strtotime($promodateEnd);
				$daysfromcut = floor($datediff/(60*60*24));
			    }			    
			}else{
			    if(strtotime($promodatestart) >= strtotime($checkInHotel)){
				$datediff = strtotime($promodatestart) - strtotime($checkInHotel);
				$daysfromcut = floor($datediff/(60*60*24));
			    }elseif(strtotime($promodateEnd) <= strtotime($checkInHotel)){
				$datediff = strtotime($checkOutHotel) - strtotime($promodateEnd);
				$daysfromcut = floor($datediff/(60*60*24));
			    }	
			}
			
		    $point  = max(max($CountryPoint), max($CityPoint), max($HotelPoint));
		    $selisihHari = (($value->Room >= 1) ? ($value->Room * $daysfromcut) : $daysfromcut ) ;
		    $Hasil_point_yang_didapat = ((($quantity - $selisihHari) * $point ) + $selisihHari ) ;
		    	
		    }		    
		}
		
	    }
	    //$checkInHotel = $checkInHotel ;
	    //$checkOutHotel = $checkOutHotel;		
	    //$promodatestart = $promodatestart;
	    //$promodateEnd = $promodateEnd;
	    
	//    $date_tohotelBooking[]		= array(
	//					'promo_toStart' => $promodatestart
	//					,'promo_toEnd' => $promodateEnd
	//					,'Check_IN' => $checkInHotel
	//					,'Check_OUT' => $checkOutHotel
	//					,'Nama_hotel' => $value->HotelName
	//					,'Point_Promo' => $point
	//					,'Night' => $value->Night
	//					,'Room' => $value->Room
	//					,'RN' => $quantity
	//					,'Hasil_selisih' => $daysfromcut
	//					,'Hasil_yg_didapat' => $Hasil_point_yang_didapat
	//					);
	    //fitur promo game
	//    if($check_promoGame){
	//	//echo '<pre>',print_r($check_promoGame);
	//	foreach($check_promoGame as $promoGame){
	//	    if(strtoupper(trim($value->City, " \t.")) == strtoupper(trim($promoGame['city_gamedetail'], " \t."))){
	//		//Check to table agent game
	//		$checkAgentGame = $this->down_model->checkAgentGame($promoGame['id_promogame'], $value->CustomerCode);
	//		if($checkAgentGame){
	//		    //update
	//		    //echo '<pre>',print_r($checkAgentGame);
	//		    //$stepComplete = array($checkAgentGame->step_completegame);
	//		    //echo '<pre>',print_r($stepComplete);die();
	//		    $n	= $checkAgentGame->step_completegame.','.$promoGame['id_detailgame'];
	//		    $d	= explode(',', $n);
	//		    $t	= array();
	//		    foreach($d as $key=> $dc){
	//			if(in_array($dc, $t) == false){
	//			    $t[]=$dc;
	//			}
	//		    }
	//		    
	//		    $key = array('id_AgentGame' => $checkAgentGame->id_AgentGame);
	//		    $dataUpdate = array(
	//			'step_completegame'	=> implode(',',$t),
	//			'update_create'		=> date('Y-m-d H:i:s')
	//		    );
	//		    
	//		    $UpdateStep = $this->general_model->updateData('agent_game', $dataUpdate, $key);
	//		    
	//			//if(!in_array($promoGame['id_detailgame'],$stepComplete) === TRUE){
	//			//    //$stepComplete[] = $promoGame['id_detailgame'];
	//			//    //update step complete
	//			//    foreach($stepComplete as $key => $steps){
	//			//	if($steps[$key] !== $promoGame['id_detailgame']){
	//			//	    $key = array('id_AgentGame' => $checkAgentGame->id_AgentGame);
	//			//	    $dataUpdate = array(
	//			//		'step_completegame'	=> $checkAgentGame->step_completegame.','.$promoGame['id_detailgame'],
	//			//		'update_create'		=> date('Y-m-d H:i:s')
	//			//	    );
	//			//	    
	//			//	    $UpdateStep = $this->general_model->updateData('agent_game', $dataUpdate, $key);
	//			//	}
	//			//    }
	//			//    
	//			//}
	//		}else{
	//		    //insert
	//		    $data = array(
	//			'kode_agent'		=> $value->CustomerCode,
	//			'id_promogame'		=> $promoGame['id_promogame'],
	//			'step_completegame'	=> $promoGame['id_detailgame'],
	//			'date_create'		=> date('Y-m-d H:i:s')
	//		    );
	//		    $insert = $this->general_model->insertData('agent_game', $data);
	//		}
	//		
	//	    }
	//	}
	//	
	//    }
	    
	    
	    //$quantityUP     = $quantity * $point ;
	    $quantityUP     = $Hasil_point_yang_didapat;
	    
	    $user_id        = $value->UserID ;
	    $namaHotel      = $value->HotelName ;
	    $City           = $value->City ;
	    $Country        = $value->Country ;            
	    $room           = $value->Room ;
	    $night          = $value->Night ;
	    $roomnight      = $quantity ;
	    $point_promo    = $quantityUP ;
	    //Convert CheckIn to datetime 
	    $CheckIn        = substr($value->CheckIn, 0, 10);
	    
	    $fromdate       = $CheckIn ;
	    
	    //Convert CheckOut to datetime
	    $CheckOut       = substr($value->CheckOut, 0, 10);
	    
	    $todate         = $CheckOut ;
	    
	    //Convert SatlementDate to datetime 
	    $satlementDate  = substr($value->SatlementDate, 0, 10);
	    
	    $satlement_date = $satlementDate ;
	    
	    $web_Invoice    = $value->WebInvoiceNumber ;
	    $kode_agent     = $value->CustomerCode;
	    $GroupLineNo    = $value->GroupLineNo;
	    $PNR	    = $value->PNR;
	    $PNRNumber	    = $value->PNRNumber;
	    $PaxName	    = $value->PaxName;
	    $SalesBase	    = $value->SalesBase;
	    $VoucherNumber  = $value->VoucherNumber;
	    $InvoiceNumber  = $value->InvoiceNumber;
	    $AgentName      = $value->CustomerName;
	    
	    
	//    try {
	//	$insert         = $this->down_model->do_insertTransaction($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night,
	//	$roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName);
	//    } catch (Exception $e) {
	//	echo 'Caught exception: ',  $e->getMessage(), "\n";
	//    }
	    $insert         = $this->down_model->do_insertTransaction($user_id, $kode_agent, $namaHotel, $City, $Country, $room, $night,
	    $roomnight, $point_promo, $fromdate, $todate, $satlement_date, $web_Invoice, $GroupLineNo, $PNR, $PNRNumber, $PaxName, $SalesBase, $VoucherNumber, $InvoiceNumber, $AgentName);
	    //$insert[]        = array('user_id' => $user_id, 'Kode_Agent' => $kode_agent, 'Nama_Hotel' => $namaHotel, 'City' => $City, 'Country' => $Country, 'Room' => $room, 'Night' => $night,
	    //'Room_Night' => $roomnight, 'Point_Promo' => $point_promo, 'from_date' => $fromdate, 'To_Date' => $todate, 'Satlement_date' => $satlement_date, 'Web_Invoince' => $web_Invoice, 'GroupLine' => $GroupLineNo, 'PNR' => $PNR, 'PNR_Number' => $PNRNumber, 'PaxName' => $PaxName, 'SalesBase' => $SalesBase
	    //, 'VoucherNumber' => $VoucherNumber, 'InvoiceNumber' => $InvoiceNumber, 'AgentName' => $AgentName);
        }
	    //echo '<pre>',print_r($date_tohotelBooking);die();
	    //echo '<pre>',print_r($insert);die();
	
            $count              = $this->down_model->countPointTransaction();
            if($count){
                $alert = 'Transaction success to insert';		
                $returnVal = 'success';
            }else{
                $alert = 'Gagal , silahkan hubungi IT';		
                $returnVal = '';
            }
            
	//menampilkan seluruh hotel dalam tabel transaction hotel booking
	$hotelListTransaction	= $this->down_model->getAllDataColumn('hotel','transaction_table');
	
	//hotel yang terdapat di list hotel history
	$Hotels = $this->db
                ->select('name')
                ->get('list_hotel_di_history')->result_array();
            
	$nameHotels = array();
	foreach($Hotels as $row){
	    $nameHotels[] = $row['name'];
	}
	//END hotel yang terdapat di list hotel history
	
	//mencari nama hotel yang belum ada di tabel list hotel history
	foreach($hotelListTransaction as $hotel){
	    if(array_search($hotel['hotel'],$nameHotels) === FALSE){
		$hotelList[]	= array(
		    'name'	=> $hotel['hotel']				
		);
	    }
	}
	
	//Insert Hotel baru yang terdapat di tabel transaction hotel booking ke tabel list hotel history
	$insertHotel	= $this->db->insert_batch('list_hotel_di_history',$hotelList);
	   
        }
	
	echo json_encode((object) array('alert'=>$alert,'returnVal'=>$returnVal)); 
        
    }
}