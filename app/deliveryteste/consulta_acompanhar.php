<?php

	require "conexao.php";

	$pdo = $conn;

	$listaracompanhar = $pdo->query("SELECT * FROM pedidos ORDER BY id DESC");

	$resultado = array();

	if($listaracompanhar->rowCount() > 0){
		while($acompanhar = $listaracompanhar->fetch(PDO::FETCH_OBJ)){
			$resultado[] = array("pedido"=>$acompanhar->id, "data"=>$acompanhar->data, "hora"=>$acompanhar->hora, "status"=>$acompanhar->status);
		}

		echo json_encode($resultado);
	}else{
		echo "erro no acompanhar";
	}

?>