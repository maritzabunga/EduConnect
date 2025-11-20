<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$query = "
    SELECT r.waktu, m.judul, m.kategori, m.durasi, m.poin
    FROM riwayat_materi r
    JOIN materi m ON r.materi_id = m.id
    WHERE r.user_id = $userId
    ORDER BY r.waktu DESC
";

$result = $conn->query($query);

include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<title>Riwayat Belajar</title>
<link rel="stylesheet" href="profil_style.css">
</head>
<body>

<main style="padding:40px">
    <h2>Riwayat Belajar Kamu</h2>
    <br>

    <table border="1" cellpadding="12" cellspacing="0" width="100%">
        <tr>
            <th>Materi</th>
            <th>Kategori</th>
            <th>Durasi</th>
            <th>Poin</th>
            <th>Waktu Diakses</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['kategori'] ?></td>
            <td><?= $row['durasi'] ?></td>
            <td><?= $row['poin'] ?></td>
            <td><?= $row['waktu'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

</body>
</html>
