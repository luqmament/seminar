<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_seminar extends CI_Model {

	function getDataKey($table, $where, $order_by = '', $limit = ''){

		$this->db->where($where);
        if($order_by){
            $this->db->order_by($order_by); 
        }
        ($limit) ? $this->db->limit($limit) : "";
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}	

?>