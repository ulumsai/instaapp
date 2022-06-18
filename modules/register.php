<?php

	// cek session, jika ada maka akan diarahkan ke home
	if(isset($_SESSION['user'])){
		header("Location:./");
		exit();
	}

	// inisialisasi variabel yang akan digunakan pada form pendaftaran
	$nama_depan = $nama_belakang = $email = $username = $jenis_kelamin = $password = $ulangi_password = '';
	$namaErr = $emailErr = $usernameErr = $jenis_kelaminErr = $passwordErr = $ulangi_passwordErr = '';
	$L_cek = $P_cek = '';
	$class_nama_d = $class_nama_b = $class_email = $class_username = $class_gender = $class_pass1 = $class_pass2 = '';
	
	include 'config/function.php'; // memanggil file fungsi
	
?>
<!-- MAIN CONTENT REGISTER -->
<div class="main-reg">
	<div class="form-registrasi">
		<div class="form-white-reg">
			<div class="title-reg">
				<p class="title-top-reg"><img src="assets/images/logo.png" id="logo-reg" alt="logo instaapp"></p>
				<p class="title2-top-reg">Daftar untuk buat kutipan indahmu</p>
			</div>
			<hr class="line">
			<form class="form-reg" method="POST" action="./?page=register">

				<!-- menampilkan field nama depan dan nama belakang -->
				<div class="row-reg">
					<div class="col-reg col-half-left">
						<input class="in-text <?php echo "$class_nama_d"; ?>" type="text" name="nama_depan" placeholder="Nama depan" value="<?php echo $nama_depan; ?>">
					</div>
					<div class="col-reg col-half-right">
						<input class="in-text <?php echo "$class_nama_b"; ?>" type="text" name="nama_belakang" placeholder="Nama belakang" value="<?php echo $nama_belakang; ?>">
					</div>
					<p class="reg-error"><?php echo $namaErr; ?></p>
				</div>

				<!-- menampilkan field email -->
				<div class="row-reg">
					<div class="col-reg">
						<input class="in-text <?php echo "$class_email"; ?>" type="text" name="email" placeholder="Alamat email" value="<?php echo $email; ?>">
					</div>
					<p class="reg-error"><?php echo $emailErr; ?></p>
				</div>
				
				<!-- menampilkan field username -->
				<div class="row-reg">
					<div class="col-reg">
						<input class="in-text <?php echo "$class_username"; ?>" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
					</div>
					<p class="reg-error"><?php echo $usernameErr; ?></p>
				</div>
				
				<!-- menampilkan field jenis kelamin -->
				<div class="row-reg">
					<p class="title2-top-reg label-gender">Jenis kelamin</p>
					<div class="col-reg <?php echo $class_gender; ?>" >
						<input type="radio" name="gender" value="L" <?php echo $L_cek; ?>> Laki-laki
						<input type="radio" name="gender" value="P" <?php echo $P_cek; ?>> Perempuan		
					</div>
					<p class="reg-error"><?php echo $jenis_kelaminErr; ?></p>							
				</div>

				<!-- menampilkan field password -->
				<div class="row-reg">
					<div class="col-reg">
						<input class="in-text <?php echo "$class_pass1"; ?>" type="password" name="password1" placeholder="Password" value="<?php echo $password; ?>">
					</div>
					<p class="reg-error"><?php echo $passwordErr; ?></p>
				</div>

				<!-- menampilkan konfirmasi password-->
				<div class="row-reg">
					<div class="col-reg">
						<input class="in-text <?php echo "$class_pass2"; ?>" type="password" name="password2" placeholder="Ulangi password" value="<?php echo $ulangi_password; ?>">
					</div>
					<p class="reg-error"><?php echo $ulangi_passwordErr; ?></p>
				</div>

				<!-- menampilkan tombol daftar -->
				<div class="row-reg">
					<span>
						<input class="button-reg" type="submit" name="daftar" value="Daftar">
					</span>
				</div>
			</form>
			<p class="title-bottom">Dengan klik daftar, anda setuju dengan <br>syarat dan ketentuan dari kami.</p>
		</div>

		<!-- FORM ASK LOGIN -->
		<div class="form-white-ask ask-log">
			<p class="title-bottom">Sudah punya akun? <a href="./?page=login">Masuk</a></p>
		</div>
		<!-- FORM ASK LOGIN -->
	</div>
	
</div>
<!-- MAIN CONTENT REGISTER -->