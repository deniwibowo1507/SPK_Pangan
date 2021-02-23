<!-- begin:: head -->
<?php include_once './atribut/head.php'; ?>
<!-- end:: head -->

<?php
if (isset($_POST['proses'])) {
  // mengambil hasil inputan
  $nama      = $_POST['inpnama'];
  $no_hp     = $_POST['inpnohp'];
  $alamat    = $_POST['inpalamat'];
  $id_lokasi = $_POST['inplokasi'];

  // insert ke dalam tabel history
  $connect->query("INSERT INTO tb_history (nama, no_hp, alamat, lokasi) VALUES ('$nama', '$no_hp', '$alamat', '$id_lokasi')");

  $qry4      = $connect->query("SELECT * FROM tb_kriteria_lokasi WHERE id_lokasi = '$id_lokasi'");
  $row4      = $qry4->fetch_array(MYSQLI_ASSOC);
  $kriteria  = json_decode($row4['kriteria'], true);

  // untuk criteria
  for ($i = 0; $i < count($kriteria); $i++) {
    $criteria[$kriteria[$i]['id_kriteria']] = $kriteria[$i]['weight'];
  }

  // untuk bobot
  for ($j = 0; $j < count($kriteria); $j++) {
    $bobot[$kriteria[$j]['id_kriteria']] = $kriteria[$j]['weight'];
  }
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
  $sample[$row['id_alternative']][$row['id_criteria']] = (int) $row['value'];

  // electre
  if ($row['id_alternative'] != $alternative) {
    $X[$row['id_alternative']] = [];
    $alternative = $row['id_alternative'];
    ++$m;
  }
  $X[$row['id_alternative']][$row['id_criteria']] = (int) $row['value'];
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
        <h2 class="mt-0">Hasil Perhitungan :</h2>
        <!-- begin:: menu tab -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="hasil-tab" data-toggle="tab" href="#hasil" role="tab" aria-controls="hasil" aria-selected="false">Hasil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="electre-tab" data-toggle="tab" href="#electre" role="tab" aria-controls="electre" aria-selected="true">Electre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="vikor-tab" data-toggle="tab" href="#vikor" role="tab" aria-controls="vikor" aria-selected="false">Vikor</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="electre" role="tabpanel" aria-labelledby="electre-tab">
            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Perbandingan Berpasangan (X)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Perbandingan Berpasangan Ternormalisasi (R)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Menentukan Bobot tiap-tiap Kriteria (W)</h6>
              </div>
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
                      <tr>
                        <?php for ($i = 1; $i <= count($criteria); $i++) { ?>
                          <td><?= $criteria[$i] ?></td>
                        <?php } ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Matrik Preferensi (V)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Menentukan Concordance Index (Ckl)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Menentukan Discordance Index (Dkl)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Matriks Concordance (C)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Threshold c</h6>
              </div>
              <div class="card-body">
                <?php
                $sigma_c = 0;
                foreach ($C as $k => $cl) {
                  foreach ($cl as $l => $value) {
                    if (is_numeric($value)) {
                      $sigma_c += $value;
                    }
                  }
                }
                $threshold_c = $sigma_c / ($m * ($m - 1));
                echo $threshold_c;
                ?>
              </div>
            </div>

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Matriks Discordance (D)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Threshold d</h6>
              </div>
              <div class="card-body">
                <?php
                $sigma_d = 0;
                foreach ($D as $k => $dl) {
                  foreach ($dl as $l => $value) {
                    if (is_numeric($value)) {
                      $sigma_d += $value;
                    }
                  }
                }
                $threshold_d = $sigma_d / ($m * ($m - 1));
                echo $threshold_d;
                ?>
              </div>
            </div>

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Matrik Concordance Dominan (F)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Matrik Discordance Dominan (G)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Membentuk Matrik Agregasi Dominan (E)</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($result2 as $key => $value) { ?>
                          <th><?= $value['name'] ?></th>
                        <?php } ?>
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
                        $hasil1[$key] = array_sum($value);

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
          <div class="tab-pane fade" id="vikor" role="tabpanel" aria-labelledby="vikor-tab">
            <br />
            <div class="card">
              <div class="card-header">
                <h6>Matrik Keputusan (F)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Matrik Normalisasi (N)</h6>
              </div>
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
                          $resultCount = ($f_plus[$j] - $nilai);
                          $N[$i][$j] = $resultCount === 0 ? 0 : $resultCount / ($f_plus[$j] - $f_min[$j]);
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Matrik Normalisasi Terbobot (F*)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Utility Measure (S & R)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Menghitung Nilai Indeks VIKOR (Q)</h6>
              </div>
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

            <br />
            <div class="card">
              <div class="card-header">
                <h6>Hasil</h6>
              </div>
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
          <div class="tab-pane fade show active" id="hasil" role="tabpanel" aria-labelledby="hasil-tab">
            <br />
            <div class="card">
              <div class="card-header">
                <span class="collapsed collapse-title">Perangkingan</span>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <h4>Electre</h4>
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
                          $rankingElectre = 1;
                          $totalElectre = [];
                          foreach ($hasil1 as $key => $value) :
                            $totalElectre[] = $value;
                          ?>
                            <tr>
                              <td><?= $rankingElectre++ ?></td>
                              <td><?= $alternatif[$key] ?></td>
                              <td><?= $value ?></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <h4>Vikor</h4>
                    <div class="table-responsive">
                      <table class="table table-striped" id="table1">
                        <thead>
                          <tr>
                            <th>Rangking</th>
                            <th>Alternatif</th>
                            <th>Poin</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $Q = get_Q($S, $R);
                          arsort($Q);
                          $rankingVikor = 1;
                          $totalVikor = [];
                          foreach ($Q as $key => $value) :
                            $totalVikor[] = $value;
                          ?>
                            <tr>
                              <td><?= $rankingVikor++ ?></td>
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

            <br />
            <div class="card">
              <div class="card-header">
                <span class="collapsed collapse-title">Keakuratan</span>
              </div>
              <div class="card-body">
                <?php
                $metodeElectre = number_format((array_sum($totalElectre) / count($hasil1)), 2);
                $metodeVikor   = number_format((array_sum($totalVikor) / count($Q)), 2);

                $presentaseElectre = number_format((100 - ($metodeElectre / 100)), 2);
                $presentaseVikor   = number_format((100 - ($metodeVikor / 100)), 2);
                ?>
                <p>
                  \[Metode Electre = {Jumlah Hasil Akhir \over Banyak Data} = {<?= number_format(array_sum($totalElectre), 2) ?> \over <?= count($hasil1) ?>} = <?= $metodeElectre ?>\]
                  \[Metode Vikor = {Jumlah Hasil Akhir \over Banyak Data} = {<?= number_format(array_sum($totalVikor), 2) ?> \over <?= count($Q) ?>} = <?= $metodeVikor ?>\]
                </p>
                <hr>
                <p>
                  \[Presentase Metode Electre = 100 - {<?= $metodeElectre ?> \over 100} = <?= $presentaseElectre ?> \% \]
                  \[Presentase Metode Vikor = 100 - {<?= $metodeVikor ?> \over 100} = <?= $presentaseVikor ?> \% \]
                </p>
              </div>
            </div>

            <br />
            <div class="card">
              <div class="card-header">
                <span class="collapsed collapse-title">Chart</span>
              </div>
              <div class="card-body">
                <figure class="highcharts-figure">
                  <div id="container"></div>
                </figure>
              </div>
            </div>
          </div>
        </div>
        <!-- end:: menu tab -->
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

<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
  // Create the chart
  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Keakuratan'
    },
    subtitle: {
      text: 'Metode Electre & Vikor'
    },
    accessibility: {
      announceNewData: {
        enabled: true
      }
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'Tingkat keakuratan'
      }

    },
    legend: {
      enabled: false
    },
    plotOptions: {
      series: {
        borderWidth: 0,
        dataLabels: {
          enabled: true,
          format: '{point.y:.1f}%'
        }
      }
    },

    tooltip: {
      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
      name: "Browsers",
      colorByPoint: true,
      data: [{
          name: "Metode Electre",
          y: <?= $presentaseElectre ?>,
          drilldown: "Metode Electre"
        },
        {
          name: "Metode Vikor",
          y: <?= $presentaseVikor ?>,
          drilldown: "Metode Vikor"
        },
      ]
    }],
  });
</script>

<?php
if (isset($_POST['proses'])) {
  $hasil_electre = json_encode($hasil1);
  $hasil_vikor = json_encode($Q);

  $sql    = "SELECT * FROM tb_ranking WHERE id_lokasi = '$id_lokasi' ";
  $tambah = mysqli_query($connect, $sql);
  $row    = mysqli_fetch_row($tambah);
  $rowCount = mysqli_num_rows($tambah);

  if ($rowCount === 0) {
    $sql   = "INSERT INTO tb_ranking (id_lokasi, hasil_electre, hasil_vikor) VALUES ('$id_lokasi', '$hasil_electre', '$hasil_vikor')";
    $query = $connect->query($sql);
  } else {
    $sql   = "DELETE FROM tb_ranking WHERE id_lokasi = '$id_lokasi'";
    $query = mysqli_query($connect, $sql);
    $sql2  = "INSERT INTO tb_ranking (id_lokasi, hasil_electre, hasil_vikor) VALUES ('$id_lokasi', '$hasil_electre', '$hasil_vikor')";
    $query = mysqli_query($connect, $sql2);
  }
}
?>