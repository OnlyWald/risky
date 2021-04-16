<?php require_once ('../extend/header.php');?>

	<?php
		$id = $_GET['id'];
		$sql = mysqli_query($connect, "SELECT * FROM data_tier_1 WHERE fk_id_soal = '$id'");
		$soal = getData("SELECT * FROM data_soal WHERE id_soal = '$id'");
		$sql_ = "SELECT * FROM atribut";
		$query = mysqli_query($connect, $sql_);
	?>

	<div id="content">
			<?php 
				$batas = 1;
				$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
				$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;

                $previous = $halaman - 1;
				$next = $halaman + 1;

                $data = mysqli_query($connect,"select * from data_tier_1 where fk_id_soal = '$id'");
				$jumlah_data = mysqli_num_rows($data);
				$total_halaman = ceil($jumlah_data / $batas);

				$data_tier_1 = mysqli_query($connect,"select * from data_tier_1 where fk_id_soal = '$id' limit $halaman_awal, $batas");
				$nomor = $halaman_awal+1;

				while ($data = mysqli_fetch_array($data_tier_1)) { 
			?>
			<div id="wrap" style="display: flex;">
				<div style="margin-left: 20px; margin-right: 20px;width: 50%; margin-top: 10px;">
					<span class="badge badge-secondary">Soal</span>
					<div id="soal" style=" background: white; padding: 3px; ">
						<h4><?= $soal['kode_soal']?></h4>
						<img src="../image/soal/<?= $soal['img_soal']?>" height="100px;" alt="">
						<p><?= $soal['text_soal']?></p>
					</div>
				</div>		
				<div style="margin-left: 20px; margin-right: 20px;  width: 50%; margin-top: 10px;">
					<span class="badge badge-secondary">Jawaban</span>	
					<div id="jawaban" style="background: white; padding: 3px;">
						<img src="../image/jawaban/<?= $data['img']?>" height="100px" alt="">	
						<div id="text" style="display: flex; margin-top: 5px;">
							<label style="background: #3661bf; padding-left: 10px; padding-right: 10px; color: white; margin-right:10px;"><?php $atribut = $data['atribut'];
								echo getData("SELECT atribut FROM atribut WHERE id = '$atribut'")['atribut'];?>
							</label>
							<p><?= $data['text_tier_1']?></p>
						</div>
					</div>
				</div>
			</div>
			<form action="" method="POST" enctype="multipart/form-data" style="margin-left: 20px; margin-right: 20px;">
				<div class="control-group jawaban">
					<div id="form-jawaban">
					    <label>Alasan</label>
					    <div class="remove" style="margin-bottom: 10px;">
							<div class="wrap" style="display: flex;">
							    <input type="text" name="alasan[]" class="form-control" style="width: 800;"placeholder="Alasan">
							    <select name="atribut[]" class="form-control" style="width: 150px; margin-left: 15px;" required>
							    	<option disabled="disabled" selected="selected">Atribut</option>
										<?php while ($atribut = mysqli_fetch_array($query)) { ?>
											<option value="<?= $atribut['id']?>"><?= $atribut['atribut']?></option>
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
				<button class="btn btn-success" type="submit" name="submit">SIMPAN</button>
			</form>		
			<?php
				if (isset($_POST['submit'])) {
					$id_jawaban = $data['id_tier_1'];
					$img = $_FILES['img']['name'];
					$alasan = $_POST['alasan'];

					if (isset($_POST['atribut'])) {
						$atribut = $_POST['atribut'];

						if (jawaban($alasan, "data_tier_2", $atribut, $id_jawaban, $img)) {
							alert("Data Berhasil Disimpan");
							if($halaman < $total_halaman) { 
								jump('alasan.php?halaman='.$next.'&id='.$id);
							}else{
								jump("data-test.php");
							}
						}else{
							alert("Data Gagal Disimpan");
						}
					}
				}
			?>
		<?php }?>	
	</div>

	<!-- fungsi javascript untuk menampilkan form dinamis  -->
	<!-- penjelasan :
	saat tombol add-more ditekan, maka akan memunculkan div dengan class copy -->
	<script>
		$(".btn-jawaban").click(function(){
			var a = `<div class="remove" style="margin-bottom: 10px;">
					<hr>
					 <label>Alasan</label>
					<div class="wrap" style="display: flex;">
					    <input type="text" name="alasan[]" class="form-control" style="width: 800;" placeholder="Alasan">
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
<?php require_once('../extend/footer.php'); ?>