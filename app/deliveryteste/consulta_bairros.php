<?php

	require "conexao.php";

	$pdo = $conn;

	$listarbairros = $pdo->query("SELECT * FROM bairros");

	$resultado = array();

	if($listarbairros->rowCount() > 0){
		while($bairro = $listarbairros->fetch(PDO::FETCH_OBJ)){
			$resultado[] = array("id"=>$bairro->id, "bairro"=>$bairro->bairro, "valor"=>$bairro->valor);
		}

		echo json_encode($resultado);
	}else{
		echo "erro no bairro";
	}

?>