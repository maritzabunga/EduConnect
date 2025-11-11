<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_pengguna'])) {
    
    $_SESSION['nama_pengguna'] = $_POST['nama_pengguna'];
    $_SESSION['usia'] = $_POST['usia'];
    $_SESSION['ttl'] = $_POST['ttl'];
}
if (!isset($_SESSION['nama_pengguna'])) {
    $_SESSION['nama_pengguna'] = "Siti Harmione Granger";
    $_SESSION['status'] = "Siswa";
    $_SESSION['usia'] = "17 Tahun";
    $_SESSION['ttl'] = "Singkawang, 27 Maret 2007";
}

include 'header.php'; 
?>

<div class="content-wrapper">
    <div class="profile-card">
        <div class="profile-header-blue">
            <img src="img/siti.jpg" alt="Foto Profil" class="profile-pic-large" id="main-profile-pic">
            <h1 class="profile-name"><?php echo htmlspecialchars($_SESSION['nama_pengguna']); ?></h1>
            <span class="status-badge-white"><?php echo htmlspecialchars($_SESSION['status']); ?></span>
        </div>
        <div class="profile-body">
            <h2>Informasi Pribadi</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value"><?php echo htmlspecialchars($_SESSION['nama_pengguna']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tempat, Tanggal Lahir</span>
                    <span class="info-value"><?php echo htmlspecialchars($_SESSION['ttl']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Usia</span>
                    <span class="info-value"><?php echo htmlspecialchars($_SESSION['usia']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value"><?php echo htmlspecialchars($_SESSION['status']); ?></span>
                </div>
            </div>
            <a href="edit_profil.php" class="btn btn-primary btn-edit-bio">
                <i class="fas fa-pencil-alt"></i> Edit Biodata
            </a>
        </div>
    </div>

    <div class="search-card">
        <h2>Cari Pengguna Lain</h2>
        
        <div class="search-bar">
           <input type="text" id="search-user-input" placeholder="Cari pengguna...">
            <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
        </div>
        
        <ul class="user-list" id="user-list-container">
            <li class="user-item">
                <a href="profil_lain.php?user=sarah" class="user-link-wrapper">
                    <img src="img/sarah.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Sarah Indira</span>
                        <span class="user-status">Siswa</span>
                    </div>
                </a>
            </li>
            <li class="user-item">
                <a href="profil_lain.php?user=budi" class="user-link-wrapper">
                    <img src="img/budi.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Budi Santoso</span>
                        <span class="user-status">Siswa</span>
                    </div>
                </a>
            </li>
            <li class="user-item">
                <a href="profil_lain.php?user=muhammad_rei" class="user-link-wrapper">
                    <img src="img/rei.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Muhammad Rei</span>
                        <span class="user-status">Guru</span>
                    </div>
                </a>
            </li>
            <li class="user-item">
                <a href="profil_lain.php?user=citra_lestari" class="user-link-wrapper">
                    <img src="img/citra.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Citra Lestari</span>
                        <span class="user-status">Guru</span>
                    </div>
                </a>
            </li>
            <li class="user-item">
                <a href="profil_lain.php?user=tri_astuto" class="user-link-wrapper">
                    <img src="img/tri.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Tri Astuto</span>
                        <span class="user-status">Guru</span>
                    </div>
                </a>
            </li>
            <li class="user-item">
                <a href="profil_lain.php?user=eka" class="user-link-wrapper">
                    <img src="img/eka.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Eka Wijaya</span>
                        <span class="user-status">Siswa</span>
                    </div>
                </a>
            </li>
             <li class="user-item">
                <a href="profil_lain.php?user=fajar_sadman" class="user-link-wrapper">
                    <img src="img/fajar.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Fajar Sadman</span>
                        <span class="user-status">Siswa</span>
                    </div>
                </a>
            </li>
             <li class="user-item">
                <a href="profil_lain.php?user=gita_slavina" class="user-link-wrapper">
                    <img src="img/gita.jpg" alt="Avatar">
                    <div class="user-info">
                        <span class="user-name">Gita Slavina</span>
                        <span class="user-status">Siswa</span>
                    </div>
                </a>
            </li>
            
            <li id="no-results-message" class="user-item-none" style="display: none;">
                Pengguna tidak ditemukan
            </li>
        </ul>
    </div>
</div>

    </div> <script src="profil_script.js"></script>
</body>
</html>