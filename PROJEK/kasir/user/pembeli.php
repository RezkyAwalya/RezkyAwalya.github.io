<?php include '../db.php'; // Koneksi ke database


// Menangani operasi Create, Update, Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Menambah pembeli baru
        $nama = $_POST['nama'];
        $jns_kelamin = $_POST['jns_kelamin'];
        $alamat = $_POST['alamat'];
        $kode_pos = $_POST['kode_pos'];
        $kota = $_POST['kota'];
        $tgl_lahir = $_POST['tgl_lahir'];

        // Insert pembeli ke database
        $conn->query("INSERT INTO pembeli (nama, jns_kelamin, alamat, kode_pos, kota, tgl_lahir) VALUES ('$nama', '$jns_kelamin', '$alamat', '$kode_pos', '$kota', '$tgl_lahir')");
    } elseif (isset($_POST['edit'])) {
        // Mengedit data pembeli
        $id_pembeli = $_POST['id_pembeli'];
        $nama = $_POST['nama'];
        $jns_kelamin = $_POST['jns_kelamin'];
        $alamat = $_POST['alamat'];
        $kode_pos = $_POST['kode_pos'];
        $kota = $_POST['kota'];
        $tgl_lahir = $_POST['tgl_lahir'];

        // Update data pembeli di database
        $conn->query("UPDATE pembeli SET nama='$nama', jns_kelamin='$jns_kelamin', alamat='$alamat', kode_pos='$kode_pos', kota='$kota', tgl_lahir='$tgl_lahir' WHERE id_pembeli='$id_pembeli'");
    }
} elseif (isset($_GET['delete'])) {
    // Menghapus pembeli
    $id_pembeli = $_GET['delete'];
    $conn->query("DELETE FROM pembeli WHERE id_pembeli='$id_pembeli'");
}

// Ambil data pembeli untuk ditampilkan
$pembeliData = $conn->query("SELECT * FROM pembeli");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembeli</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Manajemen Pembeli</h2>

        <!-- Form untuk menambah pembeli -->
        <h3>Tambah Pembeli</h3>
        <form method="POST">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required><br>

            <label for="jns_kelamin">Jenis Kelamin:</label>
            <select id="jns_kelamin" name="jns_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select><br>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required></textarea><br>

            <label for="kode_pos">Kode Pos:</label>
            <input type="text" id="kode_pos" name="kode_pos"><br>

            <label for="kota">Kota:</label>
            <input type="text" id="kota" name="kota" required><br>

            <label for="tgl_lahir">Tanggal Lahir:</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" required><br>

            <button type="submit" name="add">Tambah Pembeli</button>
            <br>
            <a href="dashboard.php">Kembali ke Dashboard</a>
        </form>

        <h3>Data Pembeli</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Pembeli</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Kode Pos</th>
                    <th>Kota</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pembeliData->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pembeli'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['jns_kelamin'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= $row['kode_pos'] ?></td>
                        <td><?= $row['kota'] ?></td>
                        <td><?= $row['tgl_lahir'] ?></td>
                        <td>
                            <a href="?edit=<?= $row['id_pembeli'] ?>">Edit</a> |
                            <a href="?delete=<?= $row['id_pembeli'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pembeli ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php
        // Menampilkan form edit pembeli jika ada ID pembeli yang diedit
        if (isset($_GET['edit'])) {
            $id_pembeli = $_GET['edit'];
            $result = $conn->query("SELECT * FROM pembeli WHERE id_pembeli = '$id_pembeli'");
            $pembeliEdit = $result->fetch_assoc();
        ?>
        <h3>Edit Pembeli</h3>
        <form method="POST">
            <input type="hidden" name="id_pembeli" value="<?= $pembeliEdit['id_pembeli'] ?>"><br>

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= $pembeliEdit['nama'] ?>" required><br>

            <label for="jns_kelamin">Jenis Kelamin:</label>
            <select id="jns_kelamin" name="jns_kelamin" required>
                <option value="Laki-laki" <?= $pembeliEdit['jns_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= $pembeliEdit['jns_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select><br>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required><?= $pembeliEdit['alamat'] ?></textarea><br>

            <label for="kode_pos">Kode Pos:</label>
            <input type="text" id="kode_pos" name="kode_pos" value="<?= $pembeliEdit['kode_pos'] ?>"><br>

            <label for="kota">Kota:</label>
            <input type="text" id="kota" name="kota" value="<?= $pembeliEdit['kota'] ?>" required><br>

            <label for="tgl_lahir">Tanggal Lahir:</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" value="<?= $pembeliEdit['tgl_lahir'] ?>" required><br>

            <button type="submit" name="edit">Update Pembeli</button>
        </form>
        <?php } ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
