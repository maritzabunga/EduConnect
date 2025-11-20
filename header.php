<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="profil_style.css">
    <link rel="stylesheet" href="search_bar.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <a href="dashboard_utama.php" class="logo">
                <span>🎓 EduConnect</span>
            </a>
            <ul class="nav-links">
                <li><a href="dashboard_utama.php">Beranda</a></li>
                <li><a href="kalender.php">Kalender</a></li>
                <li><a href="#">Laporan</a></li>
                <li><a href="riwayat.php">Riwayat</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <div class="search-wrapper" id="search-wrapper">
                <a href="#" class="nav-icon search-toggle" id="search-toggle"><i class="fas fa-search"></i></a>
                <input type="text" id="search-input" placeholder="Cari kata kunci..." class="search-input">
                <a href="#" class="nav-icon close-search" id="close-search" style="display: none;"><i class="fas fa-times"></i></a>
            </div>
            
            <a href="biodata.php" class="nav-icon">
                <img src="img/siti.jpg" alt="Profil" id="header-profile-pic" class="nav-profile-pic">
            </a>
            
            <a href="index.php" class="btn-keluar">Keluar</a>
        </div>
    </nav>

    <div class="main-container">
    <script src="search_bar.js"></script>
    <script src="search_script.js"></script>
</body>
</html>