<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: index.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Vote.php';
include_once '../objects/Token.php';

$database = new Database();
$db = $database->getConnection();

$vote = new Vote($db);
$token = new Token($db);

// Mengambil ID token berdasarkan token acak yang disimpan di sesi
$query = "SELECT id FROM token WHERE token = :token";
$stmt = $db->prepare($query);
$stmt->bindParam(':token', $_SESSION['token']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $vote->token_id = $row['id'];
    $vote->calon_id = $_POST['calon_id'];

    if ($vote->vote()) {
        $token->updateTokenStatus($_SESSION['token']);
        unset($_SESSION['token']);
        echo "<script>
            alert('Terima kasih telah memilih.');
            window.location.href = 'logout_token.php';
            </script>";
    } else {
        echo "<script>
            alert('Gagal melakukan pemilihan. Coba lagi.');
            window.location.href = 'daftar_calon.php';
            </script>";
    }
} else {
    echo "<script>
            alert('Token tidak valid.');
            window.location.href = 'logout_token.php';
            </script>";
    echo "Token tidak valid.";
}
