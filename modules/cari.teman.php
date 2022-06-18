<?php
	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	include 'config/function.php';	// memnaggil file fungsi
	$cari_teman = $ada ="";
	// untuk cek session cari
	if(isset($_SESSION['cari']) and !empty(htmlentities(strip_tags($_SESSION['cari'])))){
		// jika ada akan memanggil fungsi pencarian teman
		cariTeman($_SESSION['cari']);
	}else{
		// jika tidak ada makan akan dialihkan ke home
		header("Location:./");
		exit();
	}
?>
<!-- MAIN CONTENT CARI TEMAN -->
<div class="main-cari">
	<div class="judul-cari">
		<!-- set tittle pencarian -->
		<h1 class="h1-teman">Hasil Pencarian '<?php echo $_SESSION['cari'] ?>'</h1>
	</div>
	<hr>
	<?php
		// jika pencarian ditemukan maka user akna ditampilkan
		if($ada) {
		foreach ($cari_teman as $key => $value) {
			// untuk menampilkan foto user
			$foto = cekFoto($value['username']);
	?>
	<div class="row-teman">
		<div class="foto-cari">
			<img class="foto-cari-teman" src='<?php echo $foto; ?>' alt="foto-teman">
		</div>
		<!-- menampikan nama dari useryang dicari -->
		<div class="sub-nama">
			<a class="link-cari-teman" href="./?page=profil.teman&user=<?php echo $value['username'];; ?>"><?php echo $value['username']; ?></a>
			<p class="nama-cari-teman"><?php echo $value['nama_depan']." ".$value['nama_belakang']; ?></p>
		</div>

	</div>
	<?php }
	}else{
		// jika pencarian teman tidak ditemukan
		echo "<p>Maaf pengguna tidak ditemukan</p>";
	} ?>
</div>
<!-- MAIN CONTENT CARI TEMAN -->