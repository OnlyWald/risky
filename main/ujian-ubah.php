<?php include("header.php");?>
	<?php 
		$token = $_GET['token'];

		$data = getData("SELECT * FROM data_siswa WHERE token = '$token'");

		if (isset($_POST['daftar'])) {
			$absen = $_POST['absen'];
			$nama = $_POST['nama'];
			$kelas = $_POST['kelas'];
			$id = $_POST['id'];

			//echo $absen." ".$nama." ".$kelas." ".$id." ".$token;
			$sql = "UPDATE data_siswa SET
				absen_siswa = '$absen',
				nama_siswa = '$nama',
				fk_id_kelas = '$kelas',
				token = '$token'
				WHERE id_siswa = '$id';
				";
			if (update($sql)>0) {
				header("location: ujian-wait.php?token=$token");
			}else{
				header("location: ujian-wait.php?token=$token");
			}
		}
	?>
	
	<div class="konten d-flex align-content-center justify-content-center flex-wrap">
		<div class="card bg-light mb-3 mr-3 ml-3" style="width: 30rem;">
		  <div class="card-header">Ubah Data Siswa</div>
		  <div class="card-body">
		    <form method="POST">
		    	<input type="hidden" name="id" value="<?=$data["id_siswa"];?>">
		    	<div class="form-group">
				  <label for="absen" class="font-weight-bold">Nomor Absen</label>
				    <input type="text" class="form-control" id="absen" name="absen" placeholder="Ex : 10" maxlength="3" required value="<?= $data['absen_siswa']?>">
				  </div>
				  <div class="form-group">
				    <label for="nama" class="font-weight-bold">Nama Lengkap</label>
				    <input type="text" class="form-control" id="nama" name="nama" placeholder="Ex : Joko Susanto" required value="<?= $data['nama_siswa']?>">
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
					 	<input id="token" name="token" class="form-control" type="text" placeholder="Token.." aria-label="readonly input example" readonly style="max-width: 10rem;" value="<?php echo $token;?>">
					 </div>
				</div>
				<div class="d-flex flex-row-reverse">
					<button type="submit" class="btn btn-success align-content-end" name="daftar" style="margin-left: 1rem;">UBAH DATA</button>
					<button type="button" class="btn btn-warning" onclick="window.location.href='ujian-wait.php?token=<?=$token;?>'">BATAL</button>
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