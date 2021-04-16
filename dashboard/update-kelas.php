<?php require_once ('../extend/header.php');?>

	<?php 
		$id = $_GET['id'];

		$data = query("SELECT * FROM data_kelas WHERE id_kelas = $id")[0];	

		if (isset($_POST['submit'])) {
			$nama = $_POST['kelas'];
			$id = $_POST['id'];
			$fk = $_POST['sekolah'];

			$query = "UPDATE data_kelas SET 
				nama_kelas = '$nama',
				fk_id_sekolah = '$fk' 
				WHERE id_kelas = '$id'";

			if (update($query)>0) {
				echo "<script>
						alert('Data berhasil diedit');
						document.location.href = '../dashboard/data-kelas.php';
					</script>";
			}else{
				echo "<script>
					alert('Data gagal diedit');
					document.location.href = '../dashboard/data-kelas.php';
				</script>";
			}
		}
	?>
	<style type="text/css">
		#content{
			margin-top: 40px;
		}
	</style>

	<div id="content" >
		<form method="post" style="display: flex;">
			<input type="hidden" name="id" value="<?=$data["id_kelas"];?>">
			<select name="sekolah">
				<?php
					$sql = "SELECT * FROM data_sekolah";
					$query = mysqli_query($connect, $sql);

					while ($data_ = mysqli_fetch_array($query)) {
				?>
					<option value="<?= $data_['id_sekolah']?>"><?= $data_['nama_sekolah']?></option>
				<?php } ?>
			</select>
			<input type="text" name="kelas" value="<?=$data['nama_kelas'];?>">
			<input type="submit" name="submit">
		</form>
	</div>

<?php require_once('../extend/footer.php'); ?>
