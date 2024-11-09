<?php
// Variabel untuk koneksi database
$host = "localhost"; // Nama host
$user = "root"; // Nama pengguna MySQL
$password = ""; // Kata sandi MySQL
$database = "data_mahasiswa"; // Nama database

// Membuat koneksi ke database MySQL
$koneksi = mysqli_connect($host, $user, $password, $database);

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    // Jika koneksi gagal, menampilkan pesan kesalahan
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit(); // Keluar dari script jika koneksi gagal
}
?>
