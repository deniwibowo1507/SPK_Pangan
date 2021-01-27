<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<?php
$id_kriteria = $_GET['id_kriteria'];
$sql         = "SELECT * FROM tb_kriteria WHERE id_criteria = '$id_kriteria'";
$query       = $connect->query($sql);
$row         = $query->fetch_array(MYSQLI_ASSOC);
?>

<div id="app">
    <!-- begin:: sidebar -->
    <?php include_once 'atribut/sidebar.php'; ?>
    <!-- end:: sidebar -->
    <div id="main">
        <!-- begin:: navbar -->
        <?php include_once 'atribut/navbar.php'; ?>
        <!-- end:: navbar -->
        <div class="main-content container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="card-title">Ubah Data Kriteria</h3>
                    </div>
                    <div class="col-12 col-md-6">
                        <nav aria-label="breadcrumb" class='breadcrumb-header text-right'>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Breadcrumb</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
            <section class="section">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="col-sm-12">
                                    <label>Nama Kriteria</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="nm_kriteria" value="<?= $row['criteria'] ?>" />
                                        </div>
                                    </div>
                                    <label>Tipe</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select name="tipe" class="form-control">
                                                <option value="max" <?= ($row['tipe'] === 'max' ? 'selected' : '') ?>>Max</option>
                                                <option value="min" <?= ($row['tipe'] === 'min' ? 'selected' : '') ?>>Min</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="ubah" class="btn btn-success">UBAH</button>
                                <a href="data_kriteria.php" class="btn btn-danger">BATAL</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- begin:: footer -->
        <?php include_once 'atribut/footer.php' ?>
        <!-- end:: footer -->
    </div>
</div>

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<?php
if (isset($_POST['ubah'])) {
    $kriteria = $_POST['nm_kriteria'];
    $tipe     = $_POST['tipe'];

    $query  = "UPDATE tb_kriteria SET criteria = '$kriteria', tipe = '$tipe' WHERE id_criteria = '$id_kriteria'";
    $result = $connect->query($query);

    if ($result) {
        echo "<script>
		alert('Berhasil')
		window.location=(href='data_kriteria.php')
		</script>";
    } else {
        echo "<script>
		alert('Gagal')
		window.location=(href='data_kriteria.php')
		</script>";
    }
}
?>