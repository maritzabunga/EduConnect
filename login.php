<?php
ob_start(); // Mencegah error header
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Ambil data user berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            
            // Set Session Lengkap
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama_pengguna'] = $user['nama_pengguna'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['foto'] = $user['foto'];

            // ALUR: Redirect langsung ke dashboard.php
            header("Location: dashboard_utama.php");
            exit();
        } else {
            $error = "Kata sandi salah!";
        }
    } else {
        $error = "Email tidak terdaftar!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduConnect</title>
    <link rel="stylesheet" href="main_style.css">
    <style>
        .error-msg { color: #dc3545; font-size: 14px; margin-top: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login ke EduConnect</h2>
        <p>Mulai perjalanan pembelajaran Anda hari ini</p>
        
        <form method="post" action="">
            <input type="email" name="email" placeholder="Masukkan email" required>
            <input type="password" name="password" placeholder="Masukkan kata sandi" required>
            <button type="submit" class="btn-primary-landing">Login</button>
        </form>

        <?php if ($error): ?>
            <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>