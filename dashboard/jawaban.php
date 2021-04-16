<?php require_once ('../extend/header.php');?>

<?php
	$id = $_GET['id'];
	$soal = getData("SELECT * FROM data_soal WHERE id_soal = '$id'");

	if (isset($_POST['submit'])) {
		$jawaban = $_POST['jawaban'];
		$atribut = $_POST['atribut'];
		$img = $_FILES['img']['name'];

		if (jawaban($jawaban, "data_tier_1", $atribut, $id, $img)) {
			header("location: alasan.php?id=$id");
		}else{
			echo "gagal";
		}
	}
?>

<div id="content">
	<div id="soal" style="margin-left: 20px; margin-right: 20px; background: white; padding: 3px; margin-top: 50px;">
		<h4><?= $soal['kode_soal']?></h4>
		<img src="../image/soal/<?= $soal['img_soal']?>" width="100px;" alt="">
		<p><?= $soal['text_soal']?></p>
	</div>

	<form action="" method="POST" enctype="multipart/form-data" style="margin-left: 20px; margin-right: 20px;">
		<div class="control-group jawaban">
			<div id="form-jawaban">
			    <label>Jawaban</label>
			    <div class="remove" style="margin-bottom: 10px;">
					<div class="wrap" style="display: flex;">
					    <input type="text" name="jawaban[]" class="form-control" style="width: 800;"placeholder="Jawaban">
					    <select name="atribut[]" class="form-control" style="width: 150px; margin-left: 15px;" required>
					    	<option disabled="disabled" selected="selected">Atribut</option>
								<?php
									$sql = "SELECT * FROM atribut";
									$query = mysqli_query($connect, $sql);

									while ($data = mysqli_fetch_array($query)) {?>
									<option value="<?= $data['id']?>"><?= $data['atribut']?></option>
								<?php } ?>
						</select>
					<button class="btn btn-success btn-jawaban" type="button" style="margin-left: 15px;">
					         <i class="fa fa-plus" aria-hidden="true"></i>
					</button>
				    </div>
				    <div class="control-group">
						<label for="img_">Gambar</label>
						<input type="file" name="img[]" class="form-control" id="img_">
					</div>
				</div>
			</div>
		</div>
		<hr>
		<button class="btn btn-success" type="submit" name="submit">Next</button>
	</form>
</div>

<!-- fungsi javascript untuk menampilkan form dinamis  -->
	<!-- penjelasan :
	saat tombol add-more ditekan, maka akan memunculkan div dengan class copy -->
	<script>
		$(".btn-jawaban").click(function(){
			var a = `<div class="remove" style="margin-bottom: 10px;">
					<hr>
					 <label>Jawaban</label>
					<div class="wrap" style="display: flex;">
					    <input type="text" name="jawaban[]" class="form-control" style="width: 800;" placeholder="Jawaban">
					    <select name="atribut[]" class="form-control" style="width: 150px; margin-left: 15px;" required>
					    	<option disabled="disabled" selected="selected">Atribut</option>
								<?php
									$sql = "SELECT * FROM atribut";
									$query = mysqli_query($connect, $sql);

									while ($data = mysqli_fetch_array($query)) {?>
									<option value="<?= $data['id']?>"><?= $data['atribut']?></option>
								<?php } ?>
						</select>
					<button class="btn btn-danger hapus" style="margin-left: 15px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
				    </div>
				    <div class="control-group">
						<label for="img_soal">Gambar</label>
						<input type="file" name="img[]" class="form-control" id="img_soal">
					</div>
				</div>
          		`
			$("#form-jawaban").append(a);

			$(".hapus").click(function(){
				$(this).parents('.remove').remove();
			});
		});

	</script>
<?php require_once('../extend/footer.php');?>