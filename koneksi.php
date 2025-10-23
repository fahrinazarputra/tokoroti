<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = 'toko_roti';

$koneksi = new mysqli($host, $user, $pass, $db_name);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// data admin sederhana (untuk keperluan tutorial)
// DI LINGKUNGAN PRODUKSI, GUNAKAN TABLE USER DAN HASHING PASSWORD
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', '12345');
