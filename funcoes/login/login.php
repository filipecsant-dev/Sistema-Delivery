<?php
// Login
function login($usuario,$senha, $db){
	 $pdo = conectar($db);

	try{
		$logar = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
		$logar->bindValue(1, $usuario, PDO::PARAM_STR);
		$logar->bindValue(2, md5(strrev($senha)), PDO::PARAM_STR);
		$logar->execute();

		if($logar->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}

function pegalogin($usuario, $db){
	$pdo = conectar($db);

	try{
		$bylogin = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
		$bylogin->bindValue(1, $usuario, PDO::PARAM_STR);
		$bylogin->execute();

		if($bylogin->rowCount() == 1):
			return $bylogin -> fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Logado
function logado(){
	if (!isset($_SESSION['logado']) || empty($_SESSION['logado'])) {
		header("Location: index.php");
	} else {
		return true;
	}
	
}
?>