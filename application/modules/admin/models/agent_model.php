<?php

class agent_model extends CI_Model {

    function __construct() {
        
    }

    function do_insert($name, $email) {
        $data = array(
            'name' => $name,
            'email' => $email,
            'status' => 'approved'
        );
        $this->db->insert('agent_table', $data);
    }

    function do_update($id, $name, $email) {
        $data = array(
            'name' => $name,
            'email' => $email
        );
        $this->db->where('id', $id);
        $this->db->update('agent_table', $data);
    }

    function do_delete($id) {
        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('id', $id);
        $this->db->update('agent_table', $data);
    }

    function get_agent_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('agent_table');
        return $query->row();
    }

    function check_agent_name($name) {
        $this->db->select('*');
        $this->db->where('name', $name);
        $query = $this->db->get('agent_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_agent_email($email) {

        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get('agent_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function checkKodeAgent($kodeAgent) {
        $this->db->select('kode_Agent');
        $this->db->where('kode_Agent', $kodeAgent);
        $query = $this->db->get('agent_table');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
