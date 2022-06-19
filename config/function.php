<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){ // pengecekan jika aksi dari form dengan methos POST

		getDb();	// memanggi fungsi untuk koneksi dengan database
		// =========== pengecekan pemanggilan fungsi ======
		if(isset($_POST['daftar'])){
			daftar();
		}elseif(isset($_POST['masuk'])){
			masuk();
		}elseif(isset($_POST['posting'])){
			posting();
		}elseif (isset($_POST['updatePassword'])) {
			updatePassword();
		}elseif(isset($_POST['ikuti'])){
			ikuti();
		}elseif(isset($_POST['batalikuti'])){
			batalikuti();
		}
	}

	// ============= FUNGSI ===================
	$koneksi;
	getDb();
	function getDb(){ 				// fungsi untuk menghubungkan halaman dengan database
		global $koneksi;
		try {
		  // buat koneksi dengan database
		  $koneksi = new PDO("mysql:host=localhost;dbname=instaapp","root","");
		  
		  // set error mode
		  $koneksi->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $e) {
		  // tampilkan pesan kesalahan jika koneksi gagal
		  print "Koneksi atau query bermasalah<br/>";
		  die();
		}
	}

	function daftar(){				// fungsi saat melakukan pendaftaran
		$error = false;
		// inisialisasi variabel yang akan digunakan
		global $koneksi,$nama_depan, $nama_belakang, $jenis_kelamin, $email, $username, $password;
		// pemanggilan fungsi khusu untuk validasi dengan mengembalikan nilai true atau false	
        $error = cekNamaDepan();
        $error = cekNamaBelakang();
        $error = cekEmail('1');
		$error = cekUsername();
		$error = cekgender();
    	$error = cekPassword();
    	$error = cekPassword2();        
        
        // memasukkan data pengguna jika sudah lolos validasi
        if($error === false){
        	$in_data = $koneksi->prepare("INSERT INTO user (nama_depan, nama_belakang, jenis_kelamin, email, username, password) VALUES(?,?,?,?,?,SHA2(?,256))");
          	$in_data->bindValue(1,$_POST['nama_depan']);
          	$in_data->bindValue(2,$_POST['nama_belakang']);
          	$in_data->bindValue(3,$_POST['gender']);
          	$in_data->bindValue(4,$_POST['email']);
          	$in_data->bindValue(5,$_POST['username']);
          	$in_data->bindValue(6,$_POST['password1']);
          	$in_data->execute();
          	
          	$_SESSION['success'] = true; // untuk set informasi jika te;ah berhasil daftar, pada halaman login
          	// dana akan diarahkan ke halaman login
          	header("Location:./?page=login");
			exit();
        }
	}

	function masuk(){ 				// fungsi pada saat melakukan login
		$errorLog=false;
		// inisialisasi variabel yang akan digunakan
		global $koneksi;
		global $user_email, $password, $error;
		global $class_user, $class_pass ;
	
		// cek username/ email yang inputkan
		if(htmlentities(strip_tags(empty(trim($_POST['user']))))){
	     	$error = '*username dan password harus diisi'; // set error
	     	$class_user = 'red-box';	// untuk mewarnai border jika terjadi error/ kesalahan
	     	$errorLog = true;
	    }else{
	      	$user_email = htmlentities(trim($_POST['user'])); // jika lolos validasi nilai akan ditampung
	    }

	    // cek inputan password
	    if(htmlentities(strip_tags(empty(trim($_POST['pass']))))){
	      	$error = '*username dan password harus diisi';	// set error
	      	$class_pass = 'red-box';	// set border warna merah jika error
	      	$errorLog = true;
	    }else{
	      	$password = htmlentities(strip_tags(trim($_POST['pass']))); // tampung nilai jika lolos validasi
	    }

	    // jika lolos semua validasi akan dicek di database
        if($errorLog === false){
        	$statement = $koneksi->prepare("SELECT username FROM user WHERE (username = ? OR email = ?) AND password = SHA2(?, 256)");
        	$statement->bindValue(1, $user_email);
        	$statement->bindValue(2, $user_email);
		    $statement->bindValue(3, $password);
		    $statement->execute();
		    $ada = $statement->rowCount() > 0;

		    foreach ($statement as $val) { 	$user = $val['username'];   }

		    if ($ada) {		// jika ada maka akan men-set session user dan di alihkan ke halaman index/home
		     	session_start();
		     	$_SESSION['user'] = $user;
      			header("Location:./"); 
      			exit();        
  			}else{
  				// jika tidak ada yang cocok maka akan set variabel error
  				$error = '*username dan password tidak cocok';
  			}
        }
	}

	function posting(){				// fungsi untuk melakukan posting status
		// inisialisasi variabel yang akan digunakan
		global $koneksi;
		global $status, $statusErr, $class_war, $cek;

		// cek panjang status apakah memlebihi yang ditentukan
		if(strlen($_POST['status']) > 250){
			$statusErr = '*update kutipan gagal, kutipanmu lebih dari 250 karakter!'; // set error
			$class_war = 'warning-red';			// set border warna merah
			$status = $_POST['status'];
			$cek = 1;
			$_SESSION['status']=$status;	 // isi session status, agar bisa direpopulate

		// cek apakah status kosong
		}elseif(empty(trim($_POST['status']))){
			$statusErr = '*kutipan tidak boleh kosong'; // set error
			$class_war = 'warning-red';			// set border warna merah
			$status = $_POST['status'];
			$cek = 1;
			$_SESSION['status']=$status; 	// isi session status, agar bisa direpopulate
		}else{
			// cek dari inputan status dan mencegah sql injection
			if(!empty(htmlentities(strip_tags(trim($_POST['status']))))){	
				date_default_timezone_set("Asia/Jakarta");		// agar waktu sesuai dengan ASIA/JAKARTA
				$status = htmlentities(strip_tags(trim($_POST['status'])));
				// proses insert status ke database
				$posting = $koneksi->prepare("INSERT INTO status (status,tgl_status,jam_status,username) VALUES(?,?,?,?)");
				$posting->bindValue(1,$status);
	          	$posting->bindValue(2,date('Y-m-d'));
	          	$posting->bindValue(3,date('H:i:s'));
	          	$posting->bindValue(4,$_SESSION['user']);
	          	$posting->execute();

	          	$_SESSION['info'] = '*status berhasil dikirim';
				
	          	header("Location:./");
	          	exit();
			}
		}
	}

	function updateProfil(){		// fungsi untuk mengupdate profil
		// inisialisasi variabel yang akan digunakan
		global $koneksi,$nama_depan, $nama_belakang, $jenis_kelamin, $email, $username, $error;		
        
        // update data pengguna
    	$in_data = $koneksi->prepare("UPDATE user SET nama_depan=?, nama_belakang=?, jenis_kelamin=?, email=? WHERE username = ?");
      	$in_data->bindValue(1,$_POST['nama_depan']);
      	$in_data->bindValue(2,$_POST['nama_belakang']);
      	$in_data->bindValue(3,$_POST['gender']);
      	$in_data->bindValue(4,$_POST['email']);
      	$in_data->bindValue(5,$username);
      	$in_data->execute();
      	
      	header("Location:./?page=profil"); // sete;ah di update maka akna dialihkan ke halaman profil
      	exit();    
	}

	function updatePassword(){		// fungsi untuk mengupdate password
		// inisialisasi variabel yang akan digunakan
		global $koneksi;
		$error = false;
		global $pass_lama , $password , $ulangi_password, $pass_lamaErr, $class_pass_lama;
		
		$username = $_SESSION['user'];

		// cek kosongnya passowrd
		if(empty($_POST["password"])){    // cek password
        	$pass_lamaErr = "*password harus diisi";
        	$class_pass_lama = 'red-box';
        	$error = true;
        }else{
        	// cek password apakah sama dengan yang ada sebelumnya
          	$pass_lama = $_POST["password"];
          	$pass = $koneksi->query("SELECT password FROM user WHERE password = SHA2('$pass_lama',256) AND username = '$username' ");
          	$ada = $pass->rowCount() > 0;
          	if (!$ada) {     
            	$pass_lamaErr = "*password salah";
            	$class_pass_lama = 'red-box';
            	$error = true;
          	}
        }

		$error = cekPassword(); 	// untuk memnaggil fungsi cek password, dengan parameter password baru
		$error = cekPassword2();	// untuk memnaggil fungsi cek password, dengan parameter konfirmasi password
			
		// jika benar maka akan di update password pada databse
        if($error === false){
        	$in_data = $koneksi->prepare("UPDATE user SET password = SHA2(?,0) WHERE username = ?");
          	$in_data->bindValue(1,$_POST['password1']);
          	$in_data->bindValue(2,$username);
          	$in_data->execute();
          
          	header("Location:./?page=profil"); // dan dialihkan menuju profil
          	exit();
        }
	}

	function cekFoto($user){		// fungsi yang digunakan untuk cek foto
		global $koneksi;
		// untuk melihat jenis kelamin user yang akan dicek
		$gender = $koneksi->query("SELECT jenis_kelamin FROM user WHERE username = '$user' ");
		$ada = $gender->rowCount()>0;
		if(!$ada){
			header("Location:./");
			exit();
		}
		foreach ($gender as $key => $value) {
			if($value['jenis_kelamin'] == 'L'){	// jika dia laki-laki maka
				return 'assets/images/boy.png';	// dikembalikan gambar laki-laki
			}else{
				return 'assets/images/girl.png'; // jika perempuan akan dikembalikan gambar perempuan
			}
		}
	}

	function cariTeman($nama){		// fungsi untuk melakukan pencarian teman berdasarkan parameter nama
		global $koneksi, $cari_teman, $ada;

		// akan menampilkan semua username, nama depan dan nama belakang berdasarkan parameter
		$cari_teman = $koneksi->prepare("SELECT * FROM user WHERE username LIKE ? OR nama_depan LIKE ? OR nama_belakang LIKE ? ");
		$cari_teman->bindValue(1,'%'.$nama.'%');
		$cari_teman->bindValue(2,'%'.$nama.'%');
		$cari_teman->bindValue(3,'%'.$nama.'%');
		$cari_teman->execute();
		$ditemukan = $cari_teman->rowCount()>0;
		if($ditemukan){
			$ada=true;
		}
	}

	function ikuti(){			// fungsi untuk mengikuti teman
		global $koneksi, $username, $user;
		// insert data ke tabel tambah_teman dengan aturan username_1 adalah diri kita yang mengikuti dan username_2 yang diikuti
		$follow = $koneksi->prepare("INSERT INTO tambah_teman(username_1, username_2) VALUES (?,?)");
		$follow->bindValue(1, $username);
		$follow->bindValue(2, $user);
		$follow->execute();
		header("Location:./?page=profil.teman&user=".$user."");
		exit();
	}

	function batalikuti(){		// fungsi untuk menghapus hubungan teman yang user ikuti
		global $koneksi, $username, $user;
		$follow = $koneksi->prepare("DELETE FROM tambah_teman WHERE username_1 = ? AND username_2 = ? ");
		$follow->bindValue(1, $username);
		$follow->bindValue(2, $user);
		$follow->execute();
		header("Location:./?page=profil.teman&user=".$user."");
		exit();
	}

	function cekTeman(){		// fungsi untuk mencari teman yang diikuti oleh user
		global $koneksi, $username, $user;
		$cek = $koneksi->prepare("SELECT username_1, username_2 FROM tambah_teman WHERE username_1=? AND username_2=? ");
		$cek->bindValue(1, $username);
		$cek->bindValue(2, $user);
		$cek->execute();	
		$ada = $cek->rowCount()>0;
		return $ada;
	}

	function tampilkanStatus($user){	// fungsi untuk menampilkan status teman ketika membuka profil teman
		global $koneksi;
		$status = $koneksi->query("SELECT * FROM status WHERE username = '$user' ORDER BY id_status DESC ");
		$baris = $status->rowCount();
		foreach ($status as $key => $value) {
			if (($key+1)%3==0){
				echo "<div class='col-status-profil'>";
				echo "<p class='p-status-profil'>".$value['status']."</p></div>";
				if($baris != $key+1){
					echo "</div><div class='row-status-profil'>";
				}
			}else{
				echo "<div class='col-status-profil'>";
				echo "<p class='p-status-profil'>".$value['status']."</p></div>";
			}
		}
	}

	function tampilkanUser($user){		// fungsi untuk menampilkan username dari teman saat dibuka profilnya
		global $koneksi;
		$info = $koneksi->query("SELECT username FROM user WHERE username = '$user' ");
		foreach ($info as $value) {
			return $value['username'];
		}
	}

	function tampilkanKutipan($user){	// fungsi untuk menampilkan jumalh status dari user
		global $koneksi;
		$infoStatus = $koneksi->query("SELECT COUNT(status) FROM status WHERE username = '$user' ");
		foreach ($infoStatus as $value) {
			return $value['COUNT(status)'];
		}
	}

	function tampilkanPengikut($user){	// fungsi menampilkan jumlah pengikut dari user
		global $koneksi;
		$infoPengikut = $koneksi->query("SELECT COUNT(username_1) FROM tambah_teman WHERE username_2 = '$user' ");
		foreach ($infoPengikut as $value) {
			return $value['COUNT(username_1)'];
		}
	}

	function tampilkanMengikuti($user){	// fungsi untuk menampilkan jumlah teman yang diikuti
		global $koneksi;
		$infoMengikuti = $koneksi->query("SELECT COUNT(username_2) FROM tambah_teman WHERE username_1 = '$user'  ");
		foreach ($infoMengikuti as $value) {
			return $value['COUNT(username_2)'];
		}
	}

	function cariPengikut($nama){		// fungsi untuk menampilkan siapa saja yang jadi pengikut
		global $koneksi, $ada, $cariPengikut;
		$cariPengikut = $koneksi->prepare("SELECT username, nama_depan, nama_belakang FROM user WHERE username in ((SELECT username_1 FROM tambah_teman WHERE username_2=?))");
		$cariPengikut->bindValue(1, $nama);
		$cariPengikut->execute();	
		$ditemukan = $cariPengikut->rowCount()>0;
		if($ditemukan){
			$ada=true;
		}
	}

	function cariMengikuti($nama){		// fungsi untuk menampilkan siapa saja yang diikuti
		global $koneksi, $ada, $cariMengikuti;
		$cariMengikuti = $koneksi->prepare("SELECT username, nama_depan, nama_belakang FROM user WHERE username in ((SELECT username_2 FROM tambah_teman WHERE username_1=?))");
		$cariMengikuti->bindValue(1, $nama);
		$cariMengikuti->execute();	
		$ditemukan = $cariMengikuti->rowCount()>0;
		if($ditemukan){
			$ada=true;
		}
	}


	//============================== FUNGSI KHUSUS ==========================================

	function cekNamaDepan(){	// fungsi validasi nama depan pada form pendaftaran dan edit profil
		global $nama_depan, $namaErr, $class_nama_d, $error;
	
		if(empty(trim($_POST['nama_depan']))){	// cek kekosongan nama depan
        	$namaErr = '*nama harus diisi';
        	$class_nama_d = 'red-box';
        	$error = true;
        }else{											
          	$nama_depan = trim($_POST['nama_depan']);
          	if(!preg_match("/^[a-zA-Z. ]*$/", $nama_depan)){   		// cek nama hanya alphabet, titik dan spasi
            	$namaErr = "*nama hanya huruf, spasi dan titik";
            	$class_nama_d = 'red-box';
        		$error = true;
        	}
        }
        return $error;
	}

	function cekNamaBelakang(){		// fungsi validasi nama belakang pada form pendaftaran dan edit profil
		global $nama_belakang, $namaErr, $class_nama_b, $error;
		if(empty(trim($_POST['nama_belakang']))){	// cek kekosongan nama belakang
        	$namaErr = '*nama harus diisi';
        	$class_nama_b = 'red-box';
        	$error = true;
        }else{
          	$nama_belakang = trim($_POST['nama_belakang']);
          	if(!preg_match("/^[a-zA-Z. ]*$/", $nama_belakang)){   	// cek nama hanya alphabet, titik dan spasi
            	$namaErr = "*nama hanya huruf, spasi dan titik";
            	$class_nama_b = 'red-box';
          		$error = true;
          	}
        }
        return $error;
	}

	function cekEmail($cek){		// fungsi validasi email pada form pendaftaran dan edit profil
		global $koneksi, $email, $emailErr, $class_email, $error, $username;
	
		if (empty(trim($_POST["email"]))){		// cek kekosongan email
		    $emailErr = "*email harus diisi";
		    $class_email = 'red-box';
        	$error = true;
		} else {
			$email = trim($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {	// cek email sesuai format
		   		$emailErr = "*alamat email tidak valid";
		   		$class_email = 'red-box';
        		$error = true;
		    }else{
		    	if($cek=='1'){
		    		$data = $koneksi->query("SELECT `email` FROM `user` WHERE email = '$email' ");	// cek kesamaan email	
		    	}else{
		    		$username = $_SESSION['user'];
		    		$data = $koneksi->query("SELECT `email` FROM `user` WHERE (email = '$email' and username != '$username') ");	
		    	}
		    	
		    	$data_email = $data->rowCount() > 0;
		    	if($data_email){
		    		$emailErr = '*alamat email sudah digunakan';
		    		$class_email = 'red-box';
		    		$error = true;
		    	}
			}
		}
		return $error;
	}

	function cekUsername(){		// fungsi validasi username pada form pendaftaran
		global $koneksi, $username, $usernameErr, $class_username, $error;	
		$error = false;
		if(empty(trim($_POST['username']))){		// cek kekosongan username
        	$usernameErr = '*username harus diisi';
        	$class_username = 'red-box';
        	$error = true;
        }else{
          	$username = trim($_POST['username']);
          	if(!preg_match("/^[a-zA-Z0-9_ ]*$/", $username)){   // cek username susi format 
            	$usernameErr = "*username hanya huruf, angka, spasi dan underscore";
            	$class_username = 'red-box';
        		$error = true;
          	}else{
          		// cek kesamaan username
          		$data = $koneksi->query("SELECT `username` FROM `user` WHERE username = '$username' "); 
		    	$data_user = $data->rowCount() > 0;
		    	if($data_user){
		    		$usernameErr = '*username sudah digunakan';
		    		$class_username = 'red-box';
		    		$error = true;
		    	}
         	}
        }
        return $error;
	}

	function cekGender(){		// fungsi validasi gender pada form pendaftaran dan edit profil
		global $jenis_kelamin,$class_gender, $jenis_kelaminErr, $error, $L_cek, $P_cek;
		 
		if(empty($_POST['gender'])){	// cek kekosongan jenis kelamin
      		$jenis_kelaminErr = '*jenis kelamin harus diisi';
      		$class_gender = 'gender-box';
      		$error = true;
    	}else{
      		$jenis_kelamin = $_POST['gender'];
      		switch ($jenis_kelamin) {		// untuk checked jenis kelamin
          		case 'L': $L_cek = 'checked'; break;
          		case 'P': $P_cek = 'checked'; break;
        	}
    	}
    	return $error;
	}

	function cekPassword(){ 	// fungsi validasi password pada form pendaftaran dan ubah password
		global $password, $passwordErr, $class_pass1, $error;
		$error = false;
		if(empty($_POST["password1"])){    // cek kekosongan password
        	$passwordErr = "*password harus diisi";
        	$class_pass1 = 'red-box';
        	$error = true;
        }else{
          	$password = $_POST["password1"];
          	if (strlen($password) < 8) {     	// cek panajnag password sudah sesuai
            	$passwordErr = "*password harus terdiri dari 8 digit";
            	$class_pass1 = 'red-box';
            	$error = true;
          	}
        }
        return $error;
	}

	function cekPassword2(){	// fungsi validasi konfirmasi password pada form pendaftaran dan ubah password
		global $ulangi_password, $class_pass2, $ulangi_passwordErr, $error;
		$error = false;
		if(empty($_POST["password2"])){		// cek kekosongan password konfirmasi
        	$ulangi_passwordErr = "*password harus diisi";
        	$class_pass2 = 'red-box';
        	$error = true;
        }else{
          	$ulangi_password =  $_POST["password2"];
          	if($ulangi_password != $_POST['password1']){		// cek kesamaan konfirmasi password dengan password
            	$ulangi_passwordErr = "*password tidak cocok";
            	$class_pass2 = 'red-box';
            	$error = true;
          	}
        }
        return $error;
	}

	function cekLike($idstatus,$user){
		global $koneksi, $username;
		$liked = 'unlike';
		$data = $koneksi->query("SELECT * from `like` where id_status ='$idstatus' and penyuka ='$user' "); 
		$dtlike = $data->rowCount() > 0;
		if($dtlike){
			$liked = 'like';
		}
		return $liked;
	}

	function likePost($idstatus,$user){
		global $koneksi;
		$data = $koneksi->query("SELECT * from `like` where id_status ='$idstatus' and penyuka ='$user' "); 
		$dtlike = $data->rowCount() > 0;
		if($dtlike){
			$koneksi->query("DELETE from `like` where id_status ='$idstatus' and penyuka ='$user' "); 
			$liked = 'unlike';
		}else{
			$data = $koneksi->query("SELECT * from `status` where id_status ='$idstatus'"); 
			$data = $data->fetchAll(PDO::FETCH_ASSOC)[0];
			$koneksi->query("INSERT INTO instaapp.`like` (penyuka,disuka,`timestamp`,id_status)
				VALUES ('$user','".$data['username']."',now(),'$idstatus');"); 
			$liked = 'like';
		}
		return $liked;
	}

	function getPost($id){	// fungsi untuk menampilkan status teman ketika membuka profil teman
		global $koneksi;
		$status = $koneksi->query("SELECT * FROM status WHERE id_status = '$id'");
		$baris = $status->rowCount();
		return $status->fetchAll(PDO::FETCH_ASSOC)[0];
	}

	// ===============

?>