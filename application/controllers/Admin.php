<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    //USER ACCESS
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    //ROLE ACCESS
    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id!=', 1);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roleaccess', $data);
        $this->load->view('templates/footer');
    }

    //CHANGE ACCESS
    public function changeaccess()
    {
        $menu_id = $this->input->post('menuid');
        $role_id = $this->input->post('roleid');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if($result->num_rows() < 1)
        {
            $this->db->insert('user_access_menu', $data);
        }
        else
        {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert"> Access changed! </div>');

    }


    //TAMBAH DATA ROLE
    public function add_role()
    {
        $this->load->model('Admin_model', 'admin');

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) 
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed! No role added!
            </div>');
            redirect('admin/role');
        }
        else
        {
            $this->admin->add_role();
            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
                A role added successfully
                </div>');
            redirect('admin/role');
        }

    }

    //EDIT DATA ROLE
    public function edit_role()
    {
        $this->load->model('Admin_model', 'admin');

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) 
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed update role
            </div>');
            redirect('admin/role');
        }
        else
        {
            $this->admin->edit_role();
        
            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
            Role updated successfully
            </div>');
            redirect('admin/role');
        }
    }

    //HAPUS DATA ROLE
    public function del_role($id)
    {
        $this->load->model('Admin_model', 'admin');

        $this->admin->del_role($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
                A role deleted successfully
                </div>');
            redirect('admin/role');
        }
    }

    
}