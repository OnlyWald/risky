<?php require "../server/config.php"; ?>

<?php
	$soal = $_GET['soal'];
	$id = $_GET['id'];
	$validasi = mysqli_query($connect,"SELECT id_tier_2 FROM data_tier_2 WHERE fk_id_tier_1 = '$id'");


	if (mysqli_fetch_array($validasi)==null) {
		if (hapus("DELETE FROM data_tier_1 WHERE id_tier_1 = '$id'")) {
			echo "<script>
				alert('Data berhasil dihapus');
				document.location.href = 'read-test.php?id=".$soal."';
			</script>";
		}else{
			echo "<script>
				alert('Data gagal dihapus');
				document.location.href = 'read-test.php?id=".$soal."';
			</script>";
		}
	}else{	
		$jawaban = "DELETE FROM data_tier_1 WHERE id_tier_1 = '$id'";
		$alasan = "DELETE FROM data_tier_2 WHERE fk_id_tier_1 = '$id'";

		if (hapus($alasan)&&hapus($jawaban)>0) {
			echo "<script>
				alert('Data berhasil dihapus');
				document.location.href = 'read-test.php?id=".$soal."';
			</script>";
		}else{
			echo "<script>
				alert('Data gagal dihapus');
				document.location.href = 'read-test.php?id=".$soal."';
			</script>";
		}
	}
?>