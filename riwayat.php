<?php
session_start();
include 'config.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    die("User tidak ditemukan. Pastikan sudah login.");
}

// Ambil riwayat user
$query = "
    SELECT lh.*, rm.judul, rm.kategori, rm.warna, rm.file_path
    FROM learning_history lh
    JOIN riwayat_materi rm ON lh.materi_id = rm.id
    WHERE lh.user_id = $userId
    ORDER BY lh.last_access DESC
";

$riwayat = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Belajar</title>

    <style>
        body {
            background: #f7f8fa;
            font-family: "Inter", sans-serif;
            padding: 40px;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            cursor: pointer;
            transition: 0.2s;
            color: white;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .category {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .time {
            font-size: 13px;
            opacity: 0.8;
        }
    </style>

</head>
<body>

<h2>Riwayat Belajar</h2>

<div class="list">

    <?php if ($riwayat->num_rows > 0): ?>
        <?php while ($row = $riwayat->fetch_assoc()): ?>
            
            <a href="akses_materi.php?id=<?= $row['materi_id'] ?>" style="text-decoration:none;">
                <div class="card" style="background: <?= $row['warna'] ?>;">
                    <div class="title"><?= $row['judul'] ?></div>
                    <div class="category"><?= $row['kategori'] ?></div>
                    <div class="time">Terakhir dibuka: <?= $row['last_access'] ?></div>
                </div>
            </a>

        <?php endwhile; ?>
    <?php else: ?>
        <p>Belum ada riwayat belajar.</p>
    <?php endif; ?>

</div>

</body>
</html>
