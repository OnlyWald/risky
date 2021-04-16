<?php require "../server/config.php"; ?>

<?php
	$id = $_GET['id'];
	$validasi = mysqli_query($connect,"SELECT id_tier_1 FROM data_tier_1 WHERE fk_id_soal = '$id'");


	if (mysqli_fetch_array($validasi)==null) {
		if (hapus("DELETE FROM data_soal WHERE id_soal = '$id'")) {
			echo "<script>
				alert('Data berhasil dihapus');
				document.location.href = 'data-test.php';
			</script>";
		}else{
			echo "<script>
				alert('Data gagal dihapus');
				document.location.href = 'data-test.php';
			</script>";
		}
	}else{	
		$soal = "DELETE FROM data_soal WHERE id_soal = '$id'";
		$jawaban = "DELETE FROM data_tier_1 WHERE fk_id_soal = '$id'";
		$id_jawaban = mysqli_query($connect,"SELECT * FROM data_tier_1 WHERE fk_id_soal = '$id'");

		while ($data = mysqli_fetch_array($id_jawaban)) {
			$fk = intval($data[0]);
			$alasan = "DELETE FROM data_tier_2 WHERE fk_id_tier_1 = '$fk'";
			hapus($alasan);
		}

		if (hapus($soal)&&hapus($jawaban)>0) {
			echo "<script>
				alert('Data berhasil dihapus');
				document.location.href = 'data-test.php';
			</script>";
		}else{
			echo "<script>
				alert('Data gagal dihapus');
				document.location.href = 'data-test.php';
			</script>";
		}
	}
?>