<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

$id = $_GET["id"];

if (hapusdpt($id) > 0) {
    echo "
        <script>
            alert('Data berhasil dihapus');
            document.location.href = 'dpt.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data gagal dihapus');
            document.location.href = 'dpt.php';
        </script>
    ";
}
