<?php
session_start();
include 'koneksi.php'; // Menggunakan koneksi.php

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($nama) || empty($email) || empty($password)) {
        $error = "Semua kolom wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email sudah digunakan!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user (Database akan otomatis mengisi status='Siswa' dan foto='img/avatar.png' sesuai default)
            $stmt = $conn->prepare("INSERT INTO users (nama_pengguna, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hashed_password);

            if ($stmt->execute()) {
                // Ambil ID user yang baru dibuat
                $user_id = $conn->insert_id;

                // Set session (langsung login)
                $_SESSION['user_id'] = $user_id;
                $_SESSION['nama_pengguna'] = $nama;
                // Set default session agar dashboard tidak error
                $_SESSION['status'] = 'Siswa'; 
                $_SESSION['foto'] = 'img/avatar.png';

                $success = "Pendaftaran berhasil! Mengarahkan ke dashboard...";
                // Redirect ke dashboard.php
                echo "<script>setTimeout(() => { window.location.href = 'dashboard.php'; }, 1500);</script>";
            } else {
                $error = "Terjadi kesalahan. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - EduConnect</title>
    <link rel="stylesheet" href="main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .error-msg {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
        .success-msg {
            color: #10b981;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Daftar ke EduConnect</h2>
        <p>Mulai perjalanan pembelajaran Anda hari ini</p>
        
        <form method="post" onsubmit="return validatePassword()">
            <input type="text" name="nama" placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
            <input type="email" name="email" placeholder="Masukkan email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
            <input type="password" id="confirmPassword" placeholder="Konfirmasi kata sandi" required>
            <button type="submit" class="btn-primary-landing">Daftar</button>
        </form>

        <?php if ($error): ?>
            <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success-msg"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
    </div>

    <script src="main_script.js"></script>
</body>
</html>