<?php
// untuk koneksi
include_once './../database/koneksi.php';
ob_start();
$id_laporan = $_GET['id_laporan'];
$get_data   = "SELECT tb_laporan.*, tb_member.nik, tb_member.nama, tb_member.no_hp, tb_member.alamat, tb_lokasi.nama_lokasi FROM tb_laporan INNER JOIN tb_lokasi ON tb_laporan.id_lokasi = tb_lokasi.id_lokasi INNER JOIN tb_member ON tb_laporan.id_user = tb_member.id_user WHERE id_laporan = '$id_laporan'";
$q_data     = $connect->query($get_data);
$s_data     = $q_data->fetch_array(MYSQLI_ASSOC);

$nik        = $s_data['nik'];
$nama       = $s_data['nama'];
$no_hp      = $s_data['no_hp'];
$alamat     = $s_data['alamat'];
$id_lokasi  = $s_data['id_lokasi'];
$nma_lokasi = $s_data['nama_lokasi'];

$qry4      = $connect->query("SELECT * FROM tb_kriteria_lokasi WHERE id_lokasi = '$id_lokasi'");
$row4      = $qry4->fetch_array(MYSQLI_ASSOC);
$kriteria  = json_decode($row4['kriteria'], true);

$sql   = "SELECT * FROM tb_ranking WHERE id_lokasi = '$id_lokasi'";
$query = $connect->query($sql);
$hasil = $query->fetch_array(MYSQLI_ASSOC);

// untuk criteria
for ($i = 0; $i < count($kriteria); $i++) {
  $criteria[$kriteria[$i]['id_kriteria']] = $kriteria[$i]['weight'];
}

// untuk bobot
for ($j = 0; $j < count($kriteria); $j++) {
  $bobot[$kriteria[$j]['id_kriteria']] = $kriteria[$j]['weight'];
}

$sql1         = "SELECT * FROM tb_kriteria";
$result1      = $connect->query($sql1);
$kriteria     = [];
$namaKriteria = [];

while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {
  $kriteria[$row['id_criteria']] = array($row['criteria'], $row['tipe']);
  $namaKriteria[] = $row['criteria'];
}
$n = count($kriteria);

// untuk alternatif
$sql2       = "SELECT * FROM tb_alternatif";
$result2    = $connect->query($sql2);
$alternatif    = [];
$alternatif = [];

while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
  $alternatif[$row['id_alternative']] = $row['name'];
  // $alternatif[$row['id_alternative']] = array($row['name']);
}

// untuk evaluasi
$sql3    = 'SELECT * FROM tb_evaluasi ORDER BY id_alternative, id_criteria';
$result3 = $connect->query($sql3);
$sample  = [];
$X       = [];
$alternative = '';
$m = 0;

foreach ($result3 as $row) {
  // vikor
  if (!isset($sample[$row['id_alternative']])) {
    $sample[$row['id_alternative']] = array();
  }
  $sample[$row['id_alternative']][$row['id_criteria']] = $row['value'];

  // electre
  if ($row['id_alternative'] != $alternative) {
    $X[$row['id_alternative']] = [];
    $alternative = $row['id_alternative'];
    ++$m;
  }
  $X[$row['id_alternative']][$row['id_criteria']] = $row['value'];
}

function get_Q($S, $R, $v = 0.5)
{
  $S_plus = max($S);
  $S_min  = min($S);
  $R_plus = max($R);
  $R_min  = min($R);
  $Q      = array();
  foreach ($R as $i => $r) {
    $Q[$i] = $v * (($S[$i] - $S_min) / ($S_plus - $S_min)) + (1 - $v) * (($R[$i] - $R_min) / ($R_plus - $R_min));
  }
  return $Q;
}

function get_sQ($Q)
{
  $s_Q = array();
  foreach ($Q as $i => $v)
    $s_Q[] = array($i, $v);
  return $s_Q;
}

// untuk label kriteria
$kriteria_satu = [
  '',
  'Alluvial',
  'Grumusol',
  'Organosol',
  'Latosol',
  'Litosol',
  'Regosol',
];
$kriteria_dua = [
  '',
  'Rendah (0 - 100 mm)',
  'Menengah (100 - 300 mm)',
  'Tinggi (300 - 500 mm)',
];
$kriteria_tiga = [
  '',
  'Tidak Ada',
  'Ada',
];
$kriteria_empat = [
  '',
  'Sangat Asam (< 4)',
  'Asam Sedang (4,0 - 6,9)',
  'Netral (7,0 - 7,5)',
  'Basa Sedang (7,5 - 8,5)',
];
$kriteria_lima = [
  '',
  'Dataran Rendah (0 - 500 mdpl)',
  'Dataran Tinggi (500 - 1500 mdpl)',
];
$kriteria_enam = [
  '',
  '11,1 C - 6,2 C',
  '17,1 C - 11,1 C',
  '22 C - 17,1 C',
  '26,3 C - 22 C',
];
$kriteria_tujuh = [
  '',
  '> 75 cm',
  '50 - 75 cm',
  '20 - 50 cm',
  '< 20 cm',
];
?>

