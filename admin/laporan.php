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
                        <h3 class="card-title">Laporan</h3>
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
                        Laporan Riwayat Konsultasi
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No. Hp</th>
                                        <th>Alamat</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Akses</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    $data = $connect->query('SELECT tb_history.*, tb_lokasi.nama_lokasi FROM tb_history INNER JOIN tb_lokasi ON tb_history.lokasi = tb_lokasi.id_lokasi ORDER BY id_history');
                                    while ($row = $data->fetch_array(MYSQLI_ASSOC)) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['no_hp'] ?></td>
                                            <td><?= $row['alamat'] ?></td>
                                            <td><?= $row['nama_lokasi'] ?></td>
                                            <td><?= $row['tgl_akses'] ?></td>
                                            <td>
                                                <a href="laporan_detail.php?id_history=<?= $row['id_history'] ?>" class="btn btn-block btn-primary" target="_blank"><i data-feather="info"></i></a>
                                                <a href="laporan_cetak.php?id_history=<?= $row['id_history'] ?>" class="btn btn-block btn-info" target="_blank"><i data-feather="printer"></i></a>
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

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/vendors.js"></script>

<script type="text/javascript">

</script>