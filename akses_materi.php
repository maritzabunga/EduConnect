<?php
session_start();
include 'config.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    die("User tidak ditemukan. Pastikan sudah login.");
}

$materi_id = $_GET['id'] ?? null;

if ($materi_id) {
    $check = $conn->query("SELECT * FROM riwayat_materi WHERE user_id=$userId AND materi_id=$materi_id");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO riwayat_materi (user_id, materi_id) VALUES ($userId, $materi_id)");
}


    $materi = $conn->query("SELECT * FROM materi WHERE id=$materi_id")->fetch_assoc();
}

if ($materi_id) {

    // Cek apakah user sudah pernah membuka materi ini
    $cekHistory = $conn->query("
        SELECT * FROM learning_history 
        WHERE user_id = $userId AND materi_id = $materi_id
    ");

    if ($cekHistory->num_rows == 0) {
        // Jika belum pernah, buat catatan baru
        $conn->query("
            INSERT INTO learning_history (user_id, materi_id, last_section)
            VALUES ($userId, $materi_id, 'Awal')
        ");
    } else {
        // Jika sudah pernah, update timestamp
        $conn->query("
            UPDATE learning_history 
            SET last_access = CURRENT_TIMESTAMP
            WHERE user_id = $userId AND materi_id = $materi_id
        ");
    }
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduConnect - Detail Materi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    main * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", sans-serif;
    }

    body {
      background-color: #f7f8fa;
      color: #222;
    }

    /* ===== KONTEN ===== */
    main {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 40px 80px;
      gap: 40px;
    }

    .content {
      flex: 2;
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    .sidebar {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .card,
    .video,
    .baca,
    .progress,
    .mentor,
    .related {
      background: white;
      border-radius: 14px;
      padding: 25px 30px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .tag {
      background: #1e56ff;
      color: white;
      font-size: 13px;
      padding: 5px 12px;
      border-radius: 8px;
      display: inline-block;
      font-weight: 500;
    }

    .title {
      font-size: 18px;
      font-weight: 600;
      margin: 10px 0;
    }

    .desc {
      color: #555;
      line-height: 1.6;
      font-size: 15px;
    }

    .info {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 18px;
      color: #666;
      font-size: 14px;
      margin-top: 12px;
    }

    /* === PERBAIKAN BAGIAN POIN BELAJAR & UKURAN FILE === */
    .file-info {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      margin-top: 20px;
    }

    .file-info .box {
      flex: 1;
      padding: 14px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      text-align: left;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #f9fafc;
      border: 1px solid #e5e8f0;
    }

    .file-info .box.point {
      background: #eaf6ff;
      color: #0a66c2;
      border: 1px solid #d5ebff;
    }

    .file-info .box.size {
      background: #f9fafc;
      color: #333;
    }

    .download-btn {
      margin-top: 20px;
      background: linear-gradient(to right, #16a34a, #22c55e);
      color: white;
      border: none;
      padding: 14px 20px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 500;
      width: 100%;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background 0.3s;
    }

    .download-btn:hover {
      background: linear-gradient(to right, #15803d, #16a34a);
    }

    .video iframe {
      width: 100%;
      height: 350px;
      border-radius: 10px;
      margin-top: 10px;
    }

    .baca-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }

    .badge {
      background: #daf5e4;
      color: #0a9b4f;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
    }

    .baca p {
      margin-top: 10px;
      line-height: 1.6;
      color: #444;
    }

    .baca ol {
      margin-left: 20px;
      line-height: 1.7;
    }

    .progress-bar {
      background: #eee;
      border-radius: 10px;
      overflow: hidden;
      height: 8px;
      margin: 8px 0;
    }

    .progress-fill {
      background: #1e56ff;
      width: 0%;
      height: 8px;
    }

    /* === KARTU MENTOR === */
    .mentor {
      background: linear-gradient(135deg, #1e56ff 0%, #3d7bff 100%);
      color: white;
      text-align: center;
      border-radius: 16px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      box-shadow: 0 3px 8px rgba(30, 86, 255, 0.25);
    }

    .mentor button {
      background: white;
      color: #1e56ff;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      font-size: 14px;
      margin-top: 8px;
    }

    .mentor button:hover {
      background: #e8edff;
      transform: translateY(-2px);
    }

    .related-item {
      background: #f0f3ff;
      padding: 10px 14px;
      border-radius: 8px;
      margin-top: 10px;
      font-size: 14px;
    }
  </style>
</head>

<body>

  <!-- ===== KONTEN DETAIL ===== -->
  <main>
    <div class="content">
      <div class="card">
        <div class="tag">Pemrograman</div>
        <div class="title"><?= $materi['judul'] ?></div>
        <div class="desc">
          Pelajari dasar-dasar algoritma dan struktur data yang penting untuk pemrograman. Materi mencakup array, linked list, stack, queue, dan tree.
        </div>
        <div class="info">
          <span>👤 Dr. Budi Santoso</span>
          <span>⏱ 45 menit</span>
          <span>👁 1234 views</span>
          <span>📅 20/10/2025</span>
        </div>

        <!-- PERBAIKAN BAGIAN INI -->
        <div class="file-info">
          <div class="box point">✅ Materi ini akan menambah 10 poin belajar</div>
          <div class="box size">⬇ Ukuran File<br><strong>2.4 MB</strong></div>
        </div>
        <button class="download-btn">⬇ Unduh Materi</button>
      </div>

      <div class="video">
        <h3>Video Pembelajaran</h3>
        <iframe src="https://www.youtube.com/embed/8hly31xKli0" allowfullscreen></iframe>
      </div>

      <div class="baca">
        <div class="baca-header">
          <h3>Baca Online</h3>
          <span class="badge">Interaktif</span>
        </div>
        <p><strong>Pengenalan Algoritma dan Struktur Data</strong></p>
        <p>
          Algoritma adalah serangkaian langkah-langkah terstruktur untuk menyelesaikan suatu masalah. Struktur data adalah cara mengorganisir dan menyimpan data agar dapat digunakan secara efisien.
        </p>
        <ol>
          <li><b>Array:</b> Menyimpan kumpulan elemen dengan tipe data yang sama.</li>
          <li><b>Linked List:</b> Struktur data linear dengan node yang saling terhubung.</li>
          <li><b>Stack:</b> Mengikuti prinsip LIFO (Last In First Out).</li>
          <li><b>Queue:</b> Mengikuti prinsip FIFO (First In First Out).</li>
        </ol>
        <button class="btn">Tandai Selesai & Dapatkan Poin</button>
      </div>
    </div>

    <div class="sidebar">
      <div class="progress">
        <h4>Progres Pembelajaran</h4>
        <p>Dibaca: 0%</p>
        <div class="progress-bar">
          <div class="progress-fill"></div>
        </div>
        <small>Total Waktu Belajar: 0 / 45 menit</small>
      </div>

      <div class="mentor">
        <p><b>Dr. Budi Santoso</b></p>
        <span>Mentor</span>
        <button>Hubungi Mentor</button>
      </div>

      <div class="related">
        <h4>Materi Terkait</h4>
        <div class="related-item">Materi Lanjutan Pemrograman Part 1<br /><small>45 menit</small></div>
        <div class="related-item">Materi Lanjutan Pemrograman Part 2<br /><small>45 menit</small></div>
      </div>
    </div>
  </main>
  <script src="js/point_popup.js"></script>
  <script src="js/point_tracker.js"></script>
</body>
</html>