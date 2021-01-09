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
										<input type="text" class="form-control" name="idalternatif"
											value="<?php echo $id_alternative; ?>" required="required">
									</div>
								</div>
								<label>
									<?php 

								if ($id_criteria == 1) {
									echo "Jenis Tanah";
								} else if ($id_criteria == 2) {
									echo "Curah Hujan";
								} else if ($id_criteria == 3) {
									echo "Drainase";
								} else if ($id_criteria == 4) {
									echo "PH";
								} else if ($id_criteria == 5) {
									echo "Ketinggian Tempat";
								}

								?>
								</label>
								<input type="hidden" name="kriteria" value="<?php echo $id_criteria ?>"
									readonly="readonly">
								<?php if ($id_criteria == 1) { ?>
								<div class="form-group form-float">
									<div class="form-line">
										<select class="form-control show-tick" name="value">
											<option><?php echo $row['value']; ?></option>
											<option value="4">Latosol</option>
											<option value="3">Organosol</option>
											<option value="2">Podzolik</option>
											<option value="1">Litosol</option>
										</select>
									</div>
								</div>
								<?php } else if ($id_criteria == 2) { ?>
								<div class="form-group form-float">
									<div class="form-line">
										<select class="form-control show-tick" name="value">
											<option><?php echo $row['value']; ?></option>
											<option value="3">Tinggi (300-400 mm/bulan)</option>
											<option value="2">Menengah (200-300 mm/bulan)</option>
											<option value="1">Rendah (100-200 mm/bulan)</option>
										</select>
									</div>
								</div>
								<?php } else if ($id_criteria == 3) { ?>
								<div class="form-group form-float">
									<div class="form-line">
										<select class="form-control show-tick" name="value">
											<option><?php echo $row['value']; ?></option>
											<option value="2">Ada</option>
											<option value="1">Tidak Ada</option>
										</select>
									</div>
								</div>
								<?php } else if ($id_criteria == 4) { ?>
								<div class="form-group form-float">
									<div class="form-line">
										<select class="form-control show-tick" name="value">
											<option><?php echo $row['value']; ?></option>
											<option value="4">Basa Sedang (7,5 - 8,5)</option>
											<option value="3">Netral (7,0 - 7,5)</option>
											<option value="2">Asam Sedang (4,0 - 6,9)</option>
											<option value="1">Sangat Asam (< 4)</option> </select> </div> </div>
													<?php } else if ($id_criteria == 5) { ?> <div
													class="form-group form-float">
													<div class="form-line">
														<select class="form-control show-tick" name="value">
															<option><?php echo $row['value']; ?></option>
															<option value="2">Dataran Tinggi (500 - 1500 mdpl)</option>
															<option value="1">Dataran Rendah (0 - 500 mdpl)</option>
														</select>
													</div>
									</div>
									<?php } ?>
									<a href="data_kriteria_tanaman.php"
										class="btn btn-link btn-danger waves-effect">Batal</a>
									<input type="submit" name="ubah" value="Ubah"
										class="btn btn-link btn-primary waves-effect">
							</form>
						</div>
					</div>
				</div>
			</section>

		</div>

		<footer>
			<div class="footer clearfix mb-0 text-muted">
				<div class="float-left">
					<p>2020 &copy; Voler</p>
				</div>
				<div class="float-right">
					<p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a
							href="http://ahmadsaugi.com">Ahmad Saugi</a></p>
				</div>
			</div>
		</footer>
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
	}

	else {
		echo "<script>
		alert('Gagal')
		window.location=(href='data_kriteria_tanaman.php')
		</script>";
	}
}
?>