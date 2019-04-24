<?php
		include 'config.php';
		include BASE_DIR."lib".DS."Login.php";
		
		$login = new Login();
		$login->doLogout(); 
		setcookie('userEmail');
		setcookie('userPassword');
		header('Location: index.php');		

?>