<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$mentors = [];
$materis = [];
$error = '';

if (empty($keyword)) {
    $error = 'Masukkan kata kunci pencarian!';
} else {
    // Query Mentor
    $sql_mentor = "SELECT id, nama, email, foto, deskripsi FROM mentor WHERE nama LIKE ? LIMIT 10";
    $stmt_mentor = $conn->prepare($sql_mentor);
    $search_term = "%$keyword%";
    $stmt_mentor->bind_param("s", $search_term);
    $stmt_mentor->execute();
    $result_mentor = $stmt_mentor->get_result();
    $mentors = $result_mentor->fetch_all(MYSQLI_ASSOC);

    // Query Materi
    $sql_materi = "SELECT m.id, m.judul, m.deskripsi, m.file_path, m.gambar, m.kategori, 
                          m.views, m.durasi, ment.nama AS mentor_nama 
                   FROM materi m 
                   LEFT JOIN mentor ment ON m.mentor_id = ment.id 
                   WHERE m.judul LIKE ? OR m.deskripsi LIKE ? LIMIT 10";
    $stmt_materi = $conn->prepare($sql_materi);
    $stmt_materi->bind_param("ss", $search_term, $search_term);
    $stmt_materi->execute();
    $result_materi = $stmt_materi->get_result();
    $materis = $result_materi->fetch_all(MYSQLI_ASSOC);

    if (empty($mentors) && empty($materis)) {
        $error = 'Tidak ada hasil ditemukan untuk "' . htmlspecialchars($keyword) . '". Coba kata kunci lain!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - EduConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="profil_style.css">
    <link rel="stylesheet" href="search_style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-container">
        <div class="content-wrapper-center">
            <div class="search-results-container">
                <div class="search-results-container">
    <?php if ($error): ?>
    <div class="no-results">
        <div class="no-results-icon">
            <i class="fas fa-search"></i>
        </div>
        <h1 class="no-results-title"><?php echo $error; ?></h1>
        <p class="no-results-subtitle">
            Coba gunakan kata kunci lain atau periksa ejaan Anda.
        </p>
        <a href="dashboard_utama.php" class="btn btn-primary error-btn">
            Kembali ke Beranda
        </a>
    </div>
<?php else: ?>
        <!-- JIKA ADA HASIL: Hanya judul pencarian, TANPA tombol kembali -->
        <div class="search-header">
            <h1 class="search-title">Hasil Pencarian: "<?php echo htmlspecialchars($keyword); ?>"</h1>
            <!-- TOMBOL DIHAPUS DI SINI -->
        </div>

        <!-- PEOPLE: Mentor Horizontal -->
        <?php if (!empty($mentors)): ?>
        <section class="people-section">
            <div class="people-header">
                <h2>Mentor</h2>
            </div>
            <div class="people-bar">
                <?php if (empty($mentors)): ?>
                    <p class="no-result-text">Tidak ada mentor ditemukan.</p>
                <?php else: ?>
                    <?php foreach ($mentors as $mentor): ?>
                        <div class="people-item">
                            <div class="people-avatar">
                                <img src="<?php echo htmlspecialchars($mentor['foto'] ?? 'img/default-avatar.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($mentor['nama']); ?>">
                            </div>
                            <div class="people-name"><?php echo htmlspecialchars($mentor['nama']); ?></div>
                            <div class="people-username">
                                @<?php echo strtolower(str_replace(' ', '', $mentor['nama'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- MATERI: Grid 2 Kolom -->
        <section class="materi-section">
            <h2 class="section-title">Materi (<?php echo count($materis); ?> hasil)</h2>
            <?php if (empty($materis)): ?>
                <p class="no-result-text">Tidak ada materi ditemukan.</p>
            <?php else: ?>
                <div class="materi-grid">
                    <?php foreach ($materis as $materi): ?>
                        <?php
                        $views = $materi['views'] > 0 ? $materi['views'] . ' kali dilihat' : rand(100, 2000) . ' kali dilihat';
                        $durasi = $materi['durasi'] > 0 ? $materi['durasi'] . ' menit' : rand(30, 90) . ' menit';
                        $kategori = $materi['kategori'] ?? 'Umum';
                        ?>
                        <div class="materi-card">
                            <div class="card-image" 
                                 style="background-image: url('<?php echo htmlspecialchars($materi['gambar'] ?? 'img/default-cover.jpg'); ?>');">
                                <span class="category-badge"><?php echo htmlspecialchars($kategori); ?></span>
                            </div>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($materi['judul']); ?></h3>
                                <p class="materi-desc"><?php echo substr($materi['deskripsi'], 0, 100) . '...'; ?></p>
                                <div class="card-meta">
                                    <span class="views"><?php echo $views; ?></span>
                                    <span class="duration"><?php echo $durasi; ?></span>
                                </div>
                                <p class="materi-author">Oleh: <?php echo htmlspecialchars($materi['mentor_nama'] ?? 'Unknown'); ?></p>
                                <?php if ($materi['file_path']): ?>
                                    <a href="<?php echo htmlspecialchars($materi['file_path']); ?>" 
                                       target="_blank" class="btn btn-green btn-small">Unduh Materi</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</div>
            </div>
        </div>
    </div>

    <script src="search_script.js"></script>
</body>
</html>