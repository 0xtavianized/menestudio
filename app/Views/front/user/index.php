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
                    <li><a href="<?= base_url(); ?>transaksi">Transaksi</a></li>
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
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="services-list">
                        <a href="<?= base_url() ?>profile" class="active">Profile</a>
                        <a href="<?= base_url() ?>profile/edit">Edit Profil</a>
                        <a href="<?= base_url() ?>transaksi">Transaksi</a>
                    </div>
                    <h4>Selamat datang <?= $user['nama_lengkap']; ?></h4>
                    <p>Selamat menikmati layanan Mene Photo Studio.</p>
                </div>

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="row-xl" data-aos="fade-up" data-aos-delay="100">
                        <section id="call-to-action" class="call-to-action section accent-background">
                            <div class="container">
                                <div class="row justify-content-between" data-aos="zoom-in" data-aos-delay="100">
                                    <h3>DATA DIRI :</h3>
                                    <div class="col-lg-7">
                                        <div class="text-left">
                                            <div class="services-list">
                                                <a class="active">Nama : <?= $user['nama_lengkap']; ?></a>
                                                <a class="active">Email : <?= $user['email']; ?></a>
                                                <a class="active">Alamat :
                                                    <?= !empty($user['alamat']) ? $user['alamat'] : 'Belum diinput'; ?></a>
                                                <a class="active">No. HP :
                                                    <?= !empty($user['no_hp']) ? $user['no_hp'] : 'Belum diinput'; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 d-flex align-items-stretch" data-aos="fade-up"
                                        data-aos-delay="100">
                                        <div class="team">
                                            <div class="team-member">
                                                <div class="member-img py-1 px-1">
                                                    <img src="<?= !empty($user['foto_profil']) ? base_url('uploads/foto_profil/' . $user['foto_profil']) : base_url('assets/img/default_pp.jpg') ?>"
                                                        alt="Foto Profil" class="img" height="228" width="228">
                                                    <div class="social">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#modalGantiFoto">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <a class="cta-btn col-sm-3 text-center"
                                            href="<?= base_url('profile/edit') ?>">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>

</main>
<div class="modal fade" id="modalGantiFoto" tabindex="-1" aria-labelledby="modalGantiFotoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGantiFotoLabel">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('profile/updatePhoto/' . $user['id_user']) ?>" method="post"
                enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Pilih Foto</label>
                        <input class="form-control" type="file" id="formFile" name="foto_profil" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<?= $this->include('front/layouts/footer'); ?>