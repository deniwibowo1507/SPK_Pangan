<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<?php
$sql    = "SELECT * FROM tb_lokasi";
$lokasi = $connect->query($sql);
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
                        <h3 class="card-title">Konsultasi</h3>
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
                        <h4 class="card-title">Konsultasi</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="hasil_metode.php" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <select class="form-control show-tick" name="nm_lokasi">
                                            <option value="">Pilih Lokasi</option>
                                            <?php while ($row = $lokasi->fetch_array(MYSQLI_ASSOC)) { ?>
                                                <option value="<?php echo $row['id_lokasi'] ?>"><?php echo $row['nama_lokasi']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 d-flex">
                                        <button type="submit" name="proses" class="btn btn-primary mr-1 mb-1">Proses</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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