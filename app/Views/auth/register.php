<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/img/favicon.png" rel="icon">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 600px;
            width: 100%;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }

        .btn-login {
            width: 100%;
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            border: none;
        }
    </style>
</head>

<body>
    <div class="login-container container-fluid">
        <h2>Register</h2>
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Peringatan</strong><?= $validation->listErrors() ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="register" method="post">
            <?= csrf_field() ?>
            <div class="row px-2 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?= set_value('username') ?>" required>
            </div>
            <div class="row px-2 mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    value="<?= set_value('nama_lengkap') ?>" required>
            </div>
            <div class="row px-2 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>"
                    required>
            </div>
            <div class="row px-2 mb-3">
                <label for="no_hp" class="form-label">Nomor Telepon</label>
                <input type="number" class="form-control" id="no_hp" name="no_hp" value="<?= set_value('no_hp') ?>"
                    required>
            </div>
            <div class="row px-2 mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= set_value('alamat') ?>"
                    required>
            </div>
            <div class="row px-2 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div>
                <input type="hidden" class="form-control" id="role" name="role" value="2">
            </div>
            <div class="row px-2 pt-4">
                <button type="submit" class="btn btn-login">Register</button>
            </div>
            <div class="text-center mt-2 pt-4">
                <p>Have an account? <a href="<?= base_url(); ?>login">Login</a></p>
            </div>
        </form>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Registrasi Berhasil</h5>
                    <button type="button" class="btn-close" id="okButton" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Akun berhasil dibuat! Silakan login untuk melanjutkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="okButtons">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (session()->getFlashdata('sukses')): ?>
        <script>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            document.getElementById('okButton').addEventListener('click', function () {
                successModal.hide();
                window.location.href = "<?= base_url(); ?>";
            });
            document.getElementById('okButtons').addEventListener('click', function () {
                successModal.hide();
                window.location.href = "<?= base_url(); ?>";
            });
        </script>
    <?php endif; ?>

</body>


</html>