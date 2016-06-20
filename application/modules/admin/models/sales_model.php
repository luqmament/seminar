<?php
 
class sales_model extends CI_Model {
    function __construct()
    {
         
    }

    
    function select_by_id_sales($id)
    {
        $this->db->select('*');
        $this->db->where('id_sales', $id);
        $query = $this->db->get('mgf_sales');
        return $query->row();
    }
    
    function check_sales_email($email, $id) {
        $this->db->select('*');
        $this->db->where('email_sales', $email);
        $this->db->where('id_sales !=', $id);
        $query = $this->db->get('mgf_sales');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}