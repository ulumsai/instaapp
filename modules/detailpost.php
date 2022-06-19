<?php

	require 'config/authen.php';	// meminta aksi autentikasi user terlebih dahulu
	
	// untuk unset cari, agar filed pencarian teman kosong 
	if(isset($_SESSION['cari'])){
		unset($_SESSION['cari']);
		header("Location:./?page=profil");
		exit();
	}
    $user = $_SESSION['user']; 
    // var_dump($detailpost);
	// include 'config/function.php'; // memanggil file fungsi

?>
<!-- code dibawah merupakan konten home/index -->
<div class="main-home">
    <div class="post">
        <header class="header-status">
            <div class="profil-status">
                <?php $foto = cekFoto($detailpost['username']); ?>
                <img class="foto-penstatus" src='<?php echo $foto; ?>' alt="foto-teman">
            </div>
            <div class="link-user">
                <!--untuk menampilkan username pembuat status -->
                <a href="./?page=profil"><?php echo $detailpost['username']; ?></a>
            </div>
        </header>
        <div class="isi-status">
            <!-- untuk menampilkan status -->
            <a href="./?page=detailpost"><p class="p-status"><?php echo $detailpost['status']; ?></p></a> 
        </div>
        <div class="footer-status">
            <div class="likekomen-status">
                <div class="row">
                    <div class="col">
                        <?php $like = cekLike($detailpost['id_status'],$user); ?>
                        <a href="./?page=liked<?php echo "&id=".$detailpost['id_status']."&user=".$user; ?>"><img class="logo-like" src="assets/images/<?php echo $like; ?>.png" alt=""></a>
                    </div>
                    <div class="col">
                        <img class="logo-like" src="assets/images/comment.png" alt="">
                    </div>
                </div>
            </div>
            <!-- untuk menampilkan tanggal dan waktu status dibuat -->
            <div class="waktu-status">
                <p><?php echo date('d F Y', strtotime($detailpost['tgl_status'])); 
                echo ", ".date('H:i', strtotime($detailpost['jam_status'])); ?></p>
            </div>
        </div>
    </div>    

    <div class="home-kanan">
        <!-- html untuk menampilkan daftar teman yang diikuti -->
        <div class="list-komentar">
            <div class="friends-list">
                <div class="profil-teman-kanan">
                    <!-- untuk melakukan cek foto berdasarkan jenis kelamin dengan memnaggil fungsi cekFoto() -->
                    <?php //$foto = cekFoto($value['username_2']); ?>
                    <img class="foto-teman-kanan" src="<?php //echo $foto; ?>" alt="foto-teman">
                </div>
                <div class="link-teman-kanan">
                    <!-- menampilkan username teman yang diikuti -->
                    <a class="teman-diikuti" href="./?page=profil.teman&user=<?php //echo $value['username_2']; ?>"><?php //echo $value['username_2']; ?></a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END OF MAIN CONTENT -->