<?php
defined('BASEPATH') or exit('No direct script access allowed');

class laporanpemeliharaan extends CI_Controller
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
        $data['title'] = "Laporan Data Pemeliharaan";
        $data['pemeliharaan'] = $this->admin->getPemeliharaan();
        $this->template->load('templates/dashboard', 'laporan_pemeliharaan/data', $data);
    }

    public function cetak()
    {
        $query = $this->admin->getPemeliharaan();
        $this->_cetak($query);
    }

    private function _cetak($data)
    {
        $this->load->library('CustomPDF');

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan Pemeliharaan Barang', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
        $pdf->Cell(45, 7, 'No Bukti', 1, 0, 'C');
        $pdf->Cell(27, 7, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Jenis', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Pemelihara', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Biaya', 1, 0, 'C');
        $pdf->Ln();

        $no = 1;
        foreach ($data as $d) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
          $pdf->Cell(45, 7, $d['no_pemeliharaan'], 1, 0, 'L');
          $pdf->Cell(27, 7, $d['tanggal_pemeliharaan'], 1, 0, 'C');
          $pdf->Cell(45, 7, $d['nama_barang'], 1, 0, 'L');
          $pdf->Cell(30, 7, $d['jenis'], 1, 0, 'C');
          $pdf->Cell(20, 7, $d['nama_supplier'], 1, 0, 'L');
          $pdf->Cell(20, 7, $d['biaya'], 1, 0, 'L');
          $pdf->Ln();
        }

        $file_name = 'LaporanStokBarang-'.date('d-m-Y');
        $pdf->Output('I', $file_name);
    }
}
