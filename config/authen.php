<?php
	
	// fungsi dibawah digunakan untuk authentikasi user dengan pengecekan session
	// jika session belum ter-set maka akan dialihkan menuju halaman login

	if(!isset($_SESSION['user']) and empty($_SESSION['user'])){
		header("Location:./?page=login");
		exit();
	}
?>