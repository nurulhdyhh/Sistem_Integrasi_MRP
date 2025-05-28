<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['pelanggan'])) {
    echo "<script>
        alert('Anda harus login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}

$akun = $_SESSION['pelanggan'];

// Proses update data profil
$execUpdate = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username      = $_POST['username'];
    $email         = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $gender        = $_POST['gender'];
    $alamat        = $_POST['alamat'];
    $kota          = $_POST['kota'];
    $no_telp       = $_POST['no_telp'];
    $paypal_id     = $_POST['paypal_id'];

    $id_pelanggan = $akun['id_pelanggan'];

    $queryUpdate = "UPDATE tbl_pelanggan SET
        username         = '$username',
        email_pelanggan  = '$email',
        tanggal_lahir    = '$tanggal_lahir',
        gender           = '$gender',
        alamat_pelanggan = '$alamat',
        kota_pelanggan   = '$kota',
        no_telp          = '$no_telp',
        paypal_id        = '$paypal_id'
        WHERE id_pelanggan = '$id_pelanggan'";

    $execUpdate = mysqli_query($db, $queryUpdate);

    if ($execUpdate) {
        // Ambil data terbaru dari DB
        $getUpdated = mysqli_query($db, "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
        $akunBaru = mysqli_fetch_assoc($getUpdated);

        // Perbarui data session
        $_SESSION['pelanggan'] = $akunBaru;

        $success = true;
    } else {
        $error = mysqli_error($db);
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil - MediStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
        .edit-card {
            max-width: 700px; margin: 60px auto;
            background: #fff; border-radius: 16px;
            padding: 30px 40px; box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .edit-card h3 { text-align:center; margin-bottom:30px; color:#2c3e50; }
        .form-group { margin-bottom:15px; }
        .form-group label { font-weight:500; color:#555; }
        .btn-save {
            background:#3498db; color:#fff;
            padding:12px 25px; border:none;
            border-radius:8px; width:100%;
        }
        .btn-save:hover { background:#2980b9; }
    </style>
</head>
<body>
    <div class="edit-card">
        <h3>Edit Profil Pengguna</h3>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input name="username" class="form-control" required value="<?= htmlspecialchars($akun['username']) ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($akun['email_pelanggan']) ?>">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required value="<?= $akun['tanggal_lahir'] ?>">
            </div>
            <div class="form-group">
                <label>Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderL" value="Laki-laki" <?= $akun['gender'] == 'Laki-laki' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="genderL">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderP" value="Perempuan" <?= $akun['gender'] == 'Perempuan' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="genderP">Perempuan</label>
                </div>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required><?= htmlspecialchars($akun['alamat_pelanggan']) ?></textarea>
            </div>
            <div class="form-group">
                <label>Kota</label>
                <select name="kota" class="form-control" required>
                    <option value="">Pilih Kota</option>
                    <option value="Jakarta" <?= $akun['kota_pelanggan'] == 'Jakarta' ? 'selected' : '' ?>>Jakarta</option>
                    <option value="Bandung" <?= $akun['kota_pelanggan'] == 'Bandung' ? 'selected' : '' ?>>Bandung</option>
                    <option value="Surabaya" <?= $akun['kota_pelanggan'] == 'Surabaya' ? 'selected' : '' ?>>Surabaya</option>
                    <option value="Lamongan" <?= $akun['kota_pelanggan'] == 'Lamongan' ? 'selected' : '' ?>>Lamongan</option>
                    <option value="Sidoarjo" <?= $akun['kota_pelanggan'] == 'Sidoarjo' ? 'selected' : '' ?>>Sidoarjo</option>
                    <option value="Malang" <?= $akun['kota_pelanggan'] == 'Malang' ? 'selected' : '' ?>>Malang</option>
                    <option value="Mojokerto" <?= $akun['kota_pelanggan'] == 'Mojokerto' ? 'selected' : '' ?>>Mojokerto</option>
                    <option value="Gresik" <?= $akun['kota_pelanggan'] == 'Gresik' ? 'selected' : '' ?>>Gresik</option>
                    <option value="Tuban" <?= $akun['kota_pelanggan'] == 'Tuban' ? 'selected' : '' ?>>Tuban</option>
                </select>
            </div>
            <div class="form-group">
                <label>No Telepon</label>
                <input name="no_telp" class="form-control" required value="<?= htmlspecialchars($akun['no_telp']) ?>">
            </div>
            <div class="form-group">
                <label>Paypal ID</label>
                <input name="paypal_id" class="form-control" required value="<?= htmlspecialchars($akun['paypal_id']) ?>">
            </div>
            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </form>
    </div>

    <?php if (isset($success) && $success): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data profil berhasil diperbarui!',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'profile.php';
        });
    </script>
    <?php elseif (isset($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= addslashes($error) ?>'
        });
    </script>
    <?php endif; ?>
</body>
</html>
