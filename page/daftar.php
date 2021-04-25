<?php
// untuk koneksi ke database
include_once './../database/koneksi.php';
session_start();

if (isset($_POST["daftar"])) {

    $nik     = $_POST['inpnik'];
    $nama    = $_POST['inpnama'];
    $no_hp   = $_POST['inpnohp'];
    $tmp_lhr = $_POST['inptmplahir'];
    $tgl_lhr = $_POST['inptgllahir'];
    $jen_kel = $_POST['inpjenkel'];
    $alamat  = $_POST['inpalamat'];
    $user    = $_POST['inpusername'];
    $pass    = password_hash($_POST['inppassword'], PASSWORD_DEFAULT);
    $level   = 'user';
    
    $connect->query("INSERT INTO tb_user (username, password, level) VALUES ('$user', '$pass', '$level')");
    $last_id = $connect->insert_id;
    $connect->query("INSERT INTO tb_member (id_user, nik, nama, no_hp, tmp_lhr, tgl_lhr, jen_kel, alamat) VALUES ('$last_id', '$nik', '$nama', '$no_hp', '$tmp_lhr', '$tgl_lhr', '$jen_kel', '$alamat')");

    echo "<script>location.href = 'masuk.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Voler Admin Dashboard</title>
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
                                <h3>Sign Up</h3>
                            </div>
                            <form method="post" class="form-box">
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" class="form-control inputNumber" name="inpnik" id="inpnik" pattern="\d*" maxlength="16" required="required" placeholder="Masukkan NIK" />
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="inpnama" id="inpnama" required="required" placeholder="Masukkan Nama" />
                                        <div class="form-control-icon">
                                            <i data-feather="eye"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" class="form-control inputNumber" name="inpnohp" id="inpnohp" pattern="\d*" maxlength="12" required="required" placeholder="Masukkan No. Hp" />
                                        <div class="form-control-icon">
                                            <i data-feather="tablet"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="inptmplahir" id="inptmplahir" required="required" placeholder="Masukkan Tempat Lahir" />
                                        <div class="form-control-icon">
                                            <i data-feather="triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="date" class="form-control" name="inptgllahir" id="inptgllahir" required="required" placeholder="Masukkan Tanggal Lahir" />
                                        <div class="form-control-icon">
                                            <i data-feather="calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <select name="inpjenkel" class="form-control" required="required">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L">Laki - laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <div class="form-control-icon">
                                            <i data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="inpalamat" id="inpalamat" required="required" placeholder="Masukkan Alamat" />
                                        <div class="form-control-icon">
                                            <i data-feather="triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="inpusername" id="inpusername" required="required" placeholder="Masukkan Username" />
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="position-relative">
                                        <input type="password" class="form-control" name="inppassword" id="inppassword" required="required" placeholder="Masukkan Password" />
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" name="daftar" class="btn btn-primary btn-block">Daftar</button>
                                    <a href="beranda.php" class="btn btn-danger btn-block">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="./../admin/assets/js/feather-icons/feather.min.js"></script>
    <script src="./../admin/assets/js/app.js"></script>
    <script src="./../admin/assets/js/main.js"></script>

    <script>
        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));

        $(".inputNumber").inputFilter(function(value) {
            return /^-?\d*$/.test(value);
        });
    </script>
</body>

</html>