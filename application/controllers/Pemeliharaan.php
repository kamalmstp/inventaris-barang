<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemeliharaan extends CI_Controller
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
        $data['title'] = "Pemeliharaan";
        $data['pemeliharaan'] = $this->admin->getPemeliharaan();
        $this->template->load('templates/dashboard', 'pemeliharaan/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('no_pemeliharaan', 'Nomor Pemeliharaan', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jenis', 'Jenisk Pemeliharaan', 'required');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('tanggal_pemeliharaan', 'Tanggal Pemeliharaan', 'required|trim');
        $this->form_validation->set_rules('biaya', 'Biaya', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pemeliharaan";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->admin->get('barang');

            $this->template->load('templates/dashboard', 'pemeliharaan/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('pemeliharaan', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('pemeliharaan');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('pemeliharaan/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('pemeliharaan', 'id', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('pemeliharaan');
    }
}
