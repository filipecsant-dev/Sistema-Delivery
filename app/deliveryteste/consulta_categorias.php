<?php

	require "conexao.php";

	$pdo = $conn;

	$listarprodutos = $pdo->query("SELECT * FROM categorias");

	$resultado = array();

	if($listarprodutos->rowCount() > 0){
		while($produto = $listarprodutos->fetch(PDO::FETCH_OBJ)){
			$resultado[] = array("id"=>$produto->id, "categoria"=>$produto->categoria, "img"=>$produto->img);
		}

		echo json_encode($resultado);
	}else{
		echo "erro na categoria";
	}

?>