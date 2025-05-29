<?php
require "../koneksi.php";

// Query Statistik Order
$totalOrder        = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order"));
$blmDibayar        = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Belum Dibayar'"));
$sudahDibayar      = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Sudah Dibayar'"));
$menyiapkanProduk  = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Menyiapkan Produk'"));
$produkDikirim     = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Produk Dikirim'"));
$produkDiterima    = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Produk Diterima'"));

// Total order per bulan
$qOrders = "SELECT MONTH(tgl_order) AS bulan, COUNT(*) AS jumlah_order 
            FROM tbl_order 
            GROUP BY MONTH(tgl_order)";
$resOrders = mysqli_query($db, $qOrders);

// Produk Diterima per bulan
$qDiterima = "SELECT MONTH(tgl_order) AS bulan, COUNT(*) AS jumlah_diterima 
              FROM tbl_order 
              WHERE status = 'Produk Diterima' 
              GROUP BY MONTH(tgl_order)";
$resDiterima = mysqli_query($db, $qDiterima);

// Gabungkan data ke array JS (pakai PHP)
$data = [];
while ($row = mysqli_fetch_assoc($resOrders)) {
    $bulan = (int)$row['bulan'];
    $data[$bulan]['order'] = (int)$row['jumlah_order'];
}
while ($row = mysqli_fetch_assoc($resDiterima)) {
    $bulan = (int)$row['bulan'];
    $data[$bulan]['diterima'] = (int)$row['jumlah_diterima'];
}
?>

<!-- Kartu Statistik -->
<div class="row">
    <?php
    $stats = [
        ['label' => 'Total Order',        'count' => $totalOrder['jml'],       'icon' => 'mdi-cart-outline',     'color' => 'text-primary'],
        ['label' => 'Belum Dibayar',      'count' => $blmDibayar['jml'],       'icon' => 'mdi-currency-usd',     'color' => 'text-success'],
        ['label' => 'Sudah Dibayar',      'count' => $sudahDibayar['jml'],     'icon' => 'mdi-currency-usd',     'color' => 'text-warning'],
        ['label' => 'Menyiapkan Produk',  'count' => $menyiapkanProduk['jml'], 'icon' => 'mdi-gift',             'color' => 'text-info'],
        ['label' => 'Produk Dikirim',     'count' => $produkDikirim['jml'],    'icon' => 'mdi-airplane-takeoff', 'color' => 'text-danger'],
        ['label' => 'Produk Diterima',    'count' => $produkDiterima['jml'],   'icon' => 'mdi-home',             'color' => 'text-success']
    ];

    foreach ($stats as $s) {
        echo '
        <div class="col-md-6 col-lg-4 col-xl-2 mb-3">
            <div class="mini-stat clearfix bg-white p-3 rounded shadow-sm">
                <span class="font-30 ' . $s['color'] . ' float-end"><i class="mdi ' . $s['icon'] . '"></i></span>
                <div class="mini-stat-info">
                    <h4 class="mb-0">' . number_format($s['count']) . '</h4>
                    <small class="text-muted">' . $s['label'] . '</small>
                </div>
            </div>
        </div>';
    }
    ?>
</div>

<!-- Grafik -->
<div class="card mt-4 p-4 shadow-sm">
    <h5 class="mb-4">Grafik Total Order per Bulan</h5>
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("myChart").getContext('2d');

        const bulanLabels = [];
        const jumlahOrder = [];
        const jumlahDiterima = [];

        <?php
        for ($i = 1; $i <= 12; $i++) {
            $label = date('F', mktime(0, 0, 0, $i, 10));
            $order = isset($data[$i]['order']) ? $data[$i]['order'] : 0;
            $diterima = isset($data[$i]['diterima']) ? $data[$i]['diterima'] : 0;
            echo "bulanLabels.push('$label');";
            echo "jumlahOrder.push($order);";
            echo "jumlahDiterima.push($diterima);";
        }
        ?>

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bulanLabels,
                datasets: [
                    {
                        label: 'Jumlah Order',
                        data: jumlahOrder,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Produk Diterima',
                        data: jumlahDiterima,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>


