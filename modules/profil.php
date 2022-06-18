<?php

	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk unset cari, agar filed pencarian teman kosong 
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=profil");
		exit();
	}
	
	include 'config/function.php'; // memanggil file fungsi

?>
<!-- MAIN CONTENT PROFIL -->
<div class="main-profil">
	<div class="header-profil">
		<div class="foto-profil">
			<?php  
				// memanggil fungsi cek foto berdasar username
				$foto = cekFoto($_SESSION['user']);
			?>
			<img id="Foto-Profil" src="<?php echo $foto; ?>" alt="fotoku">
		</div>
		<div class="info-profil">
			<?php 

				$user = $_SESSION['user'];
				$nama = tampilkanUser($user); 	// pemanggilan fungsi untuk menampilkan username
				$status = tampilkanKutipan($user);	// pemanggilan fungsi untuk menampilkan jumlah status
				$pengikut = tampilkanPengikut($user);	// pemanggilan fungsi untuk menampilkan jumlah pengikut
				$mengikuti = tampilkanMengikuti($user);	// pemanggilan fungsi untuk menampilkan jumlah yang diiukti
			?>
			<div class="row-user-profil">
				<!-- menampikan usrname -->
				<p class="username-profil"><?php echo $nama; ?></p>
			</div>
			<div class="row-user-profil">
				<div class="col-follow-profil">
					<!-- menampikan jumlah status -->
					<p><b><?php echo $status; ?></b> Kutipan</p>
				</div>
				<div class="col-follow-profil">
					<!-- menampikan jumlah pengikut -->
					<a href="./?page=pengikut"><p><b><?php echo $pengikut; ?></b> pengikut</p></a>
				</div>
				<div class="col-follow-profil">
					<!-- menampikan jumlah yang diikuti -->
					<a href="./?page=mengikuti"><p><b><?php echo $mengikuti; ?></b> mengikuti</p></a>
				</div>
			</div>

			<div class="row-user-profil button-row-profil">
				<div class="col-but-profil">
					<!-- menampikan tombol edit profil -->
					<a class="button-profil" href="./?page=edit.profil">Edit Profil</a>
				</div>
				<div class="col-but-profil">
					<!-- menampikan tombol ubah password -->
					<a class="button-profil" href="./?page=ubah.password">Ubah Password</a>
				</div>
				<div class="col-but-profil">
					<!-- menampikan tombol logout -->
					<a class="button-profil" href="./?page=logout">Logout</a>
				</div>
			</div>
		</div>
	</div>


	<div class="status-profil">
		<div class="row-status-profil">
		<?php 
			$user = $_SESSION['user'];
			tampilkanStatus($user);		
		?>
		</div>
	</div>

</div>
<!-- MAIN CONTENT PRFOL -->