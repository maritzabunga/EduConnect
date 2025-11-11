<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php'; 

// --- UNTUK PROFIL PENGGUNA LAIN ---
$userName = "Pengguna Tidak Dikenal";
$userStatus = "-";
$userImage = "img/avatar_kosong.jpg"; 

if (isset($_GET['user'])) {
    $userKey = $_GET['user'];
    if ($userKey == 'budi') {
        $userName = "Budi Santoso";
        $userStatus = "Siswa";
        $userImage = "img/budi.jpg"; 
    } else if ($userKey == 'sarah') {
        $userName = "Sarah Indira";
        $userStatus = "Siswa";
        $userImage = "img/sarah.jpg";
    } else if ($userKey == 'muhammad_rei') {
        $userName = "Muhammad Rei";
        $userStatus = "Guru";
        $userImage = "img/rei.jpg";
    } else if ($userKey == 'citra_lestari') {
        $userName = "Citra Lestari";
        $userStatus = "Guru";
        $userImage = "img/citra.jpg";
    } else if ($userKey == 'tri_astuto') {
        $userName = "Tri Astuto";
        $userStatus = "Siswa";
        $userImage = "img/tri.jpg";
    } else if ($userKey == 'eka') {
        $userName = "Eka Wijaya";
        $userStatus = "Siswa";
        $userImage = "img/eka.jpg"; 
    } else if ($userKey == 'fajar_sadman') {
        $userName = "Fajar Sadman";
        $userStatus = "Siswa";
        $userImage = "img/fajar.jpg"; 
    } else if ($userKey == 'gita_slavina') {
        $userName = "Gita Slavina";
        $userStatus = "Guru";
        $userImage = "img/gita.jpg"; 
    }
}
?>

 
<div class="content-wrapper-center">
    <div class="card-simple text-center">
        
        <img src="<?php echo $userImage; ?>" alt="Foto Profil" class="profile-pic-medium">
        
        <div class="other-profile-info">
            <span class="info-label">Nama Pengguna</span>
            <h1 class="other-profile-name"><?php echo htmlspecialchars($userName); ?></h1>
            
            <span class="info-label">Status</span>
            <h2 class="other-profile-status"><?php echo htmlspecialchars($userStatus); ?></h2>
        </div>

        <a href="biodata.php" class="btn btn-primary btn-kembali">Kembali</a>

    </div>
</div>

    </div> <script src="profil_script.js"></script>
</body>
</html>