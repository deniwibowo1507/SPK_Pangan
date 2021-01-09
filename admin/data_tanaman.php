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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#smallModal">
                                            <i class="material-icons">add</i>
                                            <span>Tambah Tanaman</span>
                                        </button>
                        </div>
                        <div class="card-body">
                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Tanaman</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $no = 1;
                                                $sql = "SELECT * FROM tb_alternatif";
                                                $query = $connect->query($sql);

                                                while ($row = $query->fetch_array()) {
                                                    echo "<tr>";
                                                    echo "<td>".$no++."</td>";
                                                    echo "<td>".$row['name']."</td>";
                                                    echo "<td>
                                                    <div class='btn-group btn-group-sm' role='group' aria-label='Small button group'>
                                                    <a href='#editmodal' class='btn btn-primary waves-effect' data-toggle='modal' data-id=".$row['id_alternative']."><i class='material-icons'>edit</i>Ubah</a>
                                                    <a href='data_tanaman_hapus.php?id_tanaman=".$row['id_alternative']."' class='btn btn-danger waves-effect'><i class='material-icons'>delete</i>Hapus</a>
                                                    </div>

                                                    </td>";
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
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="smallModalLabel">Input Nama Tanaman</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php 
                                                        $query = "SELECT max(id_alternative) as maxKode FROM tb_alternatif";
                                                        $hasil = mysqli_query($connect,$query);
                                                        $data = mysqli_fetch_array($hasil);
                                                        $kodeOtomatis = $data['maxKode'];
                                                        $noUrut = (int) substr($kodeOtomatis, 0, 3);
                                                        $noUrut++;
                                                        $kodeOtomatis = $noUrut;
                                                        ?>

                                                        <form method="POST">
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="hidden" name="inp_idalternative" value="<?php echo $kodeOtomatis; ?>" />
                                                                        <input type="text" class="form-control" name="inp_tan" required="required">
                                                                        <label class="form-label">Nama Tanaman</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <input type="submit" name="tambah" value="TAMBAH" class="btn btn-link waves-effect">
                                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="body table-responsive">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
            var id_tanaman = $(e.relatedTarget).data('id');

            $.ajax ({
                type : 'get',
                url : 'data_tanaman_ubah.php',
                data : 'id_tanaman='+ id_tanaman,
                success : function(data){
                    $('.hasil-data').html(data);
                }
            });
        });
    });
</script>

<?php 

if (isset($_POST['tambah'])) {
    $id_alternative = $_POST['inp_idalternative'];
    $nama_tanaman = $_POST['inp_tan'];

    $query  = "INSERT INTO tb_alternatif (id_alternative, name) VALUES ('$id_alternative', '$nama_tanaman')";
    $result = $connect->query($query);

    if ($result) {
        echo "<script>
        alert('Berhasil')
        window.location=(href='data_tanaman.php')
        </script>";
    }

    else {
        echo "<script>
        alert('Gagal')
        window.location=(href='data_tanaman.php')
        </script>";
    }
} else if (isset($_POST['ubah'])) {
    $id = $_POST['id'];
    $nama_tanaman = $_POST['nm_tanaman'];

    $query  = "UPDATE tb_alternatif SET name = '$nama_tanaman' WHERE id_alternative = '$id' ";
    $result = $connect->query($query);

    if ($result) {
        echo "<script>
        alert('Berhasil')
        window.location=(href='data_tanaman.php')
        </script>";
    }

    else {
        echo "<script>
        alert('Gagal')
        window.location=(href='data_tanaman.php')
        </script>";
    }
}

?>
