<?php
include_once 'atribut/head.php';
error_reporting(0);

$sql2 = "SELECT * FROM tb_alternatif";
$result2 = $connect->query($sql2);

$tanaman = array();
$alternatif = array();

while($row = $result2->fetch_row()){
  $tanaman[$row[0]] = $row[0];
  $alternatif[$row[0]]=array($row[1]);
}

$sql3 = "SELECT id_criteria, criteria FROM tb_kriteria";
$result3 = $connect->query($sql3);

$id_lokasi = $_POST['nm_lokasi'];

// if (isset($_POST['proses'])) {
//   $id_bulan = $_POST['id_bulan'];
//   $bulan1   = date($id_bulan);
//   $bulan2   = date($id_bulan) + 1;
//   $bulan3   = date($id_bulan) + 2;

//   $sql      = "SELECT * FROM tb_kriteria WHERE id_criteria = '2'";
//   $query    = $connect->query($sql);
//   $row      = $query->fetch_array(MYSQLI_ASSOC);
//   $kriteria = json_decode($row['bulan'], true);

//   for ($i = 0; $i < count($kriteria); $i++) {
//     if ($kriteria[$i]['id_bulan'] == $bulan1) {
//       if ($id_bulan == 12) {
//         $data_bulan = array(
//           $bulan1 => $kriteria[$i]['value'],
//           $bulan2 => $kriteria[1]['value'],
//           $bulan3 => $kriteria[2]['value']
//         );
//       } else {
//         $data_bulan = array(
//           $bulan1 => $kriteria[$i]['value'],
//           $bulan2 => $kriteria[$i+1]['value'],
//           $bulan3 => $kriteria[$i+2]['value']
//         );
//       }
//     }
//   }

//   $hitung = array_sum($data_bulan) / 3;

//   if ($hitung >= 300 && $hitung <= 400) {
//     $hasil = 3;
//     $ket = "Tinggi (300-400 mm/bulan)";
//   } else if ($hitung >= 200 && $hitung <= 300) {
//     $hasil = 2;
//     $ket = "Menengah (200-300 mm/bulan)";
//   } else if ($hitung >= 100 && $hitung <= 200) {
//     $hasil = 1;
//     $ket = "Rendah (100-200 mm/bulan)";
//   }

//   $query4   = $connect->query("SELECT * FROM tb_kriteria_lokasi WHERE id_lokasi = '$id_lokasi'");
//   $row      = $query4->fetch_array(MYSQLI_ASSOC);
//   $kriteria = json_decode($row['kriteria'], true);

//   $array_kriteria = array(
//     ['id_kriteria' => $kriteria[0]['id_kriteria'], 'kriteria' => $kriteria[0]['kriteria'], 'weight' => $kriteria[0]['weight']],
//     ['id_kriteria' => $kriteria[1]['id_kriteria'], 'kriteria' => $kriteria[1]['kriteria'], 'weight' => $hasil, 'data_bulan' => $data_bulan, 'ket' => $ket],
//     ['id_kriteria' => $kriteria[2]['id_kriteria'], 'kriteria' => $kriteria[2]['kriteria'], 'weight' => $kriteria[2]['weight']],
//     ['id_kriteria' => $kriteria[3]['id_kriteria'], 'kriteria' => $kriteria[3]['kriteria'], 'weight' => $kriteria[3]['weight']],
//     ['id_kriteria' => $kriteria[4]['id_kriteria'], 'kriteria' => $kriteria[4]['kriteria'], 'weight' => $kriteria[4]['weight']],
//   );
//   $data_kriteria = json_encode($array_kriteria);
//   $connect->query("UPDATE tb_kriteria_lokasi SET kriteria = '$data_kriteria' WHERE id_lokasi = '$id_lokasi'");
// }
?>

<!-- Page Loader -->
<div class="page-loader-wrapper">
  <div class="loader">
    <div class="preloader">
      <div class="spinner-layer pl-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
    <p>Please wait...</p>
  </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
  <div class="search-icon">
    <i class="material-icons">search</i>
  </div>
  <input type="text" placeholder="START TYPING...">
  <div class="close-search">
    <i class="material-icons">close</i>
  </div>
</div>

<!-- Untuk Menu -->
<?php include_once 'atribut/menu.php'; ?>

<section class="content">
  <div class="container-fluid">

    <!-- Body Copy -->
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>
              Hasil Metode
            </h2>
          </div>
          <div class="body">
           <!-- Nav tabs -->
           <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#home" data-toggle="tab">Proses Electre</a></li>
            <li role="presentation"><a href="#profile" data-toggle="tab">Proses Topsis</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">

             
  </div>
</div>
</div>

</div>
<div role="tabpanel" class="tab-pane fade" id="profile">

  <?php 
  $sql  = "SELECT a.value, b.name, c.criteria FROM tb_evaluasi AS a JOIN tb_alternatif AS b USING(id_alternative) JOIN tb_kriteria AS c USING(id_criteria)";
  $tampil = $connect->query($sql);

