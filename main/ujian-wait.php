<?php include("header.php");?>
	<?php
		session_start();
		$token = $_GET['token'];

		$data = getData("SELECT * FROM data_siswa WHERE token = '$token'");

		$id_kelas = $data['fk_id_kelas'];

		$data_kelas = getData("SELECT * FROM data_kelas WHERE id_kelas = '$id_kelas'");

		$id_sekolah = $data_kelas['fk_id_sekolah'];

		$data_sekolah = getData("SELECT * FROM data_sekolah WHERE id_sekolah = '$id_sekolah'");

		if (isset($_POST['mulai'])) {
			$_SESSION['token'] = $token;
			jump("ujian-mulai.php");
			exit;
		}
	?>

	<div class="konten d-flex align-content-center justify-content-center flex-wrap">
		<div class="card bg-light mb-3 mr-1 ml-1" style="width: 35rem;">
		  <div class="card-header">DATA SISWA</div>
		  <div class="card-body">
		    <h6 class="judul font-weight-bold">Nama Lengkap</h6>
		    <h6 class="isi"><?=$data['nama_siswa'];?></h6>
		    <hr>
		    <h6 class="judul font-weight-bold">Absen</h6>
		    <h6 class="isi"><?=$data['absen_siswa'];?></h6>
		    <hr>
		    <h6 class="judul font-weight-bold">Sekolah</h6>
		    <h6 class="isi"><?=$data_sekolah['nama_sekolah'];?></h6>
		    <hr>
		    <h6 class="judul font-weight-bold">Kelas</h6>
		    <h6 class="isi"><?=$data_kelas['nama_kelas'];?></h6>
		    <hr>
		    <form method="POST">
		    	<div class="form-group font-weight-bold">
					<label for="token">Token</label>
					<input id="token" name="token" class="form-control" type="text" placeholder="Token.." aria-label="readonly input example" readonly style="max-width: 10rem;" value="<?php echo $data['token'];?>">
				</div>
			    <div class="d-flex flex-row-reverse">
			    	<button type="submit" class="btn btn-success" style="margin-left: 10px;" name="mulai">MULAI</button>  	
			    	<button type="button" class="btn btn-danger" onclick="window.location.href='ujian-ubah.php?token=<?=$data['token'];?>'">UBAH</button>
				</div>
			</form> 
		  </div>
		</div>
	</div>

<?php include("footer.php");?>