<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Calon.php';
include_once '../config/helpers.php';

$database = new Database();
$db = $database->getConnection();

$calon = new Calon($db);
$calon->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

$calon->readOne();

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Calon <?= $kontes; ?></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>

<body>
    <div class="container bg-body-tertiary">

        <?php include '../assets/header.php' ?>

        <h2 class="text-center mb-3 my-3">Edit Calon <?= $kontes; ?></h3>

            <img class="rounded mx-auto d-block mb-4" width="150" src="../uploads/<?= $calon->foto; ?>">
            <form class="row g-3" action="edit_calon_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $calon->id; ?>">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">Nama Lengkap</span>
                        <input class="form-control" type="text" name="nama" value="<?php echo $calon->nama; ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">Tanggal Lahir</span>
                        <input class="form-control" type="date" name="tanggal_lahir" value="<?php echo $calon->tanggal_lahir; ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">Jenis Kelamin</span>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option selected>Pilih...</option>
                            <option value="L" <?php echo $calon->jenis_kelamin == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?php echo $calon->jenis_kelamin == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">NISN</span>
                        <input class="form-control" type="text" name="nisn" value="<?php echo $calon->nisn; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">Kelas</span>
                        <input class="form-control" type="text" name="kelas" value="<?php echo $calon->kelas; ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="visi" name="visi" required><?php echo $calon->visi; ?></textarea>
                        <label for="visi">Visi</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="misi" name="misi" required><?php echo $calon->misi; ?></textarea>
                        <label for="misi">Misi</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input class="form-control" type="file" id="foto" name="foto" accept=".jpg, .jpeg, .png">
                        <label class="input-group-text" for="foto">Gambar</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    <a class="btn btn-secondary" href="detail_calon.php?id=<?= $calon->id; ?>">Batal</a>
                </div>
            </form>

            <?php include '../assets/footer.php' ?>

    </div>
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>