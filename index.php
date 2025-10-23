<?php
// index.php
// Pastikan file data_menu.php ada di folder yang sama
include 'data_menu.php';
// Variabel $minuman, $makanan, dan $ulasan harus sudah terisi data dari database.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="keywords" content="NisaCake, cake murah, toko roti,">
    <meta name="description" content="Website NisaCake">

    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/styles.css">
    <title>NisaCake</title>
    <style>
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.7);
            /* Latar belakang gelap transparan */
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light p-100">
        <a class="navbar-brand" href="#">
            <img src="assets/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Kopi Kita Aja
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="ml-auto navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#banner">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Kontak</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="banner" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#banner" data-slide-to="0" class="active"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/cafe.jpeg" class="d-block w-100" alt="Kopi Kita Banner">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Kopi Kita Aja</h5>
                    <p>Coffeshop terkemuka dengan berbagai menunya yang otentik</p>
                </div>
            </div>
        </div>
    </div>

    <div id="q-menu" class="p-100" style="margin-top: 72px;">
        <div class="row">
            <div class="col-lg-4">
                <a href="#menu" class="card" style="width: 100%;">
                    <img src="assets/coffee.jpg" class="card-img-top" alt="Menu">
                    <a href="#menu" class="placeholder">Menu</a>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="#profile" class="card" style="width: 100%;">
                    <img src="assets/bartender.jpeg" class="card-img-top" alt="Menu">
                    <a href="#profile" class="placeholder">Profile</a>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="#contact" class="card" style="width: 100%;">
                    <img src="assets/cafe.jpeg" class="card-img-top" alt="Menu">
                    <a href="#contact" class="placeholder">Contact</a>
                </a>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-8">
            <h2 id="menu" class="font-weight-normal p-50 text-center" style="padding-top: 100px;">Menu <b>Kami</b></h2>
            <div class="row p-50 mt-5" id="menu-section">
                <div class="col-lg-6">
                    <h3 class="font-weight-normal mb-3 mt-4">Minuman</h3>
                    <div id="drink" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <?php foreach ($minuman as $index => $item): ?>
                                <li data-target="#drink" data-slide-to="<?php echo $index ?>"
                                    class="<?php echo $index === 0 ? 'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php if (empty($minuman)): ?>
                                <div class="carousel-item active">
                                    <img src="assets/coffee.jpg" class="d-block w-100" alt="Minuman Default">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Data Menu Belum Tersedia</h5>
                                        <p>Silakan masukkan menu baru melalui Dashboard Admin.</p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($minuman as $index => $item): ?>
                                    <div class="carousel-item<?php echo $index === 0 ? 'active' : '' ?>">
                                        <img src="assets/<?php echo htmlspecialchars($item['gambar']) ?>" class="d-block w-100"
                                            alt="<?php echo htmlspecialchars($item['nama']) ?>">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5><?php echo htmlspecialchars($item['nama']) ?></h5>
                                            <p>Harga: Rp. <?php echo number_format($item['harga'], 0, ',', '.') ?> -
                                                <?php echo htmlspecialchars($item['deskripsi'] ?? 'Deskripsi tidak tersedia') ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-target="#drink" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#drink" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="font-weight-normal mb-3 mt-4">Makanan</h3>
                    <div id="food" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <?php foreach ($makanan as $index => $item): ?>
                                <li data-target="#food" data-slide-to="<?php echo $index ?>"
                                    class="<?php echo $index === 0 ? 'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php if (empty($makanan)): ?>
                                <div class="carousel-item active">
                                    <img src="assets/cafe.jpeg" class="d-block w-100" alt="Makanan Default">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Data Menu Belum Tersedia</h5>
                                        <p>Silakan masukkan menu baru melalui Dashboard Admin.</p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($makanan as $index => $item): ?>
                                    <div class="carousel-item<?php echo $index === 0 ? 'active' : '' ?>">
                                        <img src="assets/<?php echo htmlspecialchars($item['gambar']) ?>" class="d-block w-100"
                                            alt="<?php echo htmlspecialchars($item['nama']) ?>">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5><?php echo htmlspecialchars($item['nama']) ?></h5>
                                            <p>Rp. <?php echo number_format($item['harga'], 0, ',', '.') ?> -
                                                <?php echo htmlspecialchars($item['deskripsi'] ?? 'Deskripsi tidak tersedia') ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-target="#food" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#food" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <h2 id="profile" class="font-weight-normal text-center p-50" style="padding-top: 100px;">Profil <b>Kami</b>
            </h2>
            <div class="p-50" style="padding-right: none;">
                <p class="text-center mt-4">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis ipsa dolorum dolores! Culpa,
                    nihil! Rerum, aliquam necessitatibus voluptatem hic esse consectetur aut architecto inventore autem
                    tempora error laboriosam, assumenda commodi, expedita ut!
                </p>
                <iframe class="mt-4" width="100%" height="400"
                    src="https://www.youtube.com/embed/PG0BVmJIpFc?si=5FHeUpm1mB-oi0xh" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
        </div>

        <div class="col-lg-4 p-3 bg-light pr-4" style="margin-top: 100px;">
            <h4 class="text-center mb-4">Ulasan Pelanggan</h4>
            <?php if (empty($ulasan)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text text-muted">Belum ada ulasan yang ditambahkan.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($ulasan as $review): ?>
                    <div class="card mb-3" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($review['nama_pelanggan']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($review['status']) ?></h6>
                            <p class="card-text"><?php echo htmlspecialchars($review['isi_ulasan']) ?></p>
                            <?php if (! empty($review['tag_satu'])): ?>
                                <span class="badge badge-info"><?php echo htmlspecialchars($review['tag_satu']) ?></span>
                            <?php endif; ?>
                            <?php if (! empty($review['tag_dua'])): ?>
                                <span class="badge badge-secondary"><?php echo htmlspecialchars($review['tag_dua']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


    <div id="contact" class="p-100" style="margin-top: 100px;">
        <h2 class="text-center font-weight-normal">Kontak <b>Kami</b></h2>
        <div class="row mt-5">
            <div class="col-lg-5">
                <div class="mb-3 border-solid border-bottom">
                    <h3 class="font-weight-normal">Kopi Kita Aja</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia beatae et doloremque nam,
                        tempora voluptatem earum. Libero distinctio aliquam, laboriosam reprehenderit in illum harum.
                    </p>
                </div>
                <div class="mb-4 border-solid border-bottom">
                    <div class="row mb-1">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3">
                                    <img src="assets/instagram.png" width="30" height="30" alt="Instagram"
                                        draggable="false">
                                </div>
                                <div class="col-xs-9 col-sm-9">
                                    <p>kopikitaaja</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3">
                                    <img src="assets/instagram.png" width="30" height="30" alt="Instagram"
                                        draggable="false">
                                </div>
                                <div class="col-xs-9 col-sm-9">
                                    <p>kopikitaaja</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3">
                                    <img src="assets/instagram.png" width="30" height="30" alt="Instagram"
                                        draggable="false">
                                </div>
                                <div class="col-xs-9 col-sm-9">
                                    <p>kopikitaaja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <h3 class="font-weight-normal mb-3">Berlangganan Sekarang</h3>
                    <button class="btn btn-danger mb-5">Subscribe!</button>
                </div>
            </div>
            <div class="col-lg-7">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2778.1843731350245!2d111.90544650857692!3d-7.18063947043645!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e77810651b96081%3A0xf1720c99ff09edce!2sSMK%20Negeri%204%20Bojonegoro!5e1!3m2!1sid!2sid!4v1758073274046!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" width="100%" height="450" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <footer class="mt-5 bg-dark d-flex justify-content-center align-items-center" style="height: 96px;">
        <p style="margin-bottom: 0;" class="text-light">2025 © Fahri Nazar</p>
    </footer>

    <script src="scripts/jquery-3.7.1.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
</body>

</html>