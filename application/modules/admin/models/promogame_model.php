<?php
/* Programmer Identification */
/* Nama				: Luqman Hakim */
/* Tanggal Mulai		: Mei 27 2015 */
/* Fungsi File			: Management promo game */
/* End Of Programmer Identification */
Class Promogame_model extends CI_Model
{	
    function __constuct()
    {
            parent::__constuct();  // Call the Model constructor 
            loader::database();    // Connect to current database setting.
    }
	
    function GetAllPromoGame($today){
        $this->db->from('promo_game');
        $this->db->where('DATE_FORMAT(end_promogame, "%Y-%m-%d") >= ',$today); 
        $query =  $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }  

}
	
?>