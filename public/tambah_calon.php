<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

include_once '../config/helpers.php';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Calon <?= $kontes; ?></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>

<body>
    <div class="container bg-body-tertiary">

        <?php include '../assets/header.php' ?>

        <h2 class="text-center mb-3 my-3">Tambah Calon <?= $kontes; ?></h2>

        <form class="row g-3" action="tambah_calon_process.php" method="post" enctype="multipart/form-data">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text">Nama Lengkap</span>
                    <input class="form-control" type="text" name="nama" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">Tanggal Lahir</span>
                    <input class="form-control" type="date" name="tanggal_lahir" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">Jenis Kelamin</span>
                    <select class="form-select" name="jenis_kelamin" required>
                        <option selected>Pilih...</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">NISN</span>
                    <input class="form-control" type="text" name="nisn" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">Kelas</span>
                    <input class="form-control" type="text" name="kelas" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <textarea class="form-control" id="visi" name="visi" required></textarea>
                    <label for="visi">Visi</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <textarea class="form-control" id="misi" name="misi" required></textarea>
                    <label for="misi">Misi</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input class="form-control" type="file" id="foto" name="foto" accept=".jpg, .jpeg, .png" required>
                    <label class="input-group-text" for="foto">Gambar</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Tambah Calon</button>
            </div>
        </form>

        <?php include '../assets/footer.php' ?>

    </div>
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>