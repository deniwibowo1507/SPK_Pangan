<?php 
include_once '../database/koneksi.php';
if (isset($_POST['tambah'])) {
	$lokasi  = $_POST['lokasi'];
	$id_lokasi = $_POST['inpidlokasi'];
	$query  = "INSERT INTO tb_lokasi (id_lokasi, nama_lokasi) VALUES ('$id_lokasi','$lokasi')";
	$result = $connect->query($query);

	if ($result) {
		echo "<script>
		window.location=(href='data_lokasi.php')
		</script>";
	}
	else {
		echo "<script>
		window.alert('Gagal Menambah Data');
		window.location=(href='data_lokasi.php')
		</script>";
	}
}

?>