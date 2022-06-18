<?php
	session_start(); // memulai session
	unset($_SESSION['user']);	// untuk men-unset session user
	header("Location:./");		// dan di redirect kemabli ke home
?>	