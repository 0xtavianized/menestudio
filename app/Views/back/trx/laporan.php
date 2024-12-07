<?= $this->extend('back/layouts/main'); ?>
<?= $this->section('content'); ?>
<?= $this->section('sidebar') ?>
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/dashboard'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url() ?>users" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url() ?>admin/users">Semua</a>
            <a class="collapse-item" href="<?= base_url() ?>admin/users/admin">Admin</a>
            <a class="collapse-item" href="<?= base_url() ?>admin/users/pelanggan">Pelanggan</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" href="<?= base_url() ?>admin/paket">
        <i class="fas fa-fw fa-box"></i>
        <span>Paket</span></a>
</li>

<!-- Nav Item - Transaksi -->
<li class="nav-item active">
    <a class="nav-link" href="<?= base_url() ?>admin/transaksi">
        <i class="fas fa-fw fa-table"></i>
        <span>Transaksi</span></a>
</li>

<hr class="sidebar-divider d-none d-md-block">

<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
<?= $this->endSection() ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Cetak Laporan Transaksi</h1>
    <p>Silahkan Pilih Transaksi Yang Ingin Dicetak</p>
    <form action="<?= base_url('admin/transaksi/laporan/cetakPdf'); ?>" method="post">
        <div class="row gy-4">
            <div class="form-group col-md-3">
                <label class="row" for="select_all"> Pilih Transaksi : </label>
                <div class="row">
                    <input class="col-xs" type="checkbox" id="select_all"><span class="col-sm">Semua
                        Transaksi</span>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="tanggal_dari">Dari Tanggal:</label>
                <input type="date" class="form-control" name="tanggal_dari" id="tanggal_dari">
            </div>
            <div class="form-group col-md-3">
                <label for="tanggal_sampai">Sampai Tanggal:</label>
                <input type="date" class="form-control" name="tanggal_sampai" id="tanggal_sampai">
            </div>
            <div class="form-group col-md-3">
                <label for="paket">Filter Paket:</label>
                <select class="form-control" name="paket" id="paket">
                    <option value="">Semua Paket</option>
                    <?php foreach ($paket as $p): ?>
                        <option value="<?= $p['id_paket']; ?>"><?= $p['paket']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group table-responsive">
            <label>Transaksi Tertentu:</label><br>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pilih</th>
                        <th>ID Transaksi</th>
                        <th>Waktu Transaksi</th>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>Tanggal Foto</th>
                        <th>Jam Foto</th>
                        <th>Harga</th>
                        <th>Waktu Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi as $trx): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="id_transaksi[]" value="<?= $trx['id_transaksi']; ?>">
                            </td>
                            <td><?= $trx['id_transaksi']; ?></td>
                            <td><?= date('d-m-Y / H:i:s', strtotime($trx['waktu_transaksi'])); ?></td>
                            <td><?= $trx['nama_lengkap']; ?></td>
                            <td><?= $trx['paket']; ?></td>
                            <td><?= $trx['tanggal_foto'] !== '0000-00-00' ? date("d F Y", strtotime($trx['tanggal_foto'])) : '-'; ?>
                            </td>
                            <td><?= $trx['jam_foto'] === '00:00:00' ? '-' : $trx['jam_foto']; ?></td>
                            <td>Rp <?= number_format($trx['harga'], 0, ',', '.'); ?></td>
                            <td><?= $trx['waktu_bayar'] ? date('d-m-Y / H:i:s', strtotime($trx['waktu_bayar'])) : 'Belum Dibayar'; ?>
                            </td>
                            <td><?= $trx['transaction_status'] === 'settlement' ? 'Berhasil' : $trx['transaction_status']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Cetak PDF</button>
        <button type="submit" formaction="<?= base_url('admin/transaksi/laporan/cetakExcel'); ?>"
            class="btn btn-success">Cetak Excel</button>
    </form>
</div>

<?= $this->section('script') ?>

<script src="<?= base_url(); ?>sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/js/demo/datatables-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('select_all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="id_transaksi[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>

<?= $this->endSection() ?>

<?= $this->endSection(); ?>