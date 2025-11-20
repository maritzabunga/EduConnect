<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$query = "
    SELECT 
        r.waktu, 
        m.judul, 
        m.kategori,
        lh.last_section,
        m.id AS materi_id
    FROM riwayat_materi r
    JOIN materi m ON r.materi_id = m.id
    LEFT JOIN learning_history lh 
        ON lh.user_id = r.user_id 
        AND lh.materi_id = r.materi_id
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
<style>
table {
    border-collapse: collapse;
    width: 100%;
    background: white;
    font-size: 15px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

/* ✨ Lebar kolom rapi & sejajar */
th:nth-child(1), td:nth-child(1) { width: 45%; }  
th:nth-child(2), td:nth-child(2) { width: 20%; }  
th:nth-child(3), td:nth-child(3) { width: 25%; }  

th {
    background: #1e56ff;
    color: white;
}

tr:hover {
    background: #f2f7ff;
}

</style>
</head>

<body>
<main style="padding:40px">
    <h2>Riwayat Belajar Kamu</h2>
    <br>

  <table>
    <colgroup>
        <col style="width: 35%;"> 
        <col style="width: 15%;">   
        <col style="width: 20%;">   
    </colgroup>

    <tr>
        <th>Materi</th>
        <th>Kategori</th>
        <th>Terakhir Diakses</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td>
    <a href="akses_materi.php?id=<?= $row['materi_id'] ?>" style="text-decoration:none; color:#1e56ff;">
        <?= $row['judul'] ?>
    </a>
</td>

        <td><?= $row['kategori'] ?></td>
        <td><?= $row['waktu'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</main>
  <script src="js/point_popup.js"></script>
  <script src="js/point_tracker.js"></script>

  <script>
  window.onload = function () {
      let section = "<?= $last_section ?>";

      if(section !== "Awal") {
          let el = document.getElementById(section);
          if(el) {
              el.scrollIntoView({behavior:"smooth"});
          }
      }
  };
  </script>

</body>
</html>