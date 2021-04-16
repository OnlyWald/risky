<?php
	include("../server/config.php");

	$id = $_POST['id'];

	$sql = mysqli_query($connect, "SELECT * FROM data_kelas WHERE fk_id_sekolah = '$id' order by nama_kelas ASC")or die(mysqli_error($connect));
	$kelas = "<option>---Kelas---</option>";
	while ($data = mysqli_fetch_array($sql)) {
		$kelas.= "<option value=".$data['id_kelas'].">".$data['nama_kelas']."</option>";
	}

	echo $kelas;
?>