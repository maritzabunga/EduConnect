<?php
$host = 'localhost';
$dbname = 'educonnect'; // Ganti nama DB-mu di phpMyAdmin
$username = 'root'; // Default phpMyAdmin
$password = ''; // Default kosong

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>