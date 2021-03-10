<!-- begin:: head -->
<?php include_once './atribut/head.php'; ?>
<!-- end:: head -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

<!-- begin:: navbar -->
<?php include_once './atribut/navbar.php'; ?>
<!-- end:: navbar -->

<!-- begin:: header -->
<?php include_once './atribut/header.php'; ?>
<!-- end:: header -->

<!-- begin:: content -->
<section class="page-section" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Kriteria Lokasi</h2>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahLokasi">
                            Tambah Lokasi
                        </button>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahLokasiKriteria">
                            Tambah Kriteria Lokasi
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lokasi Lokasi</th>
                                <?php
                                $sql      = "SELECT * FROM tb_kriteria_lokasi";
                                $query    = $connect->query($sql);
                                $result   = $query->fetch_array();
                                $kriteria = json_decode($result['kriteria'], true);
                                ?>
                                <th><?= $kriteria[0]['kriteria'] ?></th>
                                <th><?= $kriteria[1]['kriteria'] ?></th>
                                <th><?= $kriteria[2]['kriteria'] ?></th>
                                <th><?= $kriteria[3]['kriteria'] ?></th>
                                <th><?= $kriteria[4]['kriteria'] ?></th>
                                <th><?= $kriteria[5]['kriteria'] ?></th>
                                <th><?= $kriteria[6]['kriteria'] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql1 = "SELECT a.id_lokasi, b.nama_lokasi, a.kriteria FROM tb_kriteria_lokasi AS a INNER JOIN tb_lokasi AS b ON b.id_lokasi = a.id_lokasi";
                            $query = $connect->query($sql1);
                            while ($row = $query->fetch_array()) {
                                $kriteria = json_decode($row['kriteria'], true); ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama_lokasi'] ?></td>
                                    <td>
                                        <?php
                                        switch ($kriteria[0]['weight']) {
                                            case 6:
                                                echo 'Regosol';
                                                break;
                                            case 5:
                                                echo 'Litosol';
                                                break;
                                            case 4:
                                                echo 'Latosol';
                                                break;
                                            case 3:
                                                echo 'Organosol';
                                                break;
                                            case 2:
                                                echo 'Grumusol';
                                                break;
                                            case 1:
                                                echo 'Alluvial';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($kriteria[1]['weight']) {
                                            case 3:
                                                echo 'Tinggi (300 - 500 mm)';
                                                break;
                                            case 2:
                                                echo 'Menengah (100 - 300 mm)';
                                                break;
                                            case 1:
                                                echo 'Rendah (0 - 100 mm)';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($kriteria[2]['weight']) {
                                            case 2:
                                                echo 'Ada';
                                                break;
                                            case 1:
                                                echo 'Tidak Ada';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($kriteria[3]['weight']) {
                                            case 4:
                                                echo 'Basa Sedang (7,5 - 8,5)';
                                                break;
                                            case 3:
                                                echo 'Netral (7,0 - 7,5)';
                                                break;
                                            case 2:
                                                echo 'Asam Sedang (4,0 - 6,9)';
                                                break;
                                            case 1:
                                                echo 'Sangat Asam (< 4)';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($kriteria[4]['weight']) {
                                            case 2:
                                                echo 'Dataran Tinggi (500 - 1500 mdpl)';
                                                break;
                                            case 1:
                                                echo 'Dataran Rendah (0 - 500 mdpl)';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($kriteria[5]['weight']) {
                                            case 4:
                                                echo '26,3 C - 22 C';
                                                break;
                                            case 3:
                                                echo '22 C - 17,1 C';
                                                break;
                                            case 2:
                                                echo '17,1 C - 11,1 C';
                                                break;
                                            case 1:
                                                echo '11,1 C - 6,2 C';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($kriteria[6]['weight']) {
                                            case 4:
                                                echo '< 20 cm';
                                                break;
                                            case 3:
                                                echo '20 - 50 cm';
                                                break;
                                            case 2:
                                                echo '50 - 75 cm';
                                                break;
                                            case 1:
                                                echo '> 75 cm';
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end:: content -->

<!-- begin:: modal tambah lokasi -->
<div class="modal fade" id="tambahLokasi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Lokasi Penanaman</h4>
            </div>
            <div class="modal-body">
                <?php
                $query = "SELECT max(id_lokasi) as maxKode FROM tb_lokasi";
                $hasil = mysqli_query($connect, $query);
                $data = mysqli_fetch_array($hasil);
                $kodeOtomatis = $data['maxKode'];
                $noUrut = (int) substr($kodeOtomatis, 0, 3);
                $noUrut++;
                $kodeOtomatis = $noUrut;
                ?>

                <form method="POST">
                    <input type="hidden" name="inpidlokasi" value="<?= $kodeOtomatis ?>">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">Nama Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" required="required">
                            </div>
                        </div>
                        <button type="submit" name="tambah_lokasi" class="btn btn-success">TAMBAH</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end:: modal tambah lokasi -->

<!-- begin:: modal tambah kriteria lokasi -->
<div class="modal fade" id="tambahLokasiKriteria" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input Data Kriteria Lokasi</h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick" name="inp_namalokasi">
                                    <option>Nama Lokasi</option>
                                    <?php
                                    $sql      = "SELECT * FROM tb_lokasi";
                                    $lokasi = $connect->query($sql);

                                    while ($row = $lokasi->fetch_array(MYSQLI_ASSOC)) {
                                    ?>
                                        <option value="<?php echo $row['id_lokasi'] ?>"><?php echo $row['nama_lokasi']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria1" value="1" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria1" id="kriteria1">
                                    <option>Jenis Tanah</option>
                                    <option value="6">Regosol</option>
                                    <option value="5">Litosol</option>
                                    <option value="4">Latosol</option>
                                    <option value="3">Organosol</option>
                                    <option value="2">Grumusol</option>
                                    <option value="1">Alluvial</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria2" value="2" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria2" id="kriteria2">
                                    <option>Curah Hujan</option>
                                    <option value="3">Tinggi (300 - 500 mm)</option>
                                    <option value="2">Menengah (100 - 300 mm)</option>
                                    <option value="1">Renda (0 - 100 mm)h</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria3" value="3" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria3">
                                    <option>Drainase</option>
                                    <option value="2">Ada</option>
                                    <option value="1">Tidak Ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria4" value="4" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria4">
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
                                <input type="hidden" name="id_kriteria5" value="5" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria5">
                                    <option>Ketinggian Tempat</option>
                                    <option value="2">Dataran Tinggi (500 - 1500 mdpl)</option>
                                    <option value="1">Dataran Rendah (0 - 500 mdpl)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria6" value="6" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria6">
                                    <option>Temperatur</option>
                                    <option value="4">26,3 C - 22 C</option>
                                    <option value="3">22 C - 17,1 C</option>
                                    <option value="2">17,1 C - 11,1 C</option>
                                    <option value="1">11,1 C - 6,2 C</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria7" value="7" readonly="readonly">
                                <select class="form-control show-tick" name="kriteria7">
                                    <option>Kedalaman Tanah</option>
                                    <option value="4">
                                        < 20 cm</option>
                                    <option value="3">20 - 50 cm</option>
                                    <option value="2">50 - 75 cm</option>
                                    <option value="1">> 75 cm</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="tambah_lokasi_kriteria" class="btn btn-success">TAMBAH</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end:: modal tambah kriteria lokasi -->

<!-- begin:: footer -->
<?php include_once './atribut/footer.php'; ?>
<!-- end:: footer -->

<!-- begin:: foot -->
<?php include_once './atribut/foot.php'; ?>
<!-- end:: foot -->

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<script>
    $('#table').DataTable();
</script>

<?php
if (isset($_POST['tambah_lokasi_kriteria'])) {

    $nm_lokasi = $_POST['inp_namalokasi'];

    $sql = "SELECT * FROM tb_kriteria_lokasi WHERE id_lokasi = '$nm_lokasi'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {

        echo "<script>
        alert('Ada');
        window.location=(href='lokasi.php')
        </script>";
    } else {

        $array_kriteria = array(
            ['id_kriteria' => $_POST['id_kriteria1'], 'kriteria' => 'Jenis Tanah', 'weight' => $_POST['kriteria1']],
            ['id_kriteria' => $_POST['id_kriteria2'], 'kriteria' => 'Curah Hujan', 'weight' => $_POST['kriteria2']],
            ['id_kriteria' => $_POST['id_kriteria3'], 'kriteria' => 'Drainase', 'weight' => $_POST['kriteria3']],
            ['id_kriteria' => $_POST['id_kriteria4'], 'kriteria' => 'pH', 'weight' => $_POST['kriteria4']],
            ['id_kriteria' => $_POST['id_kriteria5'], 'kriteria' => 'Ketinggian Tempat', 'weight' => $_POST['kriteria5']],
            ['id_kriteria' => $_POST['id_kriteria6'], 'kriteria' => 'Temperatur', 'weight' => $_POST['kriteria6']],
            ['id_kriteria' => $_POST['id_kriteria7'], 'kriteria' => 'Kedalam Tanah', 'weight' => $_POST['kriteria7']]
        );
        $data_kriteria = json_encode($array_kriteria);

        $query  = "INSERT INTO tb_kriteria_lokasi (id_lokasi, kriteria) VALUES ('$nm_lokasi', '$data_kriteria')";
        $result = $connect->query($query);

        if ($result) {
            echo "<script>
            alert('Berhasil')
            window.location=(href='lokasi.php')
            </script>";
        } else {
            echo "<script>
            alert('Gagal')
            window.location=(href='lokasi.php')
            </script>";
        }
    }
} else if (isset($_POST['tambah_lokasi'])) {
    $lokasi    = $_POST['lokasi'];
    $id_lokasi = $_POST['inpidlokasi'];

    $query  = "INSERT INTO tb_lokasi (id_lokasi, nama_lokasi) VALUES ('$id_lokasi','$lokasi')";
    $result = $connect->query($query);

    if ($result) {
        echo "<script>
		window.location=(href='lokasi.php')
		</script>";
    } else {
        echo "<script>
		window.alert('Gagal Menambah Data');
		window.location=(href='lokasi.php')
		</script>";
    }
}
?>