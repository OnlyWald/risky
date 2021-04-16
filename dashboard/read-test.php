<?php 
	$id = $_GET['id'];
	require_once ('../extend/header.php');
	$soal = "SELECT * FROM data_soal WHERE id_soal = '$id'";
?>
	<style type="text/css">
		.icon{
			font-size: 25px;
			margin: 5px;
		}
	</style>

	<div id="content" style="margin:45px 20px 20px 10px;">
		<div id="soal" style="display: flex; margin-bottom: 10px;">
			<div style="padding: 5px; border: 1px green solid; width: 100%;">
				<img id="currentPhoto" src="../image/soal/<?php echo select($soal)['img_soal']?>" onerror="this.onerror=null; if (this.src != 'Default.jpg') alt="" width="100">
				<div class="wrap" style="display: flex;">
					<p style="margin-right: 10px"><span class="badge badge-success"><?php echo select($soal)['kode_soal'];?></span></p>
					<p><?php echo select($soal)['text_soal'];?></p>
				</div>
			</div> 
			<a href="update-soal.php?id_soal=<?=$id?>" class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
		    <a href="delete-soal.php?id=<?=$id?>" class="icon"><i class="fa fa-trash" aria-hidden="true" style="color: #ed1111"></i></a>
		</div>
		<?php
			$jawaban = mysqli_query($connect, "SELECT * FROM data_tier_1 WHERE fk_id_soal = '$id'");

			while ( $data = mysqli_fetch_array($jawaban)) {
				$fk = $data['id_tier_1'];
		?>
			<div id="jawaban" style="display: flex; margin-bottom: 10px; margin-left: 5px;">
				<div style="padding: 5px; border: 1px blue solid; width: 100%; display: flex; align-items: center;">
					<img id="currentPhoto" src="../image/jawaban/<?= $data['img']?>" width="50" style="margin-right: 10px;">
					<h6 style="margin-right: 10px"><span class="badge badge-primary">
						<?php 
							$id_atribut = $data['atribut'];
							$atribut = "SELECT * FROM atribut WHERE id = '$id_atribut'";
							echo select($atribut)['atribut'];
						?>
					</span></h6>
					<h6><?php echo $data['text_tier_1'];?></h6>
				</div>

				<a href="update-jawaban.php?id=<?=$fk?>&soal=<?=$id?>" class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			    <a href="delete-jawaban.php?id=<?=$fk?>&soal=<?=$id?>" class="icon"><i class="fa fa-trash" aria-hidden="true" style="color: #ed1111"></i></a>
			</div>
			<?php
				$alasan = mysqli_query($connect, "SELECT * FROM data_tier_2 WHERE fk_id_tier_1 = '$fk'");

				while ( $data_ = mysqli_fetch_array($alasan)) {
			?>
				<div id="alasan" style="display: flex; margin-bottom: 10px; margin-left: 10px;">
					<div style="padding: 5px; border: 1px red solid; width: 100%; display: flex; align-items: center;">
						<img id="currentPhoto" src="../image/jawaban/<?= $data_['img']?>" width="50" style="margin-right: 10px;">
						<h6 style="margin-right: 10px"><span class="badge badge-danger">
							<?php 
								$id_atribut = $data_['atribut'];
								$atribut = "SELECT * FROM atribut WHERE id = '$id_atribut'";
								echo select($atribut)['atribut'];
							?>
						</span></h6>
						<h6><?php echo $data_['text_tier_2'];?></h6>
					</div>
					<a href="update-alasan.php?id=<?=$data_['id_tier_2']?>&soal=<?=$id?>" class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			    	<a href="delete-alasan.php?id=<?=$data_['id_tier_2']?>&soal=<?=$id?>" class="icon"><i class="fa fa-trash" aria-hidden="true" style="color: #ed1111"></i></a>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
<?php require_once ('../extend/footer.php');?>