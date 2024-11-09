<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

$searchKeyword = '';
$searchJurusan = '';
$queryCondition = "1=1";

// Memeriksa  keyword pencarian
if (isset($_GET['keyword'])) {
    $searchKeyword = $_GET['keyword'];
    $queryCondition .= " AND (nim LIKE '%$searchKeyword%' OR nama LIKE '%$searchKeyword%')";
}

// Memeriksa filter jurusan
if (isset($_GET['jurusan']) && $_GET['jurusan'] !== '') {
    $searchJurusan = $_GET['jurusan'];
    $queryCondition .= " AND jurusan = '$searchJurusan'";
}

// Query data mahasiswa
$query = "SELECT * FROM students WHERE $queryCondition";
$result = mysqli_query($koneksi, $query);

// Hitung total data
$countQuery = "SELECT COUNT(*) as total FROM students WHERE $queryCondition";
$countResult = mysqli_query($koneksi, $countQuery);
$countData = mysqli_fetch_assoc($countResult);
$totalData = $countData['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - DATA MAHASISWA</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Data Tables-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">DATA MAHASISWA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link data" href="index.php">Data</a>
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
    <div class="row">
        <div class="col-md">
            <br>
            <h2 class="text-uppercase text-center fw-bold">DATA MAHASISWA FAKULTAS TEKNIK UNIVERSITAS MURIA KUDUS</h2>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md">
            <a href="tambah.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i>&nbsp;Tambah Data Mahasiswa</a>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-md">
            <form action="index.php" method="get" class="d-flex">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Cari berdasarkan NIM atau Nama" aria-label="Search" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <select class="form-select me-2" name="jurusan" aria-label="Jurusan">
                    <option value="">Pilih Jurusan</option>
                    <option value="Teknik Informatika" <?= ($searchJurusan == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                    <option value="Sistem Informasi" <?= ($searchJurusan == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                    <option value="Teknik Elektro" <?= ($searchJurusan == 'Teknik Elektro') ? 'selected' : ''; ?>>Teknik Elektro</option>
                    <option value="Teknik Industri" <?= ($searchJurusan == 'Teknik Industri') ? 'selected' : ''; ?>>Teknik Industri</option>
                    <option value="Teknik Mesin" <?= ($searchJurusan == 'Teknik Mesin') ? 'selected' : ''; ?>>Teknik Mesin</option>
                </select>
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-md">
            <p>Total Data: <?= $totalData; ?></p>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th class="table-actions">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $row['nim']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['tempat_lahir']; ?></td>
                        <td><?= $row['tanggal_lahir']; ?></td>
                        <td><?= $row['jenis_kelamin']; ?></td>
                        <td><?= $row['jurusan']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td class="table-actions">
                            <a href="ubah.php?nim=<?= $row['nim']; ?>" class="btn btn-warning"><i class="bi bi-pencil"></i>&nbsp;Ubah</a>
                            <a href="hapus.php?nim=<?= $row['nim']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="bi bi-trash"></i>&nbsp;Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Close Container -->

<!-- Footer -->
<footer class="container-fluid bg-dark text-white text-center py-1 fixed-bottom">
    <p>&copy; Ananda Nuril Wahyuni (202251223) - 2024</p>
</footer>
<!-- Close Footer -->

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Data Tables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
</body>
</html>
