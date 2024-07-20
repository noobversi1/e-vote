<?php
session_start();
include_once '../config/database.php';
include_once '../objects/Admin.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

$admin->username = $_POST['username'];
$admin->password = $_POST['password'];

if ($admin->login()) {
    $_SESSION['admin'] = $admin->id;
    header("Location: dashboard.php");
} else {
    echo "<script>
            alert('Login gagal!');
            window.location.href = 'login_admin.php';
            </script>";
}
