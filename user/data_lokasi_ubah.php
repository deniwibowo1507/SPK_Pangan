<?php
include_once '../database/koneksi.php';
$id_lokasi = $_GET['id_lokasi'];
$sql       = "SELECT * FROM tb_lokasi WHERE id_lokasi = '$id_lokasi'";
$query     = $connect->query($sql);
$row       = $query->fetch_array(MYSQLI_ASSOC);
?>

<form action="data_lokasi_proses_ubah.php" method="POST">
    <div class="col-sm-12">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="id" value="<?php echo $row['id_lokasi'] ?>" readonly="readonly" />
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="lokasi" value="<?php echo $row['nama_lokasi'] ?>" />
            </div>
        </div>
    </div>
    <button type="submit" name="ubah" class="btn btn-success">UBAH</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
</form>