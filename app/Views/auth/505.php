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
                    <li><a href="<?= base_url(); ?>schedule">Schedule</a></li>
                    <br />
                    <li><a href="<?= base_url(); ?>logout"><strong>Logout</strong></a></li>
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
    <section id="call-to-action" class="call-to-action section accent-background">
        <!-- Page Title -->
        <div class="page-title accent-background">
            <div class="container">
                <h1>505! Access Denied</h1>
                <nav class="breadcrumbs">
                    <h3>Silahkan menghubungi admin untuk meminta akses. </h2>
                        <a href="<?= base_url() ?>" class="cta-btn">Kembali ke Home</a>
                </nav>
            </div>
        </div>
    </section><!-- End Page Title -->

    <!-- Starter Section Section -->
    <!-- <section id="starter-section" class="starter-section section">

        <div class="container" data-aos="fade-up">
            <p>Use this page as a starter for your own custom pages.</p>
        </div>

    </section> -->

</main>
<?= $this->include('front/layouts/footer'); ?>