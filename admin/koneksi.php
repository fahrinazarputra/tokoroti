<?php
// koneksi.php
$host  = 'localhost';
$user  = 'root';        
$pass  = '';            // Ganti dengan password database kamu
$db_name = 'toko_roti'; // Di isi sesuai dengan nama database masing-masing

$koneksi = new mysqli($host, $user, $pass, $db_name);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}


define('ADMIN_USER', 'admin');
define('ADMIN_PASS', '12345');
