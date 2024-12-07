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
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="row gy-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="services-list col-md-4">
                        <a href="<?= base_url() ?>profile">Profile</a>
                        <a href="<?= base_url() ?>profile/edit">Edit Profil</a>
                        <a href="<?= base_url() ?>transaksi" class="active">Transaksi</a>
                    </div>
                    <div class="col-md-8">
                        <h4>Halaman Transaksi</h4>
                        <p>Ini adalah halaman yang menampilkan seluruh transaksi akun anda pada situs ini.</p>
                    </div>
                </div>
                <div class="col-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="row gy-4 table-responsive">
                        <h3>Daftar Transaksi</h3>
                        <table class="table border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">No.</th>
                                    <th class="text-center" scope="col">ID Transaksi</th>
                                    <th class="text-center" scope="col">Paket</th>
                                    <th class="text-center" scope="col">Tanggal Foto</th>
                                    <th class="text-center" scope="col">Jam Foto</th>
                                    <th class="text-center" scope="col">Harga</th>
                                    <th class="text-center" scope="col">Waktu Bayar</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($transaksi)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <br />
                                            <h3 class="text-danger">Anda Belum Memiliki Transaksi!</h3>
                                            <br />
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($transaksi as $trans): ?>
                                        <tr>
                                            <td class="text-center" scope="row"><?= $no++; ?></td>
                                            <td class="text-center"><?= $trans['id_transaksi']; ?></td>
                                            <td class="text-center"><?= $trans['paket']; ?></td>
                                            <td class="text-center <?= $trans['tanggal_foto'] === '0000-00-00' ? 'h2' : ''; ?>">
                                                <?= $trans['tanggal_foto'] !== '0000-00-00' ? date("d F Y", strtotime($trans['tanggal_foto'])) : '-'; ?>
                                            </td>
                                            <td
                                                class="text-center <?= ($trans['jam_foto'] === '00:00:00' || !$trans['jam_foto']) ? 'h2' : $trans['jam_foto']; ?>">
                                                <?= ($trans['jam_foto'] === '00:00:00' || !$trans['jam_foto']) ? '-' : date("H:i", strtotime($trans['jam_foto'])); ?>
                                            </td>
                                            <td class="text-center">Rp <?= number_format($trans['harga'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <?= $trans['waktu_bayar'] ? date('d-m-Y / H:i:s', strtotime($trans['waktu_bayar'])) : 'Belum Dibayar'; ?>
                                            </td>
                                            <td class="text-center">
                                                <strong>
                                                    <?= $trans['transaction_status'] === 'settlement' ? 'Berhasil' : $trans['transaction_status']; ?>
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($trans['waktu_bayar'] === null && $trans['transaction_status'] !== 'Failed'): ?>
                                                    <a class="btn btn-primary"
                                                        href="<?= base_url('book/pay/' . $trans['id_transaksi']); ?>">Bayar</a>
                                                    <button class="btn btn-danger"
                                                        onclick="cancelTrans('<?= $trans['id_transaksi']; ?>')">Cancel</button>
                                                <?php elseif ($trans['waktu_bayar'] === null && $trans['transaction_status'] === 'Failed'): ?>
                                                    <a class="btn btn-info"
                                                        href="<?= base_url('transaksi/' . $trans['id_transaksi']) ?>">Detail</a>
                                                <?php elseif ($trans['waktu_bayar'] !== null): ?>
                                                    <a class="btn btn-info"
                                                        href="<?= base_url('transaksi/' . $trans['id_transaksi']) ?>">Detail</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function cancelTrans(id_transaksi) {
        if (confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) {
            fetch(`<?= base_url('transaksi/cancel') ?>/${id_transaksi}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }
</script>

<?= $this->include('front/layouts/footer'); ?>