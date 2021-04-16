<?php include("header.php");
	session_start();
	$token = $_SESSION['token'];

	if (!isset($_SESSION['token'])) {
		jump("ujian-regis.php");
	}

	if (isset($_SESSION['waktu'])) {
		//jika session sudah ada
		$telah_berlalu = time() - $_SESSION["waktu"];
	}else { 
        //jika session belum ada
        $_SESSION["waktu"]  = time();
        $telah_berlalu      = 0;
    }

    $data   = select("SELECT * FROM waktu WHERE id = 1");
 
    $temp_waktu = ($data['waktu']*60) - $telah_berlalu; //dijadikan detik dan dikurangi waktu yang berlalu
    $temp_menit = (int)($temp_waktu/60);                //dijadikan menit lagi
    $temp_detik = $temp_waktu%60;                       //sisa bagi untuk detik
     
    if ($temp_menit < 60) { 
        /* Apabila $temp_menit yang kurang dari 60 meni */
        $jam    = 0; 
        $menit  = $temp_menit; 
        $detik  = $temp_detik; 
    } else { 
        /* Apabila $temp_menit lebih dari 60 menit */           
        $jam    = (int)($temp_menit/60);    //$temp_menit dijadikan jam dengan dibagi 60 dan dibulatkan menjadi integer 
        $menit  = $temp_menit%60;           //$temp_menit diambil sisa bagi ($temp_menit%60) untuk menjadi menit
        $detik  = $temp_detik;
    }    
