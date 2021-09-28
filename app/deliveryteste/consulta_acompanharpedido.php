<?php

	require "conexao.php";

	$pdo = $conn;

	$listaracompanhar = $pdo->query("SELECT * FROM pedidos");

	$listaracompanharos = $pdo->query("SELECT * FROM os");

	$resultado = array();

	if($listaracompanhar->rowCount() > 0){
		while($acompanhar = $listaracompanhar->fetch(PDO::FETCH_OBJ)){
			$valor = round($acompanhar->valor * 100) / 100;

			$resultado[] = array("id"=>$acompanhar->id, "data"=>$acompanhar->data, "hora"=>$acompanhar->hora, "status"=>$acompanhar->status, "endereco"=>$acompanhar->endereco, "referencia"=>$acompanhar->referencia, "observacao"=>$acompanhar->observacao, "pagamento"=>$acompanhar->pagamento, "entrega"=>$acompanhar->entrega, "valor"=>$valor);
		

		}

		while($acompanharos = $listaracompanharos->fetch(PDO::FETCH_OBJ)){
			$resultado[] = array("pedido"=>$acompanharos->pedido, "produto"=>$acompanharos->produto, "tamanho"=>$acompanharos->tamanho, "sabor"=>$acompanharos->sabor, "adicionais"=>$acompanharos->adicionais);

		}

		echo json_encode($resultado);
	}else{
		echo "erro no acompanhar";
	}

?>