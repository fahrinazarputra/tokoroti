<?php
// data_menu.php
include 'koneksi.php';

// 1. Ambil Data Menu (untuk carousel)
$sql_minuman    = "SELECT * FROM menu WHERE kategori = 'Minuman' ORDER BY id_menu DESC LIMIT 3";
$result_minuman = $koneksi->query($sql_minuman);
$minuman        = $result_minuman->fetch_all(MYSQLI_ASSOC);

$sql_makanan    = "SELECT * FROM menu WHERE kategori = 'Makanan' ORDER BY id_menu DESC LIMIT 3";
$result_makanan = $koneksi->query($sql_makanan);
$makanan        = $result_makanan->fetch_all(MYSQLI_ASSOC);

// 2. Ambil Data Ulasan
$sql_ulasan    = "SELECT * FROM ulasan ORDER BY id DESC LIMIT 5";
$result_ulasan = $koneksi->query($sql_ulasan);
$ulasan        = $result_ulasan->fetch_all(MYSQLI_ASSOC);
