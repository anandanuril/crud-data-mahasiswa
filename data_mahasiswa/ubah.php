<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

// Ambil data mahasiswa yang akan diubah
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $query = "SELECT * FROM students WHERE nim = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Memeriksa apakah data mahasiswa ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit;
    }
} else {
    echo "NIM mahasiswa tidak valid.";
    exit;
}

// Memproses form jika data mahasiswa diubah
if (isset($_POST['ubah'])) {
    // Mengambil nilai dari form untuk proses update
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Query untuk melakukan update data mahasiswa
    $query_update = "UPDATE students SET 
                    nama = ?,
                    tempat_lahir = ?,
                    tanggal_lahir = ?,
                    jenis_kelamin = ?,
                    jurusan = ?,
                    email = ?,
                    alamat = ?
                    WHERE nim = ?";
                    
    // Persiapan statement untuk query update
    $stmt_update = mysqli_prepare($koneksi, $query_update);
    mysqli_stmt_bind_param($stmt_update, 'ssssssss', $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $jurusan, $email, $alamat, $nim);
    $result_update = mysqli_stmt_execute($stmt_update);

    // Arahkan ke halaman index.php (data) jika update berhasil
    if ($result_update) {
        header('location: index.php');
        exit;
    } else {
        echo "Gagal mengubah data mahasiswa.";
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
    <title>UBAH DATA MAHASISWA</title>
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
                    <a class="nav-link" href="index.php">Home</a>
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
<div class="container">
    <div class="row my-3">
        <div class="col-md">
            <h2><i class="bi bi-pencil-square"></i>&nbsp;Ubah Data Mahasiswa</h2>
        </div>
        <hr>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" class="form-control w-50" id="nim" name="nim" autocomplete="off" value="<?= htmlspecialchars($row['nim']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control w-50" id="nama" name="nama" autocomplete="off" value="<?= htmlspecialchars($row['nama']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control w-50" id="tempat_lahir" name="tempat_lahir" autocomplete="off" value="<?= htmlspecialchars($row['tempat_lahir']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control w-50" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($row['tanggal_lahir']); ?>" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-Laki" value="Laki-Laki" <?= ($row['jenis_kelamin'] == 'Laki-Laki') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="Laki-Laki">Laki-Laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" <?= ($row['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="Perempuan">Perempuan</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Jurusan</label>
                    <select class="form-select w-50" required name="jurusan">
                        <option disabled>Pilih Jurusan</option>
                        <option value="Teknik Informatika" <?= ($row['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                        <option value="Sistem Informasi" <?= ($row['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                        <option value="Teknik Elektro" <?= ($row['jurusan'] == 'Teknik Elektro') ? 'selected' : ''; ?>>Teknik Elektro</option>
                        <option value="Teknik Industri" <?= ($row['jurusan'] == 'Teknik Industri') ? 'selected' : ''; ?>>Teknik Industri</option>
                        <option value="Teknik Mesin" <?= ($row['jurusan'] == 'Teknik Mesin') ? 'selected' : ''; ?>>Teknik Mesin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control w-50" id="email" name="email" autocomplete="off" value="<?= htmlspecialchars($row['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control w-50" id="alamat" rows="5" required name="alamat"><?= htmlspecialchars($row['alamat']); ?></textarea>
                </div>
                <hr>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" name="ubah" class="btn btn-warning">Ubah</button>
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
