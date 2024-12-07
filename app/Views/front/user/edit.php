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
                        <a href="<?= base_url() ?>profile">Profile</a>
                        <a href="<?= base_url() ?>profile/edit" class="active">Edit Profil</a>
                        <a href="<?= base_url() ?>transaksi">Transaksi</a>
                    </div>
                    <h4>Halaman Edit Profil</h4>
                    <p>Silahkan sesuaikan data profil anda.</p>
                </div>

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="team">
                        <div class="col-sm-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="<?= !empty($user['foto_profil']) ? base_url('uploads/foto_profil/' . $user['foto_profil']) : base_url('assets/img/team/team-1.jpg') ?>"
                                        alt="Foto Profil" class="img" height="250" width="250">
                                    <div class="social">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalGantiFoto">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row-xl" data-aos="fade-up" data-aos-delay="100">
                            <form action="<?= base_url('profile/update/' . $user['id_user']) ?>" method="post">
                                <div class="services-list">
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama:</label>
                                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                            value="<?= $user['nama_lengkap']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="<?= $user['email']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat:</label>
                                        <input type="text" id="alamat" name="alamat" class="form-control"
                                            value="<?= !empty($user['alamat']) ? $user['alamat'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp">No. HP:</label>
                                        <input type="text" id="no_hp" name="no_hp" class="form-control"
                                            value="<?= !empty($user['no_hp']) ? $user['no_hp'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password :</label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Kosongi jika tidak ingin ganti password">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                        <input class="form-control" type="file" id="formFile" name="foto_profil" accept="image/*"
                            required>
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