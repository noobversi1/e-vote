<?php
include_once '../config/database.php';
include_once '../objects/Calon.php';

$database = new Database();
$db = $database->getConnection();

$calon = new Calon($db);

// Mengambil data dari formulir
$calon->id = $_POST['id'];
$calon->nama = $_POST['nama'];
$calon->nisn = $_POST['nisn'];
$calon->kelas = $_POST['kelas'];
$calon->jenis_kelamin = $_POST['jenis_kelamin'];
$calon->tanggal_lahir = $_POST['tanggal_lahir'];
$calon->visi = $_POST['visi'];
$calon->misi = $_POST['misi'];

// Mengambil dan memproses file foto jika ada
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['foto']['tmp_name'];
    $fileName = $_FILES['foto']['name'];
    $fileSize = $_FILES['foto']['size'];
    $fileType = $_FILES['foto']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedExtensions = array('jpg', 'jpeg', 'png');

    if (in_array($fileExtension, $allowedExtensions)) {
        // Generate nama file acak
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Hapus foto lama jika ada
            if (file_exists($calon->foto)) {
                unlink($calon->foto);
            }
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
    // Jika tidak ada file foto baru yang diupload, tetap gunakan foto lama
    $query = "SELECT foto FROM " . $calon->getTableName() . " WHERE id = ?";
    $stmt = $calon->getConnection()->prepare($query);
    $stmt->bindParam(1, $calon->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $calon->foto = $row['foto'];
}

// Menyimpan data calon yang diubah ke database
if ($calon->update()) {
    echo "<script>
            alert('Calon berhasil diperbarui.');
            window.location.href = 'dashboard.php';
            </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui calon.');
            window.location.href = 'dashboard.php';
            </script>";
}
