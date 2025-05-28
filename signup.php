<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body {
            background-size: cover;
            color: #fff;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .signup-form {
            width: 60%;
            margin: 50px auto;
            padding: 30px;
            background: rgba(182, 179, 179, 0.8);
            border-radius: 10px;
        }

        .signup-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        .signup-form input,
        .signup-form select {
            margin-bottom: 15px;
        }

        .signup-form .btn {
            width: 48%;
            background-color: #3498db;
            border: none;
        }

        .signup-form .btn-clear {
            background-color: #e74c3c;
        }

        @media (min-width: 768px) {
            .signup-form {
                width: 50%;
            }
        }
    </style>
</head>

<body>
    <div class="signup-form">
        <h2>Form Registrasi</h2>
        <form action="" method="post" class="form-horizontal" autocomplete="off">

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control" value="" required autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="password" class="form-control" value="" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Ulangi Password</label>
                <div class="col-sm-9">
                    <input type="password" name="retype_password" class="form-control" value="" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email_pelanggan" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="Laki-laki" required> Laki-laki
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="Perempuan" required> Perempuan
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <input type="text" name="alamat_pelanggan" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Kota</label>
                <div class="col-sm-9">
                    <select name="kota_pelanggan" class="form-control" required>
                        <option value="">Pilih Kota</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Yogyakarta">Lamongan</option>
                        <option value="Yogyakarta">Sidoarjo</option>
                        <option value="Yogyakarta">Malang</option>
                        <option value="Yogyakarta">Mojokerto</option>
                        <option value="Medan">Gersik</option>
                        <option value="Medan">Tuban</option>
                        <option value="Medan">Bojonegoro</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">No Telepon</label>
                <div class="col-sm-9">
                    <input type="text" name="no_telp" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Paypal ID</label>
                <div class="col-sm-9">
                    <input type="text" name="paypal_id" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" name="signup" class="btn btn-success">Submit</button>
                    <button type="reset" class="btn btn-clear">Clear</button>
                </div>
            </div>

        </form>
    </div>

    <?php
    $db = mysqli_connect("localhost", "root", "", "medistore");

    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $retype_password = $_POST['retype_password'];
        $email = $_POST['email_pelanggan'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $gender = $_POST['gender'];
        $alamat = $_POST['alamat_pelanggan'];
        $kota = $_POST['kota_pelanggan'];
        $no_telp = $_POST['no_telp'];
        $paypal = $_POST['paypal_id'];

        if ($password !== $retype_password) {
            echo "<script>swal('Oops', 'Password tidak cocok!', 'error');</script>";
        } else {
            $result = mysqli_query($db, "SELECT id_pelanggan FROM tbl_pelanggan ORDER BY id_pelanggan DESC LIMIT 1");
            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['id_pelanggan'] : 'USR-000';
            $newID = 'USR-' . str_pad((int)substr($lastID, 4) + 1, 3, '0', STR_PAD_LEFT);

            $query = "INSERT INTO tbl_pelanggan 
                (id_pelanggan, username, password, email_pelanggan, tanggal_lahir, gender, alamat_pelanggan, kota_pelanggan, no_telp, paypal_id) 
                VALUES 
                ('$newID', '$username', '$password', '$email', '$tanggal_lahir', '$gender', '$alamat', '$kota', '$no_telp', '$paypal')";

            $exec = mysqli_query($db, $query);

            if ($exec) {
                echo "<script>swal('Berhasil', 'Akun berhasil didaftarkan!', 'success');</script>";
                echo "<meta http-equiv='refresh' content='2;url=login.php'>";
            } else {
                echo "<script>swal('Gagal', 'Terjadi kesalahan saat mendaftar', 'error');</script>";
            }
        }
    }
    ?>

</body>

</html>
