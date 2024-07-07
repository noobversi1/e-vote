<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$cln = query("SELECT * FROM kandidat");
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
        <h1 class="text-center">Hasil <?= $namaapp; ?></h1>
        <h2 class="text-center"><?= $instansi; ?></h2>
        <h2 class="text-center"><?= $lokasi; ?></h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">NISN</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Suara</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <?php foreach ($cln as $row) : ?>
                <tbody>
                    <tr>
                        <td scope="row"><?= $i; ?></td>
                        <td><img src="img/<?= $row["gambar"]; ?>" class="img-thumbnail" width="100"></td>
                        <td><?= $row["nisn"]; ?></td>
                        <td><?= $row["nama"]; ?></td>
                        <td><?= $row["kelas"]; ?></td>
                        <td>
                            <?php $nisn = $row["nisn"] ?>
                            <?php $sql = "SELECT COUNT(*) AS jumlah FROM pilihan WHERE nisn = '$nisn'"; ?>
                            <?php $result = mysqli_query($conn, $sql); ?>
                            <?php $row = mysqli_fetch_assoc($result); ?>
                            <h2><?= $row['jumlah']; ?></h2>
                        </td>
                </tbody>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - Versi 1.0.0</small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
</body>

</html>