<?php
require '../functions.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM dpt WHERE token LIKE '%$keyword%'";

$dpt = query($query);
?>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Token</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <?php $i = 1; ?>
    <?php foreach ($dpt as $row) : ?>
        <tbody>
            <tr>
                <td scope="row"><?= $i; ?></td>
                <td><?= $row["token"]; ?></td>
                <td><?php if ($row["stat"] == 0) {
                        echo "Belum digunakan";
                    } else {
                        echo "Sudah digunakan";
                    } ?></td>
                <td>
                    <a href="hapusdpt.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin?');" class="badge text-bg-primary text-wrap" style="width: 6rem;">hapus</a>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
</table>