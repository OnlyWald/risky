<?php require "config.php"; ?>

<?php
	$id = $_GET['id'];
	$tabel = $_GET['tabel'];
	$id_ = $_GET['id_'];
	$path = $_GET['path'];
	$tabel_ = $_GET['tabel_'];
	$fk = $_GET['fk'];

	$query = "SELECT $fk FROM $tabel_ WHERE $fk = '$id'";

	$sql = mysqli_query($connect, $query);

	if (mysqli_fetch_assoc($sql)!=null) {
		$query = "DELETE FROM $tabel WHERE $id_ = $id";
		$query_ = "DELETE FROM $tabel_ WHERE $fk = $id";

		if (hapus($query)&&hapus($query_)>0) {
			echo "<script>
					alert('Data berhasil dihapus');
					document.location.href = '../dashboard/".$path."';
				</script>";
		}else{
			echo "<script>
					alert('Data gagal dihapus');
					document.location.href = '../dashboard/".$path."';
				</script>";
		}
	}else{
		$query = "DELETE FROM $tabel WHERE $id_ = $id";

		if (hapus($query)>0) {
			echo "<script>
					alert('Data berhasil dihapus');
					document.location.href = '../dashboard/".$path."';
				</script>";
		}else{
			echo "<script>
					alert('Data gagal dihapus');
					document.location.href = '../dashboard/".$path."';
				</script>";
		}
	}


?>