<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Laporan Data Supplier
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('laporansupplier/cetak') ?>" class="btn btn-sm btn-primary btn-icon-split">
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
                  <th>Nama Supplier</th>
                  <th>Nomor Telepon</th>
                  <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($supplier) :
                    foreach ($supplier as $bm) :
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $bm['nama_supplier']; ?></td>
                          <td><?= $bm['no_telp']; ?></td>
                          <td><?= $bm['alamat']; ?></td>
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
