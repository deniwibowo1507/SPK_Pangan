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
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lokasi</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="card">
          <div class="card-header">
            Daftar Laporan
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  $data = $connect->query("SELECT tb_laporan.*, tb_lokasi.nama_lokasi FROM tb_laporan INNER JOIN tb_lokasi ON tb_laporan.id_lokasi = tb_lokasi.id_lokasi WHERE id_user = '$_SESSION[id_user]'");
                  while ($row = $data->fetch_array(MYSQLI_ASSOC)) { ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row['nama_lokasi'] ?></td>
                      <td>
                        <a href="riwayat_detail.php?id_laporan=<?= $row['id_laporan'] ?>" class="btn btn-primary" target="_blank">Detail</a>
                        <a href="riwayat_cetak.php?id_laporan=<?= $row['id_laporan'] ?>" class="btn btn-info" target="_blank">Cetak</a>
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

<script>
  $('#table').DataTable();
</script>