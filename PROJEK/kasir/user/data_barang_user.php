<?php include '../db.php'; // Koneksi ke database

// Ambil data barang dengan filter
$query = "SELECT * FROM barang";
$conditions = [];

if (isset($_GET['filter_diskon']) && $_GET['filter_diskon'] !== '') {
    $diskon = intval($_GET['filter_diskon']);
    $conditions[] = "diskon = $diskon";
}

if (isset($_GET['filter_varian']) && $_GET['filter_varian'] !== '') {
    $varian = $conn->real_escape_string($_GET['filter_varian']);
    $conditions[] = "varian = '$varian'";
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$barang = $conn->query($query);

// Ambil daftar varian unik untuk dropdown filter
$varian_result = $conn->query("SELECT DISTINCT varian FROM barang");
$varian_options = [];
while ($row = $varian_result->fetch_assoc()) {
    $varian_options[] = $row['varian'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Data Barang</h2>

        <!-- Filter Data -->
        <h3>Filter Barang</h3>
        <form method="GET">
            <label for="filter_diskon">Filter Diskon:</label>
            <select name="filter_diskon">
                <option value="">Semua</option>
                <option value="0">0%</option>
                <option value="10">10%</option>
                <option value="20">20%</option>
                <option value="30">30%</option>
                <option value="50">50%</option>
            </select>

            <label for="filter_varian">Filter Varian:</label>
            <select name="filter_varian">
                <option value="">Semua</option>
                <?php foreach ($varian_options as $option): ?>
                    <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Terapkan Filter</button>
        </form>

        <!-- Tabel untuk menampilkan data barang -->
        <h3>Data Barang</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Varian</th>
                <th>Harga Beli</th>
                <th>Diskon</th>
                <th>Harga Jual</th>
            </tr>
            <?php while ($row = $barang->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_barang'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['varian'] ?></td>
                <td>Rp<?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                <td><?= $row['diskon'] ?>%</td>
                <td>Rp<?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <br>
        <a href="dashboard_user.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
