<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
            alert('User baru berhasil ditambahkan');
            </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $namaapp; ?> <?= $instansi; ?></title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist\css\bootstrap.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Kembali</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="mb-3">
            <form action="" method="post">
                <h3>Registrasi</h3>
                <input class="form-control" type="text" id="nama" name="nama" required placeholder="Masukkan Nama" class="form-login"><br>
                <input class="form-control" type="text" id="username" name="username" maxlength="32" required placeholder="Masukkan Username" class="form-login"><br>
                <input class="form-control" type="password" id="Password" name="password" maxlength="32" required placeholder="Masukkan Password" class="form-login"><br>
                <input class="form-control" type="password" id="Password2" name="password2" placeholder="Konfirmasi Password" class="form-login"><br>
                <button class="btn btn-primary" type="submit" name="register" class="form-login">Registrasi</button><br>
            </form>
        </div>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - <?= $versi; ?></small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
</body>

</html>