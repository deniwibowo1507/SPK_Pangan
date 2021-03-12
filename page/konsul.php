<!-- begin:: head -->
<?php include_once './atribut/head.php'; ?>
<!-- end:: head -->

<!-- begin:: navbar -->
<?php include_once './atribut/navbar.php'; ?>
<!-- end:: navbar -->

<!-- begin:: header -->
<?php include_once './atribut/header.php'; ?>
<!-- end:: header -->

<!-- begin:: content -->
<section class="page-section" id="about">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <h2 class="mt-0">Silahkan isi form dibawah ini :</h2>
        <form action="konsul_proses.php" method="post">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" name="inpnama" class="form-control" placeholder="Masukkan Nama Anda" required="required" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">No. Hp</label>
            <div class="col-sm-10">
              <input type="text" name="inpnohp" class="form-control" pattern="\d*" maxlength="12" placeholder="Masukkan Nomor Hp Anda" required="required" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
              <textarea name="inpalamat" class="form-control" placeholder="Masukkan Alamat Anda" required="required"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Lokasi</label>
            <div class="col-sm-10">
              <select name="inplokasi" class="custom-select" required="required">
                <option selected>Pilih Lokasi Penanaman</option>
                <?php $tanaman = $connect->query("SELECT * FROM tb_lokasi");
                while ($row = $tanaman->fetch_array(MYSQLI_ASSOC)) { ?>
                  <option value="<?= $row['id_lokasi'] ?>"><?= $row['nama_lokasi']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <input type="submit" name="proses" value="Proses" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- end:: content -->

<!-- begin:: footer -->
<?php include_once './atribut/footer.php'; ?>
<!-- end:: footer -->

<!-- begin:: foot -->
<?php include_once './atribut/foot.php'; ?>
<!-- end:: foot -->