<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    $token = $_POST['token'];
	    

	    require_once("conexao2.php");
	    try{

		    $query = "INSERT INTO token (token) VALUES ('$token')";


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

	