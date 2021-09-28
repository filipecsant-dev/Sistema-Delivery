<?php
	require "conexao.php";

	$pdo = $conn;

	try{
		$listarprodutos = $pdo->query("SELECT * FROM produtos");

		$resultado = array();

		if($listarprodutos->rowCount() > 0){
			while($produto = $listarprodutos->fetch(PDO::FETCH_OBJ)){
				$resultado[] = array("id"=>$produto->id, "produto"=>$produto->produto, "tamanho"=>$produto->tamanho, "sabor"=>$produto->sabor, "valor"=>$produto->valor, "descrissao"=>$produto->descrissao);
			}

			echo json_encode($resultado);
		}else{
			return FALSE;
		}

	}catch(PDOException $e){
		echo $e->getMessage();
	}
?>