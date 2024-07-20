<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Menghapus semua file di folder uploads
$files = glob('../uploads/*'); // Mengambil semua file dalam folder uploads
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); // Menghapus file
    }
}

// Menghapus data dari tabel vote
$query = "DELETE FROM vote";
$stmt = $db->prepare($query);
$stmt->execute();

// Menghapus data dari tabel token
$query = "DELETE FROM token";
$stmt = $db->prepare($query);
$stmt->execute();

// Menghapus data dari tabel calon
$query = "DELETE FROM calon";
$stmt = $db->prepare($query);
$stmt->execute();

header("Location: dashboard.php");
exit();
