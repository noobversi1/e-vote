<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: index.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Calon.php';
include_once '../config/helpers.php';

$database = new Database();
$db = $database->getConnection();

$calon = new Calon($db);
$calon->id = $_GET['id'];
$calon->getDetail();

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Calon <?= $kontes; ?></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>

<body>
    <div class="container bg-body-tertiary">

        <nav class="navbar sticky-top navbar-expand-lg bg-primary border-bottom border-body" data-bs-theme="dark">
            <div class=" container-fluid">
                <a class="navbar-brand""><?= $appname; ?></a>
                <span class=" navbar-text">
                    <a class="nav-link" href="logout_token.php">Batal Memilih</a>
                    </span>
            </div>
        </nav>

        <h2 class="text-center mb-3 my-3">Detail Calon <?= $kontes; ?></h2>

        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $calon->foto; ?>" class="img-fluid rounded-start" alt="Foto">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $calon->nama; ?></h5>
                        <p class="card-text"><small class="text-body-secondary">NISN: <?= $calon->nisn; ?></p>
                        <p class="card-text">VISI :</p>
                        <p class="card-text"><?= $calon->visi; ?></p>
                        <p class="card-text">MISI :</p>
                        <p class="card-text"><?= $calon->misi; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
            <a class="btn btn-info" href="daftar_calon.php">Kembali</a> <!-- Tombol Edit -->
        </div>

        <?php include '../assets/footer.php' ?>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>