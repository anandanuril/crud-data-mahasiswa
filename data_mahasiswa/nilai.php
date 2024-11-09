<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

// Query utama untuk mengambil data nilai mahasiswa dengan LEFT JOIN antara tabel students dan nilai
$query = "SELECT students.nim, students.nama, students.jurusan AS prodi, nilai.semester, nilai.nilai
          FROM students LEFT JOIN nilai ON students.nim = nilai.nim";

// Variabel untuk menyimpan kata kunci pencarian dan semester
$search_keyword = "";
$search_semester = "";

// Memproses pencarian jika ada input dari form
if (isset($_GET['search'])) {
    $search_keyword = $_GET['keyword'];
    $search_semester = $_GET['semester'];

    $conditions = [];
    // Menambahkan kondisi pencarian berdasarkan NIM atau Nama jika kata kunci tidak kosong
    if (!empty($search_keyword)) {
        $conditions[] = "(students.nim LIKE '%$search_keyword%' OR students.nama LIKE '%$search_keyword%')";
    }
    // Menambahkan kondisi pencarian berdasarkan Semester jika dipilih dari dropdown
    if (!empty($search_semester)) {
        $conditions[] = "nilai.semester = '$search_semester'";
    }

    // Menggabungkan kondisi pencarian ke dalam query utama
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
}

// Eksekusi query
$result = mysqli_query($koneksi, $query);

// Menghitung total data mahasiswa yang memiliki nilai
$total_data_query = "SELECT COUNT(*) as total FROM students
                     LEFT JOIN nilai ON students.nim = nilai.nim
                     WHERE nilai.nilai IS NOT NULL";

// Memproses kondisi pencarian untuk total data
if (!empty($conditions)) {
    $total_data_query .= " AND " . implode(" AND ", $conditions);
}

$total_data_result = mysqli_query($koneksi, $total_data_query);
$total_data_row = mysqli_fetch_assoc($total_data_result);
$total_data = $total_data_row['total'];

// Dropdown semester
$semester_options = ["Gasal 2022/2023", "Genap 2022/2023", "Gasal 2023/2024", "Genap 2023/2024"];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilai Mahasiswa - DATA MAHASISWA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .table-center {
            margin: auto;
            width: 100%;
        }
    </style>
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
                    <a class="nav-link" href="index.php">Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="nilai.php">Nilai</a>
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
<div class="container mt-5 pt-4">
    <div class="row">
        <div class="col-md">
            <br>
            <h2 class="text-uppercase text-center fw-bold">DATA NILAI MAHASISWA FAKULTAS TEKNIK UNIVERSITAS MURIA KUDUS</h2>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md">
            <a href="tambah_nilai.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i>&nbsp;Tambah Data Nilai</a>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-md">
            <form action="nilai.php" method="get" class="d-flex">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Cari berdasarkan NIM atau Nama" aria-label="Search" value="<?= $search_keyword ?>">
                <select class="form-select me-2" name="semester" aria-label="semester">
                    <option value="">Pilih Semester</option>
                    <?php foreach ($semester_options as $option) : ?>
                        <option value="<?= $option ?>" <?= ($search_semester == $option) ? 'selected' : ''; ?>><?= $option ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-outline-primary" type="submit" name="search">Cari</button>
            </form>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-md">
            <p>Total Data: <?= $total_data; ?></p>
            <table id="example" class="table table-striped table-center">
                <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Semester</th>
                    <th class="text-center">Nilai</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $row['nim']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['prodi']; ?></td>
                        <td><?= $row['semester']; ?></td>
                        <td class="text-center">
                            <?php
                            // Kategori nilai
                            if ($row['nilai'] > 3.50) {
                                echo 'A';
                            } elseif ($row['nilai'] > 3.00) {
                                echo 'AB';
                            } elseif ($row['nilai'] > 2.50) {
                                echo 'B';
                            } elseif ($row['nilai'] > 2.00) {
                                echo 'BC';
                            } elseif ($row['nilai'] > 1.50) {
                                echo 'C';
                            } elseif ($row['nilai'] > 1.00) {
                                echo 'CD';
                            } elseif ($row['nilai'] > 0.50) {
                                echo 'D';
                            } elseif ($row['nilai'] > 0.0) {
                                echo 'E';
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="ubah_nilai.php?nim=<?= $row['nim']; ?>&semester=<?= $row['semester']; ?>" class="btn btn-warning"><i class="bi bi-pencil"></i>&nbsp;Ubah</a>
                            <a href="hapus_nilai.php?nim=<?= $row['nim']; ?>&semester=<?= $row['semester']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="bi bi-trash"></i>&nbsp;Hapus</a>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
</body>
</html>
