<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->section('nav-items'); ?>
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="<?= base_url(); ?>">Home<br></a></li>
        <li><a href="<?= base_url(); ?>paket">Paket</a></li>
        <li><a href="<?= base_url(); ?>book">Booking</a></li>

        <?php if (session()->get('logged_in')): ?>
            <li class="dropdown"><a
                    href="<?= base_url(); ?>profile"><span><strong><?php echo session()->get('username'); ?></strong></span>
                    <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                    <li><a href="<?= base_url(); ?>profile">Profile</a></li>
                    <li><a href="<?= base_url(); ?>transaksi" class="active">Transaksi</a></li>
                    <hr class="pisah">
                    <li><a href="<?= base_url(); ?>logout" style="color: red;"><strong>Logout</strong></a></li>
                </ul>
            </li>
        <?php else: ?>
        <?php endif; ?>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
<?= $this->endSection(); ?>
<?= $this->include('front/layouts/navbar'); ?>
<main class="main">
    <section id="service-details" class="service-details section">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="services-list">
                        <a href="<?= base_url() ?>profile">Profile</a>
                        <a href="<?= base_url() ?>profile/edit">Edit Profil</a>
                        <a href="<?= base_url() ?>transaksi" class="active">Transaksi</a>
                    </div>
                    <h3>PENTING!</h3>
                    <p>Tunjukkan Detail Transaksi Berikut Kepada Resepsionis Untuk Konfirmasi!</p>
                    <p>MOHON DATANG 15 MENIT SEBELUM SESI FOTO UNTUK MENGHINDARI PEMOTONGAN WAKTU.</p>
                </div>

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="row-xl" data-aos="fade-up" data-aos-delay="100">
                        <section id="call-to-action" class="call-to-action section accent-background">
                            <div class="container">
                                <div class="row justify-content-between" data-aos="zoom-in" data-aos-delay="100">
                                    <h3>DETAIL TRANSAKSI :</h3>
                                    <div class="col-lg">
                                        <div class="text-left">
                                            <div class="services-list">
                                                <a class="active">ID Transaksi : <?= $transaksi['id_transaksi']; ?></a>
                                                <a class="active">Paket : <?= $transaksi['paket']; ?></a>
                                                <a class="active">Tanggal Foto :
                                                    <?= $transaksi['tanggal_foto'] !== '0000-00-00' ? date("d F Y", strtotime($transaksi['tanggal_foto'])) : '-'; ?>
                                                </a>
                                                <a class="active">Jam Foto :
                                                    <?= ($transaksi['jam_foto'] === '00:00:00' || !$transaksi['jam_foto']) ? '-' : $transaksi['jam_foto']; ?>
                                                </a>
                                                <a class="active">Harga : Rp
                                                    <?= number_format($transaksi['harga'], 0, ',', '.'); ?></a>
                                                </a>
                                                <a class="active">
                                                    Status Transaksi : <span
                                                        class="active <?= $transaksi['transaction_status'] === 'settlement' ? 'text-success' : ($transaksi['transaction_status'] === 'Failed' ? 'text-danger' : '') ?>"><strong>
                                                            <?= $transaksi['transaction_status'] === 'settlement' ? 'Berhasil' : $transaksi['transaction_status']; ?></strong>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->include('front/layouts/footer'); ?>