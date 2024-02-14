<?php 
	//session_start();

    $dsn = "mysql:dbname=sepcon;host=localhost";
	//$dsn = "mysql:dbname=sepconcp;host=1192.168.110.16";
	$user = "root";
	$password = "root";

	try {
		$pdo = new PDO($dsn,$user,$password);
		$errorDbConexion = false;
	}
	catch ( PDOException $e) {
		echo 'Error al conectarnos ' . $e->getMessage();
	}

	$pdo->exec("SET CHARACTER SET utf8"); // <--utf8
?>