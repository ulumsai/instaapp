<?php

	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk cek apakah query string dengan variavel user ada
	if(!isset($_GET['user']) and empty(htmlentities(strip_tags($_GET['user'])))){
		header("Location:./");
		exit();
	}

	// untuk unset cari, agar filed pencarian teman kosong 
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=profil.teman&user=".$_GET['user']."");
		exit();
	}
	$ada; // inisialisasi untuk pengecekan apakah sudah berteman
	$username = $_SESSION['user'];
	$user = $_GET['user'];
	if($username == $user){	// jika user sama dengan username diri sendiri maka akan dialihkan ke profil diri sendiri
		header("Location:./?page=profil");
		exit();
	}
	
	include 'config/function.php';

?>
<!-- MAIN CONTENT -->
<div class="main-profil-teman">
	<div class="header-profil-teman">
		<div class="foto-profil-teman">
			<?php  
				// cek foto
				$foto = cekFoto($user);
			?>
			<img id="FotoProfil-teman" src="<?php echo $foto; ?>" alt="fotoku">
		</div>
		<div class="info-profil-teman">
			<?php 
				$nama = tampilkanUser($user);	// pemanggilan fungsi untuk menampilkan username
				$status = tampilkanKutipan($user);	// pemanggilan fungsi untuk menampilkan jumlah status
				$pengikut = tampilkanPengikut($user); // pemanggilan fungsi untuk menampilkan jumlah pengikut
				$mengikuti = tampilkanMengikuti($user);  // pemanggilan fungsi untuk menampilkan jumlah yang diiukti
			?>
			<div class="row-user-teman">
				<!-- menampikan usrname -->
				<p class="username-teman"><?php echo $nama; ?></p>
			</div>
			<div class="row-user-teman">
				<div class="col-follow-teman">
					<!-- menampikan jumlah status -->
					<p><b><?php echo $status; ?></b> Kutipan</p>
				</div>
				<div class="col-follow-teman">
					<!-- menampikan jumlah pengikut -->
					<a href="./?page=pengikut&nama=<?php echo $user; ?>"><p><b><?php echo $pengikut; ?></b> pengikut</p></a>
				</div>
				<div class="col-follow-teman">
					<!-- menampikan jumlah yang diikuti -->
					<a href="./?page=mengikuti&nama=<?php echo $user; ?>"><p><b><?php echo $mengikuti; ?></b> mengikuti</p></a>
				</div>
			</div>

			<div class="row-user-teman button-row-teman">
				<!-- menampikan jumlah tombol ikuti/diikuti -->
				<div class="col-but-teman">
					<form method="POST" action="./?page=profil.teman&user=<?php echo $user; ?>">
						<?php 
							// untuk cek apakah user merupkan teman
							$ada = cekTeman();
							if($ada){ // jika meruapkan teman maka akan ditampikjan tombol batal ikuti
								echo "<input class='btn-ikuti' type='submit' name='batalikuti' value='Batal Ikuti'>";
							}else{		// jika tidak teman maka akan ditampilkan tombol ikuti
								echo "<input class='btn-ikuti' type='submit' name='ikuti' value='Ikuti'>";
							}
						?>
						
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="status-teman">
		<div class="row-status-teman">
		<?php
			// dan jika teman maka akan ditampilkan status teman tersebut
			if($ada){
				tampilkanStatus($user);
			}else{
				echo "<p>Ikuti untuk melihat kutipan indahnya</p>";
			} 
		?>
		</div>
	</div>

</div>
<!-- MAIN CONTENT -->