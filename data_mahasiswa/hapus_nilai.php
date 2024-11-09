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

    // Query untuk menghapus data nilai berdasarkan NIM dan semester
    $query = "DELETE FROM nilai WHERE nim = ? AND semester = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nim, $semester);
    mysqli_stmt_execute($stmt);

    // Memeriksa jumlah baris yang dihapus
    $rows_deleted = mysqli_stmt_affected_rows($stmt);
    
    // Jika ada baris yang dihapus, alihkan ke halaman nilai.php
    if ($rows_deleted > 0) {
        header('Location: nilai.php');
        exit;
    } else {
        echo "Gagal menghapus data nilai atau data tidak ditemukan.";
    }

    // Menutup statement
    mysqli_stmt_close($stmt);
} else {
    echo "Data tidak ditemukan.";
}

// Menutup koneksi ke database
mysqli_close($koneksi);
?>
