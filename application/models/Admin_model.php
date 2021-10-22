<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    //ADD ROLE
    public function add_role()
    {
        $data =  $this->input->post('role');
        $this->db->insert('user_role', ['role' => $data]);
    }
    
    //EDIT ROLE
    public function edit_role()
    {
        $data = [
            'role' => $this->input->post('role'),
        ];
        
        $this->db->where('id', $this->input->post('id'));
        
        $this->db->update('user_role', $data);
    }
    
    // DELETE ROLE
    public function del_role($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    }
}