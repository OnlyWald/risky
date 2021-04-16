<?php require "../server/config.php"; ?>

<?php
	$soal = $_GET['soal'];
	$id = $_GET['id'];

	if (hapus("DELETE FROM data_tier_2 WHERE id_tier_2 = '$id'")) {
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
?>