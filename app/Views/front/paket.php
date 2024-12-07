<?= $this->section('nav-items'); ?>
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="<?= base_url(); ?>">Home<br></a></li>
        <li><a href="<?= base_url(); ?>paket" class="active">Paket</a></li>
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
<section id="produk" class="product-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Daftar Paket</h2>
            <p>Daftar paket foto di Mene Photo Studio</p>
        </div>
        <div class="row">
            <?php if (!empty($paket) && is_array($paket)): ?>
                <?php foreach ($paket as $index => $item): ?>
                    <div class="col-md-4 mb-4 product-card-item <?= $index >= 3 ? 'd-none' : '' ?>">
                        <div class="product-card">
                            <img style="width: 100%; height: 250px; object-fit: cover;"
                                src="<?= base_url('uploads/paket/' . $item['gambar']) ?>" class="img-fluid mb-3"
                                alt="<?= $item['paket'] ?>">
                            <h5><?= $item['paket'] ?></h5>
                            <p class="text-muted"><?= nl2br(esc(str_replace(',', "\n", $item['deskripsi']))); ?></p>
                            <h3 class="text-muted mt-2">Rp <?= number_format($item['harga'], 0, ',', '.') ?></h3>
                            <a href="<?= base_url('book?paket=' . urlencode($item['id_paket'])) ?>"
                                class="btn btn-primary">Booking</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada paket yang tersedia.</p>
            <?php endif; ?>
        </div>
        <div class="text-center">
            <button id="showMoreBtn" class="btn btn-primary mt-3">Show More</button>
            <button id="hideBtn" class="btn btn-secondary mt-3 d-none">Hide</button>
        </div>
    </div>
</section>

<script>
    document.getElementById('showMoreBtn').addEventListener('click', function () {
        const hiddenItems = document.querySelectorAll('.product-card-item.d-none');
        hiddenItems.forEach(item => item.classList.remove('d-none'));
        document.getElementById('showMoreBtn').classList.add('d-none');
        document.getElementById('hideBtn').classList.remove('d-none');
    });

    document.getElementById('hideBtn').addEventListener('click', function () {
        const items = document.querySelectorAll('.product-card-item');
        items.forEach((item, index) => {
            if (index >= 3) item.classList.add('d-none');
        });
        document.getElementById('showMoreBtn').classList.remove('d-none');
        document.getElementById('hideBtn').classList.add('d-none');
    });
</script>
<?= $this->include('front/layouts/footer'); ?>