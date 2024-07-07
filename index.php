<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: loginvoter.php");
    exit;
}

require 'functions.php';

if (isset($_POST["hapus"])) {
    $tables_to_clear = array("kandidat", "dpt", "pilihan");
    foreach ($tables_to_clear as $table) {
        if ($table !== "user") {
            $sql = "DELETE FROM $table";
            mysqli_query($conn, $sql);
        }
    }
}

$kandidat = query("SELECT * FROM kandidat ORDER BY nama ASC");
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
                <a class="navbar-brand" href="index.php"><?= $namaapp; ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="tambah.php">Tambah Calon Ketua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="dpt.php">Lihat Token</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="hasil.php">Lihat Hasil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <h1>Daftar Calon Ketua</h1>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aksi</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">NISN</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kelas</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <?php foreach ($kandidat as $row) : ?>
                    <tbody>
                        <tr>
                            <td scope="row"><?= $i; ?></td>
                            <td>
                                <a href="lihat.php?nisn=<?= $row["nisn"]; ?>" class="badge text-bg-primary text-wrap" style="width: 6rem;">Lihat</a>
                                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin?');" class="badge text-bg-primary text-wrap" style="width: 6rem;">Hapus</a><br>
                                <a href="ubah.php?id=<?= $row["id"]; ?>" class="badge text-bg-primary text-wrap" style="width: 6rem;">Ubah</a>
                            </td>
                            <td><img src="img/<?= $row["gambar"]; ?>" class="img-thumbnail" width="50"></td>
                            <td><?= $row["nisn"]; ?></td>
                            <td><?= $row["nama"]; ?></td>
                            <td><?= $row["kelas"]; ?></td>
                        </tr>
                    </tbody>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>
        <br>
        <form action="" method="post">
            <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus seluruh data? tindakan ini akan menghapus seluruh data pada aplikasi e-Vote!');" type="submit" name="hapus" class="form-login">
                Bersihkan Seluruh Data</button>
        </form>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - <?= $versi; ?></small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
</body>

</html>