<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bidang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Bidang";
        $data['bidang'] = $this->admin->get('bidang');
        $this->template->load('templates/dashboard', 'bidang/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Bidang";
            $this->template->load('templates/dashboard', 'bidang/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->admin->insert('bidang', $input);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('bidang');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('bidang/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Bidang";
            $data['bidang'] = $this->admin->get('bidang', ['id_bidang' => $id]);
            $this->template->load('templates/dashboard', 'bidang/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('bidang', 'id_bidang', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('bidang');
            } else {
                set_pesan('data gagal diedit.');
                redirect('bidang/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('bidang', 'id_bidang', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('bidang');
    }    
}
