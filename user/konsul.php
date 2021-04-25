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
            <h3 class="card-title">Kriteria Lokasi</h3>
          </div>
          <div class="col-12 col-md-6">
            <nav aria-label="breadcrumb" class='breadcrumb-header text-right'>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kriteria Lokasi</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h2 class="mt-0">Silahkan pilih lokasi :</h2>
          </div>
          <div class="card-body">
            <form action="konsul_proses.php" method="post">
              <div class="col-sm-12">
                <div class="form-group form-float">
                  <div class="form-line">
                    <select name="inplokasi" class="form-control show-tick" required="required">
                      <option selected>Pilih Lokasi Penanaman</option>
                      <?php $tanaman = $connect->query("SELECT * FROM tb_lokasi");
                      while ($row = $tanaman->fetch_array(MYSQLI_ASSOC)) { ?>
                        <option value="<?= $row['id_lokasi'] ?>"><?= $row['nama_lokasi']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <input type="submit" name="proses" value="Proses" class="btn btn-success">
            </form>
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