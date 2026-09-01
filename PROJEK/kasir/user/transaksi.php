<?php
include '../db.php'; // Koneksi ke database

// Check if quantities are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kuantitas'])) {
    $total = 0;
    $items = [];

    foreach ($_POST['kuantitas'] as $id_barang => $kuantitas) {
        $kuantitas = intval($kuantitas);
        if ($kuantitas > 0) {
            // Get item details
            $query = "SELECT * FROM barang WHERE id_barang = $id_barang";
            $result = $conn->query($query);
            if ($row = $result->fetch_assoc()) {
                $harga_jual = $row['harga_jual'];
                $subtotal = $harga_jual * $kuantitas;

                $items[] = [
                    'nama' => $row['nama'],
                    'varian' => $row['varian'],
                    'harga' => $harga_jual,
                    'kuantitas' => $kuantitas,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }
    }
} else {
    // Redirect if no items were selected
    header('Location: index.php'); // Change to your main page
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        .total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        .confirm-button {
            padding: 12px;
            background-color: #2575fc;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .confirm-button:hover {
            background-color: rgb(15, 87, 211);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Transaksi</h2>
        <table>
            <tr>
                <th>Nama</th>
                <th>Varian</th>
                <th>Harga</th>
                <th>Kuantitas</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nama']) ?></td>
                <td><?= htmlspecialchars($item['varian']) ?></td>
                <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td><?= $item['kuantitas'] ?></td>
                <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <div class="total">Total: Rp<?= number_format($total, 0, ',', '.') ?></div>
        
        <form method="POST" action="konfirmasi.php">
    <input type="hidden" name="total" value="<?= $total ?>">
    <?php foreach ($items as $index => $item): ?>
        <input type="hidden" name="items[<?= $index ?>][nama]" value="<?= htmlspecialchars($item['nama']) ?>">
        <input type="hidden" name="items[<?= $index ?>][varian]" value="<?= htmlspecialchars($item['varian']) ?>">
        <input type="hidden" name="items[<?= $index ?>][harga]" value="<?= $item['harga'] ?>">
        <input type="hidden" name="items[<?= $index ?>][kuantitas]" value="<?= $item['kuantitas'] ?>">
        <input type="hidden" name="items[<?= $index ?>][subtotal]" value="<?= $item['subtotal'] ?>">
    <?php endforeach; ?>
    <button type="submit">Konfirmasi Pembelian</button>
</form>
    </div>
</body>
</html>

<?php
$conn->close();
?>