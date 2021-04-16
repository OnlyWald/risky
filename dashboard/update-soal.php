<?php require_once ('../extend/header.php');?>
	<?php 
		$id_soal = $_GET['id_soal'];

		$data = query("SELECT * FROM data_soal WHERE id_soal = '$id_soal'")[0];	

		if (isset($_POST['submit'])) {
			$kode = $_POST['kode_soal'];
			$id = $_POST['id'];
			$text = $_POST['soal'];
			$ekstensi = explode(".", $_FILES['img']['name']);
			$img = "soal-".round(microtime(true)).".".end($ekstensi);
			$sumber = $_FILES['img']['tmp_name'];
			$upload = move_uploaded_file($sumber, "../image/soal/".$img);

				if ($upload) {
					$query = "UPDATE data_soal SET 
						kode_soal = '$kode',
						text_soal = '$text',
						img_soal = '$img'
						WHERE id_soal = '$id'";

					if (update($query)>0) {
						echo "<script>
								alert('Data berhasil diedit');
								document.location.href = '../dashboard/read-test.php?id=".$id_soal."';
							</script>";
					}else{
						echo "<script>
							alert('Data gagal diedit');
							document.location.href = '../dashboard/read-test.php?id=".$id_soal."';
						</script>";
					}
				}else{
					$query = "UPDATE data_soal SET 
						kode_soal = '$kode',
						text_soal = '$text',
						img_soal = ''
						WHERE id_soal = '$id'";

					if (update($query)>0) {
						echo "<script>
								alert('Data berhasil diedit');
								document.location.href = '../dashboard/read-test.php?id=".$id_soal."';
							</script>";
					}else{
						echo "<script>
							alert('Data gagal diedit');
							document.location.href = '../dashboard/read-test.php?id=".$id_soal."';
						</script>";
					}
				}
		}
	?>
	
	<div id="content">
		<form action="" method="POST" enctype="multipart/form-data" style="margin-left: 20px; margin-right: 20px;">
			<input type="hidden" name="id" value="<?=$id_soal;?>">

			<label for="kode">Kode Soal</label>
			<input type="text" name="kode_soal" class="form-control" style="width: 200px;" placeholder="Kode" id="kode" required maxlength="3" value="<?=$data['kode_soal'];?>">

			<div class="form-floating">
				<label for="floatingTextarea2">Soal</label>
				<textarea class="form-control" id="floatingTextarea2" style="height: 100px;" name="soal" placeholder="Soal"><?=$data['text_soal'];?></textarea>
			</div>

			<div class="control-group">
				<label for="img_soal">Gambar Soal</label>
				<input type="file" name="img" class="form-control" id="img_soal">
			</div>
		    <hr>
		    <button class="btn btn-success" type="submit" name="submit" style="margin-left: 20px;" id="btn-next">SIMPAN</button>
		</form>
	</div>

<?php require_once ('../extend/footer.php');?>