<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

$id = $_GET["id"];
// query data mahasiswa berdasarkan nrp
$cln = query("SELECT * FROM kandidat WHERE id = '$id'")[0];

// cek apakah tombol submit usdah ditekan atau belum
if (isset($_POST["submit"])) {
    // cek apakah data berhasil ditambahkan atau tidak
    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah');
                document.location.href = 'index.php';
            </script>
        ";
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

        <h1>Ubah Data Calon Ketua</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" name="id" value="<?= $cln["id"]; ?>">
                <input type="hidden" name="gambarlama" value="<?= $cln["gambar"]; ?>">
                <label class="form-label" for="nisn">No. Identitas : </label>
                <input class="form-control" type="text" name="nisn" id="nisn" required value="<?= $cln["nisn"]; ?>"><br><br>
                <label class="form-label" for="nama">Nama : </label>
                <input class="form-control" type="text" name="nama" id="nama" required value="<?= $cln["nama"]; ?>"><br><br>
                <label class="form-label" for="kelas">Kelas : </label>
                <input class="form-control" type="text" name="kelas" id="kelas" required value="<?= $cln["kelas"]; ?>"><br><br>
                <label class="form-label" for="visi">Visi : </label>
                <textarea class="form-control" id="visi" name="visi" rows="4" cols="50"><?= $cln["visi"]; ?></textarea><br><br>
                <label class="form-label" for="misi">Misi : </label>
                <textarea class="form-control" id="misi" name="misi" rows="4" cols="50"><?= $cln["misi"]; ?></textarea><br><br>
                <label class="form-label" for="tujuan">Tujuan : </label>
                <textarea class="form-control" id="tujuan" name="tujuan" rows="4" cols="50"><?= $cln["tujuan"]; ?></textarea><br><br>
            </div>
            <img class="img-thumbnail" width="50" src="img/<?= $cln['gambar']; ?>"><br>
            <div class="input-group mb-3">
                <input class="form-control" type="file" id="gambar" name="gambar">
                <label class="input-group-text" for="gambar">Upload</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Ubah Data</button>
        </form>
        <br>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - Versi 1.0.0</small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
</body>

</html>