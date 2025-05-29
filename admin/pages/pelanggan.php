<?php
// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "packindo");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Proses hapus pelanggan berdasarkan ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // pastikan id integer
    $queryHapus = "DELETE FROM tbl_pelanggan WHERE id_pelanggan = '$id'";
    $execHapus = mysqli_query($db, $queryHapus);

    if ($execHapus) {
        echo "<script>
            setTimeout(function() {
                swal('Berhasil', 'Data pelanggan berhasil dihapus!', 'success')
                .then(() => {
                    window.location.href = 'pelanggan.php';
                });
            }, 100);
        </script>";
    } else {
        echo "<script>
            setTimeout(function() {
                swal('Gagal', 'Gagal menghapus data pelanggan!', 'error');
            }, 100);
        </script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Data Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap, jQuery, SweetAlert, FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            width: 85%;
            margin: 50px auto;
        }

        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
            font-size: 14px;
        }

        .table th {
            background-color: #3498db;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .header-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .btn {
            font-size: 12px;
            padding: 5px 10px;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d68910;
        }

        .btn-info {
            background-color: #3498db;
            color: white;
        }

        .btn-info:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="header-title">Data Pelanggan</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Tanggal Lahir</th>
                    <th>Gender</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>No Telepon</th>
                    <th>Paypal ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM tbl_pelanggan";
                $result = mysqli_query($db, $query);
                $no = 1;
                while ($data = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['username']) ?></td>
                    <td><?= htmlspecialchars($data['password']) ?></td>
                    <td><?= htmlspecialchars($data['email_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($data['tanggal_lahir']) ?></td>
                    <td><?= htmlspecialchars($data['gender']) ?></td>
                    <td><?= htmlspecialchars($data['alamat_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($data['kota_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($data['no_telp']) ?></td>
                    <td><?= htmlspecialchars($data['paypal_id']) ?></td>
                
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
