<?php
    session_start();
    include "koneksi.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Toko Alat Kesehatan</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container-login {
            width: 800px;
            background-color: #fff;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        .header-login {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            width: 100%;
            text-align: center;
        }

        .header-login img {
            max-width: 80px;
            margin-right: 20px;
        }

        .header-login h2 {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            text-align: center;
            flex: 1;
            width: 100%;
            line-height: 40px;
        }

        .form-login {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group-horizontal {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            width: 100%;
            justify-content: center;
        }

        .form-group-horizontal label {
            width: 100px;
            margin: 0;
        }

        .form-group-horizontal input {
            flex: 1;
            height: 40px;
            padding: 5px 10px;
            font-size: 16px;
            max-width: 350px;
        }

        .login-btn {
            width: 100px;
            height: 45px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            max-width: 350px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .login-btn:hover {
            background-color: #45a049;
        }

        .forgot-password {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container-login">
        <!-- Header -->
        <div class="header-login">
            <img src="assets/img/icon/logo.png" alt="Logo">
            <h2>Selamat datang <br>di MediStore</h2>
        </div>

        <!-- Form Login -->
        <form class="form-login" action="" method="post">
            <div class="form-group-horizontal">
                <label for="userID">User ID</label>
                <input type="text" id="userID" name="u" class="form-control" required placeholder="Masukkan User ID">
            </div>

            <div class="form-group-horizontal">
                <label for="password">Password</label>
                <input type="password" id="password" name="p" class="form-control" required placeholder="Masukkan Password">
            </div>

            <button type="submit" class="login-btn" name="login">LOGIN</button>

            <div class="forgot-password">
                <a href="signup.php">Sign Up?</a>
            </div>

            <?php
            if (isset($_POST['login'])) {
                $ambil = $db->query("SELECT * FROM tbl_pelanggan WHERE username = '" . $_POST['u'] . "' AND password = '" . $_POST['p'] . "'");
                $yangcocok = $ambil->num_rows;
                if ($yangcocok == 1) {
                    $akun = $ambil->fetch_assoc();
                    $_SESSION['pelanggan'] = $akun;

                    echo "<script type='text/javascript'>
                        swal('Selamat', 'Anda Berhasil Login', 'success').then(() => {
                            document.getElementById('userID').value = '';
                            document.getElementById('password').value = '';
                            window.location.href = 'checkout.php';
                        });
                    </script>";
                } else {
                    echo "<script type='text/javascript'>
                        swal('Login Gagal!', 'Username Dan Password Anda Salah', 'info');
                    </script>";
                }
            }
            ?>
        </form>
    </div>

</body>

</html>
