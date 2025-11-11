<?php
session_start();
include 'config.php';

// === 1. CEK LOGIN ===
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'msg' => 'User tidak login']);
    exit;
}

$userId = $_SESSION['user_id'];
$contentId = $_POST['content_id'] ?? null;
$contentType = $_POST['content_type'] ?? null; // 'article' atau 'video'
$progress = $_POST['progress'] ?? 0;

// === 2. VALIDASI INPUT ===
if (!$contentId || !$contentType || $progress < 95) {
    echo json_encode(['success' => false, 'msg' => 'Progres belum selesai (min 95%)']);
    exit;
}

if (!in_array($contentType, ['article', 'video'])) {
    echo json_encode(['success' => false, 'msg' => 'Tipe konten tidak valid']);
    exit;
}

// === 3. CEK APAKAH SUDAH PERNAH DAPAT POIN ===
$stmt = $conn->prepare("
    SELECT completed FROM user_progress 
    WHERE user_id = ? AND content_id = ? AND content_type = ?
");
$stmt->bind_param("iis", $userId, $contentId, $contentType);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0 && $result->fetch_assoc()['completed']) {
    echo json_encode(['success' => false, 'msg' => 'Sudah mendapat poin sebelumnya']);
    exit;
}

// === 4. AMBIL NILAI POIN DARI DB ===
$points = 0;
$table = $contentType === 'article' ? 'articles' : 'videos';

$stmt = $conn->prepare("SELECT points_value FROM $table WHERE id = ?");
$stmt->bind_param("i", $contentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $points = (int)$row['points_value'];
} else {
    echo json_encode(['success' => false, 'msg' => 'Konten tidak ditemukan']);
    exit;
}

if ($points <= 0) {
    echo json_encode(['success' => false, 'msg' => 'Poin tidak valid']);
    exit;
}

// === 5. TAMBAH POIN KE USER ===
$update = $conn->query("UPDATE users SET points = points + $points WHERE id = $userId");
if (!$update) {
    echo json_encode(['success' => false, 'msg' => 'Gagal update poin user']);
    exit;
}

// === 6. LOG POIN ===
$log = $conn->prepare("
    INSERT INTO point_logs (user_id, content_id, content_type, points_earned) 
    VALUES (?, ?, ?, ?)
");
$log->bind_param("iisi", $userId, $contentId, $contentType, $points);
$log->execute();

// === 7. UPDATE PROGRES ===
$progressStmt = $conn->prepare("
    INSERT INTO user_progress (user_id, content_id, content_type, completed, progress_percent) 
    VALUES (?, ?, ?, 1, 100) 
    ON DUPLICATE KEY UPDATE completed = 1, progress_percent = 100
");
$progressStmt->bind_param("iis", $userId, $contentId, $contentType);
$progressStmt->execute();

// === 8. RESPON SUKSES ===
echo json_encode([
    'success' => true,
    'msg' => 'Poin berhasil ditambahkan!',
    'points' => $points,
    'total_points' => getUserPoints($conn, $userId) // opsional: total poin sekarang
]);

// === FUNGSI BANTU: Ambil total poin user ===
function getUserPoints($conn, $userId) {
    $stmt = $conn->prepare("SELECT points FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['points'] ?? 0;
}
?>