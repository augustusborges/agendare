<?php
		require '../config.php';
		require BASE_DIR."lib".DS."utils.php";
		require BASE_DIR."model".DS."pessoa.php";

		$pessoa = new pessoa();

		$pessoa->fazerLogout();
		header('Location: index.php');

?>
