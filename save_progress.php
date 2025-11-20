<?php
include "koneksi.php";
session_start();

$user_id = $_SESSION['user_id'];
$materi_id = $_POST['materi_id'];
$section = $_POST['section'];

// insert or update
$query = "INSERT INTO learning_history (user_id, materi_id, last_section) 
          VALUES ('$user_id', '$materi_id', '$section')
          ON DUPLICATE KEY UPDATE 
          last_section = '$section', 
          last_access = NOW()";

mysqli_query($conn, $query);
?>