<?php
require "../koneksi.php";

// Tampilkan error untuk debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Query total penjualan per bulan
$q = "SELECT MONTH(tgl_order) AS bulan, SUM(total_order) AS total_penjualan 
      FROM tbl_order
      WHERE status = 'Produk Diterima'
      GROUP BY MONTH(tgl_order)";
$res = mysqli_query($db, $q) or die("Query gagal: " . mysqli_error($db));

// Query total pembayaran
$q3 = "SELECT SUM(jml_pembayaran) as jml FROM tbl_pembayaran";
$res3 = mysqli_query($db, $q3) or die("Query gagal: " . mysqli_error($db));
$dta3 = mysqli_fetch_assoc($res3);

// Query jumlah pelanggan
$q4 = "SELECT COUNT(id_pelanggan) as jml FROM tbl_pelanggan";
$res4 = mysqli_query($db, $q4) or die("Query gagal: " . mysqli_error($db));
$dta4 = mysqli_fetch_assoc($res4);

// Query jumlah stok produk
$q5 = "SELECT SUM(stok) as jml FROM tbl_produk";
$res5 = mysqli_query($db, $q5) or die("Query gagal: " . mysqli_error($db));
$dta5 = mysqli_fetch_assoc($res5);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="assets/js/Chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .container {
      margin-bottom: 30px;
    }
    .mini-stat {
      padding: 20px;
      border-radius: 10px;
      color: white;
      margin-bottom: 20px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }
    .bg-orange { background-color: orange; }
    .bg-primary { background-color: #007bff; }
    .bg-success { background-color: #28a745; }
    h4 { margin: 0; }
  </style>
</head>
<body>

<div class="container">
  <div class="row" style="display: flex; gap: 20px;">
    <div class="col-md-4">
      <div class="mini-stat bg-orange">
        <span title="Total Pendapatan"><i class="mdi mdi-cart-outline" style="font-size: 30px;"></i></span>
        <div>
          <small>Total Pendapatan</small>
          <h4>Rp. <?= number_format($dta3['jml']); ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mini-stat bg-primary">
        <span title="Total Member"><i class="mdi mdi-account-multiple" style="font-size: 30px;"></i></span>
        <div>
          <small>Total Member</small>
          <h4><?= number_format($dta4['jml']); ?> Orang</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mini-stat bg-success">
        <span title="Total Produk"><i class="mdi mdi-gift" style="font-size: 30px;"></i></span>
        <div>
          <small>Total Produk</small>
          <h4><?= number_format($dta5['jml']); ?> Unit</h4>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="card" style="padding: 20px;">
    <h3>Grafik Total Penjualan per Bulan</h3>
    <canvas id="myChart"></canvas>
  </div>
</div>

<script>
  // Cek apakah Chart.js dimuat
  if (typeof Chart === 'undefined') {
    console.error("Chart.js gagal dimuat. Pastikan 'assets/js/Chart.js' tersedia.");
  }

  const ctx = document.getElementById("myChart").getContext('2d');

  const months = [];
  const sales = [];

  <?php while ($row = mysqli_fetch_array($res)) { ?>
    months.push('<?php echo date("F", mktime(0, 0, 0, $row['bulan'], 10)); ?>');
    sales.push(<?php echo $row['total_penjualan']; ?>);
  <?php } ?>

  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Total Penjualan Per Bulan',
        data: sales,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

</body>
</html>
