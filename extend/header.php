<?php require("../server/config.php");?>
<?php
	session_start();
    if (!isset($_SESSION['login'])){
        header("Location: login.php");
		exit;
   }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tes Pemahaman</title>
		<link rel="stylesheet" type="text/css" href="../extend/edit.css">

		<link rel="stylesheet" href="/test_pemahaman/assets/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../assets/bootstrap-4.6.0-dist/css/bootstrap.min.css">
		<script type="text/javascript" src="../assets/bootstrap-4.6.0-dist/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>

		<link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@600&display=swap" rel="stylesheet"> 
		<link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet"> 
		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
	</head>
	<body style="display: flex; background: #EEEEEE;">
		<div id="navbar">
			<img src="/test_pemahaman/assets/um.png" width="100px">
			<ul>
				<li><a href="/test_pemahaman/dashboard/home.php">
					<span><i class="fa fa-home" aria-hidden="true" style="font-size: 25px;"></i></span>
					<span class="text" style="margin-top: 3px;">HOME</span>
				</a></li>

				<li><a href="/test_pemahaman/dashboard/data-siswa.php">
					<span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
					<span class="text">DATA SISWA</span> 
				</a></li>

				<li><a href="/test_pemahaman/dashboard/data-sekolah.php">
					<span><i class="fa fa-university" aria-hidden="true"></i></span>
					<span class="text">DATA SEKOLAH</span>
				</a></li>

				<li><a href="/test_pemahaman/dashboard/data-kelas.php">
					<span><i class="fa fa-university" aria-hidden="true"></i></span>
					<span class="text">DATA KELAS</span>
				</a></li>

				<li><a href="/test_pemahaman/dashboard/data-test.php">
					<span><i class="fa fa-file-text" aria-hidden="true"></i></span>
					<span class="text">DATA TEST</span>
				</a></li>

				<li><a href="/test_pemahaman/dashboard/data-hasil.php">
					<span><i class="fa fa-file-text" aria-hidden="true"></i></span>
					<span class="text">DATA HASIL TEST</span>
				</a></li>

				<li><a href="/test_pemahaman/dashboard/data-admin.php">
					<span><i class="fa fa-user" aria-hidden="true" style="font-size: 25px;"></i></span>
					<span class="text" style="margin-top: 3px;">DATA ADMIN</span>
				</a></li>
			</ul>
		</div>

		<div id="r-side">
			<div id="header" style="background: transparent;">
				<div id="text-dashboard" style="display: flex;">
					<h1>Dashboard</h1>
					<i class="fa fa-book" aria-hidden="true"></i>
				</div>	
				<div id="text-nama" style="display: flex;">
					<h1 id="nama">Administration</h1>
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<a href="../dashboard/logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a>
			</div>