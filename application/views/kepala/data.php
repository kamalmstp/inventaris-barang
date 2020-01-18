<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Data Kepala Instansi
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open(); ?>

                <?php foreach ($kepala as $row) { ?>
                <div class="row form-group">
                    <table  class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                        <tr>
                            <td>Nama Kepala</td>
                            <td> : </td>
                            <td><?=$row['nama_kepala']?></td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td> : </td>
                            <td><?=$row['nip']?></td>
                        </tr>
                    </table>
                </div>
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                    <a href="<?= base_url('kepala/edit/') . $row['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> Ubah
                    </a>
                    </div>
                </div>
                <?php } ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
