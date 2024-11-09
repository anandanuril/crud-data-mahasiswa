<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

require 'fungsi.php';

// Memeriksa apakah form login telah disubmit
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password menggunakan MD5

    // Query untuk memeriksa kecocokan username dan password di database
    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");

    // Jika ditemukan hasil query (username dan password cocok)
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['login'] = true; // Set session login menjadi true
        header('Location: index.php'); // Alihkan ke halaman index setelah login berhasil
        exit;
    } else {
        $error = true; // Jika tidak ditemukan, set variabel error untuk menampilkan pesan kesalahan
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DATA MAHASISWA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">DATA MAHASISWA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nilai.php">Nilai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->

    <!-- Container -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <?php if (isset($_GET['registered']) && $_GET['registered'] == 'true') : ?>
                    <div class="alert alert-success" role="alert">
                        Akun berhasil dibuat, silakan login!
                    </div>
                <?php endif; ?>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        Username atau Password salah!
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <h4 class="my-5 fw-bold">Login</h4>
                    <div class="my-5">
                        <input type="text" class="form-control w-50 mx-auto" name="username" placeholder="Username" required>
                    </div>
                    <div class="my-5">
                        <input type="password" class="form-control w-50 mx-auto" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary text-uppercase">Login</button>
                    <p class="mt-3">Belum memiliki akun? <a href="register.php">Register sekarang</a></p>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
