<?php
class Calon
{
    private $conn;
    private $table_name = "calon";

    public $id;
    public $nama;
    public $nisn;
    public $kelas;
    public $jenis_kelamin;
    public $tanggal_lahir;
    public $visi;
    public $misi;
    public $foto;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function tambahCalon()
    {
        $query = "INSERT INTO " . $this->table_name . " SET nama=:nama, nisn=:nisn, kelas=:kelas, jenis_kelamin=:jenis_kelamin, tanggal_lahir=:tanggal_lahir, visi=:visi, misi=:misi, foto=:foto";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":nisn", $this->nisn);
        $stmt->bindParam(":kelas", $this->kelas);
        $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
        $stmt->bindParam(":tanggal_lahir", $this->tanggal_lahir);
        $stmt->bindParam(":visi", $this->visi);
        $stmt->bindParam(":misi", $this->misi);
        $stmt->bindParam(":foto", $this->foto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getDetail()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nama = $row['nama'];
            $this->nisn = $row['nisn'];
            $this->kelas = $row['kelas'];
            $this->jenis_kelamin = $row['jenis_kelamin'];
            $this->tanggal_lahir = $row['tanggal_lahir'];
            $this->visi = $row['visi'];
            $this->misi = $row['misi'];
            $this->foto = $row['foto'];
        }
    }

    // Fungsi untuk menghapus calon dari database dan menghapus file foto
    public function delete()
    {
        // Mengambil path foto sebelum menghapus data calon
        $query = "SELECT foto FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->foto = $row['foto'];

        // Menghapus data dari tabel vote yang terkait
        $query = "DELETE FROM vote WHERE calon_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        // Menghapus data calon dari database
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            // Menghapus file foto dari folder uploads
            if (file_exists($this->foto)) {
                unlink($this->foto);
            }
            return true;
        }

        return false;
    }

    // Fungsi untuk membaca satu calon berdasarkan ID
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama = $row['nama'];
        $this->nisn = $row['nisn'];
        $this->kelas = $row['kelas'];
        $this->jenis_kelamin = $row['jenis_kelamin'];
        $this->tanggal_lahir = $row['tanggal_lahir'];
        $this->foto = $row['foto'];
        $this->visi = $row['visi'];
        $this->misi = $row['misi'];
    }

    // Fungsi untuk memperbarui data calon
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                SET nama = :nama, nisn = :nisn, kelas = :kelas, 
                jenis_kelamin = :jenis_kelamin, tanggal_lahir = :tanggal_lahir, 
                foto = :foto, visi = :visi, misi = :misi
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':nisn', $this->nisn);
        $stmt->bindParam(':kelas', $this->kelas);
        $stmt->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam(':tanggal_lahir', $this->tanggal_lahir);
        $stmt->bindParam(':foto', $this->foto);
        $stmt->bindParam(':visi', $this->visi);
        $stmt->bindParam(':misi', $this->misi);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
