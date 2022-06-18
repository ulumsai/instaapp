<?php
	// cek session, jika ada maka akan diarahkan ke home
	if(isset($_SESSION['user'])){
		header("Location:./");
		exit();
	}

	// inisialisasi variabel yang akan digunakan
	$user_email = $password = $error = "";
	$class_user = $class_pass = '';
	include 'config/function.php';	// memanggil file fungsi

?>
<!-- MAIN CONTENT LOGIN -->
<div class="main-log">
	<div>
		<?php
			// untuk menampilkan pesan setelah melakuka pendaftaran
			if(isset($_SESSION['success'])){
				echo "<p class='info-reg-login'>anda berhasil mendaftar, silahkan masuk!</p>";
				unset($_SESSION['success']);
				echo "<script>setTimeout('window.location.href =\"./\";',2000);</script>";	
			}
		?>
	</div>

	<div class="form-login">
		<div class="form-white-login">
			<div class="title">
				<p class="title-top"><img src="assets/images/logo.png" id="logo-log" alt="logo instaapp"></p>
				<p class="title2-top">Masuk untuk bagikan kutipan indahmu</p>
			</div>
			<hr class="line-login">

			<!-- FORM LOGIN -->
			<form class="form-log" method="POST" action="./?page=login">
				<!-- field username/email -->
				<div class="row-login">
					<div class="col-login">
						<input class="in-text <?php echo "$class_user"; ?>" type="text" placeholder="Masukan email atau username" name="user" value="<?php echo $user_email; ?>">
					</div>
				</div>

				<!-- field password -->
				<div class="row-login">
					<div class="col-login">
						<input class="in-text <?php echo "$class_pass"; ?>" type="password" placeholder="Masukan password" name="pass" value="<?php echo $password; ?>">
					</div>
				</div>
				
				<!-- tombol login/masuk -->
				<div class="row-login">
					<span>
						<input class="button-login" type="submit" name="masuk" value="Masuk" >
					</span>
				</div>
				<p class="log-error"><?php echo $error; ?></p>
			</form>
		</div>

		<!-- FORM ASK SIGNUP -->
		<div class="form-white-ask">
			<p class="title-bottom">Belum punya akun? <a href="./?page=register">Daftar</a></p>
		</div>
		<!-- FORM ASK SIGNUP -->
	</div>	
</div>
<!-- MAIN CONTENT LOGIN -->