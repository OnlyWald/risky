<?php require_once ('../extend/header.php');?>
	<?php
		if (isset($_POST['daftar'])) {
			if (daftar($_POST)>0) {
				echo "<script>
						alert('User Baru Telah Dibuat');
				</script>";
			}else{
				echo mysqli_error($connect);
			}
		}
	?>

	<style type="text/css">
		#content{
			width: 100%;
			padding-left: 35%;
			padding-top: 2%;
		}label{
			display: block;
			width: 70px;	
			font-family: 'Yusei Magic', sans-serif;
			margin-top: 3px;
			margin-bottom: 5px;
		}input{
			line-height: 30px;
			padding-left: 3px;
			width: 300px;
			border-radius: 5px;
			font-size: 20px;
		}.input-text{
			list-style: none;
			margin-bottom: 10px;
		}button{
			font-family: 'Montserrat', sans-serif;
			background: #A82E67;
			border:none;
			color: white;
			width: 300px;
			height: 30px;
			margin-left: 3px;
		}h2{
			font-family: 'Oswald', sans-serif;
			width: 300px;
			text-align: center;
		}
	</style>

	<div id="content" style="margin-top: 40px;">
		<h2>Daftar Admin Baru</h2>
		<form method="post">
			<ul>
				<li class="input-text">
					<label>Nama </label>
					<input type="text" name="nama">
				</li>

				<li class="input-text">
					<label>Username </label>
					<input type="text" name="username">
				</li>

				<li class="input-text">
					<label>Password </label>
					<input type="password" name="password">
				</li>

				<button type="submit" name="daftar">DAFTAR</button>
			</ul>
		</form>
	</div>
<?php require_once '../extend/footer.php';?>