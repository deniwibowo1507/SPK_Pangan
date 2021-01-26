<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<?php
error_reporting(0);

// untuk kriteria
$bobot = [];

if (isset($_POST['proses'])) {
  $id_lokasi = $_POST['nm_lokasi'];
  $qry4      = $connect->query("SELECT * FROM tb_kriteria_lokasi WHERE id_lokasi = '$id_lokasi'");
  $row4      = $qry4->fetch_array(MYSQLI_ASSOC);
  $kriteria  = json_decode($row4['kriteria'], true);

  $bobot = [
    $kriteria[0]['id_kriteria'] => $kriteria[0]['weight'],
    $kriteria[1]['id_kriteria'] => $kriteria[1]['weight'],
    $kriteria[2]['id_kriteria'] => $kriteria[2]['weight'],
    $kriteria[3]['id_kriteria'] => $kriteria[3]['weight'],
    $kriteria[4]['id_kriteria'] => $kriteria[4]['weight'],
  ];
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

        <div class="card collapse-icon accordion-icon-rotate">
          <div class="card-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="electre-tab" data-toggle="tab" href="#electre" role="tab" aria-controls="electre" aria-selected="true">Electre</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="vikor-tab" data-toggle="tab" href="#vikor" role="tab" aria-controls="vikor" aria-selected="false">Vikor</a>
              </li>
            </ul>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="tab-content" id="myTabContent">
                <!-- begin:: metode electre -->
                <div class="tab-pane fade show active" id="electre" role="tabpanel" aria-labelledby="electre-tab">
                  <div class="accordion" id="cardAccordion">
                    <div class="card">
                      <div class="card-header" id="headingSatu" data-toggle="collapse" data-target="#collapseSatu" aria-expanded="false" aria-controls="collapseSatu" role="button">
                        <span class="collapsed collapse-title">Membentuk Perbandingan Berpasangan (X)</span>
                      </div>
                      <div id="collapseSatu" class="collapse pt-1" aria-labelledby="headingSatu" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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
                                <?php foreach ($X as $key => $value) { ?>
                                  <tr>
                                    <td><?= $alternatif[$key] ?></td>
                                    <?php for ($i = 1; $i <= count($value); $i++) { ?>
                                      <td><?= $value[$i] ?></td>
                                    <?php } ?>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingDua" data-toggle="collapse" data-target="#collapseDua" aria-expanded="false" aria-controls="collapseDua" role="button">
                        <span class="collapsed collapse-title">Perbandingan Berpasangan Ternormalisasi (R)</span>
                      </div>
                      <div id="collapseDua" class="collapse pt-1" aria-labelledby="headingDua" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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

                                $x_rata = array();
                                foreach ($X as $i => $x) {
                                  foreach ($x as $j => $value) {
                                    $x_rata[$j] = (isset($x_rata[$j]) ? $x_rata[$j] : 0) + pow($value, 2);
                                  }
                                }
                                for ($j = 1; $j <= $n; $j++) {
                                  $x_rata[$j] = sqrt($x_rata[$j]);
                                }
                                $R = array();
                                $alternative = '';
                                foreach ($X as $i => $x) {
                                  if ($alternative != $i) {
                                    $alternative = $i;
                                    $R[$i] = array();
                                  }
                                  foreach ($x as $j => $value) {
                                    $R[$i][$j] = $value / $x_rata[$j];
                                  }
                                }

                                foreach ($R as $key => $value) { ?>
                                  <tr>
                                    <td><?= $alternatif[$key] ?></td>
                                    <?php for ($i = 1; $i <= count($value); $i++) { ?>
                                      <td><?= $value[$i] ?></td>
                                    <?php } ?>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingTiga" data-toggle="collapse" data-target="#collapseTiga" aria-expanded="false" aria-controls="collapseTiga" role="button">
                        <span class="collapsed collapse-title">Menentukan Bobot tiap-tiap Kriteria (W)</span>
                      </div>
                      <div id="collapseTiga" class="collapse pt-1" aria-labelledby="headingTiga" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <?php foreach ($namaKriteria as $key => $value) { ?>
                                    <th><?= $value ?></th>
                                  <?php } ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                // query untuk mengambil data nilai bobot criteria
                                $sql = "SELECT kriteria FROM tb_kriteria_lokasi WHERE id_lokasi = '$id_lokasi'";
                                $result = $connect->query($sql);

                                $criteria = array();
                                while ($row = $result->fetch_array()) {

                                  $kriteria = json_decode($row['kriteria'], true);
                                  for ($i = 0; $i < count($kriteria); $i++) {
                                    $criteria[$kriteria[$i]['id_kriteria']] = $kriteria[$i]['weight'];
                                  }
                                }

                                echo "<tr>";
                                for ($i = 1; $i <= count($criteria); $i++) {
                                  echo "<td>" . $criteria[$i] . "</td>";
                                }
                                echo "</tr>";
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingEmpat" data-toggle="collapse" data-target="#collapseEmpat" aria-expanded="false" aria-controls="collapseEmpat" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Preferensi (V)</span>
                      </div>
                      <div id="collapseEmpat" class="collapse pt-1" aria-labelledby="headingEmpat" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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

                                $V = $w = array();
                                foreach ($criteria as $j => $weight)
                                  $w[$j] = $weight;
                                $alternative = '';
                                foreach ($R as $i => $r) {
                                  if ($alternative != $i) {
                                    $alternative = $i;
                                    $V[$i] = array();
                                  }
                                  foreach ($r as $j => $value) {
                                    $V[$i][$j] = $w[$j] * $value;
                                  }
                                }

                                foreach ($V as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($value); $i++) {
                                    echo "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingLima" data-toggle="collapse" data-target="#collapseLima" aria-expanded="false" aria-controls="collapseLima" role="button">
                        <span class="collapsed collapse-title">Menentukan Concordance Index (Ckl)</span>
                      </div>
                      <div id="collapseLima" class="collapse pt-1" aria-labelledby="headingLima" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $c = array();
                                $c_index = '';
                                for ($k = 1; $k <= $m; $k++) {
                                  if ($c_index != $k) {
                                    $c_index = $k;
                                    $c[$k] = array();
                                  }
                                  for ($l = 1; $l <= $m; $l++) {
                                    if ($k != $l) {
                                      for ($j = 1; $j <= $n; $j++) {
                                        if (!isset($c[$k][$l])) $c[$k][$l] = array();
                                        if ($V[$k][$j] >= $V[$l][$j]) {
                                          array_push($c[$k][$l], $j);
                                        }
                                      }
                                    } else if (isset($c[$k][$l]) == NULL) {
                                      $c[$k][$l] = $c[$k][$l] = "-";
                                    }
                                  }
                                }

                                foreach ($c as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingEnam" data-toggle="collapse" data-target="#collapseEnam" aria-expanded="false" aria-controls="collapseEnam" role="button">
                        <span class="collapsed collapse-title">Menentukan Discordance Index (Dkl)</span>
                      </div>
                      <div id="collapseEnam" class="collapse pt-1" aria-labelledby="headingEnam" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $d = array();
                                $d_index = '';
                                for ($k = 1; $k <= $m; $k++) {
                                  if ($d_index != $k) {
                                    $d_index = $k;
                                    $d[$k] = array();
                                  }
                                  for ($l = 1; $l <= $m; $l++) {
                                    if ($k != $l) {
                                      for ($j = 1; $j <= $n; $j++) {
                                        if (!isset($d[$k][$l])) $d[$k][$l] = array();
                                        if ($V[$k][$j] < $V[$l][$j]) {
                                          array_push($d[$k][$l], $j);
                                        }
                                      }
                                    } else if (isset($d[$k][$l]) == NULL) {
                                      $d[$k][$l] = $d[$k][$l] = "-";
                                    }
                                  }
                                }

                                foreach ($d as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingTujuh" data-toggle="collapse" data-target="#collapseTujuh" aria-expanded="false" aria-controls="collapseTujuh" role="button">
                        <span class="collapsed collapse-title">Membentuk Matriks Concordance (C)</span>
                      </div>
                      <div id="collapseTujuh" class="collapse pt-1" aria-labelledby="headingTujuh" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $C = array();
                                $c_index = '';
                                for ($k = 1; $k <= $m; $k++) {
                                  if ($c_index != $k) {
                                    $c_index = $k;
                                    $C[$k] = array();
                                  }
                                  for ($l = 1; $l <= $m; $l++) {
                                    if ($k != $l && count($c[$k][$l])) {
                                      $f = 0;
                                      foreach ($c[$k][$l] as $j) {
                                        $C[$k][$l] = (isset($C[$k][$l]) ? $C[$k][$l] : 0) + $w[$j];
                                      }
                                    } else if (isset($C[$k][$l]) == NULL) {
                                      $C[$k][$l] = $C[$k][$l] = "-";
                                    }
                                  }
                                }

                                foreach ($C as $key => $value) {
                                  echo "<tr>";
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingDelapan" data-toggle="collapse" data-target="#collapseDelapan" aria-expanded="false" aria-controls="collapseDelapan" role="button">
                        <span class="collapsed collapse-title">Threshold c</span>
                      </div>
                      <div id="collapseDelapan" class="collapse pt-1" aria-labelledby="headingDelapan" data-parent="#cardAccordion">
                        <div class="card-body">
                          <?php
                          $sigma_c = 0;
                          foreach ($C as $k => $cl) {
                            foreach ($cl as $l => $value) {
                              $sigma_c += $value;
                            }
                          }
                          $threshold_c = $sigma_c / ($m * ($m - 1));
                          echo $threshold_c;
                          ?>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingSembilan" data-toggle="collapse" data-target="#collapseSembilan" aria-expanded="false" aria-controls="collapseSembilan" role="button">
                        <span class="collapsed collapse-title">Membentuk Matriks Discordance (D)</span>
                      </div>
                      <div id="collapseSembilan" class="collapse pt-1" aria-labelledby="headingSembilan" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $D = array();
                                $d_index = '';
                                for ($k = 1; $k <= $m; $k++) {
                                  if ($d_index != $k) {
                                    $d_index = $k;
                                    $D[$k] = array();
                                  }
                                  for ($l = 1; $l <= $m; $l++) {
                                    if ($k != $l) {
                                      $max_d = 0;
                                      $max_j = 0;
                                      if (count($d[$k][$l])) {
                                        $mx = array();
                                        foreach ($d[$k][$l] as $j) {
                                          if ($max_d < abs($V[$k][$j] - $V[$l][$j]))
                                            $max_d = abs($V[$k][$j] - $V[$l][$j]);
                                        }
                                      }
                                      $mx = array();
                                      for ($j = 1; $j <= $n; $j++) {
                                        if ($max_j < abs($V[$k][$j] - $V[$l][$j]))
                                          $max_j = abs($V[$k][$j] - $V[$l][$j]);
                                      }
                                      $D[$k][$l] = $max_d == 0 ? 0 : $max_d / $max_j;
                                    } else if (isset($D[$k][$l]) == NULL) {
                                      $D[$k][$l] = $D[$k][$l] = "-";
                                    }
                                  }
                                }

                                foreach ($D as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingSepuluh" data-toggle="collapse" data-target="#collapseSepuluh" aria-expanded="false" aria-controls="collapseSepuluh" role="button">
                        <span class="collapsed collapse-title">Threshold d</span>
                      </div>
                      <div id="collapseSepuluh" class="collapse pt-1" aria-labelledby="headingSepuluh" data-parent="#cardAccordion">
                        <div class="card-body">
                          <?php
                          $sigma_d = 0;
                          foreach ($D as $k => $dl) {
                            foreach ($dl as $l => $value) {
                              $sigma_d += $value;
                            }
                          }
                          $threshold_d = $sigma_d / ($m * ($m - 1));
                          echo $threshold_d;
                          ?>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingSebelas" data-toggle="collapse" data-target="#collapseSebelas" aria-expanded="false" aria-controls="collapseSebelas" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Concordance Dominan (F)</span>
                      </div>
                      <div id="collapseSebelas" class="collapse pt-1" aria-labelledby="headingSebelas" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $F = array();
                                foreach ($C as $k => $cl) {
                                  $F[$k] = array();
                                  foreach ($cl as $l => $value) {
                                    $F[$k][$l] = ($value >= $threshold_c ? 1 : 0);
                                  }
                                }

                                foreach ($F as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingDuabelas" data-toggle="collapse" data-target="#collapseDuabelas" aria-expanded="false" aria-controls="collapseDuabelas" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Discordance Dominan (G)</span>
                      </div>
                      <div id="collapseDuabelas" class="collapse pt-1" aria-labelledby="headingDuabelas" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $G = array();
                                foreach ($D as $k => $dl) {
                                  $G[$k] = array();
                                  foreach ($dl as $l => $value) {
                                    $G[$k][$l] = ($value >= $threshold_d ? 1 : 0);
                                  }
                                }

                                foreach ($G as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "</tr>";
                                }

                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingTigabelas" data-toggle="collapse" data-target="#collapseTigabelas" aria-expanded="false" aria-controls="collapseTigabelas" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Agregasi Dominan (E)</span>
                      </div>
                      <div id="collapseTigabelas" class="collapse pt-1" aria-labelledby="headingTigabelas" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th></th>
                                  <?php
                                  foreach ($result2 as $key => $value) {
                                    echo "<th>" . $value['name'] . "</th>";
                                  }
                                  ?>
                                  <th>Poin</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                $hasil1 = array();

                                $E = array();
                                foreach ($F as $k => $sl) {
                                  $E[$k] = array();
                                  foreach ($sl as $l => $value) {
                                    $E[$k][$l] = $F[$k][$l] * $G[$k][$l];
                                  }
                                }

                                foreach ($E as $key => $value) {
                                  $hasil1[$alternatif[$key]] = array_sum($value);

                                  echo "<tr>";
                                  echo "<td>" . $alternatif[$key] . "</td>";
                                  for ($i = 1; $i <= count($c); $i++) {
                                    echo is_array($value[$i]) ? "<td>" . implode(", ", $value[$i]) . "</td>" : "<td>" . $value[$i] . "</td>";
                                  }
                                  echo "<td>" . array_sum($value) . "</td>";
                                  echo "</tr>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingEmpatbelas" data-toggle="collapse" data-target="#collapseEmpatbelas" aria-expanded="false" aria-controls="collapseEmpatbelas" role="button">
                        <span class="collapsed collapse-title">Ranking Tanaman</span>
                      </div>
                      <div id="collapseEmpatbelas" class="collapse pt-1" aria-labelledby="headingEmpatbelas" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th>Ranking</th>
                                  <th>Nama Tanaman</th>
                                  <th>Poin</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                arsort($hasil1);
                                $ranking = 1;
                                foreach ($hasil1 as $key => $value) {
                                  echo "<tr>";
                                  echo "<td>" . $ranking++ . "</td>";
                                  echo "<td>" . $alternatif[$key][0] . "</td>";
                                  echo "<td>" . $value . "</td>";
                                  echo "</tr>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end:: metode electre -->
                <!-- begin:: metode vikor -->
                <div class="tab-pane fade" id="vikor" role="tabpanel" aria-labelledby="vikor-tab">
                  <div class="accordion" id="cardAccordion">
                    <div class="card">
                      <div class="card-header" id="headingSatu" data-toggle="collapse" data-target="#collapseSatu" aria-expanded="false" aria-controls="collapseSatu" role="button">
                        <span class="collapsed collapse-title">Matrik Keputusan (F)</span>
                      </div>
                      <div id="collapseSatu" class="collapse pt-1" aria-labelledby="headingSatu" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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
                      <div class="card-header" id="headingDua" data-toggle="collapse" data-target="#collapseDua" aria-expanded="false" aria-controls="collapseDua" role="button">
                        <span class="collapsed collapse-title">Matrik Normalisasi (N)</span>
                      </div>
                      <div id="collapseDua" class="collapse pt-1" aria-labelledby="headingDua" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingTiga" data-toggle="collapse" data-target="#collapseTiga" aria-expanded="false" aria-controls="collapseTiga" role="button">
                        <span class="collapsed collapse-title">Matrik Normalisasi Terbobot (F*)</span>
                      </div>
                      <div id="collapseTiga" class="collapse pt-1" aria-labelledby="headingTiga" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingEmpat" data-toggle="collapse" data-target="#collapseEmpat" aria-expanded="false" aria-controls="collapseEmpat" role="button">
                        <span class="collapsed collapse-title">Utility Measure (S & R)</span>
                      </div>
                      <div id="collapseEmpat" class="collapse pt-1" aria-labelledby="headingEmpat" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
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
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingLima" data-toggle="collapse" data-target="#collapseLima" aria-expanded="false" aria-controls="collapseLima" role="button">
                        <span class="collapsed collapse-title">Menghitung Nilai Indeks VIKOR (Q)</span>
                      </div>
                      <div id="collapseLima" class="collapse pt-1" aria-labelledby="headingLima" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th>S+</th>
                                  <th>S-</th>
                                  <th>R+</th>
                                  <th>R-</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><?= max($S) ?></td>
                                  <td><?= min($S) ?></td>
                                  <td><?= max($R) ?></td>
                                  <td><?= min($R) ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingEnam" data-toggle="collapse" data-target="#collapseEnam" aria-expanded="false" aria-controls="collapseEnam" role="button">
                        <span class="collapsed collapse-title">Hasil</span>
                      </div>
                      <div id="collapseEnam" class="collapse pt-1" aria-labelledby="headingEnam" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th>Alternatif</th>
                                  <th>Nilai</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $Q = get_Q($S, $R);
                                foreach ($Q as $key => $value) : ?>
                                  <tr>
                                    <td><?= $alternatif[$key] ?></td>
                                    <td><?= $value ?></td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header" id="headingTujuh" data-toggle="collapse" data-target="#collapseTujuh" aria-expanded="false" aria-controls="collapseTujuh" role="button">
                        <span class="collapsed collapse-title">Perangkingan</span>
                      </div>
                      <div id="collapseTujuh" class="collapse pt-1" aria-labelledby="headingTujuh" data-parent="#cardAccordion">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                              <thead>
                                <tr>
                                  <th>Alternatif</th>
                                  <th>Nilai</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $Q = get_Q($S, $R);
                                arsort($Q);
                                foreach ($Q as $key => $value) : ?>
                                  <tr>
                                    <td><?= $alternatif[$key] ?></td>
                                    <td><?= $value ?></td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end:: metode vikor -->
              </div>
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