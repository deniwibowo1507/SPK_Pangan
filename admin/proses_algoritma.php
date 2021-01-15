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
                <div class="row">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PROSES ALGORITMA
                            </h2>
                        </div>
                        <div class="body">
                            <form action="hasil_metode.php" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <label>Nama Lokasi</label>
                                        <input type="hidden" name="kriteria" value="<?php echo $id_criteria ?>"
                                            readonly="readonly">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control show-tick" name="nm_lokasi">
                                                    <option>Pilih Lokasi</option>
                                                    <?php
                                                    $sql = "SELECT * FROM tb_lokasi";
                                                    $tanaman = $connect->query($sql);
                                                    while ($row = $tanaman->fetch_array(MYSQLI_ASSOC)) {
                                                    ?>
                                                    <option value="<?php echo $row['id_lokasi'] ?>">
                                                        <?php echo $row['nama_lokasi']; ?></option>
                                                    <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Bulan</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control show-tick" name="id_bulan">
                                                    <option>Pilih Bulan</option>
                                                    <?php
                                                    $sql      = "SELECT * FROM tb_kriteria WHERE id_criteria = '2'";
                                                    $query    = $connect->query($sql);
                                                    $row      = $query->fetch_array(MYSQLI_ASSOC);
                                                    $kriteria = json_decode($row['bulan'], true);
                                                    for ($i = 0; $i < count($kriteria); $i++) { ?>
                                                    <option value="<?= $kriteria[$i]['id_bulan'] ?>">
                                                        <?= $kriteria[$i]['bulan'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="proses" value="Proses" class="btn btn-link btn-primary waves-effect">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-left">
                    <p>2020 &copy; Voler</p>
                </div>
                <div class="float-right">
                    <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a href="http://ahmadsaugi.com">Ahmad Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#editmodal').on('show.bs.modal', function (e) {
            var id_lokasi = $(e.relatedTarget).data('id');

            $.ajax({
                type: 'get',
                url: 'data_lokasi_ubah.php',
                data: 'id_lokasi=' + id_lokasi,
                success: function (data) {
                    $('.hasil-data').html(data);
                }
            });
        });
    });
</script>