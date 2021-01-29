<!-- begin:: head -->
<?php include_once './atribut/head.php'; ?>
<!-- end:: head -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

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
        <h2 class="mt-0">Riwayat Pengunjung</h2>
        <div class="table-responsive">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pengunjung</th>
                <th>Tanggal Akses</th>
                <th>Lokasi</th>
                <th>Bulan Penanaman</th>
                <th>Alamat</th>
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
                  <td><?= $row['tgl_akses'] ?></td>
                  <td><?= $row['nama_lokasi'] ?></td>
                  <td><?= bulan($row['bulan']) . ", " . bulan(date($row['bulan']) + 1) . ", " . bulan(date($row['bulan']) + 2) ?></td>
                  <td><?= $row['alamat'] ?></td>
                  <td>
                    <a href="history_detail.php?id_history=<?= $row['id_history'] ?>" target="">Detail</a>
                    <a href="history_cetak.php?id_history=<?= $row['id_history'] ?>" target="_blank">Cetak</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
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

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<script>
  $('#table').DataTable();
</script>