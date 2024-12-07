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

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
<?= $this->endSection() ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Transaksi</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <a href="<?= base_url('admin/transaksi/laporan') ?>" class="btn btn-primary">Cetak Laporan</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Transaksi</th>
                            <th>Waktu Transaksi</th>
                            <th>Paket</th>
                            <th>Tanggal Foto</th>
                            <th>Jam Foto</th>
                            <th>Harga</th>
                            <th>Waktu Bayar</th>
                            <th>Status</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if (empty($transaksi)): ?>
                            <tr>
                                <td colspan="9" class="text-center">
                                    <br />
                                    <h3 class="text-danger">Belum Ada Transaksi!</h3>
                                    <br />
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($transaksi as $trans): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $trans['id_transaksi']; ?></td>
                                    <td><?= date('d-m-Y / H:i:s', strtotime($trans['waktu_transaksi'])); ?></td>
                                    <td><?= $trans['paket']; ?></td>
                                    <td class="text-center <?= $trans['tanggal_foto'] === '0000-00-00' ? 'h2' : ''; ?>">
                                        <?= $trans['tanggal_foto'] !== '0000-00-00' ? date("d F Y", strtotime($trans['tanggal_foto'])) : '-'; ?>
                                    </td>
                                    <td
                                        class="text-center <?= ($trans['jam_foto'] === '00:00:00' || !$trans['jam_foto']) ? 'h2' : $trans['jam_foto']; ?>">
                                        <?= ($trans['jam_foto'] === '00:00:00' || !$trans['jam_foto']) ? '-' : $trans['jam_foto']; ?>
                                    </td>
                                    <td>Rp <?= number_format($trans['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?= $trans['waktu_bayar'] ? date('d-m-Y / H:i:s', strtotime($trans['waktu_bayar'])) : 'Belum Dibayar'; ?>
                                    </td>
                                    <td>
                                        <strong>
                                            <?= $trans['transaction_status'] === 'settlement' ? 'Berhasil' : $trans['transaction_status']; ?>
                                        </strong>
                                    </td>
                                    <!-- <td>
                                        <a class="btn btn-info"
                                            href="<?= base_url('transaksi/' . $trans['id_transaksi']) ?>">Detail</a>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->section('script') ?>

<script src="<?= base_url(); ?>sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/js/demo/datatables-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
<?= $this->endSection(); ?>