<?php
session_start();
include_once '../config/database.php';
include_once '../objects/Token.php';

$database = new Database();
$db = $database->getConnection();

$token = new Token($db);

if ($token->verifyToken($_POST['token'])) {
    $_SESSION['token'] = $_POST['token'];
    header("Location: daftar_calon.php");
} else {
    echo "<script>
            alert('Token tidak valid atau sudah digunakan.');
            window.location.href = 'index.php';
            </script>";
}
