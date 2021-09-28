<?php
//CONSTANTES
$teste = true;
if($teste === false){
	define('HOST', 'localhost');
	define('USUARIO', 'root');
	define('SENHA', '');
} else {
	define('HOST', 'den1.mysql6.gear.host');
	define('USUARIO', 'deliveryteste');
	define('SENHA', 'teste#');
}

//CONEXÃO
function conectar($db){
	$dns = "mysql:host=".HOST.";dbname=".$db;

	try{
		$conn = new PDO($dns, USUARIO, SENHA);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}catch(PDOException $e) {
		//echo $erro->getMessage();
		return false;
	}

}

?>