<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "data_pemahaman";

	$connect = new mysqli($host, $user, $pass, $db);


?>

<?php
	function daftar($data){
		//deklarasi koneksi
		global $connect;
		
		//inisialisasi variabel untuk dimasukan
		$nama = ucwords($data['nama']);
		$user = strtolower(stripcslashes($data['username']));
		$pass = $data['password'];

		//cek data username sudah atau belum
		$result = mysqli_query($connect, "SELECT username_admin FROM data_admin WHERE username_admin =	'$user'");

		if(mysqli_fetch_assoc($result)) {
			echo "<script>
					alert('Username Telah Terpakai!!');
				</script>";
			return false;
		}

		//pembuatan fungsi insert`
		mysqli_query($connect, "INSERT INTO data_admin VALUES('','$nama','$user','$pass')");

		//megembalikan nilai, jika insert berhasil maka nilai 1 jika salah 0
		return mysqli_affected_rows($connect);
	}

	function query($query){
		global $connect;
		
		$result = mysqli_query($connect, $query);
		$rows =[];
		while ($row = mysqli_fetch_assoc($result)) {
			$rows[] = $row;
		}

		return $rows;
	}

	function sekolah($data){
		global $connect;

		mysqli_query($connect, "INSERT INTO data_sekolah VALUES('', '$data')");

		return mysqli_affected_rows($connect);
	}

	function insert($query){
		global $connect;

		mysqli_query($connect, $query);

		return mysqli_affected_rows($connect);
	}

	function hapus($query){
		global $connect;

		mysqli_query($connect, $query);

		return mysqli_affected_rows($connect);
	}

	function update($query){
		global $connect;
		
		mysqli_query($connect, $query);

		return mysqli_affected_rows($connect);
	}

	function select($query){
		global $connect;

		$sql = mysqli_query($connect, $query);

		return mysqli_fetch_assoc($sql);
	}

	function cekData($query){
		if(mysqli_fetch_assoc($query)) {
			echo "<script>
					alert('Data Sudah Ada!!');
			</script>";
			return false;
		}
		return true;
	}

	function jawaban($text, $table, $atribut, $fk, $img){
		global $connect;

		$i = 0;
		$n = count($text);

		for ($i; $i<$n; $i++) {

			$ekstensi = explode(".", $img[$i]);
			$img = "jawaban-".round(microtime(true)).".".end($ekstensi);
			$sumber = $_FILES['img']['tmp_name'][$i];
			$upload = move_uploaded_file($sumber, "../image/jawaban/".$img);

			if ($upload) {
				$sql = mysqli_query($connect, "INSERT INTO $table VALUES('', '$text[$i]','$img', '$atribut[$i]', '$fk')");
			} else{
				$sql = mysqli_query($connect, "INSERT INTO $table VALUES('', '$text[$i]','', '$atribut[$i]', '$fk')");
			}
		}
		return mysqli_affected_rows($connect);
	}

	function getData($query){
		global $connect;

		$sql = mysqli_query($connect, $query);

		return mysqli_fetch_array($sql,MYSQLI_ASSOC);
	}

	function alert($msg) {
    	echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	function validasi($kolom, $table, $data){
		global $connect;
		
		$result = mysqli_query($connect, "SELECT $kolom FROM $table WHERE $kolom =	'$data'");

		if(mysqli_fetch_assoc($result)) {
			return false;
		}else{
			return true;
		}
	}

	function hitung($table, $kolom, $data){
		global $connect;

		$data = mysqli_query($connect,"SELECT * FROM $table WHERE $kolom = '$data'");
		$jumlah_data = mysqli_num_rows($data);
		
		return $jumlah_data;
	}

	function acak($panjang){
	    $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
	    $string = '';
	    for ($i = 0; $i < $panjang; $i++) {
		  $pos = rand(0, strlen($karakter)-1);
		  $string .= $karakter{$pos};
	    }
	    return $string;
	}

	function jump($dir){
		echo "<script>
				document.location.href = '".$dir."';
			</script>";
	}

	function kategori($id){
		$kategori = select("SELECT * FROM kategori WHERE id ='$id'")['kategori'];
		return $kategori;
	}
?>