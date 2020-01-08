<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Pemeliharaan
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('pemeliharaan/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Pemeliharaan
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
                    <th>No Bukti</th>
                    <th>Tgl Pemeliharaan</th>
                    <th>Nama Barang</th>
                    <th>Jenis Pemeliharaan</th>
                    <th>Supplier/Pemelihara</th>
                    <th>Biaya</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($pemeliharaan) :
                    foreach ($pemeliharaan as $bm) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['no_pemeliharaan']; ?></td>
                            <td><?= $bm['tanggal_pemeliharaan']; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['jenis']; ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
                            <td><?= $bm['biaya']; ?></td>
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('pemeliharaan/delete/') . $bm['id'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
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
