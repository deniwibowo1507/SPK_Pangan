<?php
include_once '../database/koneksi.php';
$id_lokasi = $_GET['id_lokasi'];
$sql       = "SELECT tb_kriteria_lokasi.*, tb_lokasi.nama_lokasi FROM tb_kriteria_lokasi, tb_lokasi WHERE tb_kriteria_lokasi.id_lokasi = '$id_lokasi' AND tb_lokasi.id_lokasi = '$id_lokasi'";
$query     = $connect->query($sql);
$row       = $query->fetch_array(MYSQLI_ASSOC);
$kriteria  = json_decode($row['kriteria'], true);
?>

<form method="POST">
	<div class="col-sm-12">
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" class="form-control" name="id_lokasi" readonly="readonly" value="<?php echo $row['id_lokasi'] ?>">
			</div>
		</div>
		<label>Lokasi</label>
		<div class="form-group form-float">
			<div class="form-line">
				<select name="inp_namalokasi" class="form-control show-tick">
					<option value="<?php echo $row['id_lokasi'] ?>"><?php echo $row['nama_lokasi']; ?></option>
					<?php
					$sql      = "SELECT * FROM tb_lokasi";
					$lokasi = $connect->query($sql);

					while ($row = $lokasi->fetch_array(MYSQLI_ASSOC)) {
					?>
						<option value="<?php echo $row['id_lokasi'] ?>"><?php echo $row['nama_lokasi']; ?></option>
					<?php }	?>
				</select>
			</div>
		</div>
		<label>Jenis Tanah</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria1" value="1" readonly="readonly">
				<select name="kriteria1" class="form-control show-tick">
					<option value="6" <?= ($kriteria[0]['weight'] === '6' ? 'selected' : '') ?>>Regosol</option>
					<option value="5" <?= ($kriteria[0]['weight'] === '5' ? 'selected' : '') ?>>Litosol</option>
					<option value="4" <?= ($kriteria[0]['weight'] === '4' ? 'selected' : '') ?>>Latosol</option>
					<option value="3" <?= ($kriteria[0]['weight'] === '3' ? 'selected' : '') ?>>Organosol</option>
					<option value="2" <?= ($kriteria[0]['weight'] === '2' ? 'selected' : '') ?>>Grumusol</option>
					<option value="1" <?= ($kriteria[0]['weight'] === '1' ? 'selected' : '') ?>>Alluvial</option>
				</select>
			</div>
		</div>
		<label>Curah Hujan</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria2" value="2" readonly="readonly">
				<select class="form-control show-tick" name="kriteria2" id="kriteria2">
					<option value="3" <?= ($kriteria[1]['weight'] === '3' ? 'selected' : '') ?>>Tinggi (300 - 500 mm)</option>
					<option value="2" <?= ($kriteria[1]['weight'] === '2' ? 'selected' : '') ?>>Menengah (100 - 300 mm)</option>
					<option value="1" <?= ($kriteria[1]['weight'] === '1' ? 'selected' : '') ?>>Renda (0 - 100 mm)h</option>
				</select>
			</div>
		</div>
		<label>Drainase</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria3" value="3" readonly="readonly">
				<select name="kriteria3" class="form-control show-tick">
					<option value="2" <?= ($kriteria[2]['weight'] === '2' ? 'selected' : '') ?>>Ada</option>
					<option value="1" <?= ($kriteria[2]['weight'] === '1' ? 'selected' : '') ?>>Tidak Ada</option>
				</select>
			</div>
		</div>
		<label>Ph</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria4" value="4" readonly="readonly">
				<select name="kriteria4" class="form-control show-tick">
					<option value="4" <?= ($kriteria[3]['weight'] === '4' ? 'selected' : '') ?>>Basa Sedang (7,5 - 8,5)</option>
					<option value="3" <?= ($kriteria[3]['weight'] === '3' ? 'selected' : '') ?>>Netral (7,0 - 7,5)</option>
					<option value="2" <?= ($kriteria[3]['weight'] === '2' ? 'selected' : '') ?>>Asam Sedang (4,0 - 6,9)</option>
					<option value="1" <?= ($kriteria[3]['weight'] === '1' ? 'selected' : '') ?>>Sangat Asam (< 4)</option>
				</select>
			</div>
		</div>
		<label>Ketinggian Tempat</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria5" value="5" readonly="readonly">
				<select name="kriteria5" class="form-control show-tick">
					<option value="2" <?= ($kriteria[4]['weight'] === '2' ? 'selected' : '') ?>>Dataran Tinggi (500 - 1500 mdpl)</option>
					<option value="1" <?= ($kriteria[4]['weight'] === '1' ? 'selected' : '') ?>>Dataran Rendah (0 - 500 mdpl)</option>
				</select>
			</div>
		</div>
		<label>Temperatur</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria6" value="6" readonly="readonly">
				<select name="kriteria6" class="form-control show-tick">
					<option value="4" <?= ($kriteria[5]['weight'] === '4' ? 'selected' : '') ?>>26,3 C - 22 C</option>
					<option value="3" <?= ($kriteria[5]['weight'] === '3' ? 'selected' : '') ?>>22 C - 17,1 C</option>
					<option value="2" <?= ($kriteria[5]['weight'] === '2' ? 'selected' : '') ?>>17,1 C - 11,1 C</option>
					<option value="1" <?= ($kriteria[5]['weight'] === '1' ? 'selected' : '') ?>>11,1 C - 6,2 C</option>
				</select>
			</div>
		</div>
		<label>Kedalaman Tanah</label>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="hidden" name="id_kriteria7" value="7" readonly="readonly">
				<select name="kriteria7" class="form-control show-tick">
					<option value="4" <?= ($kriteria[6]['weight'] === '4' ? 'selected' : '') ?>>
						< 20 cm</option>
					<option value="3" <?= ($kriteria[6]['weight'] === '3' ? 'selected' : '') ?>>20 - 50 cm</option>
					<option value="2" <?= ($kriteria[6]['weight'] === '2' ? 'selected' : '') ?>>50 - 75 cm</option>
					<option value="1" <?= ($kriteria[6]['weight'] === '1' ? 'selected' : '') ?>>> 75 cm</option>
				</select>
			</div>
		</div>
	</div>
	<button type="submit" name="ubah" class="btn btn-success">UBAH</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
</form>