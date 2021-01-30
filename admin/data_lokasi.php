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
                        <h3 class="card-title">Lokasi</h3>
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
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no    = 1;
                                    $sql   = "SELECT * FROM tb_lokasi";
                                    $query = $connect->query($sql);
                                    while ($row = $query->fetch_array()) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_lokasi'] ?></td>
                                            <td>
                                                <a href="#editmodal" class="btn btn-modifikasi btn-primary" data-toggle="modal" data-id="<?= $row['id_lokasi'] ?>">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                <a href="data_lokasi_hapus.php?id_lokasi=<?= $row['id_lokasi'] ?>" class="btn btn-modifikasi btn-danger">
                                                    <i data-feather="delete"></i>
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
                <h4 class="modal-title" id="smallModalLabel">Input Lokasi Penanaman</h4>
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

                <form action="data_lokasi_tambah.php" method="POST">
                    <input type="hidden" name="inpidlokasi" value="<?= $kodeOtomatis ?>">

                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">Nama Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" required="required">
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

<!-- begin:: modal ubah -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Ubah Lokasi Penanaman</h4>
            </div>
            <div class="modal-body">
                <div class="hasil-data"></div>
            </div>
        </div>
    </div>
</div>
<!-- end:: modal ubah -->

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
                url: 'data_lokasi_ubah.php',
                data: 'id_lokasi=' + id_lokasi,
                success: function(data) {
                    $('.hasil-data').html(data);
                }
            });
        });
    });
</script>