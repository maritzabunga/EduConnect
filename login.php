<?php
session_start();
include 'config.php'; // Pastikan koneksi DB

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek user di database
    $stmt = $conn->prepare("SELECT id, nama_pengguna, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password (asumsi password disimpan dengan password_hash)
        if (password_verify($password, $user['password'])) {
            // SET SESSION DI SINI
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama_pengguna'] = $user['nama_pengguna'];

            // Redirect ke dashboard
            header("Location: dashboard_utama.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .error-msg {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login ke EduConnect</h2>
        <p>Mulai perjalanan pembelajaran Anda hari ini</p>
        
        <form method="post">
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