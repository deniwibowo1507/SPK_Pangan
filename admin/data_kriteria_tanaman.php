<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

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
                        <h3 class="card-title">Data Lokasi Penanaman</h3>
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
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#smallModal">
                            <i data-feather="plus"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no    = 1;
                                    $sql   = "SELECT  tb_alternatif.`name`, tb_kriteria.criteria, tb_kriteria.id_criteria, tb_evaluasi.`value`, tb_evaluasi.id_alternative FROM tb_evaluasi INNER JOIN tb_alternatif ON tb_evaluasi.id_alternative = tb_alternatif.id_alternative INNER JOIN tb_kriteria ON tb_evaluasi.id_criteria = tb_kriteria.id_criteria ORDER BY tb_evaluasi.id_alternative ASC,tb_evaluasi.id_criteria ASC";
                                    $query = $connect->query($sql);
                                    while ($row = $query->fetch_array(MYSQLI_ASSOC)) { ?>
                                        <tr>
                                            <td><?= $no++  ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['criteria'] ?></td>
                                            <td><?= $row['value'] ?></td>
                                            <td>
                                                <a href="data_kriteria_tanaman_ubah.php?id_alternatif=<?= $row['id_alternative'] ?>&id_kriteria=<?= $row['id_criteria'] ?>" class='btn btn-modifikasi btn-primary'>
                                                    <i data-feather="edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- begin:: footer -->
        <?php include_once 'atribut/footer.php'; ?>
        <!-- end:: footer -->
    </div>
</div>

<!-- begin:: modal tambah -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Input Kriteria Tanaman</h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control show-tick" name="nm_tanaman">
                                <option>Nama Tanaman</option>
                                <?php
                                $sql      = "SELECT * FROM tb_alternatif";
                                $tanaman = $connect->query($sql);

                                while ($row = $tanaman->fetch_array(MYSQLI_ASSOC)) {
                                ?>
                                    <option value="<?php echo $row['id_alternative'] ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="hidden" name="id_kriteria[]" value="1" readonly="readonly">
                            <select name="kriteria[]" class="form-control show-tick">
                                <option>Jenis Tanah</option>
                                <option value="4">Latosol</option>
                                <option value="3">Organosol</option>
                                <option value="2">Podzolik</option>
                                <option value="1">Litosol</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="hidden" name="id_kriteria[]" value="2" readonly="readonly">
                            <select name="kriteria[]" class="form-control show-tick">
                                <option>Curah Hujan</option>
                                <option value="3">Tinggi (300-400 mm/bulan)</option>
                                <option value="2">Menengah (200-300 mm/bulan)</option>
                                <option value="1">Rendah (100-200 mm/bulan)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="hidden" name="id_kriteria[]" value="3" readonly="readonly">
                            <select name="kriteria[]" class="form-control show-tick">
                                <option>Drainase</option>
                                <option value="2">Ada</option>
                                <option value="1">Tidak Ada</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="hidden" name="id_kriteria[]" value="4" readonly="readonly">
                            <select name="kriteria[]" class="form-control show-tick">
                                <option>PH</option>
                                <option value="4">Basa Sedang (7,5 - 8,5)</option>
                                <option value="3">Netral (7,0 - 7,5)</option>
                                <option value="2">Asam Sedang (4,0 - 6,9)</option>
                                <option value="1">Sangat Asam (< 4)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="hidden" name="id_kriteria[]" value="5" readonly="readonly">
                            <select name="kriteria[]" class="form-control show-tick">
                                <option>Ketinggian Tempat</option>
                                <option value="2">Dataran Tinggi (500 - 1500 mdpl)</option>
                                <option value="1">Dataran Rendah (0 - 500 mdpl)</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-success">TAMBAH</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end:: modal tambah -->

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/vendors.js"></script>

<?php
if (isset($_POST['tambah'])) {
    $nama_tanaman = $_POST['nm_tanaman'];
    $kriteria     = $_POST['id_kriteria'];
    $value        = $_POST['kriteria'];

    for ($i = 0; $i < count($kriteria); $i++) {
        $query  = "INSERT INTO tb_evaluasi (id_alternative, id_criteria, value) VALUES ('$nama_tanaman','$kriteria[$i]','$value[$i]')";
        $result = $connect->query($query);
    }

    if ($result) {
        echo "<script>
        alert('Berhasil')
        window.location=(href='data_kriteria_tanaman.php')
        </script>";
    } else {
        echo "<script>
        alert('Gagal')
        window.location=(href='data_kriteria_tanaman.php')
        </script>";
    }
}
?>