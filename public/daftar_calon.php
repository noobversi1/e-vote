<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: index.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Calon.php';
include_once '../objects/Vote.php';
include_once '../objects/Token.php';
include_once '../config/helpers.php';

$database = new Database();
$db = $database->getConnection();

$calon = new Calon($db);
$vote = new Vote($db);
$token = new Token($db);

$query = "SELECT * FROM calon";
$stmt = $db->prepare($query);
$stmt->execute();
$calon_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Calon <?= $kontes; ?></title>
    <link rel="stylesheet" href="..\bootstrap\css\bootstrap.css">
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

        <h2 class="text-center mb-3 my-3">Pilih Calon <?= $kontes; ?></h2>


        <form action="vote_process.php" method="post">
            <div class="justify-content-center row row-cols-1 row-cols-md-4 g-4">
                <?php foreach ($calon_list as $calon) : ?>
                    <div class="col">
                        <div class="card h-100 text-bg-info text-center border-info mb-3" style="width: 18rem;">
                            <img src="<?= $calon['foto']; ?>" class="card-img-top" alt="Foto" width="100">
                            <div class="card-body">
                                <h5 class="card-title"><?= $calon['nama']; ?></h5>
                                <a href="detail_calon_siswa.php?id=<?= $calon['id']; ?>" class="btn btn-primary">Lihat</a>
                                <input class="btn-check" type="radio" id="<?= $calon['id'] ?>" name="calon_id" value="<?= $calon['id']; ?>" autocomplete="off" required>
                                <label class="btn btn-outline-danger" for="<?= $calon['id'] ?>">Pilih</label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="d-grid gap-2">
                <button class="btn btn-danger" type="submit">Tentukan Pilihan !</button>
            </div>
        </form>

        <?php include '../assets/footer.php' ?>
    </div>

    <script src="..\bootstrap\js\bootstrap.bundle.js"></script>
</body>

</html>