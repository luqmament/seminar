<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
    
    /*function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }*/
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
         
        if ($params == NULL)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';         
        }
         
        return new mPDF(
            '',    // mode - default ''
            '',    // format - A4, for example, default ''
            0,     // font size - default 0
            '',    // default font family
            15,    // margin_left
            15,    // margin right
            16,     // margin top
            16,    // margin bottom
            9,     // margin header
            9,     // margin footer
            'L');  // L - landscape, P - portrait
    }

    public function Make_PDF($view, $data, $file_name) {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $html = $this->load->view($view, $data, true);
        $this->mpdf = new mPDF();
        $this->stylesheet = file_get_contents('css/style.css');
        $this->mpdf->AddPage('L', // L - landscape, P - portrait
                '', '', '', '',
                30, // margin_left
                30, // margin right
                30, // margin top
                30, // margin bottom
                18, // margin header
                12); // margin footer
        $this->mpdf->WriteHTML($html);
        //$this->mpdf->Output($file_name, 'D'); // download force
        $this->mpdf->Output($file_name, 'I'); // view in the explorer

        // for more information rhonalejandro@gmail.com
    }
}