<?php
include '../db.php'; // Koneksi ke database

// Check if total is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total'])) {
    $total = floatval($_POST['total']);
    $items = $_POST['items']; // Retrieve items from POST data

    // Sample transaction details
    $trx_id = "TR" . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // Generate a transaction ID
    $kasir = "administrator"; // Replace with actual user data if necessary
    $tanggal = date("Y-m-d H:i:s"); // Current date and time
    $diskon = 0; // You can set an actual discount if applicable
    $dibayar = $total; // Total payment amount
} else {
    // Redirect if no total was set
    header('Location: index.php'); // Change to your main page
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: monospace; /* Use monospace for receipt style */
            background-color: #fff;
            margin-top: 50px;
            margin-left: 470px;
            padding: 20px;
            width: 300px; /* Set width to match receipt */
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }
        h2 {
            text-align: center;
            font-size: 16px;
        }
        .details {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            padding: 5px;
            text-align: left;
            font-size: 12px;
            border-bottom: 1px dotted #000; /* Dotted line for table rows */
        }
        .total {
            font-weight: bold;
            font-size: 12px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
        .print-button {
            width: 100%;
            padding: 10px;
            background-color: #2575fc;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .print-button:hover {
            background-color: rgb(15, 87, 211);
        }
    </style>
</head>
<body>
    <h2>REZKY STORE</h2>
    <div class="details">
        <p>Telp. 081234567890</p>
        <p>TRX: <?= $trx_id ?></p>
        <p>Kasir: <?= $kasir ?></p>
        <p>Tanggal: <?= $tanggal ?></p>
    </div>
    <table>
        <tr>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?> x <?= $item['kuantitas'] ?></td>
            <td><?= $item['kuantitas'] ?></td>
            <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <div class="total">Total Bayar: Rp<?= number_format($total, 0, ',', '.') ?></div>
    <div class="total">Dibayar: Rp<?= number_format($dibayar, 0, ',', '.') ?></div>
    
    <div class="footer">TERIMA KASIH<br>ATAS KUNJUNGAN ANDA</div><br>
    <button class="print-button" onclick="window.print()">Print</button>
</body>
</html>

<?php
$conn->close();
?>