<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Calon.php';

$database = new Database();
$db = $database->getConnection();

$calon = new Calon($db);
$calon->id = $_GET['id'];

if ($calon->delete()) {
    header("Location: dashboard.php");
} else {
    echo "<script>
            alert('Gagal menghapus calon.');
            window.location.href = 'dashboard.php';
            </script>";
}
