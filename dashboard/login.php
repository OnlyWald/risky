<html>
<head>

	<title>Test Pemahaman</title>

	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

	<style type="text/css">
		@font-face{
			font-family: 'agency-fb';
			src: url(../assets/font/agency-fb/AgencyFB.ttf);
		}*{
			padding: 0px;
			margin: 0px;
		}body{
			background: #ffffff;
			display: flex;
		}

		#r-side{
			width: 60%;
			height: 650px;
		}#img-login{
			display: block;
			margin-left: auto;
			margin-right: auto;
		}h1{
			margin-top: 20px;
			font-family: 'agency-fb';
			font-size: 25px;
			color: #9B2056;
			text-align: center;
		}p{
			font-family: 'Raleway', sans-serif;
			color: #D77AAF;
			font-size: 20px;
			text-align: center;
		}

		#l-side{
			width: 40%;
			height: 100%;
			padding-top: 7%;
		}#img-logo{
			display: block;
			margin-left: auto;
			margin-right: auto;
			margin-bottom: 50px;
		}.input-text{
			border: none;
			border-bottom: 3px solid #777777;
			width: 80%;
			box-sizing: border-box;
			background: none;
			margin-bottom: 30px;
			font-size: 30px;
		}input{
			display: block;
			margin-left: auto;
			margin-right: auto;
		}::placeholder{
			color: #A5A5A5;
			font-size: 30px;
		}.img-input{
			position: absolute;
			margin-left: 32%;
			margin-top: -95px;
		}input[type=submit]{
			width: 80%;
			height: 50px;
			border: none;
			background-color: #A82E67;
			color: #FFFFFF;
			border-radius: 3px;
			font-size: 25px;
		}
	</style>

</head>
<body>
	<?php
		session_start();
		require "../server/config.php";

		if (isset($_POST['login'])) {
			//inisialisasi variable nilai form
			$user = $_POST['username'];
			$pass = $_POST['password'];

			//memilih data yang sama dengan username
			$result = mysqli_query($connect, "SELECT * FROM data_admin WHERE username_admin = '$user'");

			//cek username dan password
			if (mysqli_num_rows($result)) {
				$row = mysqli_fetch_assoc($result);
				if ($pass == $row['password_admin']) {
					//set session
					$_SESSION['login'] = true;

					header("Location: home.php");
					exit;
				}else{
					alert("Username atau password salah");
				}
			}else{
				alert("Username atau password salah");
			}
		}
	?>

	<div id="r-side">

		<h1>ADMIN LOGIN</h1>
		<p>Pastikan Username & Password Benar</p>

		<img id="img-login" width="650px" src="../assets/login-img.png">
	</div>

	<div id="l-side">
		<img id="img-logo" src="../assets/um.png" width="170px">

		<form method="post">
			<div id="username">
				<input class="input-text" type="text" name="username" placeholder="Username"><br>
			</div>
			<div id="pass">
				<input class="input-text" type="password" name="password" placeholder="Password"><br>
			</div>
			<input type="submit" name="login" value="MASUK">
		</form>
	</div>
</body>
</html>