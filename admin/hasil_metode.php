<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<?php
error_reporting(0);

// untuk kriteria
$sql1         = "SELECT * FROM tb_kriteria";
$result1      = $connect->query($sql1);
$kriteria     = [];
$bobot        = [];
$namaKriteria = [];

while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {
  $kriteria[$row['id_criteria']] = array($row['criteria'], $row['tipe']);
  $bobot[$row['id_criteria']] = $row['bobot'] / 100;
  $namaKriteria[] = $row['criteria'];
}

// untuk alternatif
$sql2       = "SELECT * FROM tb_alternatif";
$result2    = $connect->query($sql2);
$tanaman    = [];
$alternatif = [];

while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
  $alternatif[$row['id_alternative']] = $row['name'];
  // $alternatif[$row['id_alternative']] = array($row['name']);
}

// echo '<pre>';
// print_r($alternatif);
// die();

$sql3    = 'SELECT * FROM tb_evaluasi ORDER BY id_alternative, id_criteria';
$result3 = $connect->query($sql3);
$sample  = [];
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
                          <table class="table table-striped" id="table1">
                            <thead>
                              <tr>
                                <th>Alternatif</th>
                                <?php foreach ($result3 as $key) { ?>
                                  <th><?= $key['criteria'] ?></th>
                                <?php } ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php

                              $sql = "SELECT COUNT(*) FROM tb_kriteria";
                              $result = $connect->query($sql);
                              $row = $result->fetch_row();
                              $n = $row[0];
                              $sql = "SELECT * FROM tb_evaluasi ORDER BY id_alternative, id_criteria";
                              $result = $connect->query($sql);
                              $X = array();
                              $alternative = '';
                              $m = 0;

                              while ($row = $result->fetch_row()) {
                                if ($row[0] != $alternative) {
                                  $X[$row[0]] = array();
                                  $alternative = $row[0];
                                  ++$m;
                                }
                                $X[$row[0]][$row[1]] = $row[2];
                              }

                              foreach ($X as $key => $value) {
                                echo "<tr>";
                                echo "<td>" . $alternatif[$key][0] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingDua" data-toggle="collapse" data-target="#collapseDua" aria-expanded="false" aria-controls="collapseDua" role="button">
                        <span class="collapsed collapse-title">Perbandingan Berpasangan Ternormalisasi (R)</span>
                      </div>
                      <div id="collapseDua" class="collapse pt-1" aria-labelledby="headingDua" data-parent="#cardAccordion">
                        <div class="card-body">
                          <table class="table table-striped" id="table1">
                            <thead>
                              <tr>
                                <th></th>
                                <?php foreach ($result3 as $key) { ?>
                                  <th><?= $key['criteria'] ?></th>
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
                                  <td><?= $tanaman[$key] ?></td>
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

                    <div class="card">
                      <div class="card-header" id="headingTiga" data-toggle="collapse" data-target="#collapseTiga" aria-expanded="false" aria-controls="collapseTiga" role="button">
                        <span class="collapsed collapse-title">Menentukan Bobot tiap-tiap Kriteria (W)</span>
                      </div>
                      <div id="collapseTiga" class="collapse pt-1" aria-labelledby="headingTiga" data-parent="#cardAccordion">
                        <div class="card-body">
                          <table class="table table-striped" id="table1">
                            <thead>
                              <tr>
                                <?php

                                foreach ($result3 as $key) {
                                  echo "<th>" . $key['criteria'] . "</th>";
                                }

                                ?>
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

                    <div class="card">
                      <div class="card-header" id="headingEmpat" data-toggle="collapse" data-target="#collapseEmpat" aria-expanded="false" aria-controls="collapseEmpat" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Preferensi (V)</span>
                      </div>
                      <div id="collapseEmpat" class="collapse pt-1" aria-labelledby="headingEmpat" data-parent="#cardAccordion">
                        <div class="card-body">
                          <table class="table table-striped" id="table1">
                            <thead>
                              <tr>
                                <th></th>
                                <?php

                                foreach ($result3 as $key) {
                                  echo "<th>" . $key['criteria'] . "</th>";
                                }

                                ?>
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingLima" data-toggle="collapse" data-target="#collapseLima" aria-expanded="false" aria-controls="collapseLima" role="button">
                        <span class="collapsed collapse-title">Menentukan Concordance Index (Ckl)</span>
                      </div>
                      <div id="collapseLima" class="collapse pt-1" aria-labelledby="headingLima" data-parent="#cardAccordion">
                        <div class="card-body">
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingEnam" data-toggle="collapse" data-target="#collapseEnam" aria-expanded="false" aria-controls="collapseEnam" role="button">
                        <span class="collapsed collapse-title">Menentukan Discordance Index (Dkl)</span>
                      </div>
                      <div id="collapseEnam" class="collapse pt-1" aria-labelledby="headingEnam" data-parent="#cardAccordion">
                        <div class="card-body">
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingTujuh" data-toggle="collapse" data-target="#collapseTujuh" aria-expanded="false" aria-controls="collapseTujuh" role="button">
                        <span class="collapsed collapse-title">Membentuk Matriks Concordance (C)</span>
                      </div>
                      <div id="collapseTujuh" class="collapse pt-1" aria-labelledby="headingTujuh" data-parent="#cardAccordion">
                        <div class="card-body">
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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
                        <span class="collapsed collapse-title">Membentuk Matrik Concordance Dominan(F)</span>
                      </div>
                      <div id="collapseSebelas" class="collapse pt-1" aria-labelledby="headingSebelas" data-parent="#cardAccordion">
                        <div class="card-body">
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingDuabelas" data-toggle="collapse" data-target="#collapseDuabelas" aria-expanded="false" aria-controls="collapseDuabelas" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Discordance Dominan(G)</span>
                      </div>
                      <div id="collapseDuabelas" class="collapse pt-1" aria-labelledby="headingDuabelas" data-parent="#cardAccordion">
                        <div class="card-body">
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
                                echo "<td>" . $tanaman[$key] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingTigabelas" data-toggle="collapse" data-target="#collapseTigabelas" aria-expanded="false" aria-controls="collapseTigabelas" role="button">
                        <span class="collapsed collapse-title">Membentuk Matrik Agregasi Dominan(E)</span>
                      </div>
                      <div id="collapseTigabelas" class="collapse pt-1" aria-labelledby="headingTigabelas" data-parent="#cardAccordion">
                        <div class="card-body">
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
                                $hasil1[$tanaman[$key]] = array_sum($value);

                                echo "<tr>";
                                echo "<td>" . $tanaman[$key] . "</td>";
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

                    <div class="card">
                      <div class="card-header" id="headingEmpatbelas" data-toggle="collapse" data-target="#collapseEmpatbelas" aria-expanded="false" aria-controls="collapseEmpatbelas" role="button">
                        <span class="collapsed collapse-title">Ranking Tanaman</span>
                      </div>
                      <div id="collapseEmpatbelas" class="collapse pt-1" aria-labelledby="headingEmpatbelas" data-parent="#cardAccordion">
                        <div class="card-body">
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
                <!-- end:: metode electre -->
                <!-- begin:: metode vikor -->
                <div class="tab-pane fade" id="vikor" role="tabpanel" aria-labelledby="vikor-tab">
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