// sql untuk mengmabil nilai kriteria lokasi
  $sql2 = "SELECT kriteria FROM tb_kriteria_lokasi WHERE id_lokasi = '$id_lokasi'";
  $result = $connect->query($sql2);

  $data          = array();
  $kriterias     = array();
  $bobot         = array();
  $nilai_kuadrat = array();

  while ($row = $result->fetch_array()) {

    $kriteria = json_decode($row['kriteria'], true);      
    for ($i=0; $i < count($kriteria) ; $i++) { 
      $bobot[$kriteria[$i]['kriteria']] = $kriteria[$i]['weight'];
    }  

  }

  if ($tampil) {
    while($row = $tampil->fetch_object()){

      if(!isset($data[$row->name])){
        $data[$row->name]=array();
      }

      if(!isset($data[$row->name][$row->criteria])){
        $data[$row->name][$row->criteria]=array();
      }

      if(!isset($nilai_kuadrat[$row->criteria])){
        $nilai_kuadrat[$row->criteria]=0;
      }

    // $bobot[$row->criteria]=$row->weight;
      $data[$row->name][$row->criteria]=$row->value;
      $nilai_kuadrat[$row->criteria]+=pow($row->value,2);
      $kriterias[]=$row->criteria;
    }
  }

  $kriteria     =array_unique($kriterias);
  $jml_kriteria =count($kriteria);
  ?>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          Evaluation Matrix (x<sub>ij</sub>)
        </div>
        <div class="body table-responsive">
          <table class="table table-bordered">
           <thead>
            <tr>
              <th rowspan='3'>No</th>
              <th rowspan='3'>Alternatif</th>
              <th rowspan='3'>Nama</th>
              <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
            </tr>
            <tr>
              <?php
              foreach($kriteria as $k)
                echo "<th>$k</th>\n";
              ?>
            </tr>
            <tr>
              <?php
              for($n=1;$n<=$jml_kriteria;$n++)
                echo "<th>K$n</th>";
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=0;
            foreach($data as $nama=>$krit){
              echo "<tr>
              <td>".(++$i)."</td>
              <th>A$i</th>
              <td>$nama</td>";
              foreach($kriteria as $k){
                echo "<td align='center'>$krit[$k]</td>";
              }
              echo "</tr>\n";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        Rating Kinerja Ternormalisasi (r<sub>ij</sub>)
      </div>
      <div class="body table-responsive">
        <table class="table table-bordered">
         <thead>
          <tr>
            <th rowspan='3'>No</th>
            <th rowspan='3'>Alternatif</th>
            <th rowspan='3'>Nama</th>
            <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
          </tr>
          <tr>
            <?php
            foreach($kriteria as $k)
              echo "<th>$k</th>\n";
            ?>
          </tr>
          <tr>
            <?php
            for($n=1;$n<=$jml_kriteria;$n++)
              echo "<th>K$n</th>";
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=0;
          foreach($data as $nama=>$krit){
            echo "<tr>
            <td>".(++$i)."</td>
            <th>A{$i}</th>
            <td>{$nama}</td>";
            foreach($kriteria as $k){
              echo "<td align='center'>".round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)."</td>";
            }
            echo
            "</tr>\n";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        Rating Bobot Ternormalisasi(y<sub>ij</sub>)
      </div>
      <div class="body table-responsive">
        <table class="table table-bordered">
         <thead>
          <tr>
            <th rowspan='3'>No</th>
            <th rowspan='3'>Alternatif</th>
            <th rowspan='3'>Nama</th>
            <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
          </tr>
          <tr>
            <?php
            foreach($kriteria as $k)
              echo "<th>$k</th>\n";
            ?>
          </tr>
          <tr>
            <?php
            for($n=1;$n<=$jml_kriteria;$n++)
              echo "<th>K$n</th>";
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=0;
          $y=array();
          foreach($data as $nama => $krit){
            echo "<tr>
            <td>".(++$i)."</td>
            <th>A{$i}</th>
            <td>{$nama}</td>";
            foreach($kriteria as $k){
              $y[$k][$i-1] = round(($krit[$k] / sqrt($nilai_kuadrat[$k])), 4) * $bobot[$k];
              echo "<td align='center'>".$y[$k][$i-1]."</td>";
            }
            echo
            "</tr>\n";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        Solusi Ideal positif (A<sup>+</sup>)
      </div>
      <div class="body table-responsive">
        <table class="table table-bordered">
         <thead>
          <tr>
            <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
          </tr>
          <tr>
            <?php
            foreach($kriteria as $k)
              echo "<th>$k</th>\n";
            ?>
          </tr>
          <tr>
            <?php
            for($n=1;$n<=$jml_kriteria;$n++)
              echo "<th>y<sub>{$n}</sub><sup>+</sup></th>";
            ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            $yplus=array();
            foreach($kriteria as $k){
              $yplus[$k]=([$k]?max($y[$k]):min($y[$k]));
              echo "<th>$yplus[$k]</th>";
            }
            ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        Solusi Ideal negatif (A<sup>-</sup>)
      </div>
      <div class="body table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
            </tr>
            <tr>
              <?php
              foreach($kriteria as $k)
                echo "<th>{$k}</th>\n";
              ?>
            </tr>
            <tr>
              <?php
              for($n=1;$n<=$jml_kriteria;$n++)
                echo "<th>y<sub>{$n}</sub><sup>-</sup></th>";
              ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              $ymin=array();
              foreach($kriteria as $k){
                $ymin[$k]=[$k]?min($y[$k]):max($y[$k]);
                echo "<th>{$ymin[$k]}</th>";
              }

              ?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        Jarak positif (D<sub>i</sub><sup>+</sup>)
      </div>
      <div class="body table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Alternatif</th>
              <th>Nama</th>
              <th>D<suo>+</sup></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i=0;
              $dplus=array();
              $dplus_h = [];
              foreach($data as $nama=>$krit){
                echo "<tr>
                <td>".(++$i)."</td>
                <th>A{$i}</th>
                <td>{$nama}</td>";
                foreach($kriteria as $k){
                  if(!isset($dplus[$i-1])) $dplus[$i-1]=0;
                  $dplus[$i-1]+=pow($yplus[$k]-$y[$k][$i-1],2);
                }
                echo "<td>".round(sqrt($dplus[$i-1]),6)."</td>
                </tr>\n";
                $dplus_h[] = round(sqrt($dplus[$i-1]),6);
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          Jarak negatif (D<sub>i</sub><sup>-</sup>)
        </div>
        <div class="body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Alternatif</th>
                <th>Nama</th>
                <th>D<suo>-</sup></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=0;
                $dmin=array();
                $dmin_h = [];
                foreach($data as $nama=>$krit){
                  echo "<tr>
                  <td>".(++$i)."</td>
                  <th>A{$i}</th>
                  <td>{$nama}</td>";
                  foreach($kriteria as $k){
                    if(!isset($dmin[$i-1]))$dmin[$i-1]=0;
                    $dmin[$i-1]+=pow($ymin[$k]-$y[$k][$i-1],2);
                  }
                  echo "<td>".round(sqrt($dmin[$i-1]),6)."</td>
                  </tr>\n";
                  $dmin_h[] = round(sqrt($dmin[$i-1]),6);
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            Nilai Preferensi(V<sub>i</sub>)
          </div>
          <div class="body table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Alternatif</th>
                  <th>Nama</th>
                  <th>V<sub>i</sub></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $hasil2 = array();
                $i=0;
                $V=array();
                foreach($data as $nama=>$krit){
                  echo "<tr>
                  <td>".(++$i)."</td>
                  <th>A{$i}</th>
                  <td>{$nama}</td>";
                  foreach($kriteria as $k){
                    $hasil2[$tanaman[$i]] = $V[$i-1] = $dmin_h[$i-1]/($dmin_h[$i-1]+$dplus_h[$i-1]);
                    $V[$i-1] = $dmin_h[$i-1]/($dmin_h[$i-1]+$dplus_h[$i-1]);
                  }
                  echo "<td>{$V[$i-1]}</td></tr>\n";
                }

                arsort($hasil2);
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <form method="post" target="_blank">
      <input type="hidden" name="nm_lokasi" value="<?php echo $id_lokasi ?>">
      <input type="submit" name="cetak" value="Cetak" class="btn btn-primary">
    </form>
    <?php 

    if (isset($_POST['cetak'])) {
      $nm_lokasi = $_POST['nm_lokasi'];
      $hasil_akhir1 = json_encode($hasil1);
      $hasil_akhir2 = json_encode($hasil2);

      $sql    = "SELECT * FROM tb_ranking WHERE id_lokasi = '$nm_lokasi' ";
      $tambah = mysqli_query($connect, $sql);

      if ($row = mysqli_fetch_row($tambah)) {

        $sql   = "DELETE FROM tb_ranking WHERE id_lokasi = '$nm_lokasi'";
        $query = mysqli_query($connect, $sql);
        $sql2 = "INSERT INTO tb_ranking (id_lokasi, hasil_electre, hasil_topsis) VALUES ('$nm_lokasi', '$hasil_akhir1', '$hasil_akhir2')";
        $query = mysqli_query($connect, $sql2);

        if ($query) {
          echo "<script>alert('Berhasil')</script>";
          echo "<script>window.location=(href='cetak_hasil.php?nm_lokasi=".$nm_lokasi."')</script>";
        } else {
          echo "<script>alert('Gagal')</script>";
        }

      } else {

        $sql = "INSERT INTO tb_ranking (id_lokasi, hasil_electre, hasil_topsis) VALUES ('$nm_lokasi', '$hasil_akhir1', '$hasil_akhir2')";
        $query = $connect->query($sql);

        if ($query) {
         echo "<script>alert('Berhasil')</script>";
         echo "<script>window.location=(href='cetak_hasil.php?nm_lokasi=".$nm_lokasi."')</script>";
       } else  {
         echo "<script>
         alert('Gagal')
         </script>";
       }

     }
   }

   ?>

 </div>
</div>

</div>
</div>
</div>
</div>

</section>

<?php include_once 'atribut/foot.php'; ?>