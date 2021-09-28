<?php
//CONSTANTES
$teste = true;
if($teste === false){
	define('HOST', 'localhost');
	define('USUARIO', 'root');
	define('SENHA', '');
	define('DB', 'delivery');
} else {
	define('HOST', 'den1.mysql6.gear.host');
	define('USUARIO', 'deliveryteste');
	define('SENHA', 'teste#');
	define('DB', 'deliveryteste');
}

	$dns = "mysql:host=".HOST.";dbname=".DB;

	try{
		$conn = new PDO($dns, USUARIO, SENHA);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}catch(PDOException $erro){
		echo $erro->getMessage();
	}

	
?>