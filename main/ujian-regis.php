<?php include("header.php");?>
	<style type="text/css">
		.alert{
		    position:fixed; 
		    top: 0px; 
		    left: 0px; 
		    width: 100%;
		    z-index:9999; 
		    border-radius:0px;
		}
	</style>
	<?php	
		if (isset($_POST['daftar'])) {
			$absen = $_POST['absen'];
			$nama = $_POST['nama'];
			$kelas = $_POST['kelas'];
			$token = $_POST['token'];
			$cek_token = mysqli_fetch_assoc(mysqli_query($connect,"SELECT token FROM data_siswa WHERE token = '$token'"));

			if ($cek_token) {
				echo "<div class='alert alert-warning' role='alert'>
					 Token sudah telah terpakai ~ Masukan ulang data!
					</div>";
			}else{
				if (insert("INSERT INTO data_siswa VALUES('','$absen','$nama', '$kelas', '$token')")){
					header("location: ujian-wait.php?token=$token");
				}else{
				echo "<div class='alert alert-warning' role='alert'>
					 Data gagal dimasukan ~ Masukan ulang data!
					</div>";
				}
			}
		}
	?>
	
	<div class="konten d-flex align-content-center justify-content-center flex-wrap">
		<div class="card bg-light mb-3 mr-3 ml-3" style="width: 30rem;">
		  <div class="card-header">Registrasi Siswa</div>
		  <div class="card-body">
		    <form method="POST">
		    	<div class="form-group">
				  <label for="absen" class="font-weight-bold">Nomor Absen</label>
				    <input type="text" class="form-control" id="absen" name="absen" placeholder="Ex : 10" maxlength="3" required>
				  </div>
				  <div class="form-group">
				    <label for="nama" class="font-weight-bold">Nama Lengkap</label>
				    <input type="text" class="form-control" id="nama" name="nama" placeholder="Ex : Joko Susanto" required>
				  </div>
				<div class="form-group">
					 <label for="sekolah" class="font-weight-bold">Pilih Sekolah</label>
					 <select class="form-control" id="sekolah" name="sekolah" required>
					   <option disabled="disabled" selected="selected">---Sekolah---</option>
						<?php
							$sekolah = mysqli_query($connect, "SELECT * FROM data_sekolah");

							while ($data_sekolah = mysqli_fetch_array($sekolah)) {
						?>
					   <option value="<?= $data_sekolah['id_sekolah']?>"><?= $data_sekolah['nama_sekolah']?></option>
					<?php } ?>
					 </select>
				</div>
				<div class="form-group">
					 <label for="kelas" class="font-weight-bold">Pilih Kelas</label>
					 <select class="form-control" id="kelas" name="kelas" required>
					   <option>---Kelas---</option>
					 </select>
				</div>
				<div class="d-flex">
					 <div class="form-group">
					 	<label for="token" class="font-weight-bold">Token</label>
					 	<input id="token" name="token" class="form-control" type="text" placeholder="Token.." aria-label="readonly input example" readonly style="max-width: 10rem;" value="<?php echo acak(5);?>">
					 </div>
				</div>
				<div class="d-flex">
					<div>
						<a href="ujian-login.php">Masuk Dengan Token</a>
					</div>
					<div class="d-flex ml-auto">
						<button type="submit" class="btn btn-success align-content-end" name="daftar">DAFTAR</button>
					</div>
				</div>
				
			</form>
		  </div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#sekolah').on('change', function(){
				var id_sekolah = $(this).val();
				$.ajax({
					url: 'ambil-data.php',
					type: 'POST',
					data:{
						id: id_sekolah
					},
					success:function(respond){
						$("#kelas").html(respond);
					},
					error:function(){
						alert("Gagal mengambil data");
					}
				})
			})
		})
	</script>
<?php include("footer.php");?>