<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    $data = $_POST['data'];
	    $hora = $_POST['hora'];
	    $nome = $_POST['nome'];
	    $telefone = $_POST['telefone'];
	    $endereco = $_POST['endereco'];
	    $referencia = $_POST['referencia'];
	    $pagamento = $_POST['pagamento'];
	    $entrega = $_POST['entrega'];
	    $valorpedido = $_POST['valorpedido'];
	    $valortotal = $_POST['valortotal'];
	    $observacao = $_POST['observacao'];
	    $valorentrega = $_POST['valorentrega'];
	    $qnt = $_POST['qnt'];
	    $troco = $_POST['troco'];
	    $valorcartao = $_POST['valorcartao'];
	    $token = $_POST['token'];

	    require_once("conexao2.php");
	    try{

		    $query = "INSERT INTO pedidos (cliente, data, hora, telefone, endereco, referencia, status, observacao, pagamento, entrega, valorentrega, valorcartao, valorprodutos, troco, valor, qnt, token, notify) VALUES ('$nome', '$data', '$hora', '$telefone', '$endereco', '$referencia','Enviado', '$observacao', '$pagamento', '$entrega', $valorentrega, $valorcartao, '$valorpedido', '$troco', '$valortotal', '$qnt', '$token', 0)";


		    if(mysqli_query($conn, $query)){
		    	$response['sucesso'] = true;
		    	$response['mensagem'] = "Sucesso";
		    	$response['id'] = mysqli_insert_id($conn);
		    }else{
		    	$response['sucesso'] = false;
		    	$response['mensagem'] = "Falha";
		    }
			
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}

	} else {
		$response['sucesso'] = false;
	    $response['mensagem'] = "Erro";
	}

	echo json_encode($response);

	