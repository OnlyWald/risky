<?php require_once ('../extend/header.php');?>

	<?php
		if (isset($_POST['submit'])) {
			$sekolah = $_POST['sekolah'];
			$kelas = $_POST['kelas'];
			$sql = "INSERT INTO data_kelas VALUES('','$kelas','$sekolah')";

			if (insert($sql)>0) {
				echo "<script>
					alert('Data Berhasil Disimpan');
				</script>";
			}
		}
	?>

	<div id="content">
		<form method="post">
			<select name="sekolah">
			<?php
				$sql = "SELECT * FROM data_sekolah";
				$query = mysqli_query($connect, $sql);

				while ($data = mysqli_fetch_array($query)) {?>
				<option value="<?= $data['id_sekolah']?>"><?= $data['nama_sekolah']?></option>
			<?php } ?>
			</select>

			<input type="text" name="kelas">
			<input type="submit" name="submit">
		</form>

		<table border="1">
			<tr>
				<th>Id</th>
				<th>Nama Sekolah</th>
				<th>Nama Kelas</th>
				<th>Action</th>
			</tr>

				<?php
					$sql = "SELECT * FROM data_kelas";

					$query = mysqli_query($connect, $sql);

					while ($data = mysqli_fetch_array($query)) {
				?>

			<tr>
				<td><?php echo $data['id_kelas']?></td>
				<td><?php 	
						$data_id = $data['fk_id_sekolah'];
						$sql_ = "SELECT nama_sekolah FROM data_sekolah WHERE id_sekolah = '$data_id'";
						echo select($sql_)['nama_sekolah'];
					?>
				</td>
				<td><?php echo $data['nama_kelas']?></td>
				<td>
					<a href="../server/data-hapus.php?id=<?= $data['id_kelas'];?>&tabel=data_kelas&id_=id_kelas&path=data-kelas.php&tabel_=data_siswa&fk=fk_id_kelas">Hapus</a>
					<a href="update-kelas.php?id=<?= $data['id_kelas'];?>">Edit</a>
				</td>
			</tr>
				<?php } ?>
		</table>
	</div>

<?php require_once('../extend/footer.php');?>