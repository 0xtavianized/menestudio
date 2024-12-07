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
                    <h4>Enim qui eos rerum in delectus</h4>
                    <p>Nam voluptatem quasi numquam quas fugiat ex temporibus quo est. Quia aut quam quod facere ut non
                        occaecati ut aut. Nesciunt mollitia illum tempore corrupti sed eum reiciendis. Maxime modi
                        rerum.</p>
                </div>

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="row-xl" data-aos="fade-up" data-aos-delay="100">
                        <section id="call-to-action" class="call-to-action section accent-background">
                            <div class="container">
                                <div class="row justify-content-between" data-aos="zoom-in" data-aos-delay="100">
                                    <h3>DATA DIRI :</h3>
                                    <div class="col-lg">
                                        <div class="text-left">
                                            <div class="services-list">
                                                <a class="active">ID Transaksi : <?= $transaksi['id_transaksi']; ?></a>
                                                <a class="active">Paket : <?= $transaksi['paket']; ?></a>
                                                <a class="active">Tanggal Foto
                                                    : <?= date("d F Y", strtotime($transaksi['tanggal_foto'])); ?></a>
                                                <a class="active">Jam Foto : <?= $transaksi['jam_foto']; ?></a>
                                                <a class="active">Harga : Rp
                                                    <?= number_format($transaksi['harga'], 0, ',', '.'); ?></a>
                                                </a>
                                                <a class="active">Status Transaksi :
                                                    <?= $transaksi['transaction_status']; ?></a>
                                                <!-- <pre id="result-json"></pre> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-sm-3 text-left">
                                            <button class="cancel-btn" id="cancel-button"
                                                onclick="cancelTrans('<?= $transaksi['id_transaksi'] ?>')">Cancel</button>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <button class="pay-btn" id="pay-button">Bayar</button>
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
<!-- Transaksi Real -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key=""></script>
<!-- Transaksi Sandbox -->
<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key=""></script> -->
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('<?= $snapToken ?>', {
            onSuccess: function (result) {
                const id_transaksi = '<?= $transaksi['id_transaksi'] ?>';

                fetch('<?= base_url('book/checkout') ?>/' + id_transaksi, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_time: result.transaction_time,
                        transaction_status: result.transaction_status,
                        payment_type: result.payment_type,
                        transaction_id: result.transaction_id
                    })
                })
                    .then(response => {
                        console.log(response);
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.status === 'success') {
                            window.location.href = '<?= base_url('transaksi') ?>';
                        } else {
                            alert('Terjadi kesalahan: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            },
            onPending: function (result) {
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            onError: function (result) {
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };
</script>
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
                        window.location.href = '<?= base_url('transaksi') ?>';
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