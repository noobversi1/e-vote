<?php
session_start();
require 'functions.php';

//cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek user
    if (mysqli_num_rows($result) === 1) {
        //cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if (isset($_POST['remember'])) {
                //buat cookie
                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }

            header("Location: index.php");
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
        <h1 class="text-center"><?= $namaapp; ?> <?= $instansi; ?></h1>
        <h2 class="text-center"><?= $lokasi; ?></h2><br>
        <img class="rounded mx-auto d-block" width="200" src="img/<?= $logo; ?>">
        <br>
        <div class="mb-3">
            <form action="" method="post">
                <h3>Login Admin</h3>
                <input class="form-control" type="text" id="username" name="username" autofocus placeholder="Username"><br>
                <input class="form-control" type="password" id="Password" name="password" placeholder="Password"><br>
                <button class="btn btn-primary" type="submit" name="login">Login</button>
            </form><br>
            <?php if (isset($error)) : ?>
                <p class="p-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3">Username / Password salah</p>
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