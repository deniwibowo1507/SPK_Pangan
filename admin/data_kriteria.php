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
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kriteria</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                                $no = 1;
                                                $sql = "SELECT * FROM tb_kriteria";
                                                $query = $connect->query($sql);

                                                while ($row = $query->fetch_array()) {
                                                    echo "<tr>";
                                                    echo "<td>".$no++."</td>";
                                                    echo "<td>".$row['criteria']."</td>";
                                                    echo "<td><a href='data_kriteria_ubah.php?id_kriteria=".$row['id_criteria']."' class='btn btn-danger'>Ubah</a></td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                </tbody>
                            </table>
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
                    <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a
                            href="http://ahmadsaugi.com">Ahmad Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- begin:: modal tambah -->
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
<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#editmodal').on('show.bs.modal', function (e){
            var id_lokasi = $(e.relatedTarget).data('id');

            $.ajax ({
                type : 'get',
                url : 'data_lokasi_ubah.php',
                data : 'id_lokasi='+ id_lokasi,
                success : function(data){
                    $('.hasil-data').html(data);
                }
            });
        });
    });
</script>
