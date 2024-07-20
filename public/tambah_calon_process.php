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

// Mengambil data dari formulir
$calon->nama = $_POST['nama'];
$calon->nisn = $_POST['nisn'];
$calon->kelas = $_POST['kelas'];
$calon->jenis_kelamin = $_POST['jenis_kelamin'];
$calon->tanggal_lahir = $_POST['tanggal_lahir'];
$calon->visi = $_POST['visi'];
$calon->misi = $_POST['misi'];

// Mengambil dan memproses file foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['foto']['tmp_name'];
    $fileName = $_FILES['foto']['name'];
    $fileSize = $_FILES['foto']['size'];
    $fileType = $_FILES['foto']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Daftar ekstensi file yang diperbolehkan
    $allowedExtensions = array('jpg', 'jpeg', 'png');

    if (in_array($fileExtension, $allowedExtensions)) {
        // Generate nama file acak
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        // Move file ke direktori upload
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Set nama foto calon
            $calon->foto = $dest_path;
        } else {
            echo "<script>
                    alert('Ada masalah saat mengupload file foto.');
                    window.location.href = 'dashboard.php';
                    </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('Ekstensi file tidak diperbolehkan. Harap upload file jpg, jpeg, atau png.');
                window.location.href = 'dashboard.php';
                </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Tidak ada file foto yang diupload atau terjadi kesalahan.');
            window.location.href = 'dashboard.php';
            </script>";
    exit();
}

// Menyimpan data calon ke database
if ($calon->tambahCalon()) {
    echo "<script>
            alert('Calon berhasil ditambahkan.');
            window.location.href = 'dashboard.php';
            </script>";
} else {
    echo "<script>
            alert('Gagal menambahkan calon.');
            window.location.href = 'dashboard.php';
            </script>";
}
