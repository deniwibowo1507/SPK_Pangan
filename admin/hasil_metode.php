<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<?php
error_reporting(0);

$sql1         = 'SELECT * FROM tb_kriteria';
$result1      = $connect->query($sql1);
$kriteria     = array();
$bobot        = array();
$namaKriteria = [];
foreach ($result1 as $row) {
  $kriteria[$row['id_criteria']] = array($row['criteria'], $row['tipe']);
  $bobot[$row['id_criteria']] = $row['bobot'] / 100;
  $namaKriteria[] = $row['criteria'];
}

$sql2       = 'SELECT * FROM tb_alternatif';
$result2    = $connect->query($sql2);
$alternatif = array();
foreach ($result2 as $row) {
  $alternatif[$row['id_alternative']] = $row['name'];
}

$sql3    = 'SELECT * FROM tb_evaluasi ORDER BY id_alternative, id_criteria';
$result3 = $connect->query($sql3);
$sample  = array();
foreach ($result3 as $row) {
  if (!isset($sample[$row['id_alternative']])) {
    $sample[$row['id_alternative']] = array();
  }
  $sample[$row['id_alternative']][$row['id_criteria']] = $row['value'];
}

function get_Q($S, $R, $v = 0.5)
{
  $S_plus = max($S);
  $S_min  = min($S);
  $R_plus = max($R);
  $R_min  = min($R);
  $Q      = array();
  foreach ($R as $i => $r) {
    $Q[$i] = $v * (($S[$i] - $S_min[$i]) / ($S_plus[$i] - $S_min[$i])) + (1 - $v) * (($R[$i] - $R_min[$i]) / ($R_plus[$i] - $R_min[$i]));
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
        <div class="card">
          <div class="card-header">
            <h2>Matrik Keputusan</h2>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>Alternatif</th>
                  <?php
                  foreach ($namaKriteria as $key => $value) { ?>
                    <th><?= $value ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($sample as $id_altenatif => $kriteria) { ?>
                  <tr>
                    <td><?= $alternatif[$id_altenatif] ?></td>
                    <?php foreach ($kriteria as $id_kriteria => $nilai) { ?>
                      <td><?= $nilai ?></td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <?php
        $f_plus = $f_min = array();
        foreach ($sample as $id_altenatif => $kriteria) {
          foreach ($kriteria as $j => $nilai) {
            if (!isset($f_plus[$j])) {
              $f_plus[$j] = 0;
              $f_min[$j] = 9999999;
            }
            $f_plus[$j] = ($f_plus[$j] < $nilai ? $nilai : $f_plus[$j]);
            $f_min[$j] = ($f_min[$j] > $nilai ? $nilai : $f_min[$j]);
          }
        }
        ?>

        <div class="card">
          <div class="card-header">
            <h2>Matrik Normalisasi</h2>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>Alternatif</th>
                  <?php foreach ($namaKriteria as $key => $value) { ?>
                    <th><?= $value ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $N = array();
                foreach ($sample as $i => $kriteria) {
                  $N[$i] = array();
                  foreach ($kriteria as $j => $nilai) {
                    $N[$i][$j] = ($f_plus[$j] - $nilai) / ($f_plus[$j] - $f_min[$j]);
                  }
                }
                ?>

                <?php foreach ($alternatif as $key => $value) { ?>
                  <tr>
                    <td><?= $alternatif[$key] ?></td>
                    <?php for ($i = 1; $i <= count($N[$key]); $i++) { ?>
                      <td><?= $N[$key][$i] ?></td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h2>Matrik Normalisasi Terbobot</h2>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>Alternatif</th>
                  <?php foreach ($namaKriteria as $key => $value) { ?>
                    <th><?= $value ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $F_star = array();
                foreach ($N as $i => $kriteria) {
                  $F_star[$i] = array();
                  foreach ($kriteria as $j => $nilai) {
                    $F_star[$i][$j] = $nilai * $bobot[$j];
                  }
                }
                ?>

                <?php foreach ($alternatif as $key => $value) { ?>
                  <tr>
                    <td><?= $alternatif[$key] ?></td>
                    <?php for ($i = 1; $i <= count($F_star[$key]); $i++) { ?>
                      <td><?= $F_star[$key][$i] ?></td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h2>Utility Measure (S dan R)</h2>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>Alternatif</th>
                  <th>S</th>
                  <th>R</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $S = $R = array();
                foreach ($F_star as $i => $kriteria) {
                  $S[$i] = $R[$i] = 0;
                  foreach ($kriteria as $j => $nilai) {
                    $S[$i] += $nilai;
                    $R[$i] = ($R[$i] < $nilai ? $nilai : $R[$i]);
                  }
                }
                ?>

                <?php foreach ($alternatif as $key => $value) { ?>
                  <tr>
                    <td><?= $alternatif[$key] ?></td>
                    <td><?= $S[$key] ?></td>
                    <td><?= $R[$key] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h2>Menghitung Nilai Indeks VIKOR (Q)</h2>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>Alternatif</th>
                  <th>S</th>
                  <th>R</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $Q = array();
                $v = array(0.4, 0.5, 0.6);
                $Q[$v[1]] = get_Q($S, $R);
                asort($Q[$v[1]]);
                $sQ = array();
                $sQ[$v[1]] = get_sQ($Q[$v[1]]);

                echo '<pre>';
                print_r($Q);
                ?>


              </tbody>
            </table>



            <?php
            $kondisi_1 = 0;
            $m = count($sample);
            $DQ = 1 / ($m - 1);
            if (($sQ[$v[1]][1][1] - $sQ[$v[1]][0][1]) >= $DQ) {
              $kondisi_1 = 1;
              echo 'kondisi 1 terpenuhi<br>';
            } else {
              echo 'kondisi 1 tidak terpenuhi<br>';
            }

            $kondisi_2 = 0;
            $Q[$v[0]] = get_Q($S, $R, $v[0]);
            asort($Q[$v[0]]);
            $sQ[$v[0]] = get_sQ($Q[$v[0]]);
            $Q[$v[2]] = get_Q($S, $R, $v[2]);
            asort($Q[$v[2]]);
            $sQ[$v[2]] = get_sQ($Q[$v[2]]);
            if (($sQ[$v[1]][0][1] == $sQ[$v[0]][0][1]) && ($sQ[$v[1]][0][1] == $sQ[$v[2]][0][1])) {
              $kondisi_2 = 1;
              echo 'kondisi 2 terpenuhi<br>';
            } else {
              echo 'kondisi 2 tidak terpenuhi<br>';
            }



            echo "Berdasarkan hasil pembuktian kedua kondisi dapat diketahui bahwa "
              . ($kondisi_1 == 1 ? ($kondisi_2 == 1 ? "kedua kondisi tersebut" : "kondisi dua tidak") : "kondisi satu tidak")
              . " terpenuhi.";
            if ($kondisi_1 == 1) {
              if ($kondisi_2 == 1) {
                echo "<b>{$alternatif[$sQ[$v[1]][0][0]]}</b> dapat diusulkan menjadi solusi kompromi "
                  . "dan merupakan peringkat terbaik dari perankingan penerima beasiswa dengan metode VIKOR.";
              } else {
                echo "Sehingga <b>{$alternatif[$sQ[$v[1]][0][0]]}</b> dan <b>{$alternatif[$Q[$v[1]][1][0]]}</b> "
                  . "dapat diusulkan menjadi solusi kompromi penerima beasiswa dengan metode VIKOR.";
              }
            } else {
              echo "Berdasarkan persamaan [<a href='#vik12'>VIK-12</a>] diperoleh nilai m={$m}, sehingga alternatif ";
              if ($m > 1) {
                echo "A<sub>1</sub>, ..., A<sub>{$m}; yaitu ";
                $nm = array();
                for ($i = 0; $i < $m; $i++) $nm[] = $alternatif[$sQ[$v[1]][$i][0]];
                $nm_a = array_pop($nm);
                echo "<b>" . implode(', ', $nm) . "</b> dan <b>{$nm_a}</b> ";
              } else {
                echo "A<sub>1</sub>; yaitu <b>{$alternatif[$sQ[$v[1]][0][0]]}</b> ";
              }
              echo "dapat diusulkan menjadi solusi kompromi penerima beasiswa dengan metode VIKOR.";
            }

            print_r($sQ);
            ?>
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