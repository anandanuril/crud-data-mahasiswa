<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

// Proses tambah data
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Query untuk memeriksa apakah NIM sudah ada dalam database
    $query_check = "SELECT * FROM students WHERE nim = ?";
    $stmt_check = mysqli_prepare($koneksi, $query_check);
    mysqli_stmt_bind_param($stmt_check, 's', $nim);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    // Jika NIM sudah ada dalam database, tampilkan pesan alert
    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        echo "<script>
                alert('NIM sudah ada dalam database.');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Query untuk menambahkan data mahasiswa ke dalam tabel students
    $query = "INSERT INTO students (nim, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, jurusan, email, alamat)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssss', $nim, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $jurusan, $email, $alamat);

    // Eksekusi query untuk menambahkan data
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil ditambahkan');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan');
                window.location.href = 'tambah.php';
              </script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Mahasiswa - DATA MAHASISWA</title>
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
            <h2><i class="bi bi-person-plus-fill"></i>&nbsp;Tambah Data Mahasiswa</h2>
        </div>
        <hr>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            <form action="tambah.php" method="post">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" class="form-control w-50" id="nim" name="nim" placeholder="NIM" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control w-50" id="nama" name="nama" placeholder="Nama Lengkap" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control w-50" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control w-50" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-Laki" value="Laki-Laki" required>
                        <label class="form-check-label" for="Laki-Laki">Laki-Laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" required>
                        <label class="form-check-label" for="Perempuan">Perempuan</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Jurusan</label>
                    <select class="form-select w-50" required name="jurusan">
                        <option selected disabled>Pilih Jurusan</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Teknik Elektro">Teknik Elektro</option>
                        <option value="Teknik Industri">Teknik Industri</option>
                        <option value="Teknik Mesin">Teknik Mesin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control w-50" id="email" placeholder="E-Mail" name="email" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control w-50" id="alamat" rows="5" required name="alamat" placeholder="Alamat"></textarea>
                </div>
                <hr>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
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
