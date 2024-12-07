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
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/users/update/' . $user['id_user']) ?>" enctype="multipart/form-data"
                method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap"
                        value="<?= esc($user['nama_lengkap']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username"
                        value="<?= esc($user['username']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= esc($user['email']) ?>"
                        required>
                </div>
                <div class="row px-2 mb-3">
                    <label for="no_hp" class="form-label">Nomor Telepon</label>
                    <input type="number" class="form-control" id="no_hp" name="no_hp"
                        value="<?= esc($user['no_hp']) ?>">
                </div>
                <div class="row px-2 mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat"
                        value="<?= esc($user['alamat']) ?>">
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" id="role" required>
                        <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Pelanggan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="foto_profil" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="foto_profil" name="foto_profil">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Kosongi jika tidak ingin ubah">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="javascript:void(0);" class="btn btn-secondary" onclick="window.history.back();">Batal</a>
            </form>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>