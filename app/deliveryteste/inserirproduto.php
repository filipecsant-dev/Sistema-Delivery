<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    $id = $_POST['id'];
	    $produto = $_POST['produto'];
	    $tamanho = $_POST['tamanho'];
	    $sabor = $_POST['sabor'];
	    

	    require_once("conexao2.php");
	    try{

		    $query = "INSERT INTO os (pedido, produto, tamanho, sabor, adicionais) VALUES ('$id', '$produto', '$tamanho', '$sabor', '-')";


		    if(mysqli_query($conn, $query)){
		    	$response['sucesso'] = true;
		    	$response['mensagem'] = "Sucesso";
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

	