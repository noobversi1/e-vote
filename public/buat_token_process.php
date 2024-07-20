<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Token.php';

$database = new Database();
$db = $database->getConnection();

$token = new Token($db);

$jumlah = $_POST['jumlah'];
$token->generateTokens($jumlah);

echo "<script>
            alert('Token berhasil dibuat.');
            window.location.href = 'dashboard.php';
            </script>";
