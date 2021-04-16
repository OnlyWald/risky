<?php require_once ('../extend/header.php');?>

	<?php
		$soal = $_GET['soal'];
		$id_jawaban = $_GET['id'];

		$data = query("SELECT * FROM data_tier_1 WHERE id_tier_1 = '$id_jawaban'")[0];	

		if (isset($_POST['submit'])) {
			$id = $_POST['id'];
			$atribut = $_POST['atribut'];
			$text = $_POST['jawaban'];
			$ekstensi = explode(".", $_FILES['img']['name']);
			$img = "jawaban-".round(microtime(true)).".".end($ekstensi);
			$sumber = $_FILES['img']['tmp_name'];
			$upload = move_uploaded_file($sumber, "../image/jawaban/".$img);

				if ($upload) {
					$query = "UPDATE data_tier_1 SET 
						text_tier_1 = '$text',
						img = '$img',
						atribut = '$atribut',
						fk_id_soal = '$soal'
						WHERE id_tier_1 = '$id'";

					if (update($query)>0) {
						echo "<script>
								alert('Data berhasil diedit');
								document.location.href = '../dashboard/read-test.php?id=".$soal."';
							</script>";
					}else{
						echo "<script>
							alert('Data gagal diedit');
							document.location.href = '../dashboard/read-test.php?id=".$soal."';
						</script>";
					}
				}else{
					$query = "UPDATE data_tier_1 SET 
						text_tier_1 = '$text',
						img = '',
						atribut = '$atribut',
						fk_id_soal = '$soal'
						WHERE id_tier_1 = '$id'";

					if (update($query)>0) {
						echo "<script>
								alert('Data berhasil diedit');
								document.location.href = '../dashboard/read-test.php?id=".$soal."';
							</script>";
					}else{
						echo "<script>
							alert('Data gagal diedit');
							document.location.href = '../dashboard/read-test.php?id=".$soal."';
						</script>";
					}
				}
		}
	?>

	<div id="content">
		<form action="" method="POST" enctype="multipart/form-data" style="margin-left: 20px; margin-right: 20px;">
			<div class="control-group jawaban">
				<div id="form-jawaban">
				    <label>Jawaban</label>
				    <div class="remove" style="margin-bottom: 10px;">
						<div class="wrap" style="display: flex;">
							<input type="hidden" name="id" value="<?=$data['id_tier_1'];?>">
						    <input type="text" name="jawaban" class="form-control" style="width: 800;"placeholder="Jawaban" value="<?= $data['text_tier_1']?>">
						    <select name="atribut" class="form-control" style="width: 150px; margin-left: 15px;" required>
						    	<option disabled="disabled" selected="selected">Atribut</option>
									<?php
										$sql = "SELECT * FROM atribut";
										$query = mysqli_query($connect, $sql);

										while ($data = mysqli_fetch_array($query)) {?>
										<option value="<?= $data['id']?>"><?= $data['atribut']?></option>
									<?php } ?>
							</select>
					    </div>
					    <div class="control-group">
							<label for="img_">Gambar</label>
							<input type="file" name="img" class="form-control" id="img_">
						</div>
					</div>
				</div>
			</div>
			<hr>
			<button class="btn btn-success" type="submit" name="submit">SIMPAN</button>
		</form>
	</div>

<?php require_once ('../extend/footer.php');?>