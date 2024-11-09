<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require 'fungsi.php';

// Memeriksa apakah parameter 'nim' ada di URL
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Memulai transaksi ke database
    mysqli_begin_transaction($koneksi);

    try {
        // Query untuk menghapus data nilai berdasarkan NIM
        $query_nilai = "DELETE FROM nilai WHERE nim = '$nim'";
        $result_nilai = mysqli_query($koneksi, $query_nilai);
        if (!$result_nilai) {
            // Jika gagal menghapus nilai, lempar exception
            throw new Exception("Gagal menghapus nilai.");
        }

        // Query untuk menghapus data mahasiswa berdasarkan NIM
        $query_student = "DELETE FROM students WHERE nim = '$nim'";
        $result_student = mysqli_query($koneksi, $query_student);
        if (!$result_student) {
            // Jika gagal menghapus data mahasiswa, lempar exception
            throw new Exception("Gagal menghapus data mahasiswa.");
        }

        // Jika semua query berhasil, commit transaksi
        mysqli_commit($koneksi);

        // Alihkan ke halaman index.php
        header('location: index.php');
        exit;
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        mysqli_rollback($koneksi);
        echo $e->getMessage();
    }
} else {
    echo "NIM tidak valid.";
}
?>
