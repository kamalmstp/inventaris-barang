<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kepala extends CI_Controller
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
        $data['title'] = "Data Kepala Instansi";
        $data['kepala'] = $this->admin->get('ttd');
        $this->template->load('templates/dashboard', 'kepala/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_kepala', 'Nama Kepala', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Ubah Kepala Instansi";
            $data['kepala'] = $this->admin->get('ttd', ['id' => $id]);
            $this->template->load('templates/dashboard', 'kepala/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('ttd ', 'id', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('kepala');
            } else {
                set_pesan('data gagal diedit.');
                redirect('kepala/edit/' . $id);
            }
        }
    }
}
