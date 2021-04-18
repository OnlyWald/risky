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
		if (isset($_POST['login'])) {
			$token = $_POST['token'];
			$cek_token = mysqli_fetch_assoc(mysqli_query($connect,"SELECT token FROM data_siswa WHERE token = '$token'"));

			if ($cek_token) {
				jump("ujian-wait.php?token=$token");
			}else{
				echo "<div class='alert alert-warning' role='alert'>
					 Token Salah!! ~ Masukan ulang token!
					</div>";
			}
		}
	?>
	
	<div class="konten d-flex align-content-center justify-content-center flex-wrap">
		<div class="card bg-light mb-3 mr-3 ml-3" style="width: 30rem;">
		  <div class="card-header">Login</div>
		  <div class="card-body">
		    <form method="POST">
		    	<div class="form-group">
					<label for="absen" class="font-weight-bold">Token</label>
				    <input type="text" class="form-control" id="absen" name="token" maxlength="5" required>
				</div>
				<div class="d-flex">
					<button type="button" class="btn btn-warning" onclick="window.location.href='ujian-regis.php'">BATAL</button>
					<button type="submit" class="btn btn-success d-flex ml-auto" name="login">MASUK</button>
				</div>
			</form>
		  </div>
		</div>
	</div>

<?php include("footer.php");?>