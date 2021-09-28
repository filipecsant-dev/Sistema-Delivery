<?php

	require "conexao.php";

	$pdo = $conn;

	$verestado = $pdo->query("SELECT status FROM empresa");

	$resultado = array();

	if($verestado->rowCount() > 0){
		while($estado = $verestado->fetch(PDO::FETCH_OBJ)){
			$resultado[] = array("estado"=>$estado->status);
		}

		echo json_encode($resultado);
	}else{
		echo "erro no estado";
	}

?>