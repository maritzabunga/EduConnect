<?php
require_once 'config.php';

$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
$output = '';

if (empty($keyword)) {
    $output = '<p style="text-align: center; color: var(--dark-grey);">Masukkan kata kunci!</p>';
} else {
    // Query Mentor (sama seperti sebelumnya)
    $sql_mentor = "SELECT id, nama, email, foto, deskripsi FROM mentor WHERE nama LIKE ? LIMIT 10";
    $stmt_mentor = $conn->prepare($sql_mentor);
    $search_term = "%$keyword%";
    $stmt_mentor->bind_param("s", $search_term);
    $stmt_mentor->execute();
    $result_mentor = $stmt_mentor->get_result();
    $mentors = $result_mentor->fetch_all(MYSQLI_ASSOC);

    // Query Materi (sama seperti sebelumnya)
    $sql_materi = "SELECT m.id, m.judul, m.deskripsi, m.file_path, ment.nama AS mentor_nama 
                   FROM materi m 
                   LEFT JOIN mentor ment ON m.mentor_id = ment.id 
                   WHERE m.judul LIKE ? OR m.deskripsi LIKE ? LIMIT 10";
    $stmt_materi = $conn->prepare($sql_materi);
    $stmt_materi->bind_param("ss", $search_term, $search_term);
    $stmt_materi->execute();
    $result_materi = $stmt_materi->get_result();
    $materis = $result_materi->fetch_all(MYSQLI_ASSOC);

    // Include template partial
    ob_start(); // Capture output dari include
    include 'search_results.php';
    $output = ob_get_clean();
}

echo $output;
$conn->close();
?>