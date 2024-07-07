<?php
session_start();
require 'functions.php';

if (isset($_SESSION["loginvoter"])) {
    header("Location: pilihcalon.php");
    exit;
}

if (isset($_POST["loginvoter"])) {
    $username = $_POST["username"];

    $result = mysqli_query($conn, "SELECT * FROM dpt WHERE token = '$username'");

    //cek token
    if (mysqli_num_rows($result) === 1) {
        //cek password
        $row = mysqli_fetch_assoc($result);
        if ($row["stat"] == 0) {
            $_SESSION["loginvoter"] = true;
            $_SESSION['username'] = $row['token'];
            header("Location: pilihcalon.php");
            exit;
        }
    }
    $error = true;
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
        <h1 class="text-center"><?= $namaapp; ?></h1>
        <h2 class="text-center"><?= $instansi; ?></h2><br>
        <img class="rounded mx-auto d-block" width="200" src="img/<?= $logo; ?>">
        <br>
        <div class="mb-3">
            <form action="" method="post">
                <h3>Masukkan Token</h3>
                <input class="form-control" type="text" id="username" name="username" autofocus placeholder="Masukkan Token"><br>
                <button class="btn btn-primary" type="submit" name="loginvoter" class="form-login">Masuk</button>
            </form><br>
            <?php if (isset($error)) : ?>
                <p class="p-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3">Token Salah atau Sudah Digunakan</p>
            <?php endif; ?>
        </div>
        <br><br><br>
        <footer class="position-relative">
            <p class="position-absolute bottom-0 end-0">Developed by <a class="text-danger" href="https://tarigan.web.id" target="_blank">Tarigan Hosting</a><i><small> - <?= $versi; ?></small></i></p>
        </footer>
    </div>
    <script src="bootstrap-5.3.3-dist\js\bootstrap.bundle.js"></script>
</body>

</html>