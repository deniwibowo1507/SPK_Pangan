<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<?php
$id_alternative = $_GET['id_alternatif'];
$id_criteria = $_GET['id_kriteria'];
$sql      = "SELECT * FROM tb_evaluasi WHERE id_alternative = '$id_alternative' AND id_criteria = '$id_criteria'";
$query    = $connect->query($sql);
$row = $query->fetch_array(MYSQLI_ASSOC);
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
						<h3 class="card-title">Ubah Data</h3>
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
				<div class="row">
					<div class="card">
						<div class="card-header">
						</div>
						<div class="card-body">
							<form method="POST">
								<label>Id Alternatif</label>
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" class="form-control" name="idalternatif" value="<?php echo $id_alternative; ?>" required="required">
									</div>
								</div>
								<label>
									<?php
									switch ($id_criteria) {
										case 1:
											echo "Jenis Tanah";
											break;
										case 2:
											echo "Curah Hujan";
											break;
										case 3:
											echo "Drainase";
											break;
										case 4:
											echo "PH";
											break;
										case 5:
											echo "Ketinggian Tempat";
											break;
										case 6:
											echo "Temperatur";
											break;
										case 7:
											echo "Kedalaman Tanah";
											break;
									}
									?>
								</label>
								<input type="hidden" name="kriteria" value="<?php echo $id_criteria ?>" readonly="readonly">

								<?php
								switch ($id_criteria) {
									case 1: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="6" <?= ($row['value'] === '6' ? 'selected' : '') ?>>Regosol</option>
													<option value="5" <?= ($row['value'] === '5' ? 'selected' : '') ?>>Litosol</option>
													<option value="4" <?= ($row['value'] === '4' ? 'selected' : '') ?>>Latosol</option>
													<option value="3" <?= ($row['value'] === '3' ? 'selected' : '') ?>>Organosol</option>
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>Grumusol</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>Alluvial</option>
												</select>
											</div>
										</div>
									<?php break;
									case 2: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="3" <?= ($row['value'] === '3' ? 'selected' : '') ?>>Tinggi (300 - 500 mm)</option>
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>Menengah (100 - 300 mm)</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>Renda (0 - 100 mm)h</option>
												</select>
											</div>
										</div>
									<?php break;
									case 3: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>Ada</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>Tidak Ada</option>
												</select>
											</div>
										</div>
									<?php break;
									case 4: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="4" <?= ($row['value'] === '4' ? 'selected' : '') ?>>Basa Sedang (7,5 - 8,5)</option>
													<option value="3" <?= ($row['value'] === '3' ? 'selected' : '') ?>>Netral (7,0 - 7,5)</option>
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>Asam Sedang (4,0 - 6,9)</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>Sangat Asam (< 4)</option>
												</select>
											</div>
										</div>
									<?php break;
									case 5: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>Dataran Tinggi (500 - 1500 mdpl)</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>Dataran Rendah (0 - 500 mdpl)</option>
												</select>
											</div>
										</div>
									<?php break;
									case 6: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="4" <?= ($row['value'] === '4' ? 'selected' : '') ?>>26,3 C - 22 C</option>
													<option value="3" <?= ($row['value'] === '3' ? 'selected' : '') ?>>22 C - 17,1 C</option>
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>17,1 C - 11,1 C</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>11,1 C - 6,2 C</option>
												</select>
											</div>
										</div>
									<?php break;
									case 7: ?>
										<div class="form-group form-float">
											<div class="form-line">
												<select name="value" class="form-control">
													<option value="4" <?= ($row['value'] === '4' ? 'selected' : '') ?>>
														< 20 cm</option>
													<option value="3" <?= ($row['value'] === '3' ? 'selected' : '') ?>>20 - 50 cm</option>
													<option value="2" <?= ($row['value'] === '2' ? 'selected' : '') ?>>50 - 75 cm</option>
													<option value="1" <?= ($row['value'] === '1' ? 'selected' : '') ?>>> 75 cm</option>
												</select>
											</div>
										</div>
								<?php break;
								} ?>
								<input type="submit" name="ubah" value="Ubah" class="btn btn-primary">
								<a href="data_kriteria_tanaman.php" class="btn btn-danger">Batal</a>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>

		<!-- begin:: footer -->
		<?php include_once 'atribut/footer.php' ?>
		<!-- end:: footer -->
	</div>
</div>

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->

<?php
if (isset($_POST['ubah'])) {
	$idalternatif = $_POST['idalternatif'];
	$kriteria     = $_POST['kriteria'];
	$value        = $_POST['value'];

	$query  = "UPDATE tb_evaluasi SET value = '$value' WHERE id_alternative = '$idalternatif' AND id_criteria = '$kriteria'";
	$result = $connect->query($query);

	if ($result) {
		echo "<script>
		alert('Berhasil')
		window.location=(href='data_kriteria_tanaman.php')
		</script>";
	} else {
		echo "<script>
		alert('Gagal')
		window.location=(href='data_kriteria_tanaman.php')
		</script>";
	}
}
?>