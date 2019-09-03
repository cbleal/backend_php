<?php 

	try {
		$pdo = new PDO("mysql:dbname=projeto_esqueciasenha;host=localhost", "root", "wsbcbl");
	} catch (PDOException $e) {
		echo "ERRO: ".$e->getMessage();
		exit;
	}

?>