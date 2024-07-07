<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

if (isset($_POST["tambahdpt"])) {
    if (tambahdpt($_POST) > 0) {
        echo "<script>
            alert('Token berhasil dibuat');
            </script>";
        $jlhdpt = 0;
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {
    mysqli_query($conn, "DELETE FROM dpt");
}

//pagination
$jumlahdataperhalaman = 20;
$jumlahdata = count(query("SELECT * FROM dpt"));
$jumlahhalaman = ceil($jumlahdata / $jumlahdataperhalaman);
$halamanaktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awaldata = ($jumlahdataperhalaman * $halamanaktif) - $jumlahdataperhalaman;
$halamantengah = ceil($jumlahhalaman / 2);

$dpt = query("SELECT * FROM dpt LIMIT $awaldata, $jumlahdataperhalaman");

if (isset($_POST["cari"])) {
    $dpt = cari($_POST["keyword"]);
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
        <h1>Token <?= $namaapp; ?></h1>
        <form class="row g-3" action="" method="post">
            <div class="col-auto">
                <input class="form-control" type="text" id="jlhdpt" name="jlhdpt" required placeholder="Masukkan Jumlah Token">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary mb-3" type="submit" name="tambahdpt">Buat Token</button>
            </div>
        </form>
        <div class="col-auto">
            <button class="btn btn-success" type="submit" name="cetak" onclick="window.open('dptexcel.php')">Cetak Token</button>
        </div>
        <!--navigasi-->
        <br>
        <nav aria-label="...">
            <ul class="pagination">
                <?php if ($jumlahhalaman > 10) : ?>
                    <?php if ($halamanaktif > 1) : ?>
                        <li class="page-item">
                            <a href="?halaman=1" class="page-link"> First </a>
                        </li>
                        <li class="page-item">
                            <a href="?halaman=<?= $halamanaktif - 1; ?>" class="page-link"> &laquo; </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                        <?php if ($i == $halamanaktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php for ($i = $jumlahhalaman - 2; $i <= $jumlahhalaman; $i++) : ?>
                        <?php if ($i == $halamanaktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($halamanaktif < $jumlahhalaman) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanaktif + 1; ?>"> &raquo; </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $jumlahhalaman; ?>"> Last </a>
                        </li>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($halamanaktif > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanaktif - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $jumlahhalaman; $i++) : ?>
                        <?php if ($i == $halamanaktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($halamanaktif < $jumlahhalaman) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanaktif + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
        <form class="row g-3" action="" method="post">
            <div class="col-auto">
                <input class="form-control" type="text" name="keyword" autofocus placeholder="Cari Token..." autocomplete="off" id="keyword">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary mb-3" type="submit" name="cari">Cari</button>
            </div>
        </form>
        <br>
        <p><small>Halaman : <?= $halamanaktif; ?> dari <?= $jumlahhalaman; ?> halaman</small></p>
        <div id="datadpt">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Token</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <?php foreach ($dpt as $row) : ?>
                    <tbody>
                        <tr>
                            <td scope="row"><?= $i; ?></td>
                            <td><?= $row["token"]; ?></td>
                            <td><?php if ($row["stat"] == 0) {
                                    echo "Belum digunakan";
                                } else {
                                    echo "Sudah digunakan";
                                } ?></td>
                            <td>
                                <a href="hapusdpt.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin?');" class="badge text-bg-primary text-wrap" style="width: 6rem;">hapus</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
            </table>
        </div>
        <br>
        <!--navigasi-->
        <br>
        <nav aria-label="...">
            <ul class="pagination">
                <?php if ($jumlahhalaman > 10) : ?>
                    <?php if ($halamanaktif > 1) : ?>
                        <li class="page-item">
                            <a href="?halaman=1" class="page-link"> First </a>
                        </li>
                        <li class="page-item">
                            <a href="?halaman=<?= $halamanaktif - 1; ?>" class="page-link"> &laquo; </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                        <?php if ($i == $halamanaktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php for ($i = $jumlahhalaman - 2; $i <= $jumlahhalaman; $i++) : ?>
                        <?php if ($i == $halamanaktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($halamanaktif < $jumlahhalaman) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanaktif + 1; ?>"> &raquo; </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $jumlahhalaman; ?>"> Last </a>
                        </li>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($halamanaktif > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanaktif - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $jumlahhalaman; $i++) : ?>
                        <?php if ($i == $halamanaktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($halamanaktif < $jumlahhalaman) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanaktif + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
        <br><br>
        <form action="" method="post">
            <div class="col-auto">
                <button class="btn btn-danger" type="submit" name="hapus" onclick="return confirm('Yakin?');">Hapus Semua Token</button></td>
            </div>
        </form>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - <?= $versi; ?></small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>