<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['pelanggan'])) {
    echo "<script>swal('Akses Ditolak', 'Anda harus login terlebih dahulu!', 'warning');</script>";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    exit();
}

$akun = $_SESSION['pelanggan'];
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Pengguna - MediStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }

        .profile-card {
            max-width: 700px;
            margin: 60px auto;
            background: #ffffff;
            border-radius: 16px;
            padding: 30px 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .profile-card h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #2c3e50;
        }

        .profile-item {
            margin-bottom: 15px;
        }

        .profile-item label {
            font-weight: 500;
            color: #555;
        }

        .profile-item .value {
            font-weight: 600;
            color: #333;
        }

        hr {
            margin: 15px 0;
            border-top: 1px solid #ddd;
        }

        .btn-back, .btn-edit {
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-back {
            background-color: #3498db;
            color: white;
        }

        .btn-back:hover {
            background-color: #2980b9;
            color: #fff;
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e67e22;
            color: #fff;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            text-align: center;
        }

        .button-group a {
            width: 48%;
            text-align: center; 
        }

        @media (max-width: 576px) {
            .profile-card {
                padding: 25px 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group a {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="profile-card">
        <h3>Profil Pengguna</h3>

        <div class="profile-item">
            <label>ID User</label>
            <div class="value"><?php echo $akun['id_pelanggan']; ?></div>
        </div>

        <div class="profile-item">
            <label>Username</label>
            <div class="value"><?php echo $akun['username']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>Email</label>
            <div class="value"><?php echo $akun['email_pelanggan']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>Tanggal Lahir</label>
            <div class="value"><?php echo $akun['tanggal_lahir']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>Gender</label>
            <div class="value"><?php echo $akun['gender']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>Alamat</label>
            <div class="value"><?php echo $akun['alamat_pelanggan']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>Kota</label>
            <div class="value"><?php echo $akun['kota_pelanggan']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>No Telepon</label>
            <div class="value"><?php echo $akun['no_telp']; ?></div>
        </div>
        <hr>

        <div class="profile-item">
            <label>Paypal ID</label>
            <div class="value"><?php echo $akun['paypal_id']; ?></div>
        </div>

        <!-- Tombol Edit Profil dan Kembali -->
        <div class="button-group">
            <a href="edit_profil.php" class="btn-edit">Edit Profil</a>
            <a href="index.php" class="btn-back">Kembali</a>
        </div>
    </div>

</body>

</html>