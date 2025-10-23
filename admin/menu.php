<?php
include 'header.php';
include '../koneksi.php';

$upload_dir = "../uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $gambar_file = "";

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar_file = $file_name;
        } else {
            $message = "<div class='alert alert-danger'>Gagal mengupload gambar.</div>";
        }
    }

    $query = "INSERT INTO menu (nama, kategori, deskripsi, harga, gambar)
              VALUES ('$nama', '$kategori', '$deskripsi', '$harga', '$gambar_file')";
    if (mysqli_query($koneksi, $query)) {
        $message = "<div class='alert alert-success'>Menu berhasil ditambahkan!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Gagal menambah menu: " . mysqli_error($koneksi) . "</div>";
    }
    $action = 'list';
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_file = $gambar_lama;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            if ($gambar_lama && file_exists($upload_dir . $gambar_lama)) {
                unlink($upload_dir . $gambar_lama);
            }
            $gambar_file = $file_name;
        }
    }

    $query = "UPDATE menu SET 
                nama='$nama',
                kategori='$kategori',
                deskripsi='$deskripsi',
                harga='$harga',
                gambar='$gambar_file'
              WHERE id_menu='$id'";
    if (mysqli_query($koneksi, $query)) {
        $message = "<div class='alert alert-success'>Menu berhasil diperbarui!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Gagal memperbarui menu: " . mysqli_error($koneksi) . "</div>";
    }
    $action = 'list';
}


if ($action == 'delete' && isset($id)) {
    $get_img = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE id_menu='$id'");
    $img_data = mysqli_fetch_assoc($get_img);
    $gambar = $img_data['gambar'];
    if ($gambar && file_exists($upload_dir . $gambar)) {
        unlink($upload_dir . $gambar);
    }

    $delete = mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu='$id'");
    if ($delete) {
        $message = "<div class='alert alert-warning'>Menu berhasil dihapus.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Gagal menghapus menu: " . mysqli_error($koneksi) . "</div>";
    }
    $action = 'list';
}
?>

<div class="container mt-4">
    <h2>Kelola Menu</h2>
    <?php echo $message; ?>

    <?php if ($action == 'list'): ?>
        <a href="?action=add" class="btn btn-primary mb-3">+ Tambah Menu</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY id_menu DESC");
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                        <td>Rp <?php echo number_format($row['harga']); ?></td>
                        <td>
                            <?php if ($row['gambar']): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" width="60">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?action=edit&id=<?php echo $row['id_menu']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?action=delete&id=<?php echo $row['id_menu']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php elseif ($action == 'add' || $action == 'edit'):
        $menu_data = ['nama' => '', 'kategori' => '', 'deskripsi' => '', 'harga' => '', 'gambar' => ''];
        if ($action == 'edit' && $id) {
            $edit_q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id'");
            $menu_data = mysqli_fetch_assoc($edit_q);
        }
    ?>
        <h3><?php echo ($action == 'add') ? 'Tambah Menu' : 'Edit Menu'; ?></h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <?php if ($action == 'edit'): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo $menu_data['gambar']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" class="form-control" name="nama" value="<?php echo $menu_data['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select class="form-control" name="kategori" required>
                    <option value="Minuman" <?php echo ($menu_data['kategori'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                    <option value="Makanan" <?php echo ($menu_data['kategori'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required><?php echo $menu_data['deskripsi']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" class="form-control" name="harga"
                    value="<?php echo $menu_data['harga']; ?>" required>
            </div>

            <div class="form-group">
                <label>Gambar Menu</label>
                <input type="file" class="form-control-file" name="gambar">
                <?php if ($action == 'edit' && !empty($menu_data['gambar'])): ?>
                    <small>Gambar saat ini: <img src="../uploads/<?php echo htmlspecialchars($menu_data['gambar']); ?>" width="80"></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success">
                <?php echo ($action == 'add') ? 'Tambah' : 'Simpan'; ?>
            </button>
            <a href="menu.php" class="btn btn-secondary">Batal</a>
        </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>