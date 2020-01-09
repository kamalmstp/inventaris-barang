<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporanstok extends CI_Controller
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
        $data['title'] = "Laporan Data Stok Barang";
        $data['stok'] = $this->admin->getStok();
        $this->template->load('templates/dashboard', 'laporan_stok/data', $data);
    }

    public function cetak()
    {
        $query = $this->admin->getStok();
        $this->_cetak($query);
    }

    private function _cetak($data)
    {
        $this->load->library('CustomPDF');

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan Stok Barang', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(27, 7, 'Jenis Brg', 1, 0, 'C');
        $pdf->Cell(17, 7, 'Satuan', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Harga Satuan', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Jml Masuk', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Jml Keluar', 1, 0, 'C');
        $pdf->Cell(15, 7, 'Stok', 1, 0, 'C');
        $pdf->Ln();

        $no = 1;
        foreach ($data as $d) {
          $masuk = $this->db->select('sum(jumlah_masuk) as total_masuk')->where('barang_id' . '=', $d['id_barang'])->get('barang_masuk')->row();
          $keluar = $this->db->select('sum(jumlah_keluar) as total_keluar')->where('barang_id' . '=', $d['id_barang'])->get('barang_keluar')->row();
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
          $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
          $pdf->Cell(27, 7, $d['nama_jenis'], 1, 0, 'C');
          $pdf->Cell(17, 7, $d['nama_satuan'], 1, 0, 'C');
          $pdf->Cell(30, 7, $d['harga'], 1, 0, 'L');
          $pdf->Cell(20, 7, $masuk->total_masuk, 1, 0, 'C');
          $pdf->Cell(20, 7, $keluar->total_keluar, 1, 0, 'C');
          $pdf->Cell(15, 7, $d['stok'], 1, 0, 'C');
          $pdf->Ln();
        }

        $file_name = 'LaporanStokBarang-'.date('d-m-Y');
        $pdf->Output('I', $file_name);
    }
}
