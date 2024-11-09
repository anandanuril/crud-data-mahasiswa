<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

require 'fungsi.php';

// Proses registrasi
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password di-hash sebelum disimpan ke database

    // Periksa apakah username sudah terdaftar
    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($result) > 0) {
        $error = "Username sudah terdaftar.";
    } else {
        // Jika username belum terdaftar, lakukan proses insert ke database
        $insert = mysqli_query($koneksi, "INSERT INTO user (username, password) VALUES ('$username', '$password')");

        if ($insert) {
            // Jika berhasil, mengarahkan ke halaman login.php dengan parameter registered=true
            header('Location: login.php?registered=true');
            exit;
        } else {
            // Jika gagal, menampilkan pesan kesalahan
            $error = "Gagal melakukan registrasi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - DATA MAHASISWA</title>
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
                        <a class="nav-link" href="login.php">Login</a>
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
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <div class="card-container">
                    <form action="" method="POST">
                        <h4 class="my-5 fw-bold">Register</h4>
                        <div class="my-5">
                            <input type="text" class="form-control w-50 mx-auto" name="username" placeholder="Username" required>
                        </div>
                        <div class="my-5">
                            <input type="password" class="form-control w-50 mx-auto" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary text-uppercase">Register</button>
                        <p class="mt-3">Sudah memiliki akun? <a href="login.php">Login sekarang</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
