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
                            <i data-feather="plus" width="20"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>
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
                                        <th>Aksi</th>
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
                                                        echo 'Podzolik';
                                                        break;
                                                    case 1:
                                                        echo 'Litosol';
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
                                            <td>
                                                <a href="#editmodal" class="btn btn-modifikasi btn-primary" data-toggle='modal' data-id="<?= $row['id_lokasi'] ?>"><i data-feather="edit"></i></a>
                                                <a href="data_kriteria_lokasi_hapus.php?id_lokasi=<?= $row['id_lokasi'] ?>" class="btn btn-modifikasi btn-danger waves-effect"><i data-feather="delete"></i></a>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Input Data Kriteria Lokasi</h4>
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
                                    <option value="2">Podzolik</option>
                                    <option value="1">Litosol</option>
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
                                <select name="kriteria3" class="form-control show-tick">
                                    <option>Drainase</option>
                                    <option value="2">Ada</option>
                                    <option value="1">Tidak Ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria4" value="4" readonly="readonly">
                                <select name="kriteria4" class="form-control show-tick">
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
                                <select name="kriteria5" class="form-control show-tick">
                                    <option>Ketinggian Tempat</option>
                                    <option value="2">Dataran Tinggi (500 - 1500 mdpl)</option>
                                    <option value="1">Dataran Rendah (0 - 500 mdpl)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_kriteria6" value="6" readonly="readonly">
                                <select name="kriteria6" class="form-control show-tick">
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
                                <select name="kriteria7" class="form-control show-tick">
                                    <option>Kedalaman Tanah</option>
                                    <option value="4">
                                        < 20 cm</option>
                                    <option value="3">20 - 50 cm</option>
                                    <option value="2">50 - 75 cm</option>
                                    <option value="1">> 75 cm</option>
                                </select>
                            </div>
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

<!-- begin:: modal edit -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Ubah Data Lokasi</h4>
            </div>
            <div class="modal-body">
                <div class="hasil-data"></div>
            </div>
        </div>
    </div>
</div>
<!-- end:: modal edit -->

<!-- begin:: tombol aktif -->
<a href="link" id="tombol-modal" data-toggle="modal"></a>
<!-- end:: tombol aktif -->

<!-- <div class="modal fade" id="modal4" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Latosol</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: justify;">Tanah latosol atau tanah inceptisol merupakan tanah yang mempunyai
                    beberapa ciri atau karakteristik tertentu, yakni :</p>
                <p style="text-align: justify;">a. Memiliki solum tanah yang agak tebal hingga tebal, yakni mulai
                    sekitar 130 cm hingga lebih dari 5 meter.</p>
                <p style="text-align: justify;">b. Tanahnya berwarna merah, coklat, hingga kekuning- kuningan.</p>
                <p style="text-align: justify;">c. Tekstur tanah pada umumnya adalah liat.</p>
                <p style="text-align: justify;">d. Struktur tanah pada umumnya adalah remah dengan konsistensi gembur.
                </p>
                <p style="text-align: justify;">e. Memiliki pH 4,5 hingga 6,5, yakni dari asam hingga agak asam.</p>
                <p style="text-align: justify;">f. Mengandung unsur hara yang sedang hingga tinggi. Unsur hara yang
                    terkandung di dalam tanah bisa dilihat dari warnanya. Semakin merah warna tanah maka unsur hara yang
                    terkandung adalah semakin sedikit.</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-danger waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal3" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Organosol</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: justify;">Jenis tanah Organosol memiliki ciri sebagai berikut :</p>
                <p style="text-align: justify;">a. Berwarna kehitaman.</p>
                <p style="text-align: justify;">b. Mudah basah.</p>
                <p style="text-align: justify;">c. Sangat subur.</p>
                <p style="text-align: justify;">d. Mengandung sangat banyak bahan organik.</p>
                <p style="text-align: justify;">e. Memiliki unsur hara yang rendah.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-danger waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Podzolik</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: justify;">Jenis tanah Podzolik memiliki karakteristik sebagai berikut :</p>
                <p style="text-align: justify;">a. Biasanya dimanfaatkan untuk persawahan dan perkebunan.</p>
                <p style="text-align: justify;">b. Tekstur tanahnya berlempung dan berpasir.</p>
                <p style="text-align: justify;">c. Memiliki unsur aluminum dan besi yang tinggi.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-danger waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Litosol</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: justify;">Jenis Tanah Litosol memiliki karakteristik sebagai berikut :</p>
                <p style="text-align: justify;">a. Mempunyai penampang yang besar, berbentuk kerikil, pasir, dan
                    bebatuan kecil.</p>
                <p style="text-align: justify;">b. Terbentuk dari proses meletusnya gunung berapi.</p>
                <p style="text-align: justify;">c. Mempunyai kandungan unsur hara yang sedikit sekali.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-danger waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div> -->

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/vendors.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#editmodal').on('show.bs.modal', function(e) {
            var id_lokasi = $(e.relatedTarget).data('id');

            $.ajax({
                type: 'get',
                url: 'data_kriteria_lokasi_ubah.php',
                data: 'id_lokasi=' + id_lokasi,
                success: function(data) {
                    $('.hasil-data').html(data);
                }
            });
        });

        $('#kriteria1').change(function() {
            var val = $(this).val();

            if (val == 4) {
                $('#tombol-modal').attr('href', '#modal4').trigger("click");
            } else if (val == 3) {
                $('#tombol-modal').attr('href', '#modal3').trigger("click");
            } else if (val == 2) {
                $('#tombol-modal').attr('href', '#modal2').trigger("click");
            } else if (val == 1) {
                $('#tombol-modal').attr('href', '#modal1').trigger("click");
            }

        });
    });
