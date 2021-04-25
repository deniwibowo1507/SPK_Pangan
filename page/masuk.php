<?php
// untuk koneksi ke database
include_once './../database/koneksi.php';
session_start();

if (isset($_POST["masuk"])) {

    $user = $_POST['inpusername'];
    $pass = $_POST['inppassword'];

    $sql    = "SELECT * FROM tb_user WHERE username = '$user'";
    $result = $connect->query($sql);
    // cek username
    if ($result->num_rows > 0) {
        // cek password
        $row = $result->fetch_array(MYSQLI_ASSOC);
        // untuk mengecek username
        if ($row['username'] == $user) {
            // untuk mengecek password
            if (password_verify($pass, $row["password"])) {
                // untuk mengecek level user
                if ($row['level'] == 'admin') {
                    // set session
                    $_SESSION["inpusername"] = $user;
                    $_SESSION["level"]       = 'admin';
                    header("location: ./../admin/index.php");
                    exit;
                }
                if ($row['level'] == 'user') {
                    // set session
                    $_SESSION["inpusername"] = $user;
                    $_SESSION["id_user"]     = $row['id_user'];
                    $_SESSION["level"]       = 'user';
                    header("location: ./../user/index.php");
                    exit;
                }
            } else {
                $inppassword = true;
            }
        }
    } else {
        $inpuserornpm = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Voler Admin Dashboard</title>
    <link rel="stylesheet" href="./../admin/assets/css/bootstrap.css">
    <link rel="stylesheet" href="./../admin/assets/vendors/simple-datatables/style.css">
    <link rel="stylesheet" href="./../admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="./../admin/assets/css/app.css">
    <link rel="shortcut icon" href="./../admin/assets/images/favicon.png" type="image/x-icon">
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="./../admin/assets/images/favicon.png" height="48" class='mb-4'>
                                <h3>Sign In</h3>
                            </div>
                            <!-- begin:: alert -->
                            <?php if (isset($inpuserornpm)) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> Username atau Password yang Anda masukkan tidak terdaftar.
                                </div>
                            <?php } else if (isset($inppassword)) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> Password yang Anda masukkan salah!
                                </div>
                            <?php } else if (isset($_GET['masuk'])) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> untuk mengakses Anda harus login terlebih dahulu.
                                </div>
                            <?php } else if (isset($_GET['admin'])) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> untuk mengakses Anda harus login terlebih dahulu.
                                </div>
                            <?php } ?>
                            <!-- end:: alert -->
                            <form method="post" class="form-box">
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" name="inpusername" class="form-control" id="username" required="required" placeholder="Username" />
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="password" name="inppassword" class="form-control" id="password" required="required" placeholder="Password" />
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" name="masuk" class="btn btn-primary btn-block">Masuk</button>
                                    <a href="beranda.php" class="btn btn-danger btn-block">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./../admin/assets/js/feather-icons/feather.min.js"></script>
    <script src="./../admin/assets/js/app.js"></script>
    <script src="./../admin/assets/js/main.js"></script>
</body>

</html>