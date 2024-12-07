<?= $this->section('nav-items'); ?>
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="<?= base_url(); ?>" class="active">Home<br></a></li>
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

    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <img src="<?= base_url(); ?>assets/img/hero-bg-abstract.jpg" alt="" data-aos="fade-in" class="">

        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Mene Photo Studio</h1>
                    <p>We are team of talented Photograpers and Editors that can make your special moments more special.
                    </p>
                </div>
            </div>
            <div class="text-center" data-aos="zoom-out" data-aos-delay="100">
                <?php if (session()->get('logged_in')): ?>
                    <a href="<?= base_url(); ?>book" class="btn-get-started">Book Now</a>
                <?php else: ?>
                    <a href="<?= base_url(); ?>login" class="btn-get-started">Book Now</a>
                <?php endif; ?>

            </div>
            <div class="row gy-4 mt-5">
                <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-camera"></i></div>
                        <h4 class="title"><a href="">Kamera Canggih</a></h4>
                        <p class="description">Menggunakan kamera seri terbaru yang canggih</p>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="200">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-gem"></i></div>
                        <h4 class="title"><a href="">Editor Handal</a></h4>
                        <p class="description">Editor foto yang handal dan menggunakan perangkat yang mumpuni</p>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-currency-dollar"></i></div>
                        <h4 class="title"><a href="">Harga Terjangkau</a></h4>
                        <p class="description">Harga yang sangat ramah untuk dompet</p>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="400">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-command"></i></div>
                        <h4 class="title"><a href="">Studio Nyaman</a></h4>
                        <p class="description">Studio foto yang nyaman dan banyak pilihan background</p>
                    </div>
                </div><!--End Icon Box -->

            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- Pricing Section -->
    <section id="pricing" class="pricing section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Pricelist</h2>
            <p>Daftar Pricelist Paket Mene Photo Studio</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row g-4 g-lg-0">

                <?php foreach ($paket as $index => $item): ?>
                    <?php if ($index >= 3)
                        break; ?>
                    <div class="col-lg-4 paket-item" data-aos="zoom-in" data-aos-delay="100">
                        <div class="pricing-item">
                            <h3><?= esc($item['paket']); ?></h3>
                            <h4><sup>Rp</sup><?= number_format($item['harga'], 0, ',', '.'); ?></h4>
                            <ul>
                                <p><?= nl2br(esc(str_replace(',', "\n", $item['deskripsi']))); ?></p>
                            </ul>
                            <div class="text-center mt-auto">
                                <a href="<?= base_url(); ?>book" class="buy-btn">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="text-center mt-4">
                <?php if (session()->get('logged_in')): ?>
                    <a href="<?= base_url('paket'); ?>" class="btn btn-primary">Show More</a>
                <?php else: ?>
                    <a href="<?= base_url('login'); ?>" class="btn btn-primary">Show More</a>
                <?php endif; ?>
            </div>
        </div>

    </section><!-- /Pricing Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                <iframe style="border:0; width: 100%; height: 270px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.130744917891!2d109.66164!3d-6.9075491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7027653ae84f47%3A0x1c8ce7cb284be570!2sMene%20Studio%20Photo!5e0!3m2!1sen!2sid!4v1699371745113!5m2!1sen!2sid"
                    frameborder="0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div><!-- End Google Maps -->

            <div class="row gy-4">

                <div class="col-md-8">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>Gg. IV No.24, Pringlangu, Kec. Pekalongan Barat, Kota Pekalongan, Jawa Tengah 51117</p>
                        </div>
                    </div><!-- End Info Item -->
                </div>
                <div class="col-md-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+62 895 4117 05480</p>
                        </div>
                    </div><!-- End Info Item -->
                </div>
                <!-- <div class="col-md-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>info@example.com</p>
                        </div>
                    </div>
                </div> -->

            </div>

        </div>

    </section><!-- /Contact Section -->

</main>

<?= $this->include('front/layouts/footer'); ?>