<!-- koding CSS -->
<style media="screen">
  .judul {
    padding: 4mm;
    text-align: center;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    margin: 0;
    padding: 0;
  }

  .admin {
    font-weight: bold;
  }

  .nama {
    text-decoration: underline;
  }
</style>

<div class="judul">
  <h2>Pemerintah Kabupaten Polewali Mandar</h2>
  <h2>Dinas Pertanian dan Pangan</h2>
  <p><em>JL. Muhammad Yamin No. 177, Madatte, Polewali, Kabupaten Polewali Mandar, Sulawesi Barat</em> </p>
  <hr>
</div>

<p align="center">Data User</p>

<table align="center">
  <tr>
    <td width="50">NIK</td>
    <td>:</td>
    <td><?= $nik ?></td>
  </tr>
  <tr>
    <td width="50">Nama</td>
    <td>:</td>
    <td><?= $nama ?></td>
  </tr>
</table>

<p align="center">Data Lokasi</p>

<table align="center">
  <tr>
    <td width="50">Lokasi</td>
    <td>:</td>
    <td><?= $nma_lokasi ?></td>
  </tr>
</table>

<br>

<table border="1" align="center">
  <tr align="center">
    <?php foreach ($namaKriteria as $key => $value) { ?>
      <th><?= $value ?></th>
    <?php } ?>
  </tr>
  <tr>
    <td><?= $kriteria_satu[$criteria[1]] ?></td>
    <td><?= $kriteria_dua[$criteria[2]] ?></td>
    <td><?= $kriteria_tiga[$criteria[3]] ?></td>
    <td><?= $kriteria_empat[$criteria[4]] ?></td>
    <td><?= $kriteria_lima[$criteria[5]] ?></td>
    <td><?= $kriteria_enam[$criteria[6]] ?></td>
    <td><?= $kriteria_tujuh[$criteria[7]] ?></td>
  </tr>
</table>

<p align="center">Ranking Tanaman Hasil Electre</p>

<table border="1" align="center">
  <tr>
    <th>Ranking</th>
    <th>Nama Tanaman</th>
    <th>Poin</th>
  </tr>
  <?php
  $ranking1 = 1;
  $hasil_akhir1 = json_decode($hasil['hasil_electre'], true);
  foreach ($hasil_akhir1 as $key1 => $value1) { ?>
    <tr>
      <td><?= $ranking1++  ?></td>
      <td><?= $alternatif[$key1] ?> </td>
      <td><?= $value1  ?></td>
    </tr>
  <?php } ?>
</table>

<p align="center">Ranking Tanaman Hasil Vikor</p>

<table border="1" align="center">
  <tr>
    <th>Ranking</th>
    <th>Nama Tanaman</th>
    <th>Poin</th>
  </tr>
  <?php
  $ranking2 = 1;
  $hasil_akhir2 = json_decode($hasil['hasil_vikor'], true);
  foreach ($hasil_akhir2 as $key2 => $value2) { ?>
    <tr>
      <td><?= $ranking2++  ?></td>
      <td><?= $alternatif[$key2] ?> </td>
      <td><?= $value2  ?></td>
    </tr>
  <?php } ?>
</table>

<?php
$electre = key($hasil_akhir1);
$topsis = key($hasil_akhir2);
?>

<table align="center">
  <tr>
    <td align="justify" width="600">
      <p>Berdasarkan Hasil analisa diatas, untuk metode Electre, tanaman yang memiliki poin tertinggi adalah <?php echo "<b>{$alternatif[$electre]}</b>" ?>. Sedangkan untuk hasil metode Vikor, yang memiliki nilai tertinggi adalah tanaman <?php echo "<b>{$alternatif[$topsis]}</b>" ?>.</p>
    </td>
  </tr>
</table>

<?php
$content = ob_get_clean();
include_once('./../vendor/html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('L', 'A4', 'en', 'utf-8');
$html2pdf->WriteHTML($content);
$html2pdf->Output('Cetak.pdf');
?>