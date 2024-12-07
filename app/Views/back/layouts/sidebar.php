<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?= base_url('admin/dashboard'); ?>">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="<?= base_url(); ?>assets/img/favicon.png" height="50" width="50">
        </div>
        <div class="sidebar-brand-text mx-1">Mene Photo Studio</div>
    </a>

    <!-- Divider -->
    <?= $this->renderSection('sidebar') ?>

</ul>
<!-- End of Sidebar -->