<?php
include_once '../config/helpers.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>

<body>
    <div class="container bg-body-tertiary">

        <nav class="navbar sticky-top navbar-expand-lg bg-primary border-bottom border-body" data-bs-theme="dark">
            <div class=" container-fluid">
                <a class="navbar-brand"><?= $appname; ?></a>
                <span class=" navbar-text">
                    <a class="nav-link" href="index.php">Login Voter</a>
                </span>
        </nav>

        <img class="my-4 mb-4 mx-auto d-block" width="200" src="../assets/logo.png">

        <h2 class="text-center mb-3 my-3">LOGIN ADMIN</h2>

        <form class="row" action="login_process.php" method="post">
            <div class="col-md-5 col-sm-6 col-lg-3 mx-auto">
                <div class="form-group mt-3">
                    <label class="form-label mb-2" for="username">Username:</label>
                    <input class="form-control" type="text" name="username" required>
                </div>
                <div class="form-group mt-3">
                    <label class="form-label mb-2" for="password">Password:</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <button class="btn btn-success mt-4" type="submit">Login</button>
        </form>

    </div>

    <?php include '../assets/footer.php' ?>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>