<?php
 
class transaction_model extends CI_Model {
    function __construct()
    {
         
    }
    
    function do_insert($user,$hotel,$room,$night,$from,$to)
    {
        $this->db->select('*');
        $this->db->where('user_id', $user);
        $query = $this->db->get('user_table');
        $point = $query->row()->point;
        $point = $point + ($room*$night);
        
        $data = array(
               'point' => $point
            );

        $this->db->where('id', $user);
        $this->db->update('user_table', $data);
        
        $data = array(
            'user_id' => $user,
            'hotel' => $hotel,
            'room' => $room,
            'roomnight' => $room*$night,
            'night' => $night,
            'fromdate' => $from,
            'todate' => $to
        );
        $this->db->insert('transaction_table', $data);
        
    }
        
    function get_approved_user(){
        $this->db->select('*');
        $this->db->where('status', 'approved');
        $query = $this->db->get('user_table');
        return $query->result();
    }
}