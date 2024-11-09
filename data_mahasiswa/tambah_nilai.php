<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

// Query untuk mengambil daftar mahasiswa dari tabel students
$query_students = "SELECT * FROM students";
$result_students = mysqli_query($koneksi, $query_students);

// Proses tambah data nilai
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $semester = $_POST['semester'];
    $nilai = $_POST['nilai'];

    // Validasi jika ada field yang kosong
    if (empty($nim) || empty($semester) || empty($nilai)) {
        echo "<script>
                alert('Mohon lengkapi semua field.');
                window.location.href = 'tambah_nilai.php';
              </script>";
        exit;
    }

    // Query untuk memeriksa apakah NIM sudah terdaftar di database students
    $query_check = "SELECT * FROM students WHERE nim = ?";
    $stmt_check = mysqli_prepare($koneksi, $query_check);
    mysqli_stmt_bind_param($stmt_check, 's', $nim);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    // Jika NIM tidak ditemukan dalam database akan muncul pesan kesalahan
    if (mysqli_stmt_num_rows($stmt_check) == 0) {
        echo "<script>
                alert('NIM tidak ditemukan dalam database.');
                window.location.href = 'tambah_nilai.php';
              </script>";
        exit;
    }

    // Query untuk memeriksa apakah data nilai sudah ada untuk NIM dan semester tersebut
    $query_check_nilai = "SELECT * FROM nilai WHERE nim = ? AND semester = ?";
    $stmt_check_nilai = mysqli_prepare($koneksi, $query_check_nilai);
    mysqli_stmt_bind_param($stmt_check_nilai, 'ss', $nim, $semester);
    mysqli_stmt_execute($stmt_check_nilai);
    mysqli_stmt_store_result($stmt_check_nilai);

    // Jika data nilai sudah ada untuk NIM dan semester tersebut akan muncul pesan kesalahan
    if (mysqli_stmt_num_rows($stmt_check_nilai) > 0) {
        echo "<script>
                alert('Data nilai sudah ada untuk nim dan semester tersebut.');
                window.location.href = 'tambah_nilai.php';
              </script>";
        exit;
    }

    // Query untuk menambahkan data nilai ke dalam tabel nilai
    $query_tambah_nilai = "INSERT INTO nilai (nim, semester, nilai) VALUES (?, ?, ?)";
    $stmt_tambah_nilai = mysqli_prepare($koneksi, $query_tambah_nilai);
    mysqli_stmt_bind_param($stmt_tambah_nilai, 'sss', $nim, $semester, $nilai);

    // Eksekusi query tambah nilai
    if (mysqli_stmt_execute($stmt_tambah_nilai)) {
        echo "<script>
                alert('Data nilai berhasil ditambahkan.');
                window.location.href = 'nilai.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Gagal menambahkan data nilai.');
                window.location.href = 'tambah_nilai.php';
              </script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Nilai - DATA MAHASISWA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
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
<!-- Close Navbar -->

<!-- Container -->
<div class="container">
    <div class="row my-3">
        <div class="col-md">
            <h2><i class="bi bi-plus-square-fill"></i>&nbsp;Tambah Data Nilai Mahasiswa</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            <form action="tambah_nilai.php" method="post">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <select class="form-select w-50" id="nim" name="nim" required>
                        <option selected disabled>Pilih NIM</option>
                        <?php while ($row = mysqli_fetch_assoc($result_students)) : ?>
                            <option value="<?= $row['nim']; ?>"><?= $row['nim']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-select w-50" id="semester" name="semester" required>
                        <option selected disabled>Pilih Semester</option>
                        <option value="Gasal 2022/2023">Gasal 2022/2023</option>
                        <option value="Genap 2022/2023">Genap 2022/2023</option>
                        <option value="Gasal 2023/2024">Gasal 2023/2024</option>
                        <option value="Genap 2023/2024">Genap 2023/2024</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nilai" class="form-label">Nilai</label>
                    <input type="text" class="form-control w-50" id="nilai" name="nilai" placeholder="Masukkan Nilai"
                           autocomplete="off" required>
                </div>
                <hr>
                <a href="nilai.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<!-- Close Container -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
