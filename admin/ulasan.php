<?php

include 'header.php';
include '../koneksi.php';

$action  = $_GET['action'] ?? 'list';
$id      = $_GET['id'] ?? null;
$message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_ulasan'])) {
    $nama   = $_POST['nama_pelanggan'];
    $status = $_POST['status'];
    $isi    = $_POST['isi_ulasan'];
    $tag1   = $_POST['tag_satu'];
    $tag2   = $_POST['tag_dua'];

    $stmt = $koneksi->prepare("INSERT INTO ulasan (nama_pelanggan, status, isi_ulasan, tag_satu, tag_dua) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $status, $isi, $tag1, $tag2);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Ulasan dari <b>$nama</b> berhasil ditambahkan!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
    $action = 'list';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_ulasan'])) {
    $id_update = $_POST['id'];
    $nama   = $_POST['nama_pelanggan'];
    $status = $_POST['status'];
    $isi    = $_POST['isi_ulasan'];
    $tag1   = $_POST['tag_satu'];
    $tag2   = $_POST['tag_dua'];

    $stmt = $koneksi->prepare("UPDATE ulasan SET nama_pelanggan=?, status=?, isi_ulasan=?, tag_satu=?, tag_dua=? WHERE id=?");
    $stmt->bind_param("sssssi", $nama, $status, $isi, $tag1, $tag2, $id_update);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Ulasan dari <b>$nama</b> berhasil diperbarui!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
    $action = 'list';
}

if ($action == 'delete' && $id) {
    $stmt = $koneksi->prepare("DELETE FROM ulasan WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Ulasan berhasil dihapus.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Gagal menghapus ulasan.</div>";
    }
    $stmt->close();
    $action = 'list';
}


if ($action == 'list') {
    $result = $koneksi->query("SELECT * FROM ulasan ORDER BY id DESC");
    $ulasan = $result->fetch_all(MYSQLI_ASSOC);
} elseif ($action == 'edit' && $id) {
    $result = $koneksi->query("SELECT * FROM ulasan WHERE id='$id'");
    $ulasan_data = $result->fetch_assoc();
    if (!$ulasan_data) {
        $message = "<div class='alert alert-warning'>Data ulasan tidak ditemukan.</div>";
        $action = 'list';
    }
}
?>

<h1 class="h2">Kelola Ulasan Pelanggan</h1>
<hr>

<?php echo $message; ?>

<?php if ($action == 'list'): ?>
    <a href="?action=add" class="btn btn-primary mb-3">Tambah Ulasan Baru</a>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Isi Ulasan</th>
                    <th>Tag</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ulasan as $review): ?>
                    <tr>
                        <td><?php echo $review['id']; ?></td>
                        <td><?php echo htmlspecialchars($review['nama_pelanggan']); ?></td>
                        <td><?php echo htmlspecialchars($review['status']); ?></td>
                        <td><?php echo substr(htmlspecialchars($review['isi_ulasan']), 0, 50) . '...'; ?></td>
                        <td>
                            <span class="badge badge-info"><?php echo htmlspecialchars($review['tag_satu']); ?></span>
                            <span class="badge badge-secondary"><?php echo htmlspecialchars($review['tag_dua']); ?></span>
                        </td>
                        <td>
                            <a href="?action=edit&id=<?php echo $review['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="?action=delete&id=<?php echo $review['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($action == 'add' || $action == 'edit'): ?>
    <h3 class="mt-4"><?php echo $action == 'add' ? 'Tambah' : 'Edit'; ?> Ulasan</h3>
    <form method="POST" action="?action=<?php echo $action; ?>">
        <?php if ($action == 'edit'): ?>
            <input type="hidden" name="id" value="<?php echo $ulasan_data['id']; ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                value="<?php echo $ulasan_data['nama_pelanggan'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status"
                value="<?php echo $ulasan_data['status'] ?? 'Pelanggan Toko Roti Kita'; ?>" required>
        </div>

        <div class="form-group">
            <label for="isi_ulasan">Isi Ulasan</label>
            <textarea class="form-control" id="isi_ulasan" name="isi_ulasan" rows="4" required><?php echo $ulasan_data['isi_ulasan'] ?? ''; ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="tag_satu">Tag 1</label>
                <input type="text" class="form-control" id="tag_satu" name="tag_satu"
                    value="<?php echo $ulasan_data['tag_satu'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
                <label for="tag_dua">Tag 2 (Opsional)</label>
                <input type="text" class="form-control" id="tag_dua" name="tag_dua"
                    value="<?php echo $ulasan_data['tag_dua'] ?? ''; ?>">
            </div>
        </div>

        <button type="submit" name="<?php echo $action == 'add' ? 'tambah_ulasan' : 'edit_ulasan'; ?>" class="btn btn-success">Simpan</button>
        <a href="ulasan.php" class="btn btn-secondary">Batal</a>
    </form>
<?php endif; ?>

<?php include 'footer.php'; ?>