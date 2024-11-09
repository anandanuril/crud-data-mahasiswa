<?php
session_start();

$_SESSION = []; // Mengosongkan array $_SESSION
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi

header('location: login.php'); // Mengarahkan kembali ke halaman login
