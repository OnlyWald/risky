<?php require_once ('../extend/header.php');?>

	<?php 
		if (isset($_POST['submit'])) {
			$text_soal = $_POST['soal'];
			$kode_soal = $_POST['kode_soal'];
			$ekstensi = explode(".", $_FILES['img']['name']);
			$img = "soal-".round(microtime(true)).".".end($ekstensi);
			$sumber = $_FILES['img']['tmp_name'];
			$upload = move_uploaded_file($sumber, "../image/soal/".$img);

			if (validasi("kode_soal","data_soal", $kode_soal)) {
				if ($upload) {
					$data = insert("INSERT INTO data_soal VALUES('', '$kode_soal', '$text_soal', '$img')");

					if ($data) {
						$query = getData("SELECT id_soal FROM data_soal WHERE kode_soal = '$kode_soal'");
						$id = $query['id_soal'];
						header("Location: jawaban.php?id=$id");
					}
				}else{
					$data = insert("INSERT INTO data_soal VALUES('', '$kode_soal', '$text_soal', '')");

					if ($data) {
						$query = getData("SELECT id_soal FROM data_soal WHERE kode_soal = '$kode_soal'");
						$id = $query['id_soal'];
						header("Location: jawaban.php?id=$id");
					}
				}
			}else{
				echo "	<div class='alert alert-warning'>
						  <strong>Warning!</strong> Data telah terpakai!!
						</div>";
			}			
		}
	?>

	<style type="text/css">
		#content{
			margin-top: 40px;
	</style>

	<div id="content">
		<form action="" method="POST" enctype="multipart/form-data" style="margin-left: 20px; margin-right: 20px;">
			<label for="kode">Kode Soal</label>
			<input type="text" name="kode_soal" class="form-control" style="width: 200px;" placeholder="Kode" id="kode" required maxlength="3">

			<div class="form-floating">
				<label for="floatingTextarea2">Soal</label>
				<textarea class="form-control" id="floatingTextarea2" style="height: 100px;" name="soal" placeholder="Soal"></textarea>
			</div>

			<div class="control-group">
				<label for="img_soal">Gambar Soal</label>
				<input type="file" name="img" class="form-control" id="img_soal">
			</div>
	    </div>
	    <hr>
	    <button class="btn btn-success" type="submit" name="submit" style="margin-left: 20px;" id="btn-next">Next</button>
	</form>
</div>
<?php require_once('../extend/footer.php'); ?>