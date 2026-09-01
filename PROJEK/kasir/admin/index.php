<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir Mini</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        a {
            color: rgb(0, 0, 0);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s, transform 0.3s;
        }

        .navbar {
            background-color: #0d6efd;
            color: white;
            padding: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 18px;
        }

        .container {
            padding: 20px;
            text-align: center;
        }

        .store-info {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: left;
        }

        .store-info img {
            float: left;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .store-info h3 {
            margin: 0;
            font-size: 16px;
        }

        .store-info p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card i {
            font-size: 30px;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        .card h4 {
            font-size: 14px;
            margin: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Kasir Online</h1>
    </div>

    <div class="container">
        <div class="store-info">
            <img src="https://via.placeholder.com/50" alt="Logo">
            <h3>Rezky Store</h3>
            <p>Jl. Rappokalling, Kota Makassar</p>
        </div>

        <div class="grid">
            <div class="card">
                <i class="fas fa-box"></i>
                <h4><a href="data_barang.php">Produk</a></h4>
            </div>
            <div class="card">
                <i class="fas fa-users"></i>
                <h4><a href="pembeli.php">Pembeli</a></h4>
            </div>
            <div class="card">
                <i class="fas fa-shopping-cart"></i>
                <h4><a href="pembelian.php">Pembelian</a></h4>
            </div>
            <div class="card">
                <i class="fas fa-file-invoice"></i>
                <h4><a href="pesanan.php">Pesanan</a></h4>
            </div>
            <div class="card">
                <i class="fas fa-cash-register"></i>
                <h4><a href="kasir_transaksi.php">Transaksi Barang</a></h4>
            </div>
            <div class="card">
                <i class="fas fa-truck"></i>
                <h4><a href="Supplier.php">Supplier</a></h4>
            </div>
            <div class="card">
                <i class="fas fa-chart-line"></i>
                <h4><a href="laporan.php">Laporan</a></h4>
            </div>
        </div>
    </div>
</body>
</html>
