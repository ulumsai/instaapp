<?php

	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk mengosngkan filed pencarian teman jika ada
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=edit.profil");
		exit();
	}

	// inisialisasi variabel yang akan digunakan pada form
	$nama_depan = $nama_belakang = $email = $username = $jenis_kelamin ='';
	$namaErr = $emailErr = $usernameErr = $jenis_kelaminErr='';
	$L_cek = $P_cek = '';
	$class_nama_d = $class_nama_b = $class_email = $class_username = $class_gender = '';
	$error=false;
	
	include 'config/function.php';	// memanggil file fungsi
		
	$username = $_SESSION['user']; // untuk ambil username pengguna
	$usernameErr = "*username tidak dapat diubah";	// set error username, karena tidak dapat diubah
	
	// cek jika aksi form dengen methos post dijalankan
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		// jika menekan tombol update profil
		if(isset($_POST['updateProfil'])){
			$error = cekNamaDepan();		// cek validasi nama depan
			$error = cekNamaBelakang();		// cek validasi nama belakang
	        $error = cekEmail('2');			// cek validasi email
			$error = cekgender(); 			// cek validasi jenis kelamin
			if($error === false){
				updateProfil();				// jika benar maka akan memanggil fungsi update profil, untuk update data di  database
			}
		}	
	}else{

		// untuk mengambil data user, yang nanti akna ditampilkan pada form edit profil
		$data = $koneksi->query("SELECT * FROM user WHERE username ='$username' ");
		foreach ($data as $key => $value) {
			$nama_depan = $value['nama_depan'];
			$nama_belakang = $value['nama_belakang'];
			$email = $value['email'];
			$jenis_kelamin = $value['jenis_kelamin'];
			switch ($jenis_kelamin) {
				case 'L':$L_cek='checked'; break;
				case 'P':$P_cek='checked'; break;
			}
		}
	}
?>
<!-- MAIN CONTENT EDIT PROFIL -->
<div class="main-edit">
	<div class="form-edit">
		<div class="form-white-edit">
			<div class="title">
				<h1 class="title">Edit Profil</h1>
			</div>
			<hr class="line">
			<form class="form-reg" method="POST" action="./?page=edit.profil">

				<!-- menampilkan field nama depan dan nama belakang -->
				<div class="row-edit">
					<div class="col-edit col-half-left">
						<input class="in-text <?php echo "$class_nama_d"; ?>" type="text" name="nama_depan" placeholder="Nama depan" value="<?php echo $nama_depan; ?>">
					</div>
					<div class="col-edit col-half-right">
						<input class="in-text <?php echo "$class_nama_b"; ?>" type="text" name="nama_belakang" placeholder="Nama belakang" value="<?php echo $nama_belakang; ?>">
					</div>
					<p class="reg-error"><?php echo $namaErr; ?></p>
				</div>

				<!-- menampilkan field email -->
				<div class="row-edit">
					<div class="col-edit">
						<input class="in-text <?php echo "$class_email"; ?>" type="text" name="email" placeholder="Alamat email" value="<?php echo $email; ?>">
					</div>
					<p class="reg-error"><?php echo $emailErr; ?></p>
				</div>
				
				<!-- menampilkan field username -->
				<div class="row-edit">
					<div class="col-edit">
						<input class="in-text <?php echo "$class_username"; ?>" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" disabled>
					</div>
					<p class="reg-error"><?php echo $usernameErr; ?></p>
				</div>
				
				<!-- menampilkan field jenis kelamin -->
				<div class="row-edit">
					<p class="title2-top label-gender">Jenis kelamin</p>
					<div class="col-reg <?php echo $class_gender; ?>" >
						<input type="radio" name="gender" value="L" <?php echo $L_cek; ?>> Laki-laki
						<input type="radio" name="gender" value="P" <?php echo $P_cek; ?>> Perempuan		
					</div>
					<p class="reg-error"><?php echo $jenis_kelaminErr; ?></p>							
				</div>

				<!-- menampilkan tombol update -->
				<div class="row-edit">
					<span>
						<input class="button-edit" type="submit" name="updateProfil" value="Update">
					</span>
				</div>
			</form>
		</div>
	</div>
	
</div>
<!-- MAIN CONTENT EDIT PROFIL -->