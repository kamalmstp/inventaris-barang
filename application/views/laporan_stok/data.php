<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Laporan Data Stok Barang
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('laporanstok/cetak') ?>" class="btn btn-sm btn-primary btn-icon-split">
                  <span class="icon">
                      <i class="fa fa-print"></i>
                  </span>
                  <span class="text">
                      Cetak
                  </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Sisa Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($stok) :
                    foreach ($stok as $bm) :
                      $masuk = $this->db->select('sum(jumlah_masuk) as total_masuk')->where('barang_id' . '=', $bm['id_barang'])->get('barang_masuk')->row();
                      $keluar = $this->db->select('sum(jumlah_keluar) as total_keluar')->where('barang_id' . '=', $bm['id_barang'])->get('barang_keluar')->row();
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['nama_jenis']; ?></td>
                            <td><?= $bm['nama_satuan']; ?></td>
                            <td><?= "Rp. ".number_format($bm['harga'],2,',','.'); ?></td>
                            <td><?= $masuk->total_masuk; ?></td>
                            <td><?= $keluar->total_keluar; ?></td>
                            <td><?= $bm['stok']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
