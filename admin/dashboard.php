<?php
include 'header.php';
include '../koneksi.php';

$total_menu = $koneksi->query("SELECT COUNT(*) as total FROM menu")->fetch_assoc()['total'];
$total_ulasan = $koneksi->query("SELECT COUNT(*) as total FROM ulasan")->fetch_assoc()['total'];
?>

<h1 class="h2">Dashboard</h1>
<p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']) ?>.</p>
<hr>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Menu</h5>
                <p class="card-text h1"><?php echo $total_menu ?></p>
                <a href="menu.php" class="text-white">Lihat Detail &raquo;</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Ulasan Pelanggan</h5>
                <p class="card-text h1"><?php echo $total_ulasan ?></p>
                <a href="ulasan.php" class="text-white">Lihat Detail &raquo;</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>