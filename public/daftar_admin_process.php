<?php
include_once '../config/database.php';
include_once '../objects/Admin.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

$admin->username = $_POST['username'];
$admin->password = password_hash($_POST['password'], PASSWORD_BCRYPT);

if ($admin->register()) {
    echo "Admin berhasil didaftarkan.";
} else {
    echo "Gagal mendaftarkan admin.";
}
