<?php
	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk unset cari, agar filed pencarian teman kosong 
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=ubah.password");
		exit();
	}

	// inisialisasi variabel yang akan digunakan pada form ubah password
	$pass_lama = $password = $ulangi_password = '';
	$pass_lamaErr = $passwordErr = $ulangi_passwordErr = '';
	$class_pass_lama = $class_pass1 = $class_pass2 = '';
	
	include 'config/function.php'; // memanggil file fungsi

?>
<!-- MAIN CONTENT UBAH PASSWORD -->
<div class="main-ubah">
	<div class="form-ubah">
		<div class="form-white-ubah">
			<div class="title">
				<h1 class="title">Ubah Password</h1>
			</div>
			<hr class="line">
			<form class="form-reg" method="POST" action="./?page=ubah.password">
				
				<!-- menampilkan field password lama -->
				<div class="row-ubah">
					<div class="col-ubah">
						<input class="in-text <?php echo "$class_pass_lama"; ?>" type="password" name="password" placeholder="Password lama" value="<?php echo $pass_lama; ?>">
					</div>
					<p class="reg-error"><?php echo $pass_lamaErr; ?></p>
				</div>

				<!-- menampilkan field password baru-->
				<div class="row-ubah">
					<div class="col-ubah">
						<input class="in-text <?php echo "$class_pass1"; ?>" type="password" name="password1" placeholder="Password baru" value="<?php echo $password; ?>">
					</div>
					<p class="reg-error"><?php echo $passwordErr; ?></p>
				</div>

				<!-- menampilkan konfirmasi password -->
				<div class="row-ubah">
					<div class="col-ubah">
						<input class="in-text <?php echo "$class_pass2"; ?>" type="password" name="password2" placeholder="Konfirmasi password" value="<?php echo $ulangi_password; ?>">
					</div>
					<p class="reg-error"><?php echo $ulangi_passwordErr; ?></p>
				</div>
				
				<!-- menampilkan tombol update -->
				<div class="row-ubah">
					<span>
						<input class="button-ubah" type="submit" name="updatePassword" value="Update">
					</span>
				</div>
			</form>
		</div>
	</div>
	
</div>
<!-- MAIN CONTENT UBAH PASSWORD -->