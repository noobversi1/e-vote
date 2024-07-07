<?php
session_start();

if (!isset($_SESSION["loginvoter"])) {
    header("Location: loginvoter.php");
    exit;
}

require 'functions.php';

// ambil data di URL
$nisn = $_GET["nisn"];
// query data kandidat berdasarkan nisn
$cln = query("SELECT * FROM kandidat WHERE nisn = '$nisn'")[0];
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
                <a class="navbar-brand" href="pilihcalon.php">Kembali</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <h1>Profil Calon Ketua</h1><br>
        <table class="table table-hover">
            <tr>
                <th><img class="rounded mx-auto d-block" width="150" src="img/<?= $cln["gambar"]; ?>"></th>
            </tr>
            <tr>
                <th>NAMA</th>
            </tr>
            <tr>
                <td><?= $cln["nama"] ?></td>
            </tr>
            <tr>
                <th>IDENTITAS</th>
            </tr>
            <tr>
                <td><?= $cln["nisn"] ?></td>
            </tr>
            <tr>
                <th>KELAS</th>
            </tr>
            <tr>
                <td><?= $cln["kelas"] ?></td>
            </tr>
            <tr>
                <th>VISI</th>
            </tr>
            <tr>
                <td><?= $cln["visi"] ?></td>
            </tr>
            <tr>
                <th>MISI</th>
            </tr>
            <tr>
                <td><?= $cln["misi"] ?></td>
            </tr>
            <tr>
                <th>TUJUAN</th>
            </tr>
            <tr>
                <td><?= $cln["tujuan"] ?></td>
            </tr>
        </table>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - Versi 1.0.0</small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
</body>

</html>