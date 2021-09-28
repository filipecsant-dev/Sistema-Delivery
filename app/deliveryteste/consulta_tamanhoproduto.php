<?php
	require "conexao.php";

	$pdo = $conn;

	try{
		$listarprodutos = $pdo->query("SELECT * FROM subcategorias");

		$resultado = array();

		if($listarprodutos->rowCount() > 0){
			while($produto = $listarprodutos->fetch(PDO::FETCH_OBJ)){
				$resultado[] = array("id"=>$produto->id, "categoria"=>$produto->categoria, "tamanho"=>$produto->tamanho, "limite"=>$produto->limite);
			}

			echo json_encode($resultado);
		}else{
			return FALSE;
		}

	}catch(PDOException $e){
		echo $e->getMessage();
	}
?>