<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan Transaksi";
            $this->template->load('templates/dashboard', 'laporan/form', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }

            $this->_cetak($query, $table, $tanggal);
        }
    }

    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

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
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang_masuk') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');
            $pdf->Cell(35, 7, 'No Penerimaan', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Masuk', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Supplier', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_masuk'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_barang_masuk'], 1, 0, 'C');
                $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(40, 7, $d['nama_supplier'], 1, 0, 'L');
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
            
            else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Keluar', 1, 0, 'C');
            $pdf->Cell(35, 7, 'No Pengeluaran', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Keluar', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Bidang', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_barang_keluar'], 1, 0, 'C');
                $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(40, 7, $d['nama_bidang'], 1, 0, 'L');
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
        endif;

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}
