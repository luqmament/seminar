<?php
 
class Slider_model extends CI_Model {
    function __construct()
    {
         
    }

    function get_category_gift(){
        return $this->db->get('gift_category')->result_array();
    }
    
    function do_insert($filename,$name,$point,$description)
    {
        $data = array(
            'filename' => $filename,
            'name' => addslashes($name),
            'point' => $point,
            'status' => 'approved',
            'description' => $description
        );
        $this->db->insert('gift_table', $data);
    }
    
    function delete_gift($id)
    {
        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('id', $id);
        $this->db->update('gift_table', $data);  
    }

    function update_gift($id,$filename,$name,$point,$description)
    {
        if($filename == ''){
            $data = array(
                'name' => $name,
                'point' => $point,
                'description' => $description
            );
        }else{            
            $data = array(
                'filename' => $filename ,
                'name' => $name,
                'point' => $point,
                'description' => $description
            );
        }
        $this->db->where('id', $id);
        $this->db->update('gift_table', $data); 
    }
    
    function select_by_id_slider($id)
    {
        $this->db->select('*');
        $this->db->where('id_banner', $id);
        $query = $this->db->get('banner_table');
        return $query->row();
    }
    
    function select_data_user($id_user)
    {
        $this->db->select('ut.*,at.id as id_agent_name,at.name as agent_name, at.email as email_agent');
        $this->db->from('user_table ut');
        $this->db->join('agent_table at', 'ut.kode_agent = at.kode_agent');
        $this->db->where('ut.id', $id_user);
        $query =  $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
           return false;
        }
    }

}