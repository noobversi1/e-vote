<?php
require 'database.php';
// koneksi ke database
$conn = mysqli_connect("$koneksi", "$user", "$pass", "$db");

//Pengaturan
$namaapp = "e-Vote";
$instansi = "Tarigan Hosting";
$lokasi = "Indonesia";
$logo = "logo.png";
$versi = "Versi 1.0.0";

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $conn;

    $nama = ($data["nama"]);
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('Username sudah terdaftar')
            </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
            alert('Konfirmasi password tidak sesuai')
            </script>";
        return false;
    }
    //enksripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user VALUE('', '$nama', '$username', '$password')");
    return mysqli_affected_rows($conn);
}

function tambah($data)
{
    global $conn;

    $nisn = htmlspecialchars($data["nisn"]);
    $nama = strtoupper(htmlspecialchars($data["nama"]));
    $kelas = strtoupper(htmlspecialchars($data["kelas"]));
    $visi = htmlspecialchars($data["visi"]);
    $misi = htmlspecialchars($data["misi"]);
    $tujuan = htmlspecialchars($data["tujuan"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO kandidat
    VALUES ('', '$nisn', '$nama', '$kelas', '$visi', '$misi', '$tujuan', '$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambahdpt($data)
{
    global $conn;

    $jlhdpt = ($data["jlhdpt"]);

    for ($i = 0; $i < $jlhdpt; $i++) {
        $token = uniqid();
        $query = "INSERT INTO dpt VALUES ('', '$token', 0)";
        mysqli_query($conn, $query);
    }

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpname = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
            alert('Pilih gambar terlebih dahulu');
            </script>";
        return false;
    }

    //cek apakah yang diupload adalah gambar
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
    $ekstensigambarpecah = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambarpecah));
    if (!in_array($ekstensigambar, $ekstensigambarvalid)) {
        echo "<script>
            alert('Yang anda upload bukan gambar');
            </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranfile > 1048576) {
        echo "<script>
            alert('Ukuran gambar terlalu besar');
            </script>";
        return false;
    }

    // lolos penegcekan, gambar siap diupload
    // generate nama gambar baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpname, 'img/' . $namafilebaru);
    return $namafilebaru;
}

function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nisn = htmlspecialchars($data["nisn"]);
    $nama = strtoupper(htmlspecialchars($data["nama"]));
    $kelas = strtoupper(htmlspecialchars($data["kelas"]));
    $visi = htmlspecialchars($data["visi"]);
    $misi = htmlspecialchars($data["misi"]);
    $tujuan = htmlspecialchars($data["tujuan"]);
    $gambarlama = htmlspecialchars($data["gambarlama"]);
    //cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $hapusgambar = hapusgambar($id);
        $gambar = upload();
        if (!$gambar) {
            return false;
        }
    }

    $query = "UPDATE kandidat SET
    nisn = '$nisn', nama = '$nama', kelas = '$kelas', visi = '$visi', misi = '$misi',
    tujuan = '$tujuan', gambar = '$gambar' WHERE id = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;
    $hapusgambar = hapusgambar($id);

    mysqli_query($conn, "DELETE FROM kandidat WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function hapusdpt($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM dpt WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function hapusgambar($id)
{
    global $conn;
    $file = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kandidat WHERE id='$id'"));
    unlink('img/' . $file["gambar"]);
    return mysqli_affected_rows($conn);
}

function plhcalon($id)
{
    global $conn;
    $rad = $id["radpilih"];
    $pil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kandidat WHERE id='$rad'"));
    $nisn = $pil["nisn"];
    $nama = $pil["nama"];
    $kelas = $pil["kelas"];

    $updatestatus = updatestatus($id);
    // if (!$updatestatus) {
    //     return false;
    // }

    $query = "INSERT INTO pilihan
    VALUES ('', '$nisn', '$nama', '$kelas')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function updatestatus($id)
{
    global $conn;
    $token = $id["token"];

    $query = "UPDATE dpt SET stat = 1 WHERE token = '$token'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM dpt WHERE token LIKE '%$keyword%'";

    return query($query);
}
