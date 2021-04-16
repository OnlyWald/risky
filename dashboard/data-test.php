<?php require_once ('../extend/header.php');?>
	<style type="text/css">
		.icon{
			font-size: 20px;
			margin: 5px;
		}
	</style>

	<div id="content"  width="100%"; style="margin: 40px 20px 20px 10px;">
		<a href="create-test.php">Create</a>
		<table class="table table-striped" width="95%;">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col" width="100px;">Kode</th>
		      <th scope="col" width="450px;">Soal</th>
		      <th scope="col" width="100px;">Gambar</th>
		      <th scope="col" width="100px;">Jawaban</th>
		      <th scope="col" width="100px;">Alasan</th>
		      <th scope="col">Aksi</th>
		    </tr>
		  </thead>
		  <tbody>
		  		<?php
					$sql = "SELECT * FROM data_soal";
					$query = mysqli_query($connect, $sql);
					$num = 1;

					while ($data = mysqli_fetch_array($query))
				{?>
		    <tr>
		      <th scope="row"><?=$num?></th>
		      <td><?php echo $data['kode_soal']?></td>
		      <td ><?php echo $data['text_soal']?></td>
		      <td><img src="../image/soal/<?= $data['img_soal']?>" width="50px;"></td>
		      <td><?php echo hitung("data_tier_1", "fk_id_soal", $data['id_soal']);?></td>
		      <td><?php 
		      			$fk = $data['id_soal'];
		      			$sql_ = "SELECT * from data_tier_1 where fk_id_soal = '$fk'";
						$query_ = mysqli_query($connect, $sql_);
						$i=0;
						while ($data_ = mysqli_fetch_array($query_)) {
							$count = hitung("data_tier_2", "fk_id_tier_1", $data_[0]);
							$i = $i + intval($count);
						} 
						echo $i;
		      		?>
		      </td>
		      <td>
		      		<a href="read-test.php?id=<?=$data['id_soal']?>" class="icon"><i class="fa fa-eye" aria-hidden="true" style="color: #00de0b"></i></a>
		      		<a href="delete-soal.php?id=<?=$data['id_soal']?>" class="icon"><i class="fa fa-trash" aria-hidden="true" style="color: #ed1111"></i></a>
		      </td>
		    </tr>
		    	<?php $num=$num+1;} ?>
		  </tbody>
		</table>
	</div>

<?php require_once('../extend/footer.php'); ?>