<?php
session_start();
if (!isset($_SESSION["loginvoter"])) {
    header("Location: loginvoter.php");
    exit;
}

require 'functions.php';
$cln = query("SELECT * FROM kandidat ORDER BY nama ASC");

// cek apakah tombol pilih usdah ditekan atau belum
if (isset($_POST["pilih"])) {
    // cek apakah data berhasil ditambahkan atau tidak
    if (plhcalon($_POST) > 0) {
        $_SESSION = [];
        session_unset();
        session_destroy();
        echo "
            <script>
                alert('Pilihan anda telah disimpan');
                document.location.href = 'loginvoter.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Pilihan anda gagal disimpan');
                document.location.href = 'loginvoter.php';
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
        <h1>Pilih Calon Ketua</h1>
        <div class="table table-hover">
            <form action="" method="post">
                <?php $token = $_SESSION['username']; ?>
                <input type="hidden" name="token" value="<?= $token; ?>">
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
                    <?php foreach ($cln as $row) : ?>
                        <tbody>
                            <tr>
                                <td scope="row"><?= $i; ?></td>
                                <td>
                                    <a class="badge text-bg-primary text-wrap" style="width: 6rem;" href="lihatcalon.php?nisn=<?= $row["nisn"]; ?>">Lihat Profil</a><br><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="<?= $row["id"] ?>" name="radpilih" value="<?= $row["id"] ?>" required>
                                        <label class="form-check-label" for="<?= $row["id"] ?>">Pilih</label>
                                    </div>
                                </td>
                                <td><img class="img-thumbnail" width="100" src="img/<?= $row["gambar"]; ?>" width="100"></td>
                                <td><label name="<?= $row["nisn"]; ?>"><?= $row["nisn"]; ?></label></td>
                                <td><label name="<?= $row["nama"]; ?>"><?= $row["nama"]; ?></label></td>
                                <td><label name="<?= $row["kelas"]; ?>"><?= $row["kelas"]; ?></label></td>
                            </tr>
                        </tbody>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
                <button class="btn btn-primary" type="submit" name="pilih">Tentukan Pilihan</button>
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