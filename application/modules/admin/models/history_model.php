<?php
 
class history_model extends CI_Model {
    function __construct(){
         
    }

    function get_history(){
        return $this->db->get('history_user')->result_array();
    }
    
}