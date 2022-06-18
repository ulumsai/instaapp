<?php
	
	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk unset cari, agar filed pencarian teman kosong 
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=mengikuti");
		exit();
	}

	include 'config/function.php';	// memanggil file fungsi
	
	$cariMengikuti = $ada = $nama = "";

	// untuk mengecek query string dengan variabel nama, daftar teman yang mengikuti akan dicari berdasar variabel nama
	if(isset($_GET['nama']) and !empty($_GET['nama'])){
		$nama = $_GET['nama'];	// jika ada maka akan ditampung
	}elseif(isset($_GET['nama']) and empty($_GET['nama'])){
		header("Location:./");	// jika ada tetapi kosong maka akan dialihkan ke home
	}else{
		$nama = $_SESSION['user'];	// jika tidak ada maka akan mengambil username sendiri
	}

	// memanggil fungsi untuk menampilkan siapa yang diikuti
	cariMengikuti($nama);

?>
<!-- MAIN CONTENT MENGIKUTI -->
<div class="main-mengikuti">
	<div class="judul-mengikuti">
		<h1>Yang diikuti '<?php echo $nama ?>'</h1>
	</div>
	<hr>
	<?php
		// jika ada yang diikuti maka akan ditampilkan
		if($ada) {
		foreach ($cariMengikuti as $key => $value) {
			$foto = cekFoto($value['username']);
	?>
			<div class="row-mengikuti">
				<!-- menampikkan foto -->
				<div class="foto">
					<img class="foto-mengikuti" src='<?php echo $foto; ?>' alt="foto-teman">
				</div>

				<!-- menampilkan username dan nama -->
				<div class="nama-mengikuti">
					<a class="mengikuti-a" href="./?page=profil.teman&user=<?php echo $value['username']; ?>"><?php echo $value['username']; ?></a>
					<p class="mengikuti-p"><?php echo $value['nama_depan']." ".$value['nama_belakang']; ?></p>
				</div>

			</div>
			<?php }
			}else{
				// jika tidak ada yang diikuti
				echo "<p>$nama tidak mengikuti siapapun</p>";
	} ?>
</div>
<!-- MAIN CONTENT MENGIKUTI -->