</script>

<?php
if (isset($_POST['tambah'])) {

    $nm_lokasi = $_POST['inp_namalokasi'];

    $sql = "SELECT * FROM tb_kriteria_lokasi WHERE id_lokasi = '$nm_lokasi'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {

        echo "<script>
        alert('Ada')
        window.location=(href='data_kriteria_lokasi.php')
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
            window.location=(href='data_kriteria_lokasi.php')
            </script>";
        } else {
            echo "<script>
            alert('Gagal')
            window.location=(href='data_kriteria_lokasi.php')
            </script>";
        }
    }
} else if (isset($_POST['ubah'])) {

    $id_lokasi = $_POST['id_lokasi'];
    $nm_lokasi = $_POST['inp_namalokasi'];

    $array_kriteria = array(
        ['id_kriteria' => $_POST['id_kriteria1'], 'kriteria' => 'Jenis Tanah', 'weight' => $_POST['kriteria1']],
        ['id_kriteria' => $_POST['id_kriteria2'], 'kriteria' => 'Curah Hujan', 'weight' => ''],
        ['id_kriteria' => $_POST['id_kriteria3'], 'kriteria' => 'Drainase', 'weight' => $_POST['kriteria3']],
        ['id_kriteria' => $_POST['id_kriteria4'], 'kriteria' => 'pH', 'weight' => $_POST['kriteria4']],
        ['id_kriteria' => $_POST['id_kriteria5'], 'kriteria' => 'Ketinggian Tempat', 'weight' => $_POST['kriteria5']],
        ['id_kriteria' => $_POST['id_kriteria6'], 'kriteria' => 'Temperatur', 'weight' => $_POST['kriteria6']],
        ['id_kriteria' => $_POST['id_kriteria7'], 'kriteria' => 'Kedalam Tanah', 'weight' => $_POST['kriteria7']]
    );
    $data_kriteria = json_encode($array_kriteria);

    $query  = "UPDATE tb_kriteria_lokasi SET kriteria = '$data_kriteria' WHERE id_lokasi = '$id_lokasi' ";
    $result = $connect->query($query);

    if ($result) {
        echo "<script>
        alert('Berhasil')
        window.location=(href='data_kriteria_lokasi.php')
        </script>";
    } else {
        echo "<script>
        alert('Gagal')
        window.location=(href='data_kriteria_lokasi.php')
        </script>";
    }
}
?>