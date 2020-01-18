<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi extends CI_Controller
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
        $data['title'] = "Mutasi Barang";
        $data['mutasi'] = $this->admin->getMutasi();
        $this->template->load('templates/dashboard', 'mutasi/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_mutasi', 'Tanggal Mutasi', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Mutasi Barang";
            $data['barang'] = $this->admin->get('barang');
            $this->template->load('templates/dashboard', 'mutasi/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('mutasi', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('mutasi');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('mutasi/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('mutasi', 'id', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('mutasi');
    }
}
