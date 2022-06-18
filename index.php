<?php 
	session_start();	// untuk memulai sesi website yang dibuka pada web browser 
?>
<!DOCTYPE HTML>
<HTML lang="id">
<head>
	<meta charset="utf-8">
	<title>InstaApp</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">	<!-- pemaggilan css untuk body -->
	<link rel="stylesheet" type="text/css" href="assets/css/header.css"> <!-- pemaggilan css untuk header -->
	<link rel="stylesheet" type="text/css" href="assets/css/content.css"> <!-- pemaggilan css untuk semua konten -->
</head>
<body class="bg">
	<div class="container">
		
		<!-- START HEADER -->
		<?php
			// code php bagian ini berfungsi untuk men-set pencarian nama dari header field cari teman dan diarahkan ke halamn cari teman //
			$cari='';
			if(isset($_POST['cari'])){
				unset($_SESSION['cari']);
				$_SESSION['cari']=$_POST['cari'];
				header("Location:./?page=cari.teman");
				exit();
			}else{
				if(isset($_SESSION['cari'])){
					$cari = $_SESSION['cari'];
				}
			}
		?>

		<div class="header" id="grad1">
			<div class="header-center">
				<ul class="menu-header">
					<li><a class="a-left" href="./"><img src="assets/images/logo2.png" id="logo-header" alt="logo instaapp header"></a></li>
				<?php 
					if(isset($_SESSION['user']) and !empty($_SESSION['user'])){	// untuk authentikasi session pada user 
					?>
						<!-- menu pencarian dan profil yang ditampilkan jika sudah login -->
						<li class="cari-teman">
							<form method="POST" action="./">
								<input class="search" type="text" name="cari" placeholder="Cari teman" value="<?php echo $cari; ?>">
							</form>
						</li>
						<li class="li-right"><a href="./?page=profil"><img class='icon-header' src='assets/images/user.svg' alt='profil'></a></li>
						<!-- end dari menu pencarian dan profil -->

						<?php
					}
				?>
				</ul>
			</div>
		</div>
		<!-- END OF HEADER -->

		<!-- START MAIN CONTENT -->
		
		<?php

			// MAIN CONTENT MODULE 
			
			// fungsi dibawah digunakan untuk pengecekan konten berdasarkan query string pada header
			// jika query string cocok maka akan dipanggil kontenya dari folder modules
			if(isset($_GET['page'])){
				$page = $_GET['page'];
				switch ($page) {
					case 'login':
						include 'modules/login.php';
						break;
					
					case 'register':
						include 'modules/register.php';
						break;
					
					case 'profil':
						include 'modules/profil.php';
						break;
					
					case 'edit.profil':
						include 'modules/edit.profil.php';
						break;
					
					case 'ubah.password':
						include 'modules/ubah.password.php';
						break;
					
					case 'pengikut':
						include 'modules/pengikut.php';
						break;
					
					case 'mengikuti':
						include 'modules/mengikuti.php';
						break;
					
					case 'profil.teman':
						include 'modules/profil.teman.php';
						break;
					
					case 'logout':
						include 'modules/logout.php';
						break;
					
					case 'cari.teman':
						include 'modules/cari.teman.php';
						break;
					
					default:		// jika query string tidak sempurna/ tidak ditemukan maka akan diarahke ke home
						header("Location:./");
						break;
				}

			}else{

				// MAIN CONTENT INDEX

		?>

		<!-- code dibawah merupakan halam index / home dimana jika query string tidak ada yg cocok dengan module maka code dibawah yang akan dijalankan yang merupakan home atau index -->

		<?php
			require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu

			// code ini digunakan untuk mereset session cari agar pada filed pencarian nama orang kembali kosong jika membuka home
			if(isset($_SESSION['cari'])){
				unset($_SESSION['cari']);
				header("Location:./");
				exit();
			}

			// inisialisasi variabel yang akan digunakan saat posting pesan/ status dan daftar teman yang sudah diikuti
			$status = $statusErr = $class_war = $cek = $cek_status = $cek_teman = '';
			
			include 'config/function.php'; // untuk memanggil file fungsi

			// digunakan untuk menset class pada textarea, apakah dia error atau tidak
			if(isset($_SESSION['info'])){
				$statusErr = $_SESSION['info'];
				$class_war = 'warning-green';
				$cek = 1;
				unset($_SESSION['info']);
			}
			// untuk merepopulate isi dari status jika terjadi error, agar tidak hilang status yang telah ditulis
			if(isset($_SESSION['status'])){
				$status = $_SESSION['status'];
				unset($_SESSION['status']);
			}
						
		?>
		<!-- code dibawah merupakan konten home/index -->
		<div class="main-home">
			<div class="status">
				<div class="buat-status">
					<!-- form textarea untuk membuat status -->
					<form class="form-status" action="./" method="POST">
						<div class="tooltip">
							<textarea class="create-status" name="status" placeholder="Apa kutipan indahmu hari in?"><?php echo $status; ?></textarea>
							<span class="tooltiptext">maksimal 250 karakter</span>
						</div>
						<input class="button-post" type="submit" name="posting" value="Kirim">
						<div class="<?php echo $class_war; ?>">
							<p>
								<?php 
									echo $statusErr; //  untuk memuncul status error saat buat status
									if($cek == 1){ 
							 	?>
									 	<script>
									 		setTimeout('window.location.href="./";',1000); // untuk reload halaman jika ada error //
									 	</script>
							 	<?php } ?>
						 	</p>
						</div>
					</form>
				</div>
				<?php
					// fungsi dibawah digunakan untuk mengambil status dan username dari database dengan aturan status yang diambil hanya teman yang diikuti saja dan status diri sendiri
					$user = $_SESSION['user']; 
					$post = $koneksi->query("SELECT * FROM `status` WHERE `username` in ((SELECT username_2 FROM tambah_teman tt WHERE username_1 = '$user')) OR `username` = '$user' ORDER BY `id_status` DESC ");
					$cek_status  = $post->rowCount()>0;

					// jika status ditemukan makan akan di tampilkan
					if($cek_status){
						foreach ($post as $key => $value) {
				?>
							<!-- html untuk menapilkan status teman yang diikuti dan status diri sendiri -->
							<div class="post">
								<header class="header-status">
									<div class="profil-status">
										<?php $foto = cekFoto($value['username']); ?>
										<img class="foto-penstatus" src='<?php echo $foto; ?>' alt="foto-teman">
									</div>
									<div class="link-user">
										<!--untuk menampilkan username pembuat status -->
										<a href="./?page=profil"><?php echo $value['username']; ?></a>
									</div>
								</header>
								<div class="isi-status">
									<!-- untuk menampilkan status -->
									<p class="p-status"><?php echo $value['status']; ?></p>
								</div>
								<div class="footer-status">
									<!-- untuk menampilkan tanggal dan waktu status dibuat -->
									<div class="waktu-status">
										<p><?php echo date('d F Y', strtotime($value['tgl_status'])); 
										echo ", ".date('H:i', strtotime($value['jam_status'])); ?></p>
									</div>
								</div>
							</div>
							<?php 
						}
					}else{
						// jika tidak ada status yang ditampilkan
						echo "<p>anda belum mebuat kutipan</p>";
					}
					 ?>
			</div>

			<!-- html untuk menampilkan akuns sekilas dibagian side kanan halaman dan daftar teman yang diikuti -->
			<div class="home-kanan">
				<div class="info-home-profil">
					<!-- menampilkan foto akun -->
					<div class="foto-home">
						<?php $foto = cekFoto($_SESSION['user']); ?>
						<img id="FotoProfil" src="<?php echo $foto; ?>" alt="foto-profil">
					</div>
					<div class="row-info">
						<?php 
							// untuk menampilkan username, nama depan dan nama belakang dari akun
							$user = $_SESSION['user'];
							$info = $koneksi->query("SELECT * FROM user WHERE username = '$user' ");
							foreach ($info as $key => $value) {
						?>
								<a href="./?page=profil"><p class="user"><b><?php echo $value['username']; ?></b></p></a>
								<p class="nama"><?php echo $value['nama_depan']." ".$value['nama_belakang']; ?></p>
						<?php } ?>
					</div>
				</div>
				<hr class="line-home">

				<!-- html untuk menampilkan daftar teman yang diikuti -->
				<div class="friends-online">
					<?php
						// mengambil siapa saja yang telah diikuti dengan aturan username 1 adalah diri sendiri
						$user = $_SESSION['user'];
						$teman = $koneksi->query("SELECT username_2 FROM tambah_teman WHERE username_1 = '$user' ");
						$cek_teman  = $teman->rowCount()>0;

						// jika ada maka akan ditampilkan
						if($cek_teman){
							foreach ($teman as $key => $value) {
					?>
								<div class="friends-list">
									<div class="profil-teman-kanan">
										<!-- untuk melakukan cek foto berdasarkan jenis kelamin dengan memnaggil fungsi cekFoto() -->
										<?php $foto = cekFoto($value['username_2']); ?>
										<img class="foto-teman-kanan" src="<?php echo $foto; ?>" alt="foto-teman">
									</div>
									<div class="link-teman-kanan">
										<!-- menampilkan username teman yang diikuti -->
										<a class="teman-diikuti" href="./?page=profil.teman&user=<?php echo $value['username_2']; ?>"><?php echo $value['username_2']; ?></a>
									</div>
								</div>
					<?php
							}
						}else{
							// jika tidak ada teman yang diikuti
							echo "<p style='text-align:center;'> anda belum mengikuti sipapun</p>";
						}
					?>

				</div>
			</div>
		</div>
		<!-- END OF MAIN CONTENT -->
		<?php }?>
	</div>
</body>
</html>