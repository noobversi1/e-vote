<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

include_once '../config/database.php';
include_once '../objects/Calon.php';
include_once '../objects/Token.php';
include_once '../objects/Vote.php';
include_once '../config/helpers.php';

$database = new Database();
$db = $database->getConnection();

$calon = new Calon($db);
$token = new Token($db);
$vote = new Vote($db);

// Mengambil data calon
$query = "SELECT * FROM calon";
$stmt = $db->prepare($query);
$stmt->execute();
$calon_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data token
$query = "SELECT * FROM token";
$stmt = $db->prepare($query);
$stmt->execute();
$token_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengambil hasil voting
$query = "SELECT vote.calon_id, calon.nama, COUNT(vote.calon_id) as jumlah_suara FROM vote JOIN calon ON vote.calon_id = calon.id GROUP BY vote.calon_id";
$stmt = $db->prepare($query);
$stmt->execute();
$vote_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Membuat array asosiatif untuk jumlah suara berdasarkan calon_id
$jumlah_suara = [];
foreach ($vote_result as $result) {
    $jumlah_suara[$result['calon_id']] = $result['jumlah_suara'];
}

// Mendapatkan kata kunci pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mengatur jumlah token per halaman
$limit = 15;

// Mengambil nomor halaman dari URL, jika tidak ada default halaman 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Menghitung offset
$offset = ($page - 1) * $limit;

// Mengambil daftar token dari database dengan pagination dan pencarian
$query = "SELECT * FROM token WHERE token LIKE :search LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
$stmt->execute();
$token_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Menghitung total token untuk pagination
$query = "SELECT COUNT(*) FROM token WHERE token LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->execute();
$total_tokens = $stmt->fetchColumn();

// Menghitung total halaman
$total_pages = ceil($total_tokens / $limit);

// Menentukan jumlah halaman yang akan ditampilkan di pagination
$max_links = 7; // Jumlah link halaman yang akan ditampilkan
$start = max(1, $page - floor($max_links / 2));
$end = min($total_pages, $page + floor($max_links / 2));

// Jika halaman awal lebih kecil dari 1, atur start ke 1
if ($start < 1) {
    $start = 1;
    $end = min($total_pages, $max_links);
}

// Jika halaman akhir lebih besar dari total halaman, atur end ke total_pages
if ($end > $total_pages) {
    $end = $total_pages;
    $start = max(1, $total_pages - $max_links + 1);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="..\bootstrap\css\bootstrap.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <script>
        function confirmReset() {
            if (confirm("Apakah Anda yakin akan mereset aplikasi ini? Seluruh data tidak akan bisa dikembalikan setelah Anda menekan Ya.")) {
                window.location.href = 'reset_data.php';
            }
        }

        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus calon ini?")) {
                window.location.href = 'delete_calon.php?id=' + id;
            }
        }
    </script>
</head>

<body>
    <div class="container bg-body-tertiary">

        <?php include '../assets/header.php' ?>

        <h2 class="text-center mb-3 my-3">Daftar Calon <?= $kontes; ?></h2>

        <div class="justify-content-center row row-cols-1 row-cols-md-3 g-3">
            <?php foreach ($calon_list as $calon) : ?>
                <div class="col">
                    <div class="card h-100 text-bg-info text-center border-info mb-3" style="width: 18rem;">
                        <img src="<?= $calon['foto']; ?>" class="card-img-top" alt="foto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $calon['nama']; ?></h5>
                            <p class="card-text">Jumlah Suara: <?php echo isset($jumlah_suara[$calon['id']]) ? $jumlah_suara[$calon['id']] : 0; ?></p>
                            <a href="detail_calon.php?id=<?= $calon['id']; ?>" class="btn btn-primary">Lihat</a>
                            <button class="btn btn-warning" onclick="confirmDelete(<?= $calon['id']; ?>)">Hapus</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <hr>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand">Daftar Token</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToken" aria-controls="navbarToken" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarToken">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <form action="buat_token_process.php" method="post" class="d-flex">
                        <input class="form-control me-2" type="number" name="jumlah" placeholder="Buat Token" required>
                        <button class="btn btn-outline-primary" type="submit">Buat</button>
                    </form>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <form method="GET" action="dashboard.php" class="d-flex" role="search">
                        <input type="search" name="search" class="form-control me-2" placeholder="Cari token..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                        <button class="btn btn-outline-success" type="submit">Cari</button>
                    </form>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <form action="export_token.php" method="post" class="d-flex">
                        <button class="btn btn-secondary" type="submit">Export Token</button>
                    </form>
                </div>
            </div>
        </nav>

        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Token</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($token_list as $token) : ?>

                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $token['token']; ?></td>
                        <td><?= $token['status'] ? 'Digunakan' : 'Belum Digunakan'; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div>
            <p>Halaman: <?= $page; ?> dari <?= $total_pages; ?> Halaman</p>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
            <button class="btn btn-danger" onclick="confirmReset()">Reset Aplikasi</button>
        </div>

        <?php include '../assets/footer.php' ?>

    </div>
    <script src="..\bootstrap\js\bootstrap.bundle.js"></script>
</body>

</html>