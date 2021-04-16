<?php require_once ('../extend/header.php');?>

	<?php 
		if (isset($_POST['submit'])) {
			$sekolah =$_POST['sekolah'];
			$query = mysqli_query($connect, "SELECT nama_sekolah FROM data_sekolah WHERE nama_sekolah =	'$sekolah'");
			if (cekData($query)) {
				if (sekolah($_POST['sekolah'])>0) {
					echo "<script>
						alert('Data berhasil disimpan');
					</script>";
				}else{
					echo mysqli_error($connect);
				}
			}
		}
	?>
	<style type="text/css">


	</style>

	<div id="content" >
		<form method="post" style="display: flex;">
			<input type="text" name="sekolah">
			<input type="submit" name="submit">
		</form>
		
			<table border="1">
				<tr>
					<th>Id</th>
					<th>Nama Sekolah</th>
					<th>Action</th>
				</tr>
				<?php
					$sql = "SELECT * FROM data_sekolah";
					$query = mysqli_query($connect, $sql);

					while ($data = mysqli_fetch_array($query)) {?>
					<tr>
						<td><?php echo $data['id_sekolah']?></td>
						<td><?php echo $data['nama_sekolah']?></td">
						<td>
							<a href="../server/data-hapus.php?id=<?= $data['id_sekolah'];?>&tabel=data_sekolah&id_=id_sekolah&path=data-sekolah.php&tabel_=data_kelas&fk=fk_id_sekolah">Hapus</a>
							<a href="update-sekolah.php?id=<?= $data['id_sekolah'];?>">Edit</a>
						</td>
					</tr>
				<?php } ?>
			</table>
	</div>
<?php require_once('../extend/footer.php'); ?>
