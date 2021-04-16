<?php require_once ('../extend/header.php');?>

	<?php 
		$id = $_GET['id'];

		$data = query("SELECT * FROM data_sekolah WHERE id_sekolah = $id")[0];

		if (isset($_POST['submit'])) {
			$nama = $_POST['sekolah'];
			$id = $_POST['id'];

			$query = "UPDATE data_sekolah SET 
				nama_sekolah = '$nama' 
				WHERE id_sekolah = $id
				";

			if (update($query)>0) {
				echo "<script>
						alert('Data berhasil diedit');
						document.location.href = '../dashboard/data-sekolah.php';
					</script>";
			}else{
				echo "<script>
					alert('Data gagal diedit');
					document.location.href = '../dashboard/data-sekolah.php';
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
			<input type="hidden" name="id" value="<?=$data["id_sekolah"];?>">
			<input type="text" name="sekolah" value="<?=$data['nama_sekolah'];?>">
			<input type="submit" name="submit">
		</form>
	</div>
<?php require_once('../extend/footer.php'); ?>