?>

	<script type="text/javascript">
        $(document).ready(function() {
            /** Membuat Waktu Mulai Hitung Mundur Dengan 
                * var detik;
                * var menit;
                * var jam;
            */
            var detik   = <?= $detik; ?>;
            var menit   = <?= $menit; ?>;
            var jam     = <?= $jam; ?>;
                  
            /**
               * Membuat function hitung() sebagai Penghitungan Waktu
            */
            function hitung() {
                /** setTimout(hitung, 1000) digunakan untuk 
                     * mengulang atau merefresh halaman selama 1000 (1 detik) 
                */
                setTimeout(hitung,1000);
  
                /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
                if(menit < 5 && jam == 0){
                    var peringatan = 'text-danger"';
                };
  
                /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
                $('#timer').html(
                    '<span class="badge badge-light '+peringatan+'" style="font-size: 15px; margin-left: 0.5rem;">'+ jam + ' : ' + menit + ' : ' + detik +'</span>'
                );
  
                /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
                detik --;
  
                /** Jika var detik < 0
                    * var detik akan dikembalikan ke 59
                    * Menit akan Berkurang 1
                */
                if(detik < 0) {
                    detik = 59;
                    menit --;
  
                   /** Jika menit < 0
                        * Maka menit akan dikembali ke 59
                        * Jam akan Berkurang 1
                    */
                    if(menit < 0) {
                        menit = 59;
                        jam --;
  
                        /** Jika var jam < 0
                            * clearInterval() Memberhentikan Interval dan submit secara otomatis
                        */
                             
                        if(jam < 0) { 
                            clearInterval(hitung); 
                            /** Variable yang digunakan untuk submit secara otomatis di Form */
                            var frmSoal = document.getElementById("frmSoal"); 
                            alert('Waktu Anda telah habis, Jika ingin mencoba lagi silahkan dihapus dulu SESSION browser anda');
                            frmSoal.submit(); 
                        } 
                    } 
                } 
            }           
            /** Menjalankan Function Hitung Waktu Mundur */
            hitung();
        });
    </script>

	<div id="ujian">
		<div class="header bg-primary sticky-top">
			<h4 class="mr-auto p-2 bd-highlight text-light"><?php
				echo select("SELECT * FROM data_siswa WHERE token = '$token'")['nama_siswa'];
			?></h4>
		</div>
		<?php
			$batas = 1;
			$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
			$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;

            $previous = $halaman - 1;
			$next = $halaman + 1;

			$soal = mysqli_query($connect, "SELECT * from data_soal ORDER BY RAND ()");
            
			$jumlah_data = mysqli_num_rows($soal);
			$total_halaman = ceil($jumlah_data / $batas);

			$data_soal = mysqli_query($connect,"SELECT * from data_soal limit $halaman_awal, $batas");
			$nomor = $halaman_awal+1;
			while ($data = mysqli_fetch_assoc($data_soal)) {
				$id_soal = $data['id_soal'];
				$text_soal = $data['text_soal'];
				$img_soal = $data['img_soal'];
		?>
		<div class="d-flex justify-content-center mt-4" style="width: 100%; padding-left: 1rem; padding-right: 1rem">
			<div class="card border-dark mb-3 align-self-baseline" style="width: 80rem;" >
			  <div class="card-header bg-transparent border-dark d-flex" >
			  	<span class="badge badge-primary d-flex align-items-center justify-content-center" style="height: 2.5rem; font-size: 15px; max-width: 10rem;">
			  		Soal No.
			  		<span class="badge badge-light mr-auto bd-highlight" style="font-size: 15px; margin-left: 0.5rem;"><?php echo $halaman."/".$jumlah_data?></span>
			  	</span>
			  	<span class="badge badge-danger d-flex align-items-center justify-content-center ml-auto bd-highlight" style="height: 2.5rem; font-size: 15px; max-width: 12rem;">
			  		Sisa Waktu :
			  		<div id="timer"></div>
			  	</span>
			  </div>
			  	<form method="POST" action="" id="frmSoal">
			  	<div class="card-body text-dark">

			  	<?php
			  		if (!empty($text_soal)&&empty($img_soal)) {
			  			echo "<h5 class='soal'>".$text_soal."</h5><hr>";
			  		}elseif (!empty($img_soal)&&empty($text_soal)) {
			  			echo '<img src="../image/soal/'.$img_soal.'" class="img-fluid" alt="" style="max-height: 5rem; max-width: auto;"><hr>';
			  		}elseif (!empty($text_soal)&&!empty($img_soal)) {
			  			echo "<h5 class='soal'>".$text_soal."</h5>";
			  			echo '<img src="../image/soal/'.$img_soal.'" class="img-fluid" alt="" style="max-height: 5rem; max-width: auto;"><hr>';
			  		}else{
			  			echo "Soal tidak ditemukan";
			  		}
			  	?>

			  		<input type="hidden" name="id_soal" value="<?= $id_soal?>">
			  		<?php
			  			$jawaban = mysqli_query($connect, "SELECT * from data_tier_1 WHERE fk_id_soal = '$id_soal' ORDER BY RAND ()");
						while ($ans = mysqli_fetch_assoc($jawaban)) {
							$id_ans = $ans['id_tier_1'];
							$text_ans = $ans['text_tier_1'];
							$img_ans = $ans['img'];
			  		?>
				  	<div id="jawaban">
				  		<div class="form-check">
							<input class="form-check-input" type="radio" name="jawaban" id="ans" value="<?= $id_ans;?>" data-toggle="collapse" data-target="#alasan<?=$id_ans?>" aria-expanded="true" aria-controls="alasan<?=$id_ans?>" required>
							<label>
							 	<?php
									if (!empty($text_ans)&&empty($img_ans)) {
								  		echo "<h5 class='soal'>".$text_ans."</h5>";
								  	}elseif (!empty($img_ans)&&empty($text_ans)) {
								  		echo '<img src="../image/jawaban/'.$img_ans.'" class="img-fluid" alt="" style="max-height: 5rem; max-width: auto;">';
								  	}elseif (!empty($text_ans)&&!empty($img_ans)) {
								  		echo "<h5 class='soal'>".$text_ans."</h5>";
								  		echo '<img src="../image/jawaban/'.$img_ans.'" class="img-fluid" alt="" style="max-height: 5rem; max-width: auto;">';
								  	}else{
								  		echo "Soal tidak ditemukan";
								  	}
								?>
							</label>
						</div>
				  	</div>

					  	<?php
					  		$alasan = mysqli_query($connect, "SELECT * from data_tier_2 WHERE fk_id_tier_1 = '$id_ans' ORDER BY RAND ()");
							while ($rea = mysqli_fetch_assoc($alasan)) {
								$id_rea = $rea['id_tier_2'];
								$text_rea = $rea['text_tier_2'];
								$img_rea = $rea['img'];
				  		?>

						<div class="collapse" id="alasan<?=$rea['fk_id_tier_1']?>">
						  	<div class="form-check ml-3">
								<input class="form-check-input" type="radio" name="alasan" id="rea" value="<?= $id_rea;?>" required>
								<label>
									<?php
										  if (!empty($text_rea)&&empty($img_rea)) {
									  		echo "<h5 class='soal'>".$text_rea."</h5>";
									  	}elseif (!empty($img_rea)&&empty($text_rea)) {
									  		echo '<img src="../image/jawaban/'.$img_rea.'" class="img-fluid" alt="" style="max-height: 5rem; max-width: auto;">';
									  	}elseif (!empty($text_rea)&&!empty($img_rea)) {
									  		echo "<h5 class='soal'>".$text_rea."</h5>";
									  		echo '<img src="../image/jawaban/'.$img_rea.'" class="img-fluid" alt="" style="max-height: 5rem; max-width: auto;">';
									  	}else{
									  		echo "Soal tidak ditemukan";
									  	}
									?>
								</label>
							</div>
						</div>

						<?php } ?>

						<div class="collapse" id="alasan<?=$id_ans?>">
							<div class="form-check ml-3 d-flex">
					  			<input class="form-check-input" type="radio" name="alasan" id="rea" value="" required>
					  			<label><h5>Alasan Lain: </h5></label>
					  			<input class="form-control ml-3" type="text" name="other_reason<?=$id_ans?>" style="width: 20rem;" />
					  		</div>
				  		</div>

			  		<?php } ?>
				  							  			
			  		<div id="jawaban">
						<div class="form-check d-flex">
				  			<input class="form-check-input" type="radio" name="jawaban" id="rea" value="" data-toggle="collapse" data-target="#alasan" aria-expanded="true" aria-controls="alasan<" required>
				  			<label><h5>Jawaban Lain: </h5></label> 
				  			<input class="form-control ml-3" type="text" name="other_answer" style="width: 20rem;"/>
				  		</div>
					</div>
					<div class="collapse" id="alasan">
						<div class="form-check ml-3 d-flex">
				  			<input class="form-check-input" type="radio" name="alasan" id="rea" value="" required>
				  			<label><h5>Alasan Lain: </h5></label> 
				  			<input class="form-control ml-3" type="text" name="other_reason" style="width: 20rem;" />
				  		</div>
			  		</div>
					<div class="card-footer bg-transparent border-dark d-flex align-items-center" style="width: 100%">

						<a class="btn btn-success mr-auto d-flex" href="<?php if($halaman > 1){ echo "ujian-mulai.php?halaman=$previous"; } ?>" role="button" style="max-width: 7rem">KEMBALI</a>

							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-secondary active ml-2 bg-primary">
									<input type="radio" name="yakin" id="option1" autocomplete="off" value="1" required> Yakin
								</label>
								<label class="btn btn-secondary mr-2 bg-primary">
									<input type="radio" name="yakin" id="option2" autocomplete="off" value="2" required> Tidak Yakin
								</label>
							</div>

						<button type="submit" name="submit" class="btn btn-success ml-auto d-flex" style="max-width: 5rem">LANJUT</button>
					</div>
			  	</form>
			  </div>
			</div>
		</div>
	</div>

	<?php }	?>
	
	<?php
		if (isset($_POST['submit'])){
			$jawaban = $_POST['jawaban'];
			$jawaban_lain = $_POST['other_answer'];
			$alasan = $_POST['alasan'];
			$alasan_lain = $_POST['other_reason'];
			$yakin = $_POST['yakin'];
			$id_siswa = select("SELECT * FROM data_siswa WHERE token = '$token'")['id_siswa'];
			$id_soal = $_POST['id_soal'];
			$nama = "other_reason".$jawaban;
			$waktu_submit = date("Y-m-d h:i:sa");
			$cek_jawaban = select("SELECT * FROM data_hasil WHERE fk_id_soal = '$id_soal' && fk_id_siswa = '$id_siswa'");
			$cek_ans = select("SELECT * FROM jawaban_lain WHERE fk_soal = '$id_soal' && fk_siswa = '$id_siswa'");
			$cek_rea = select("SELECT * FROM alasan_lain WHERE fk_soal = '$id_soal' && fk_siswa = '$id_siswa'");

			if ($cek_jawaban) {
				if ($jawaban==null) {
					if ($cek_ans && $cek_rea) {
						$sql_rea = "UPDATE alasan_lain 
								SET alasan = '$alasan_lain'
								WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'";
						$sql_ans = "UPDATE jawaban_lain 
								SET jawaban = '$jawaban_lain'
								WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'";
					}else if ($cek_rea || $cek_ans) {
						$sql_rea = "UPDATE alasan_lain 
								SET alasan = '$alasan_lain'
								WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'";
						$sql_ans = "INSERT INTO jawaban_lain 
									VALUES('','$jawaban_lain','$id_soal','$id_siswa')";
					}else{
						$sql_rea = "INSERT INTO alasan_lain 
									VALUES('','$alasan_lain','$id_soal','$id_siswa')";
						$sql_ans = "INSERT INTO jawaban_lain 
									VALUES('','$jawaban_lain','$id_soal','$id_siswa')";
					}
					

					if (insert($sql_ans)&&insert($sql_rea)) {
						$data_rea = select("SELECT * FROM alasan_lain WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'")['id'];
						$data_ans = select("SELECT * FROM jawaban_lain WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'")['id'];
						$sql_hasil = "	UPDATE data_hasil 
										SET hasil_pemahaman = 'Tidak Terdefinisi', hasil_tier_1 = '', hasil_tier_2 = '', hasil_tier_3 = '$yakin', hasil_tier_1_lain = '$data_ans', hasil_tier_2_lain = '$data_rea', waktu = '$waktu_submit'
										WHERE fk_id_soal = '$id_soal' AND fk_id_siswa = '$id_siswa'";
						if (insert($sql_hasil)) {
							if($halaman < $total_halaman) { 
								jump('ujian-mulai.php?halaman='.$next);
							}else{
								jump('ujian-wait.php');
							}
						}
					}
				}else{
					$alasan_ = $_POST[$nama];

					if ($alasan==null){ 

						if ($cek_rea) {
							$sql_rea = "UPDATE alasan_lain 
									SET alasan = '$alasan_'
									WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'";
						}else{
							$sql_rea = "INSERT INTO alasan_lain 
									VALUES('','$alasan_','$id_soal','$id_siswa')";
						}

						if (insert($sql_rea)){
							$data_rea = select("SELECT * FROM alasan_lain WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'")['id'];
							$sql_hasil = "	UPDATE data_hasil 
											SET hasil_pemahaman = 'Tidak Terdefinisi', 
												hasil_tier_1 = '$jawaban', 
												hasil_tier_2 = '', 
												hasil_tier_3 = '$yakin', 
												hasil_tier_1_lain = '', 
												hasil_tier_2_lain = '$data_rea', 
												waktu = '$waktu_submit'
											WHERE 	fk_id_soal = '$id_soal' AND 
													fk_id_siswa = '$id_siswa'";
							if (insert($sql_hasil)) {
								if($halaman < $total_halaman) { 
									jump('ujian-mulai.php?halaman='.$next);
								}else{
									jump('ujian-wait.php');
								}
							}
						}
					}else{
						$result_ans = select("SELECT * FROM data_tier_1 WHERE id_tier_1 = '$jawaban'")['atribut'];
						$result_rea = select("SELECT * FROM data_tier_2 WHERE id_tier_2 = '$alasan'")['atribut'];

						if ($result_ans == 1 && $result_rea == 1 && $yakin == 1) {
							$pemahamanan = kategori('1');
						}else if ($result_ans == 1 && $result_rea == 1 && $yakin == 2) {
							$pemahamanan = kategori('2');
						}else if ($result_ans == 2 && $result_rea == 2 && $yakin == 2) {
							$pemahamanan = kategori('3');
						}else if ($result_ans == 1 && $result_rea == 2 && $yakin == 2 || $result_ans == 2 && $result_rea == 1 && $yakin == 2 || $result_ans == 1 && $result_rea == 2 && $yakin == 1) {
							$pemahamanan = kategori('4');
						}else if ($result_ans == 2 && $result_rea == 1 && $yakin == 1 || $result_ans == 2 && $result_rea == 2 && $yakin == 1) {
							$pemahamanan = kategori('5');
						}

						$sql_hasil = "	UPDATE data_hasil 
										SET hasil_pemahaman = '$pemahamanan', hasil_tier_1 = '$jawaban', hasil_tier_2 = '$alasan', hasil_tier_3 = '$yakin', hasil_tier_1_lain = '', hasil_tier_2_lain = '', waktu = '$waktu_submit'
										WHERE fk_id_soal = '$id_soal' AND fk_id_siswa = '$id_siswa'";
						if (insert($sql_hasil)) {
							if($halaman < $total_halaman) { 
								jump('ujian-mulai.php?halaman='.$next);
							}else{
								jump('ujian-wait.php');
							}
						}
					}
				}
			}else{
				if ($jawaban==null) {
					$sql_rea = "INSERT INTO alasan_lain VALUES('','$alasan_lain','$id_soal','$id_siswa')";
					$sql_ans = "INSERT INTO jawaban_lain VALUES('','$jawaban_lain','$id_soal','$id_siswa')";

					if (insert($sql_ans)&&insert($sql_rea)) {
						$data_rea = select("SELECT * FROM alasan_lain WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'")['id'];
						$data_ans = select("SELECT * FROM jawaban_lain WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'")['id'];
						$sql_hasil = "INSERT INTO data_hasil VALUES('','$id_soal','$id_siswa','Tidak Terdefinisi','','','$yakin','$data_ans','$data_rea','$waktu_submit')";
						if (insert($sql_hasil)) {
							if($halaman < $total_halaman) { 
								jump('ujian-mulai.php?halaman='.$next);
							}else{
								jump('ujian-wait.php');
							}
						}
					}
				}else{
					$alasan_ = $_POST[$nama];
					if ($alasan==null){ 
						$sql_rea = "INSERT INTO alasan_lain VALUES('','$alasan_','$id_soal','$id_siswa')";

						if (insert($sql_rea)){
							$data_rea = select("SELECT * FROM alasan_lain WHERE fk_soal = '$id_soal' AND fk_siswa = '$id_siswa'")['id'];
							$sql_hasil = "INSERT INTO data_hasil VALUES('','$id_soal','$id_siswa','Tidak Terdefinisi','$jawaban','','$yakin','','$data_rea','$waktu_submit')";
							if (insert($sql_hasil)) {
								if($halaman < $total_halaman) { 
									jump('ujian-mulai.php?halaman='.$next);
								}else{
									jump('ujian-wait.php');
								}
							}
						}
					}else{
						$result_ans = select("SELECT * FROM data_tier_1 WHERE id_tier_1 = '$jawaban'")['atribut'];
						$result_rea = select("SELECT * FROM data_tier_2 WHERE id_tier_2 = '$alasan'")['atribut'];

						if ($result_ans == 1 && $result_rea == 1 && $yakin == 1) {
							$pemahamanan = kategori('1');
						}else if ($result_ans == 1 && $result_rea == 1 && $yakin == 2) {
							$pemahamanan = kategori('2');
						}else if ($result_ans == 2 && $result_rea == 2 && $yakin == 2) {
							$pemahamanan = kategori('3');
						}else if ($result_ans == 1 && $result_rea == 2 && $yakin == 2 || $result_ans == 2 && $result_rea == 1 && $yakin == 2 || $result_ans == 1 && $result_rea == 2 && $yakin == 1) {
							$pemahamanan = kategori('4');
						}else if ($result_ans == 2 && $result_rea == 1 && $yakin == 1 || $result_ans == 2 && $result_rea == 2 && $yakin == 1) {
							$pemahamanan = kategori('5');
						}

						$sql_hasil = "INSERT INTO data_hasil VALUES('','$id_soal','$id_siswa','$pemahamanan','$jawaban','$alasan','$yakin','','','$waktu_submit')";

						if (insert($sql_hasil)) {
							if($halaman < $total_halaman) { 
								jump('ujian-mulai.php?halaman='.$next);
							}else{
								jump('ujian-wait.php');
							}
						}
					}
				}
			}
		}
	?>

<?php include("footer.php");?>