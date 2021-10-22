<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu
                FROM user_sub_menu JOIN user_menu
                ON user_sub_menu.menu_id = user_menu.id";

        return $this->db->query($query)->result_array();
    }

    // delete Menu
    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
    }

    // delete SUBMENU
    public function delsm($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
    }

    //PROSES EDIT MENU
    public function editmenu()
    {
        $data = [
            'menu' => $this->input->post('menu'),
        ];

        $this->db->where('id', $this->input->post('id'));
        
        $this->db->update('user_menu', $data);
    }

    //PROSES EDIT SUBMENU
    public function editsubmenu()
    {
        $data = [
            'title' => $this->input->post('title'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active'),
        ];

        $this->db->where('id', $this->input->post('id'));
        
        $this->db->update('user_sub_menu', $data);
    }
}