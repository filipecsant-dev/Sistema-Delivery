<?php 
	require "../funcoes/banco/conexao.php";
	function listarsubcategorias2($categoria){
		$db = $_SESSION['logado']->empresa;
		$pdo = conectar($db);
	
		try{
				


			$listarsubcategorias2 = $pdo->prepare("SELECT * FROM subcategorias WHERE categoria = ?");
			$listarsubcategorias2->bindValue(1, $categoria, PDO::PARAM_STR);
			$listarsubcategorias2->execute();

			if($listarsubcategorias2->rowCount() > 0){
				return $listarsubcategorias2->fetchAll(PDO::FETCH_OBJ);
			}else{
				
				return FALSE;
			}


		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);

	
?>
<option selected value="">- Escolha o tamanho -</option>
<?php
	if(listarsubcategorias2($categoria))
	{
		$minhacategoria = listarsubcategorias2($categoria);
		foreach ($minhacategoria as $mcat) {
?>

<option value="<?php echo $mcat->tamanho; ?>"><?php echo $mcat->tamanho; ?></option>
<?php
		}
	}
?>
<option value="Todos">Todos</option>

