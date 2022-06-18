<?php
	
	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk unset cari, agar filed pencarian teman kosong 
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=pengikut");
		exit();
	}
	
	include 'config/function.php';	// memanggil file fungsi
	
	$cariPengikut = $ada = $nama = "";

	// untuk mengecek query string dengan variabel nama, daftar teman yang jadi pengikut dan dicari berdasar variabel nama
	if(isset($_GET['nama']) and !empty($_GET['nama'])){
		$nama = $_GET['nama'];		// jika ada maka akan ditampung
	}elseif(isset($_GET['nama']) and empty($_GET['nama'])){
		header("Location:./");		// jika ada tetapi kosong maka akan dialihkan ke home
	}else{
		$nama = $_SESSION['user'];	// jika tidak ada maka akan mengambil username sendiri
	}

	// memanggil fungsi untuk menampilkan teman yang jadi pengikut
	cariPengikut($nama);

?>
<!-- MAIN CONTENT PENGIKUT -->
<div class="main-pengikut">
	<div class="judul-pengikut">
		<h1>Pengikut '<?php echo $nama ?>'</h1>
	</div>
	<hr>
	<?php
		// jika ada teman yang jadi pengikut maka akan ditampilkan
		if($ada) {
		foreach ($cariPengikut as $key => $value) {
			$foto = cekFoto($value['username']);
	?>
			<div class="row-pengikut">
				<!-- menampikkan foto -->
				<div class="foto">
					<img class="foto-pengikut" src='<?php echo $foto; ?>' alt="foto-teman">
				</div>

				<!-- menampilkan username dan nama -->
				<div class="nama-pengikut">
					<a class="pengkut-a" href="./?page=profil.teman&user=<?php echo $value['username']; ?>"><?php echo $value['username']; ?></a>
					<p class="pengikut-p"><?php echo $value['nama_depan']." ".$value['nama_belakang']; ?></p>
				</div>

			</div>
			<?php }
			}else{
				// jika tidak ada pengikut
				echo "<p>$nama tidak memiliki pengikut</p>";
	} ?>
</div>
<!-- MAIN CONTENT PENGIKUT -->