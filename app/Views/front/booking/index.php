<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->section('nav-items'); ?>
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="<?= base_url(); ?>">Home<br></a></li>
        <li><a href="<?= base_url(); ?>paket">Paket</a></li>
        <li><a href="<?= base_url(); ?>book" class="active">Booking</a></li>

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
        <?php endif; ?>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
<?= $this->endSection(); ?>
<?= $this->include('front/layouts/navbar'); ?>

<main class="main">
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Booking</h2>
            <p>Silahkan isi formulir untuk memproses booking.</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg">
                    <form action="<?= base_url() ?>book/transaksi" method="post" class="php-email-form"
                        data-aos="fade-up" data-aos-delay="200">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <label for="paketSelect" class="form-label">Pilih Paket</label>
                                <select id="paketSelect" class="form-select" name="id_paket" required>
                                    <option value="" selected disabled>Pilih Paket</option>
                                    <?php foreach ($paket as $p): ?>
                                        <option value="<?= $p['id_paket']; ?>" data-harga="<?= $p['harga']; ?>"
                                            data-deskripsi="<?= $p['deskripsi']; ?>">
                                            <?= $p['paket']; ?> - Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="tanggalInput" name="tanggal"
                                    aria-label="Pilih Tanggal" required>
                            </div>
                            <div class="col-md-6">
                                <select id="timeSelect" class="form-select" aria-label="Pilih Jam" name="jam" required>
                                    <option value="" selected disabled>Pilih Jam</option>
                                    <?php
                                    $startHour = 10;
                                    $endHour = 21;
                                    for ($h = $startHour; $h <= $endHour; $h++) {
                                        for ($m = 0; $m < 60; $m += 30) {
                                            $jam = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT);
                                            echo "<option value=\"$jam\">$jam</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" id="datetimeInput" name="datetime">
                            <input type="hidden" name="nama_lengkap">
                            <input type="hidden" name="no_hp">
                            <input type="hidden" id="harga" name="harga" value="0">
                            <div class="col-md-12">
                                <h4 id="hargaDisplay">
                                    Rp 0
                                </h4>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <button type="submit">Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.42/moment-timezone-with-data.min.js"></script>
<script>
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    document.addEventListener('DOMContentLoaded', function () {
        const paketId = getUrlParameter('paket');
        if (paketId) {
            const select = document.getElementById('paketSelect');
            const options = select.options;

            for (let i = 0; i < options.length; i++) {
                if (options[i].value == paketId) {
                    options[i].selected = true;
                    const harga = options[i].getAttribute('data-harga');
                    document.getElementById('harga').value = parseInt(harga.replace(/\./g, ''));
                    document.getElementById('hargaDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
                    break;
                }
            }
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jakartaToday = moment.tz("Asia/Jakarta");
        const minDate = jakartaToday.format("YYYY-MM-DD");
        document.getElementById('tanggalInput').setAttribute('min', minDate);

        const maxDate = jakartaToday.clone().add(3, 'months').format("YYYY-MM-DD");
        document.getElementById('tanggalInput').setAttribute('max', maxDate);
    });

    const takenTimesByDate = <?= json_encode($takenTimesByDate); ?>;

    // function updateTimeOptions() {
    //     const selectedDate = document.getElementById('tanggalInput').value;
    //     const timeSelect = document.getElementById('timeSelect');
    //     const today = new Date();
    //     const selectedDay = new Date(selectedDate);

    //     for (let option of timeSelect.options) {
    //         option.disabled = false;
    //     }

    //     if (selectedDay.toDateString() === today.toDateString()) {
    //         const currentHour = today.getHours();
    //         const currentMinute = today.getMinutes();

    //         for (let option of timeSelect.options) {
    //             const [hour, minute] = option.value.split(':').map(Number);

    //             if (hour < currentHour || (hour === currentHour && minute <= currentMinute)) {
    //                 option.disabled = true;
    //             }
    //         }
    //     }

    //     if (takenTimesByDate[selectedDate]) {
    //         for (let option of timeSelect.options) {
    //             if (takenTimesByDate[selectedDate].includes(option.value)) {
    //                 option.disabled = true;
    //             }
    //         }
    //     }
    // }
    document.addEventListener('DOMContentLoaded', function () {
        const paketSelect = document.getElementById('paketSelect');
        const tanggalInput = document.getElementById('tanggalInput');
        const timeSelect = document.getElementById('timeSelect');

        function isOutdoorPackage() {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            const deskripsi = selectedOption.getAttribute('data-deskripsi');
            return deskripsi && deskripsi.toLowerCase().includes('outdoor');
        }

        function updateTimeOptions() {
            const selectedDate = tanggalInput.value;
            const today = new Date();
            const selectedDay = new Date(selectedDate);

            for (let option of timeSelect.options) {
                option.disabled = false;
            }

            if (isOutdoorPackage()) {
                return;
            }

            if (selectedDay.toDateString() === today.toDateString()) {
                const currentHour = today.getHours();
                const currentMinute = today.getMinutes();

                for (let option of timeSelect.options) {
                    const [hour, minute] = option.value.split(':').map(Number);

                    if (hour < currentHour || (hour === currentHour && minute <= currentMinute)) {
                        option.disabled = true;
                    }
                }
            }

            if (takenTimesByDate[selectedDate]) {
                for (let option of timeSelect.options) {
                    if (takenTimesByDate[selectedDate].includes(option.value)) {
                        option.disabled = true;
                    }
                }
            }
        }

        tanggalInput.addEventListener('change', updateTimeOptions);

        paketSelect.addEventListener('change', updateTimeOptions);

        updateTimeOptions();
    });


    document.getElementById('tanggalInput').addEventListener('change', updateTimeOptions);

    // document.getElementById('paketSelect').addEventListener('change', function () {
    //     const selectedOption = this.options[this.selectedIndex];
    //     const harga = selectedOption.getAttribute('data-harga');
    //     document.getElementById('harga').value = parseInt(harga.replace(/\./g, ''));
    //     document.getElementById('hargaDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
    // });
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM fully loaded and parsed');

        const paketSelect = document.getElementById('paketSelect');
        const hargaDisplay = document.getElementById('hargaDisplay');
        const hargaInput = document.getElementById('harga');

        console.log('paketSelect:', paketSelect);
        console.log('hargaDisplay:', hargaDisplay);
        console.log('hargaInput:', hargaInput);

        function updateHarga() {
            console.log('updateHarga function called');
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            console.log('Selected option:', selectedOption);

            if (selectedOption && selectedOption.value) {
                const harga = selectedOption.getAttribute('data-harga');
                console.log('Harga attribute:', harga);

                if (harga) {
                    const parsedHarga = parseFloat(harga.replace(/\./g, '').replace(',', '.'));
                    console.log('Parsed harga:', parsedHarga);

                    hargaInput.value = parsedHarga;
                    hargaDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(parsedHarga);

                    console.log('Updated hargaInput:', hargaInput.value);
                    console.log('Updated hargaDisplay:', hargaDisplay.textContent);
                } else {
                    console.error('Harga attribute is missing for the selected option');
                }
            } else {
                hargaInput.value = 0;
                hargaDisplay.textContent = 'Rp 0';
                console.log('No option selected or invalid option');
            }
        }

        if (paketSelect) {
            paketSelect.addEventListener('change', updateHarga);
            console.log('Change event listener added to paketSelect');
        } else {
            console.error('paketSelect element not found');
        }

        updateHarga();
    });
    // document.getElementById('hargaDisplay').addEventListener('change', updateHarga);

    function combineDateTime() {
        const tanggal = document.getElementById('tanggalInput').value;
        const jam = document.getElementById('timeSelect').value;
        if (tanggal && jam) {
            const dateTimeValue = tanggal + ' ' + jam + ':00';
            document.getElementById('datetimeInput').value = dateTimeValue;
        }
    }

    document.getElementById('timeSelect').addEventListener('change', combineDateTime);
</script>

<?= $this->include('front/layouts/footer'); ?>