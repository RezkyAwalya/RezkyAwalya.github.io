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
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }
        /* Sidebar */
        .sidebar {
            width: 300px;
            background: #ddd;
            color: white;
            padding: 30px 20px;
            height: 100vh;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .sidebar h3 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .sidebar label {
            font-size: 14px;
            margin-bottom: 8px;
            color:  #2575fc;
        }

        .sidebar select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background: #fff;
            color: #333;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar select:focus {
            outline: none;
            border-color: #2575fc;
            box-shadow: 0 2px 10px rgba(37, 117, 252, 0.4);
        }

        .sidebar button {
            width: 100%;
            padding: 12px;
            background-color: #2575fc;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            font-weight: 500;
        }

        .sidebar button:hover {
            background-color: rgb(15, 87, 211);
        }
        
        .container {
            flex: 1;
            background: white;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background: #007BFF;
            color: white;
        }

        .quantity {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity button {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .quantity input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Filter Barang</h3>
        <form method="GET" class="filter">
            <label for="filter_diskon">Filter Diskon:</label>
            <select name="filter_diskon">
                <option value="">Semua</option>
                <option value="0">0%</option>
                <option value="10">10%</option>
                <option value="20">20%</option>
                <option value="30">30%</option>
                <option value="40">40%</option>
                <option value="50">50%</option>
                <option value="60">60%</option>
                <option value="70">70%</option>
                <option value="80">80%</option>
                <option value="90">90%</option>
                <option value="100">100%</option>
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
    </div>
    
    <div class="container">
        <h2>Dashboard User</h2>

        <div class="search">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari nama barang..." />
                <button type="submit">Cari</button>
            </form>
        </div>

        <h3>Data Barang</h3>
        <form method="POST" action="transaksi.php">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Varian</th>
                    <th>Harga Asli</th>
                    <th>Diskon</th>
                    <th>Harga Diskon</th>
                    <th>Kuantitas</th>
                </tr>
                <?php while ($row = $barang->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_barang'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['varian'] ?></td>
                    <td>Rp<?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                    <td><?= $row['diskon'] ?>%</td>
                    <td>Rp<?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    <td class="quantity">
                        <button type="button" onclick="decrement(<?= $row['id_barang'] ?>)">-</button>
                        <input type="number" name="kuantitas[<?= $row['id_barang'] ?>]" id="qty_<?= $row['id_barang'] ?>" value="0" min="0" max="99" />
                        <button type="button" onclick="increment(<?= $row['id_barang'] ?>)">+</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <button type="submit">Transaksi</button>
        </form>
    </div>

    <script>
        function increment(id) {
            var qtyInput = document.getElementById('qty_' + id);
            qtyInput.value = parseInt(qtyInput.value) + 1;
        }

        function decrement(id) {
            var qtyInput = document.getElementById('qty_' + id);
            if (qtyInput.value > 0) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>