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
            <a class="collapse-item" href="<?= base_url() ?>admin/users/admin">Admin</a>
            <a class="collapse-item" href="<?= base_url() ?>admin/users/pelanggan">Pelanggan</a>
        </div>
    </div>
</li>

<li class="nav-item active">
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

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Paket</h1>

    <!-- Form Edit Paket -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/paket/update/' . $paket['id_paket']) ?>" method="post"
                enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="paket" class="form-label">Nama Paket</label>
                    <input type="text" class="form-control" id="paket" name="paket" value="<?= esc($paket['paket']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                        required><?= esc($paket['deskripsi']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" class="form-control" id="harga" name="harga"
                            value="<?= esc($paket['harga']) ?>" required oninput="formatRupiah(this)">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('admin/paket') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        const formattedValue = new Intl.NumberFormat('id-ID').format(value);
        input.value = formattedValue;
    }
</script>

<?= $this->endSection(); ?>