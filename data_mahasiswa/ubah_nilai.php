<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

// Memeriksa apakah parameter 'nim' dan 'semester' ada di URL
if (isset($_GET['nim']) && isset($_GET['semester'])) {
    $nim = $_GET['nim'];
    $semester = $_GET['semester'];

    // Query untuk mengambil data nilai mahasiswa berdasarkan NIM dan semester
    $query = "SELECT * FROM nilai WHERE nim = ? AND semester = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nim, $semester);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Memeriksa apakah data ditemukan
    if ($result && mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data nilai tidak ditemukan.";
        exit;
    }
} else {
    echo "Parameter nim atau semester tidak valid.";
    exit;
}

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    $nilai = $_POST['nilai'];

    // Query untuk mengupdate data nilai
    $query_update = "UPDATE nilai SET nilai = ? WHERE nim = ? AND semester = ?";
    $stmt_update = mysqli_prepare($koneksi, $query_update);
    mysqli_stmt_bind_param($stmt_update, 'sss', $nilai, $nim, $semester);
    $result_update = mysqli_stmt_execute($stmt_update);


    // Memeriksa apakah update berhasil
    if ($result_update) {
        header('Location: nilai.php');
        exit;
    } else {
        echo "Gagal mengubah data nilai: " . mysqli_error($koneksi);
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>UBAH DATA NILAI MAHASISWA</title>
</head>
<body>
    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
    <div class="container">
        <a class="navbar-brand" href="#">DATA MAHASISWA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--Close Navbar -->

<!-- Container -->
<div class="container mt-5 pt-4">
    <div class="row my-3">
        <div class="col-md">
            <h2><i class="bi bi-pencil-square"></i>&nbsp;Ubah Nilai Mahasiswa</h2>
        </div>
        <hr>
    <div class="row my-5">
        <div class="col-md">
            <!-- Form untuk mengubah data nilai -->
            <form action="ubah_nilai.php?nim=<?= $nim ?>&semester=<?= $semester ?>" method="post">
                <input type="hidden" name="nim" value="<?= $nim; ?>">
                <input type="hidden" name="semester" value="<?= $semester; ?>">
                <div class="mb-3">
                    <label for="nilai" class="form-label">Nilai</label>
                    <input type="text" class="form-control w-50" id="nilai" name="nilai" value="<?= $data['nilai']; ?>" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<!-- Close Container -->

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
