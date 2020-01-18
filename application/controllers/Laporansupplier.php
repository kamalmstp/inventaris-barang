<?php
defined('BASEPATH') or exit('No direct script access allowed');

class laporansupplier extends CI_Controller
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
        $data['title'] = "Laporan Data Supplier";
        $data['supplier'] = $this->db->get('supplier')->result_array();
        $this->template->load('templates/dashboard', 'laporan_supplier/data', $data);
    }

    public function cetak()
    {
        $query = $this->db->get('supplier')->result_array();
        $this->_cetak($query);
    }

    private function _cetak($data)
    {
        $this->load->library('CustomPDF');

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Image(base_url('assets/logo.jpeg'), 8, 8, -600);
        $pdf->Cell(190, 7, 'Dinas Penanaman Modal dan Pelayanan Terpadu', 0, 1, 'C');
        $pdf->Cell(190, 7, 'Satu Pintu (DPMPTSP)', 0, 1, 'C');
        $pdf->Cell(190, 7, 'Tanah Laut', 0, 1, 'C');
        $pdf->Line(10,35.1,200,35.1);
        $pdf->SetLineWidth(0.1);
        $pdf->Line(10,35.2,200,35.2);
        $pdf->SetLineWidth(0);
        $pdf->ln(10);
        $pdf->Cell(190, 7, 'Laporan Data Supplier', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
        $pdf->Cell(70, 7, 'Nama Supplier', 1, 0, 'C');
        $pdf->Cell(30, 7, 'No Telepon', 1, 0, 'C');
        $pdf->Cell(85, 7, 'Alamat', 1, 0, 'C');
        $pdf->Ln();

        $no = 1;
        foreach ($data as $d) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
          $pdf->Cell(70, 7, $d['nama_supplier'], 1, 0, 'L');
          $pdf->Cell(30, 7, $d['no_telp'], 1, 0, 'C');
          $pdf->Cell(85, 7, $d['alamat'], 1, 0, 'L');
          $pdf->Ln();
        }
        $pdf->Ln(10);

        $ttd = $this->db->get('ttd')->result_array();
        foreach ($ttd as $row) {
            $pdf->Cell(130, 7, '', 0, 0, 'L');
            $pdf->Cell(70, 7, 'Kepala Dinas', 0, 0, 'L');
            $pdf->Ln(20);
            $pdf->Cell(130, 7, '', 0, 0, 'L');
            $pdf->Cell(70, 7, $row['nama_kepala'], 0, 1, 'L');
            $pdf->Cell(130, 7, '', 0, 0, 'L');
            $pdf->Cell(70, 7, $row['nip'], 0, 0, 'L');
        }

        $file_name = 'LaporanSupplier-'.date('d-m-Y');
        $pdf->Output('I', $file_name);
    }
}
