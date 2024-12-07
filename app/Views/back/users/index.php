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
<li class="nav-item active">
    <a class="nav-link collapsed active" href="<?= base_url() ?>users" data-toggle="collapse"
        data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item active" href="<?= base_url() ?>admin/users">Semua</a>
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
<li class="nav-item">
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
    <h1 class="h3 mb-2 text-gray-800">List Pelanggan</h1>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
        </div>
    <?php elseif (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-primary">Tambah User</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>E-Mail</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>Role</th>
                            <th>Foto Profil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($user['nama_lengkap']) ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['no_hp']) ?: 'Masih Kosong' ?></td>
                                <td><?= esc($user['alamat']) ?: 'Masih Kosong' ?></td>
                                <td>
                                    <?php if ($user['role'] == 1): ?>
                                        Admin
                                    <?php elseif ($user['role'] == 2): ?>
                                        Pelanggan
                                    <?php endif; ?>
                                </td>
                                <td><img src="<?= base_url('uploads/foto_profil/' . esc($user['foto_profil'])) ?>"
                                        alt="Belum ada Foto Profil" width="100" height="100"></td>
                                <td>
                                    <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('admin/users/delete/' . $user['id_user']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Registrasi Berhasil</h5>
                <button type="button" class="btn-close" id="closeButton" data-bs-dismiss="modal"
                    aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                Akun berhasil dibuat!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="okButtonFooter">Oke</button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url(); ?>sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url(); ?>sbadmin/js/demo/datatables-demo.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?php if (session()->getFlashdata('sukses')): ?>
    <script>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        document.getElementById('okButtonFooter').addEventListener('click', function () {
            successModal.hide();
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->endSection() ?>