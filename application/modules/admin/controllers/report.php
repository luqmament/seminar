<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        //$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Pragma: no-cache');
        //$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('report_model');
        $this->load->library('upload');
        $this->load->library('excel');
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->stencil->layout('admin_default');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_sidebar');
        $CMS_Session    = $this->session->userdata('CMS_logged_in');
        if(empty($CMS_Session['username'])){
            redirect('admin/login');
        }
        //echo '<pre>',print_r($CMS_Session),'</pre>';
        
    }
    
    
    function report_userList(){
        @set_time_limit(0);
        ini_set('memory_limit', '-1');
        ob_clean();
        
        $query = $this->report_model->data_ReportUserList();
        if(!$query)
            return false;
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('user list worksheet');
    
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $this->excel->getActiveSheet()->setCellValue('A1', 'List User MG Friends');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        $this->excel->setActiveSheetIndex(0);
        
        
        
        // Field names in the first row
        // set cell A1 content with some text
        $fields = array('No', 'Name', 'Email Address', 'City', 'Area', 'Point', 'Agent Code', 'Agent Name', 'MG User ID','Nama Bank', 'No Rekening', 'Register Date', 'Approved Date', 'Rekomend By', 'Status User');
        
        $col = 0;
        foreach ($fields as $field)
        {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field);
            $col++;
        }
        
        // Fetching the table data
        $row = 4;
        $no = 1 ;
        $noCol = 0 ;
        foreach($query->result() as $data)
        {
            if($data->status == 1){
                $data->$field     = 'Active' ;
            }else{
                $data->$field     = 'Non Active' ;
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($noCol, $row, $no); 
            $arrItem = array('name', 'email', 'city', 'area', 'point', 'kode_agent', 'agent_name', 'mg_user_id', 'nama_bank', 'no_rekening', 'date_created', 'date_approved', 'sales_rekomend','status');
            
            $col = 1;
            foreach ($arrItem as $field)
            {
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);                
                $col++;
            }
            $no++;
            $row++;
        }
        //make auto size        
        for($col = 'A'; $col !== 'L'; $col++) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        //make border
        $this->excel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($styleArray);
        
        //change the font size
        $this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);
        
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:L3')->getFont()->setBold(true);
        
        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:L1');
        
        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $this->excel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="User MG Friends.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //== Untuk Report History User ==//
    public function report_history(){                
        $periode    = $this->input->post('periode_download');
        $getDate    = explode(" - ", $periode);
        $startDate  = $getDate[0];
        $endDate    = $getDate[1];
            
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('History worksheet');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', 'History User');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        if(!empty($periode)){
            $this->excel->getActiveSheet()->setCellValue('A3', 'Start Date History : '.$startDate);
            $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);
            
            $this->excel->getActiveSheet()->setCellValue('A4', 'End Date History : '.$endDate);
            $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        }
        
        
        //set cell A1 content with some text
        $arrField = array('No', 'Name', 'Address', 'Agent Code', 'Agent Name', 'MG User ID', 'Email User', 'Status History', 'Gift Name', 'Value Gift', 'Point Gift', 'Last Point', 'In Point', 'Out Point', 'Current Point', 'Approved By','Tanggal History', 'Notes');
        
        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 6, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)

        $i = 0;
        foreach($arrCellsTitle as $cells){

            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
            $this->excel->getActiveSheet()->freezePane('A7');
        } 

        $report_history = $this->report_model->data_ReportHistory($startDate,date('Y-m-d', strtotime($endDate. ' + 1 days')));
        
        if($report_history){
        $no=1;
        $startNum = 7;
        foreach ($report_history as $row) {            
            $tanggal_history  = new DateTime($row['date_create']);
            $tanggal_history  = date_format($tanggal_history, 'd M Y H:i');
            
            $arrItem = array($no, $row['name'], $row['address'], $row['kode_agent'], $row['agent_name'], $row['mg_user_id'],$row['email'], $row['status'], $row['gift_name'], $row['value'], $row['point'], $row['last_point'], $row['in_point'], $row['out_point'], $row['current_point'], $row['username'],$tanggal_history, $row['notes']);

            $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
            

            $i = 0;
            foreach($arrCellsItem as $cellsItem){

                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
                $i++;

                //make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            } 

            $no++;
            $startNum++;
        }}
        
        
        //make border
        $this->excel->getActiveSheet()->getStyle('A6:R6')->applyFromArray($styleArray);

        //change the font size
        //$this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:R6')->getFont()->setBold(true);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:R1');
        
        if(!empty($periode)){
        $this->excel->getActiveSheet()->mergeCells('A3:D3');
        $this->excel->getActiveSheet()->mergeCells('A4:D4');
        }
        
        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:R6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:R6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $filename = 'history-user.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    /* untuk report transaksi booking user */    
    public function CheckAavaibilityUserAgent(){
        $kode_agent     = $this->input->post('kode_agent');
        $mg_userId      = $this->input->post('mg_user_id');
        $data = $this->report_model->reportHotelBooking($kode_agent,$mg_userId);
        if($data){
            $returnVal = "success" ;
        }else{
            $returnVal = "failed" ;
        }
        
        echo json_encode((object) array('returnVal'=>$returnVal)); 
    }
    
    public function report_OneUser(){
        $kode_agent     = $this->input->get('kode_agent');
        $mg_userId      = $this->input->get('mg_user_id');
        
        $data = $this->report_model->reportHotelBooking($kode_agent,$mg_userId);
        
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('User transaction booking');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', 'MG Friends');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        
        /*Kode Agent dan MG user ID*/
        $this->excel->getActiveSheet()->setCellValue('A3', 'Kode Agent : '.$kode_agent);
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'MG User ID : '.$mg_userId);
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        
        
        //set cell A1 content with some text
        $arrField = array('No', 'MG User ID', 'Kode Agent', 'Hotel', 'City', 'Country', 'Room', 'Night', 'Room Night', 'Point Promo', 'Check In', 'Check Out', 'Web Invoice');

        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 6, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)

        $i = 0;
        foreach($arrCellsTitle as $cells){

            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
            
        }
        
        //freeze row title
        $this->excel->getActiveSheet()->freezePane('A7');
        
        
        $no=1;
        $startNum = 7;
        foreach ($data as $row) {
            $point_promo    = '' ;
            if($row['point_promo'] > $row['roomnight']){
                $point_promo = ($row['point_promo'] / $row['roomnight']);
            }
            
            $arrItem = array($no, $row['user_id'],$row['kode_agent'], $row['hotel'], $row['city'], $row['country'], $row['room'], $row['night'], $row['roomnight'], $point_promo, $row['fromdate'], $row['todate'], $row['web_Invoice']);

            $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
            

            $i = 0;
            foreach($arrCellsItem as $cellsItem){

                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
                $i++;

                //make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            } 

            $no++;
            $startNum++;
        }


        //make border
        $this->excel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($styleArray);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:M1');
        $this->excel->getActiveSheet()->mergeCells('A3:D3');
        $this->excel->getActiveSheet()->mergeCells('A4:D4');

        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $this->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $filename = $kode_agent.'-'.$mg_userId.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function ReportAllHotelBooking(){
        @set_time_limit(0); 
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('All Hotel Booking');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', 'All Hotel Booking');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);

        //set cell A1 content with some text
        $arrField = array('No', 'MG User ID', 'Kode Agent', 'Hotel', 'City', 'Country', 'Room', 'Night', 'Room Night', 'Point Promo', 'Check In', 'Check Out', 'Web Invoice') ;

        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 3, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)

        $i = 0;
        foreach($arrCellsTitle as $cells){

            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
            $this->excel->getActiveSheet()->freezePane('A4');
        } 


        $data = $this->report_model->reportHotelBooking();
        

        //freeze row title
        $this->excel->getActiveSheet()->freezePane('A4');
        
        
        $no=1;
        $startNum = 4;
        foreach ($data as $row) {
            $point_promo    = '' ;
            if($row['point_promo'] > $row['roomnight']){
                $point_promo = ($row['point_promo'] / $row['roomnight']);
            }
            
            $arrItem = array($no, $row['user_id'],$row['kode_agent'], $row['hotel'], $row['city'], $row['country'], $row['room'], $row['night'], $row['roomnight'], $point_promo, $row['fromdate'], $row['todate'], $row['web_Invoice']);

            $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
            

            $i = 0;
            foreach($arrCellsItem as $cellsItem){

                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
                $i++;

                //make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            } 

            $no++;
            $startNum++;
        }


        //make border
        $this->excel->getActiveSheet()->getStyle('A3:M3')->applyFromArray($styleArray);

        //change the font size
        //$this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:M1');

        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $filename = 'All hotel booking.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        
    }
    
    //Start Here
    public function user_performance(){
        ini_set('memory_limit', '-1');
        $periode    = $this->input->post('periode_Report');
        $getDate    = explode(" - ", $periode);
        $from_date  = $getDate[0];
        $to_date    = $getDate[1];
        $reportBy   = $this->input->post('ReportBy');
    
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($reportBy.' Member perfomance');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', $reportBy.' Member perfomance');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A3', 'Start Date History : '.$from_date);
        //$this->excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A3:B3');
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'End Date History : '.$to_date);
        //$this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A4:B4');
        
        //set cell A1 content with some text
        if($reportBy == 'Agent'){
            $arrField = array('No', 'Agent Name', 'Kode Agent', 'Address', 'Email' , 'Phone', 'City', 'Country', 'Jumlah Point') ;
        }else{
            $arrField = array('No', 'MG User ID', 'Kode Agent', 'Agent Name', 'email', 'City', 'Area', 'Phone', 'Birth Date', 'Jumlah Point') ;    
        }
        

        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 6, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        
        $i = 0;
        foreach($arrCellsTitle as $cells){
            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
        } 

        if($reportBy == 'Agent'){
            $notAgents = array('F471','F472','G168','D300','A604','D384','H954','D792','D052','H824','E117','E600','A434','E494','H847','H062','H705','D260','H347','F333','G074','H877','G416','N002','H452','F037','i429','F667','C226','H685','A563','I420');
            $getTransaksiBooking['transaksi']    = $this->report_model->getTransaksiBookingAgent($from_date,$to_date, $this->config->item('not_agents','agents'));
            //echo $this->db->last_query();die();
            //echo '<pre>',print_r($getTransaksiBooking['transaksi']),'</pre>';die();
            //echo $this->db->last_query();
        }else if ($reportBy == 'AllMemberTop'){
            $getTransaksiBooking['transaksi']    = $this->report_model->getTransaksiBookingUser($from_date,$to_date);    
            // echo '<pre>',print_r($getTransaksiBooking['transaksi']),'</pre>';die();
        }else{
            $getTransaksiBooking['transaksi']    = $this->report_model->getTransaksiBookingUser($from_date,$to_date, 50);
            //echo '<pre>',print_r($getTransaksiBooking['transaksi']),'</pre>';die();
            //echo $this->db->last_query();
        }
        
        if($reportBy != 'AllMemberTop'){
            $index = 0 ;
            foreach($getTransaksiBooking['transaksi'] as $trans){
                if($reportBy == 'Agent'){
                    $getTransaksiBooking['transaksi'][$index]['detail_transaksi']= $this->report_model->detailTransaksibookingsAgent($from_date,$to_date,$trans['kode_agent']);
                    //echo $this->db->last_query();
                    //echo '<pre>',print_r($getTransaksiBooking);
                    $index++;
                    
                }else{
                    $getTransaksiBooking['transaksi'][$index]['detail_transaksi']= $this->report_model->detailTransaksibookings($from_date,$to_date,$trans['kode_agent'],$trans['mg_user_id']);
                    //echo $this->db->last_query();die();
                    $index++;
                }
            }
        }
        //die();
        //freeze row title
        $this->excel->getActiveSheet()->freezePane('A7');
        
        
        $no=1;
        $startNum = 7;
        $startDetail = 8 ;
        foreach ($getTransaksiBooking['transaksi'] as $row) {
            if($reportBy == 'Agent'){
                $arrItem = array($no, $row['name'],$row['kode_agent'], $row['address'], $row['email'], $row['phone'], $row['city'], $row['country'], $row['jumlah_point']);
            }else{
                $arrItem = array($no, $row['mg_user_id'],$row['kode_agent'], $row['AgentName'], $row['email'], $row['city'], $row['area'], $row['phone'], $row['birthdate'], $row['jumlah_point']);
            }
        $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        
        //make color
        $this->excel->getActiveSheet()->getStyle("A".$startNum.":J".$startNum)->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => 'e5dcdc'))));
           
            $i = 0;
            foreach($arrCellsItem as $cellsItem){
            
                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
                $i++;
            
                // make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);                
            }
            
            //$startNum = $startNum + 2;
            if($reportBy != 'AllMemberTop'){
            $startNum = $startNum + 2;
                //set detail transaksi
                /*Untuk title tulisan detail transaksi*/
                $arrFieldDetails = array('Detail Transaksi') ;
                
                $arrCellsTitleDetails = $this->excel->setValueHorizontal($arrFieldDetails, $startDetail, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
                
                $d = 0 ;
                foreach($arrCellsTitleDetails as $cellsDetails){
                    
                    $this->excel->getActiveSheet()->setCellValue($cellsDetails, $arrFieldDetails[$d]);
                    $d++;
                    
                    // make border
                    $this->excel->getActiveSheet()->getStyle($cellsDetails)->applyFromArray($styleArray);
                    $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    
                    
                }
            }
            //$startDetail = $startNum + 1;
            $startDetail = $startNum;
            /*End Untuk title tulisan detail transaksi*/
            if($reportBy != 'AllMemberTop'){
                /*Untuk Data title detail transaksi yang ditampilkan*/
                $arrFieldDetailsHeader = array('Nama Hotel','City', 'Country', 'Room', 'Night', 'RoomNight', 'Point Promo', 'Check In', 'Check Out') ;
                $arrCellsTitleDetailsHeader = $this->excel->setValueHorizontal($arrFieldDetailsHeader, $startDetail, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
                $e = 0 ;
                foreach($arrCellsTitleDetailsHeader as $cellsDetailsheader){
                    
                    $this->excel->getActiveSheet()->setCellValue($cellsDetailsheader, $arrFieldDetailsHeader[$e]);
                
                    // make border
                    $this->excel->getActiveSheet()->getStyle($cellsDetailsheader)->applyFromArray($styleArray);
                    $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    
                    //make the font become bold
                    $this->excel->getActiveSheet()->getStyle('A'.$startDetail.':J'.$startDetail)->getFont()->setBold(true);
                    
                    $e++;                
                }
            }
            $startDetail = $startNum + 1;
            /*ENd Untuk Data title detail transaksi yang ditampilkan*/
            
            if($reportBy != 'AllMemberTop'){
                //Untuk loop detail transaksi user ;
                
                $setmulaiDetailsBooking = $startDetail;
                //set isi detail booking transaksi
                foreach($row['detail_transaksi'] as $rowsDetails){
                    $arrItemDetailsBookingTransaksi = array($rowsDetails['hotel'],$rowsDetails['city'],$rowsDetails['country'],$rowsDetails['room'],$rowsDetails['night'],$rowsDetails['roomnight'],$rowsDetails['point_promo'],$rowsDetails['fromdate'],$rowsDetails['todate']);
                
                    $arrCellsItemDetailsBookingTransaksi = $this->excel->setValueHorizontal($arrItemDetailsBookingTransaksi, $setmulaiDetailsBooking, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
                    
                    $a = 0;
                    foreach($arrCellsItemDetailsBookingTransaksi as $cellsItemDetailsBookings){
                    
                        $this->excel->getActiveSheet()->setCellValue($cellsItemDetailsBookings, $arrItemDetailsBookingTransaksi[$a]);
                        
                    
                        // make border
                        $this->excel->getActiveSheet()->getStyle($cellsItemDetailsBookings)->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                        
                        $a++;
                    }
                    $setmulaiDetailsBooking++;
                }
                //End loop detail transaksi user ;
            }
            
            $startNum = ($reportBy != 'AllMemberTop') ? (($startNum + 1 ) + count($row['detail_transaksi'] )) : ($startNum + 1 );
            $startDetail = $startNum + 1;
            $no++;
        }
        
        //make auto size        
        for($col = 'A'; $col !== 'K'; $col++) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }      
        
        //make border
        $this->excel->getActiveSheet()->getStyle('A6:J6')->applyFromArray($styleArray);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A6:J6')->getFont()->setBold(true);
        
        
        //make color
        $this->excel->getActiveSheet()->getStyle("A6:J6")->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => '66CCFF'))));
        
        //change the font size
        //$this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
        //set row height
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:J1');

        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $filename = $reportBy.'-Performance'.$from_date.'-'.$to_date.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        //$objWriter->save( APPPATH.'/logs/test.xslx' );
    }
    function ClaimedAprroved($tanggalClaimed = ''){
        @set_time_limit(0);
        ob_clean();
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Claimed Approve');
    
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $this->excel->getActiveSheet()->setCellValue('A1', 'List Claimed Reward');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        $this->excel->setActiveSheetIndex(0);
        
        
        
        // Field names in the first row
        // set cell A1 content with some text
        $fields = array('No', 'Kode Agent', 'Agent Name', 'Date Claim', 'User ID', 'UserName', 'Bank Name', 'No Rekening', 'Bank Atas Nama', 'Nama Gift', 'Value', 'Status Claimed');
        
        $col = 0;
        foreach ($fields as $field)
        {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field);
            $col++;
        }
        
        // Fetching the table data
        $dataReportClaimed  = $this->report_model->report_claimed($tanggalClaimed);
        $row = 4;
        $no = 1 ;
        $noCol = 0 ;
        foreach($dataReportClaimed->result() as $data)
        {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($noCol, $row, $no); 
            $arrItem = array('kode_agent', 'agent_name', 'date_claim', 'mg_user_id', 'username', 'nama_bank', 'no_rekening', 'atas_nama_bank', 'giftname', 'value', 'status_req');
            
            $col = 1;
            foreach ($arrItem as $field)
            {
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);               
                $col++;
            }
            $no++;
            $row++;
        }
        //make auto size        
        for($col = 'A'; $col !== 'L'; $col++) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        //make border
        $this->excel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($styleArray);
        
        //change the font size
        $this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);
        
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:L3')->getFont()->setBold(true);
        
        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:L1');
        
        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $this->excel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Claimed.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //report hotel top bookers
    function hotels_tops(){
        $periode    = $this->input->post('periode_Report');
        $getDate    = explode(" - ", $periode);
        $from_date  = $getDate[0];
        $to_date    = $getDate[1];
        $reportBy   = $this->input->post('ReportBy');
        $hotel      = $this->input->post('list_hotels');
        $hotels     = '' ;
        
        if(!empty($hotel)){
            $hotels = $hotel ;
        }
        $reportHotels['hotels'] = $this->report_model->hotel_top($from_date, $to_date, $this->config->item('not_agents','agents'), $hotels);
        $reportHotels['hotels']['detail-agent'] = $this->report_model->HotelsBookingAgent($from_date, $to_date, $hotels, $this->config->item('not_agents','agents'));
        
        //echo $this->db->last_query();
        //echo '<pre>',print_r($reportHotels['hotels']);die();
        
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($reportBy.' perfomance');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', $reportBy.'perfomance');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A3', 'Start Date History : '.$from_date);
        //$this->excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A3:C3');
        $this->excel->getActiveSheet()->getStyle('A3:C3')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'End Date History : '.$to_date);
        //$this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A4:C4');
        $this->excel->getActiveSheet()->getStyle('A4:C4')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setCellValue('A5', 'Hotel : '.$reportHotels['hotels'][0]['hotel']);
        //$this->excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A5:C5');
        $this->excel->getActiveSheet()->getStyle('A5:C5')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setCellValue('A6', 'City : '.$reportHotels['hotels'][0]['city']);
        //$this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A6:C6');
        $this->excel->getActiveSheet()->getStyle('A6:C6')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setCellValue('A7', 'Country : '.$reportHotels['hotels'][0]['country']);
        //$this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A7:C7');
        $this->excel->getActiveSheet()->getStyle('A7:C7')->getFont()->setBold(true);
        
        //set cell A1 content with some text
        $arrField = array('No', 'MG User ID', 'Agent Code', 'Agent Name', 'Check In', 'Check Out', 'Room', 'Night', 'Room Night', 'Point Promo', 'Jumlah Point') ;
        
        
        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 9, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        
        $i = 0;
        foreach($arrCellsTitle as $cells){
            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
        }
        
        //freeze row title
        $this->excel->getActiveSheet()->freezePane('A10');
        
        
        $no=1;
        $startNum = 10;
        //$startDetail = 8 ;
        //$startDetailUser = 11 ;
        foreach($reportHotels['hotels']['detail-agent'] as $row){
            $arrItem        = array($no, $row['mg_user_id'],$row['kode_agent'], $row['AgentName'], $row['fromdate'], $row['todate'], $row['room'], $row['night'], $row['roomnight'], $row['point'],$row['point_promo']);
            $arrCellsItem   = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
            
            $index = 0;
            foreach($arrCellsItem as $cellsItem){
            
                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$index]);
                $index++;
            
                // make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);                
            }
            $startNum++;
            $no++;
        }
        
        
        //foreach ($reportHotels['hotels'] as $row) {    
        //    $arrItem = array($no, $row['hotel'],$row['city'], $row['country'], $row['jumlah']);
        //    $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //
        ////make color
        //$this->excel->getActiveSheet()->getStyle("A".$startNum.":I".$startNum)->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => 'e5dcdc'))));
        //   
        //    $i = 0;
        //    foreach($arrCellsItem as $cellsItem){
        //    
        //        $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
        //        $i++;
        //    
        //        // make border
        //        $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);                
        //    }
        //    
        //    $startNum = $startNum + 2;
        //    
        //    //set detail transaksi
        //    /*Untuk title tulisan detail transaksi*/
        //    $arrFieldDetails = array('List Agent') ;
        //    
        //    $arrCellsTitleDetails = $this->excel->setValueHorizontal($arrFieldDetails, $startDetail, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
        //    
        //    $d = 0 ;
        //    foreach($arrCellsTitleDetails as $cellsDetails){
        //        
        //        $this->excel->getActiveSheet()->setCellValue($cellsDetails, $arrFieldDetails[$d]);
        //        $d++;
        //        
        //        // make border
        //        $this->excel->getActiveSheet()->getStyle($cellsDetails)->applyFromArray($styleArray);
        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //        
        //        
        //    }
        //    //$startDetail = $startNum + 1;
        //    $startDetail = $startNum;
        //    /*End Untuk title tulisan detail transaksi*/
        //    
        //    /*Untuk Data title detail transaksi yang ditampilkan*/
        //    $arrFieldDetailsHeader = array('Kode Agent', 'Agent Name', 'Phone Agent', 'Hotel', 'Check Out') ;
        //    $arrCellsTitleDetailsHeader = $this->excel->setValueHorizontal($arrFieldDetailsHeader, $startDetail, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
        //    $e = 0 ;
        //    foreach($arrCellsTitleDetailsHeader as $cellsDetailsheader){
        //        
        //        $this->excel->getActiveSheet()->setCellValue($cellsDetailsheader, $arrFieldDetailsHeader[$e]);
        //    
        //        // make border
        //        $this->excel->getActiveSheet()->getStyle($cellsDetailsheader)->applyFromArray($styleArray);
        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //        
        //        //make the font become bold
        //        $this->excel->getActiveSheet()->getStyle('A'.$startDetail.':I'.$startDetail)->getFont()->setBold(true);
        //        
        //        $e++;                
        //    }
        //    $startDetail = $startNum + 1;
        //    /*ENd Untuk Data title detail transaksi yang ditampilkan*/
        //    
        //    //Untuk loop detail transaksi user ;
        //    
        //    $setmulaiDetailsBooking = $startDetail;
        //    //set isi detail booking transaksi
        //    foreach($row['detail-agent'] as $rowsDetails){
        //        
        //        
        //        $arrItemDetailsBookingTransaksi = array($rowsDetails['kode_agent'],$rowsDetails['name'],$rowsDetails['phone'],$rowsDetails['hotel'], $rowsDetails['todate']);
        //    
        //        $arrCellsItemDetailsBookingTransaksi = $this->excel->setValueHorizontal($arrItemDetailsBookingTransaksi, $setmulaiDetailsBooking, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //        
        //        $a = 0;
        //        foreach($arrCellsItemDetailsBookingTransaksi as $cellsItemDetailsBookings){
        //        
        //            $this->excel->getActiveSheet()->setCellValue($cellsItemDetailsBookings, $arrItemDetailsBookingTransaksi[$a]);
        //            
        //        
        //            // make border
        //            $this->excel->getActiveSheet()->getStyle($cellsItemDetailsBookings)->applyFromArray($styleArray);
        //            $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //            
        //            //make the font become bold
        //            $this->excel->getActiveSheet()->getStyle('A'.$setmulaiDetailsBooking.':I'.$setmulaiDetailsBooking)->getFont()->setBold(true);
        //            
        //            $a++;
        //        }
        //        
        //        $starttitleusers = $setmulaiDetailsBooking + 1;
        //        
        //         /*Untuk Data title detail transaksi yang ditampilkan*/
        //        $arrFieldUserHeader = array('MG User ID', 'Name', 'Email', 'Room ', 'Night', 'Room Night', 'Point Promo', 'Check OUt') ;
        //        $arrCellsTitleUserHeader = $this->excel->setValueHorizontal($arrFieldUserHeader, $starttitleusers, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
        //        $tus = 0 ;
        //        foreach($arrCellsTitleUserHeader as $cellsUsersheader){
        //            
        //            $this->excel->getActiveSheet()->setCellValue($cellsUsersheader, $arrFieldUserHeader[$tus]);
        //        
        //            // make border
        //            $this->excel->getActiveSheet()->getStyle($cellsUsersheader)->applyFromArray($styleArray);
        //            $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //            
        //            //make the font become bold
        //            //$this->excel->getActiveSheet()->getStyle('A'.$starttitleusers.':I'.$starttitleusers)->getFont()->setBold(true);
        //            
        //            $tus++;                
        //        }
        //        $starttitleusers = $starttitleusers;
        //        /*ENd Untuk Data title detail transaksi yang ditampilkan*/
        //        
        //        
        //        
        //        //$starttitleusers = $setmulaiDetailsBooking + 1;
        //        //foreach($rowsDetails['detail-user'] as $users){
        //        //    $arrItemDetailsBookingTransaksiUsers = array($users['mg_user_id'],$users['name'],$users['email'],$users['room'],$users['roomnight'],$users['point_promo']);
        //        //    $arrCellsItemDetailsBookingTransaksiUsers = $this->excel->setValueHorizontal($arrItemDetailsBookingTransaksiUsers, $startlistUser, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //        //    
        //        //    $def = 0 ;
        //        //    foreach($arrCellsItemDetailsBookingTransaksiUsers as $cellsUsers){
        //        //        
        //        //        $this->excel->getActiveSheet()->setCellValue($cellsUsers, $arrItemDetailsBookingTransaksiUsers[$def]);
        //        //    
        //        //        // make border
        //        //        $this->excel->getActiveSheet()->getStyle($cellsUsers)->applyFromArray($styleArray);
        //        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //        //        
        //        //        //make the font become bold
        //        //        //$this->excel->getActiveSheet()->getStyle('A'.$startlistUser.':I'.$startlistUser)->getFont()->setBold(true);
        //        //        
        //        //        $def++;                
        //        //    }
        //        //    
        //        //    $starttitleusers++;
        //        //}
        //        
        //        $startlistUser = $starttitleusers + 1;
        //        foreach($rowsDetails['detail-user'] as $users){
        //            $arrItemDetailsBookingTransaksiUsers = array($users['mg_user_id'],$users['name'],$users['email'],$users['room'],$users['night'],$users['roomnight'],$users['point_promo'],$users['todate']);
        //            $arrCellsItemDetailsBookingTransaksiUsers = $this->excel->setValueHorizontal($arrItemDetailsBookingTransaksiUsers, $startlistUser, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //            
        //            $def = 0 ;
        //            foreach($arrCellsItemDetailsBookingTransaksiUsers as $cellsUsers){
        //                
        //                $this->excel->getActiveSheet()->setCellValue($cellsUsers, $arrItemDetailsBookingTransaksiUsers[$def]);
        //            
        //                // make border
        //                $this->excel->getActiveSheet()->getStyle($cellsUsers)->applyFromArray($styleArray);
        //                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //                
        //                //make the font become bold
        //                //$this->excel->getActiveSheet()->getStyle('A'.$startlistUser.':I'.$startlistUser)->getFont()->setBold(true);
        //                
        //                $def++;                
        //            }
        //            
        //            $startlistUser++;
        //        }
        //        
        //        $setmulaiDetailsBooking = $startlistUser;
        //        
        //        
        //    }
        //    //End loop detail transaksi user ;
        //    
        //    
        //    $startNum = ($startNum + 1 ) + count($row['detail-agent']) ;
        //    //$startDetail = $startNum + 2 ;
        //    //$startDetailUser = $setmulaiDetailsBooking + 1 ;
        //    $no++;
        //}
        
        //make auto size        
        for($col = 'A'; $col !== 'K'; $col++) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }      
        
        //make border
        $this->excel->getActiveSheet()->getStyle('A9:K9')->applyFromArray($styleArray);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A9:K9')->getFont()->setBold(true);
        
        
        //make color
        $this->excel->getActiveSheet()->getStyle("A9:K9")->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => '66CCFF'))));
        
        //change the font size
        //$this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
        //set row height
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:K1');

        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $filename = $reportBy.'-Performance'.$from_date.'-'.$to_date.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    function destinasi_tops(){
        $periode    = $this->input->post('periode_Report');
        $getDate    = explode(" - ", $periode);
        $from_date  = $getDate[0];
        $to_date    = $getDate[1];
        $reportBy   = $this->input->post('ReportBy');
        $katDest    = $this->input->post('katDest');
        $city       = $this->input->post('list_citys');
        $citys      = '' ;
        if(!empty($city)){
            $citys = $city ;
        }
        $reportDestinasi['destinasi'] = $this->report_model->destinasi_top($from_date, $to_date, $this->config->item('not_agents','agents'), $citys, $katDest);
        $reportDestinasi['destinasi']['detail-hotels'] = $this->report_model->BookingDestinasi($from_date, $to_date, $citys, $this->config->item('not_agents','agents'), $katDest);
        
        //foreach($reportDestinasi['destinasi'] as $lists){
        //    $reportDestinasi['destinasi'][$index]['detail-hotels'] = $this->report_model->BookingDestinasi($from_date, $to_date, $lists['city'], $this->NotAgents, $katDest);
        //    //echo $this->db->last_query();die();
        //    //$indexdestinasiUsers = 0 ;
        //    //foreach($reportDestinasi['destinasi'][$index]['detail-hotels'] as $rows){
        //    //    $reportDestinasi['destinasi'][$index]['detail-hotels'][$indexdestinasiUsers]['details-user'] = $this->report_model->DestinasiBookingUsers($from_date, $to_date,$rows['hotel'], $rows['kode_agent'], $this->NotAgents);
        //    //    $indexdestinasiUsers++;
        //    //    //echo $this->db->last_query();
        //    //}
        //    $index++;
        //    
        //    //echo $this->db->last_query();die();
        //}
        //echo $this->db->last_query();
        //echo '<pre>',print_r($reportDestinasi['destinasi']);die();
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($reportBy.' '.$katDest.' perfomance');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', $reportBy.' '.$katDest.' perfomance');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        
        
        $this->excel->getActiveSheet()->setCellValue('A3', 'Start Date History : '.$from_date);
        //$this->excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A3:C3');
        $this->excel->getActiveSheet()->getStyle('A3:C3')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'End Date History : '.$to_date);
        //$this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A4:C4');
        $this->excel->getActiveSheet()->getStyle('A4:C4')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setCellValue('A5', 'City : '.$citys);
        //$this->excel->getActiveSheet()->getStyle("A4")->getFont()->setSize(12);
        $this->excel->getActiveSheet()->mergeCells('A5:C5');
        $this->excel->getActiveSheet()->getStyle('A5:C5')->getFont()->setBold(true);
        
        //set cell A1 content with some text
        if($katDest == 'Hotels'){
            $arrField = array('No', 'Hotel', 'City', 'Country', 'Check In', 'Check Out', 'Room', 'Night', 'Room Night', 'Point Promo', 'MG User ID', 'Agent Code', 'Agent Name', 'Jumlah Point') ;            
        }else{
            $arrField = array('No', 'MG User ID', 'Agent Code', 'Agent Name', 'Country', 'City', 'Hotel', 'Check In', 'Check Out', 'Room', 'Night', 'Room Night', 'Point Promo', 'Jumlah Point') ;            
        }
        
        
        

        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 7, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        
        $i = 0;
        foreach($arrCellsTitle as $cells){
            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
        }
        
        //freeze row title
        $this->excel->getActiveSheet()->freezePane('A8');
        
        
        $no=1;
        $startNum = 8;
        //$startDetail = 8 ;
        foreach($reportDestinasi['destinasi']['detail-hotels'] as $row){
            if($katDest == 'Hotels'){
                $arrItem = array($no, $row['hotel'], $row['city'], $row['country'], $row['fromdate'], $row['todate'], $row['room'], $row['night'], $row['roomnight'], $row['point'], $row['mg_user_id'], $row['kode_agent'], $row['AgentName'], $row['point_promo']) ;            
            }else{
                $arrItem = array($no, $row['mg_user_id'], $row['kode_agent'], $row['AgentName'], $row['country'], $row['city'], $row['hotel'], $row['fromdate'], $row['todate'], $row['room'], $row['night'], $row['roomnight'], $row['point'], $row['point_promo']) ;            
            }
            
            $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)  
            $i = 0;
            foreach($arrCellsItem as $cellsItem){
            
                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
                $i++;
            
                // make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);                
            }
            $startNum++;
            $no++;
        }
        
        
        //foreach ($reportDestinasi['destinasi'] as $row) {    
        //    $arrItem = array($no, $row['city'], $row['country'], $row['jumlah'], $row['todate']);
        //    $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //
        ////make color
        //$this->excel->getActiveSheet()->getStyle("A".$startNum.":G".$startNum)->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => 'e5dcdc'))));
        //   
        //    $i = 0;
        //    foreach($arrCellsItem as $cellsItem){
        //    
        //        $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
        //        $i++;
        //    
        //        // make border
        //        $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);                
        //    }
        //    
        //    $startNum = $startNum + 2;
        //    
        //    //set detail transaksi
        //    /*Untuk title tulisan detail transaksi*/
        //    $arrFieldDetails = array('Detail Transaksi') ;
        //    
        //    $arrCellsTitleDetails = $this->excel->setValueHorizontal($arrFieldDetails, $startDetail, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
        //    
        //    $d = 0 ;
        //    foreach($arrCellsTitleDetails as $cellsDetails){
        //        
        //        $this->excel->getActiveSheet()->setCellValue($cellsDetails, $arrFieldDetails[$d]);
        //        $d++;
        //        
        //        // make border
        //        $this->excel->getActiveSheet()->getStyle($cellsDetails)->applyFromArray($styleArray);
        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //        
        //        
        //    }
        //    //$startDetail = $startNum + 1;
        //    $startDetail = $startNum;
        //    /*End Untuk title tulisan detail transaksi*/
        //    
        //    /*Untuk Data title detail transaksi yang ditampilkan*/
        //    if($katDest == 'Hotels'){
        //        $arrFieldDetailsHeader = array('Hotels', 'City', 'Room', 'Night', 'Room Night') ;
        //    }else{
        //        $arrFieldDetailsHeader = array('Kode Agent', 'Agent Name', 'Phone', 'Hotels', 'City') ;
        //    }
        //    //$arrFieldDetailsHeader = array('Hotels', 'City', 'Room', 'Night', 'Room Night', 'Jumlah Point') ;
        //    $arrCellsTitleDetailsHeader = $this->excel->setValueHorizontal($arrFieldDetailsHeader, $startDetail, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z) 
        //    $e = 0 ;
        //    foreach($arrCellsTitleDetailsHeader as $cellsDetailsheader){
        //        
        //        $this->excel->getActiveSheet()->setCellValue($cellsDetailsheader, $arrFieldDetailsHeader[$e]);
        //    
        //        // make border
        //        $this->excel->getActiveSheet()->getStyle($cellsDetailsheader)->applyFromArray($styleArray);
        //        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //        
        //        //make the font become bold
        //        $this->excel->getActiveSheet()->getStyle('A'.$startDetail.':G'.$startDetail)->getFont()->setBold(true);
        //        
        //        $e++;                
        //    }
        //    $startDetail = $startNum + 1;
        //    /*ENd Untuk Data title detail transaksi yang ditampilkan*/
        //    
        //    //Untuk loop detail transaksi user ;
        //    
        //    $setmulaiDetailsBooking = $startDetail;
        //    //set isi detail booking transaksi
        //    foreach($row['detail-hotels'] as $rowsDetails){
        //        if($katDest == 'Hotels'){
        //            $arrItemDetailsBookingTransaksi = array($rowsDetails['hotel'],$rowsDetails['city'],$rowsDetails['room'],$rowsDetails['night'],$rowsDetails['roomnight']);
        //        }else{
        //            $arrItemDetailsBookingTransaksi = array($rowsDetails['kode_agent'],$rowsDetails['name'],$rowsDetails['phone'],$rowsDetails['hotel'],$rowsDetails['city']);
        //        }
        //        
        //    
        //        $arrCellsItemDetailsBookingTransaksi = $this->excel->setValueHorizontal($arrItemDetailsBookingTransaksi, $setmulaiDetailsBooking, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //        
        //        $a = 0;
        //        foreach($arrCellsItemDetailsBookingTransaksi as $cellsItemDetailsBookings){
        //        
        //            $this->excel->getActiveSheet()->setCellValue($cellsItemDetailsBookings, $arrItemDetailsBookingTransaksi[$a]);
        //            
        //        
        //            // make border
        //            $this->excel->getActiveSheet()->getStyle($cellsItemDetailsBookings)->applyFromArray($styleArray);
        //            $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //            
        //            //make the font become bold                
        //            $this->excel->getActiveSheet()->getStyle('A'.$setmulaiDetailsBooking.':G'.$setmulaiDetailsBooking)->getFont()->setBold(true);
        //            
        //            $a++;
        //        }
        //        
        //        $starttitleUser = $setmulaiDetailsBooking + 1 ;
        //        $arrItemtittleUser = array('MG user ID','Nama', 'Email User', 'Kode Agent', 'Hotel', 'City', 'Room', 'Night', 'Room Night', 'Point Promo', 'Check Out');
        //        $arrCellsItemTittleUsers = $this->excel->setValueHorizontal($arrItemtittleUser, $starttitleUser, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //        
        //        $tit = 0;
        //        foreach($arrCellsItemTittleUsers as $cellsItemtittleUsersBookings){
        //        
        //            $this->excel->getActiveSheet()->setCellValue($cellsItemtittleUsersBookings, $arrItemtittleUser[$tit]);
        //            
        //        
        //            // make border
        //            $this->excel->getActiveSheet()->getStyle($cellsItemtittleUsersBookings)->applyFromArray($styleArray);
        //            $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //            
        //            //make the font become bold                
        //            //$this->excel->getActiveSheet()->getStyle('A'.$setmulaiDetailsBooking.':G'.$setmulaiDetailsBooking)->getFont()->setBold(true);
        //            
        //            $tit++;
        //        }
        //        
        //        $startDetailUser = $starttitleUser + 1 ;
        //        foreach($rowsDetails['details-user'] as $usersDet){
        //            
        //            
        //            $arrItemDetailsUsersTransaksi = array($usersDet['mg_user_id'],$usersDet['name'],$usersDet['email'],$usersDet['kode_agent'],$usersDet['hotel'], $usersDet['city'], $usersDet['room'], $usersDet['night'], $usersDet['roomnight'], $usersDet['point_promo'], $usersDet['todate']);
        //            $arrCellsItemDetailsUsersTransaksi = $this->excel->setValueHorizontal($arrItemDetailsUsersTransaksi, $startDetailUser, 66); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        //            
        //            $b = 0;
        //            foreach($arrCellsItemDetailsUsersTransaksi as $cellsItemDetailsUsersBookings){
        //            
        //                $this->excel->getActiveSheet()->setCellValue($cellsItemDetailsUsersBookings, $arrItemDetailsUsersTransaksi[$b]);
        //                
        //            
        //                // make border
        //                $this->excel->getActiveSheet()->getStyle($cellsItemDetailsUsersBookings)->applyFromArray($styleArray);
        //                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        //                
        //                //make the font become bold                
        //                //$this->excel->getActiveSheet()->getStyle('A'.$setmulaiDetailsBooking.':G'.$setmulaiDetailsBooking)->getFont()->setBold(true);
        //                
        //                $b++;
        //            }
        //            $startDetailUser++;
        //        }
        //        $setmulaiDetailsBooking = $startDetailUser;
        //    }
        //    //End loop detail transaksi user ;
        //    
        //    
        //    $startNum = ($startNum + 1 ) + count($row['detail-hotels'] );
        //    $startDetail = $startNum + 1;
        //    $no++;
        //}
        
        //make auto size        
        for($col = 'A'; $col !== 'K'; $col++) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }      
        
        //make border
        $this->excel->getActiveSheet()->getStyle('A7:N7')->applyFromArray($styleArray);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A7:N7')->getFont()->setBold(true);
        
        
        //make color
        $this->excel->getActiveSheet()->getStyle("A7:N7")->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => '66CCFF'))));
        
        //change the font size
        //$this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
        //set row height
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:N1');

        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $filename = $reportBy.'-Performance'.$from_date.'-'.$to_date.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    public function Promo_point_report(){
        ob_clean();
        @set_time_limit(0);
        ini_set('memory_limit', '-1');       
        
        $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Report Promo Point');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->setCellValue('A1', 'Report Promo Point');
        $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(20);
        
        //set cell A1 content with some text
        
        $arrField = array('No', 'Kategori Promo', 'Nama Promo', 'Point', 'Date From' , 'Date to') ;
        
        

        $arrCellsTitle = $this->excel->setValueHorizontal($arrField, 3, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        
        $i = 0;
        foreach($arrCellsTitle as $cells){
            $this->excel->getActiveSheet()->setCellValue($cells, $arrField[$i]);
            $i++;
        } 
        //die();
        //freeze row title
        $this->excel->getActiveSheet()->freezePane('A4');
        
        //get data report from database
        $getReportPromoPoint = $this->report_model->ReportPromoPoint();
        
        $no=1;
        $startNum = 4;
        foreach ($getReportPromoPoint as $row) {

        $arrItem = array($no, $row['kategori_promo'],$row['nama_promo'], $row['point_promo'], $row['date_from'], $row['date_to']);

        $arrCellsItem = $this->excel->setValueHorizontal($arrItem, $startNum, 65); //array field, nomer cells, abjad cells (start 65 = A, end 90 = Z)
        
        //make color
        $this->excel->getActiveSheet()->getStyle("A".$startNum.":F".$startNum)->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => 'e5dcdc'))));
           
            $i = 0;
            foreach($arrCellsItem as $cellsItem){
            
                $this->excel->getActiveSheet()->setCellValue($cellsItem, $arrItem[$i]);
                $i++;
            
                // make border
                $this->excel->getActiveSheet()->getStyle($cellsItem)->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);                
            }
            
            $startNum++;
            $no++;
        }
        
        //make auto size        
        for($col = 'A'; $col !== 'K'; $col++) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }      
        
        //make border
        $this->excel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($styleArray);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
        
        
        //make color
        $this->excel->getActiveSheet()->getStyle("A3:F3")->applyFromArray(array("fill" => array("type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array( "rgb" => '66CCFF'))));
        
        //change the font size
        //$this->excel->getActiveSheet()->getStyle()->getFont()->setSize(10);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        //set row height
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        //merge cell
        $this->excel->getActiveSheet()->mergeCells('A1:F1');

        //set aligment to center for that merged cell 
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $filename = 'Report Promo Point.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        //$objWriter->save( APPPATH.'/logs/test.xslx' );
    }
}