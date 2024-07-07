<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$dpt = query("SELECT * FROM dpt");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=dpt.xls");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $namaapp; ?> <?= $instansi; ?></title>
</head>

<body>
    <h1>Token <?= $namaapp; ?></h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>#</th>
            <th>Token</th>
            <th>Status</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($dpt as $row) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $row["token"]; ?></td>
                <td><?php if ($row["stat"] == 0) {
                        echo "Belum digunakan";
                    } else {
                        echo "Sudah digunakan";
                    } ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>

</html>