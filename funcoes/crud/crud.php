<?php
//Função de cadastro
function cadastrouser($usuario,$senha,$email,$telefone,$cargo){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	$empresa = $_SESSION['logado']->empresa;

	try{
		$cadastro = $pdo->prepare("INSERT INTO usuarios (usuario, senha, email, telefone, cargo, empresa) VALUES (?,?,?,?,?,?)");
		$cadastro->bindValue(1, $usuario, PDO::PARAM_STR);
		$cadastro->bindValue(2, md5(strrev($senha)), PDO::PARAM_STR);
		$cadastro->bindValue(3, $email, PDO::PARAM_STR);
		$cadastro->bindValue(4, $telefone, PDO::PARAM_STR);
		$cadastro->bindValue(5, $cargo, PDO::PARAM_STR);
		$cadastro->bindValue(6, $empresa, PDO::PARAM_STR);
		$cadastro->execute();

		if($cadastro->rowCount() > 0):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//VERIFICAR SE EXISTE FUNCIONARIO
function verifuser($usuario){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$verifuser = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
		$verifuser->bindValue(1,$usuario,PDO::PARAM_STR);
		$verifuser->execute();

		if($verifuser->rowCount() == 1):
			return true;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}


//FUNCAO DE LISTAR FUNCIONARIO
function listarfuncionarios(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$listarfun = $pdo->query("SELECT * FROM usuarios");

		if($listarfun->rowCount() > 0):
			return $listarfun->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO EDITAR FUNCIONARIO
function edituser($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$edituser = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
		$edituser->bindValue(1,$id,PDO::PARAM_INT);
		$edituser->execute();

		if($edituser->rowCount() > 0):
			return $edituser->fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO ATUALIZAR FUNCIONARIO
function atualizaruser($id,$usuario,$email,$telefone,$cargo){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizaruser = $pdo->prepare("UPDATE usuarios SET usuario=?, email=?, telefone=?, cargo=? WHERE id=?");
		$atualizaruser->bindValue(1,$usuario,PDO::PARAM_STR);
		$atualizaruser->bindValue(2,$email,PDO::PARAM_STR);
		$atualizaruser->bindValue(3,$telefone,PDO::PARAM_STR);
		$atualizaruser->bindValue(4,$cargo,PDO::PARAM_STR);
		$atualizaruser->bindValue(5,$id,PDO::PARAM_INT);
		$atualizaruser->execute();

		if($atualizaruser->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}


//FUNCAO DELETAR USUARIO
function delete($table,$id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$deleteuser = $pdo->prepare("DELETE FROM $table WHERE id=?");
		$deleteuser->bindValue(1,$id,PDO::PARAM_INT);
		$deleteuser->execute();

		if($deleteuser->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}


//----------------------------------- PEDIDOS REALIZADOS -------------------------->

//FUNCAO DE LISTAR PEDIDOS
function listarpedidos(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listarpedidos = $pdo->query("SELECT * FROM pedidos");

		if($listarpedidos->rowCount() > 0):
			return $listarpedidos->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO DE VISUALIZAR PEDIDO
function visualizarpedido($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$visualizarpedido = $pdo->prepare("SELECT * FROM pedidos WHERE id=?");
		$visualizarpedido->bindValue(1, $id,PDO::PARAM_INT);
		$visualizarpedido->execute();

		if($visualizarpedido->rowCount() > 0):
			return $visualizarpedido->fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO ATUALIZAR PEDIDO
function atualizarpedido($id,$status){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizarpedido = $pdo->prepare("UPDATE pedidos SET status=? WHERE id=?");
		$atualizarpedido->bindValue(1,$status,PDO::PARAM_STR);
		$atualizarpedido->bindValue(2,$id,PDO::PARAM_INT);
		$atualizarpedido->execute();

		if($atualizarpedido->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}

//FUNCAO NOTIFY
function atualizarnotify($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizarnotify = $pdo->prepare("UPDATE pedidos SET notify='1' WHERE id=?");
		$atualizarnotify->bindValue(1,$id,PDO::PARAM_INT);
		$atualizarnotify->execute();

		if($atualizarnotify->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}


//FUNCAO DE LISTAR OS
function listaros($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listaros = $pdo->prepare("SELECT * FROM os WHERE pedido=?");
		$listaros->bindValue(1, $id, PDO::PARAM_INT);
		$listaros->execute();

		if($listaros->rowCount() > 0):
			return $listaros->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO DE LISTAR OS
function listarosbebida($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listaros = $pdo->prepare("SELECT * FROM os WHERE pedido=?");
		$listaros->bindValue(1, $id, PDO::PARAM_INT);
		$listaros->execute();

		if($listaros->rowCount() > 0):
			return $listaros->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}


//-------------------------------------------- PRODUTOS ----------------------------------->

//FUNCAO DE LISTAR OS
function listarprodutos(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listarprodutos = $pdo->query("SELECT * FROM produtos");

		if($listarprodutos->rowCount() > 0):
			return $listarprodutos->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Cadastrar produto
function cadastroprod($produto,$tamanho,$sabor,$descrissao,$valor){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$cadastroprod = $pdo->prepare("INSERT INTO produtos (produto,tamanho,sabor,descrissao,valor) VALUES (?,?,?,?,?)");
		$cadastroprod->bindValue(1, $produto, PDO::PARAM_STR);
		$cadastroprod->bindValue(2, $tamanho, PDO::PARAM_STR);
		$cadastroprod->bindValue(3, $sabor, PDO::PARAM_STR);
		$cadastroprod->bindValue(4, $descrissao, PDO::PARAM_STR);
		$cadastroprod->bindValue(5, $valor, PDO::PARAM_INT);
		$cadastroprod->execute();
		if($cadastroprod->rowCount() > 0):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO EDITAR PRODUTO
function editprod($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$editprod = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
		$editprod->bindValue(1,$id,PDO::PARAM_INT);
		$editprod->execute();

		if($editprod->rowCount() > 0):
			return $editprod->fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO ATUALIZAR PRODUTO
function atualizarprod($id,$produto,$tamanho,$sabor,$descrissao,$valor){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizarprod = $pdo->prepare("UPDATE produtos SET produto=?, tamanho=?, sabor=?, descrissao=?, valor=? WHERE id=?");
		$atualizarprod->bindValue(1,$produto,PDO::PARAM_STR);
		$atualizarprod->bindValue(2,$tamanho,PDO::PARAM_STR);
		$atualizarprod->bindValue(3,$sabor,PDO::PARAM_STR);
		$atualizarprod->bindValue(4,$descrissao,PDO::PARAM_STR);
		$atualizarprod->bindValue(5,$valor,PDO::PARAM_INT);
		$atualizarprod->bindValue(6,$id,PDO::PARAM_INT);
		$atualizarprod->execute();

		if($atualizarprod->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}



//-------------------------------------------- BAIRROS ----------------------------------->

//FUNCAO DE LISTAR BAIRROS
function listarbairros(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listarbairros = $pdo->query("SELECT * FROM bairros");

		if($listarbairros->rowCount() > 0):
			return $listarbairros->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Cadastrar produto
function cadastrobairro($bairro,$valor){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$cadastrobairro = $pdo->prepare("INSERT INTO bairros (bairro,valor) VALUES (?,?)");
		$cadastrobairro->bindValue(1, $bairro, PDO::PARAM_STR);
		$cadastrobairro->bindValue(2, $valor, PDO::PARAM_INT);
		$cadastrobairro->execute();
		if($cadastrobairro->rowCount() > 0):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO EDITAR PRODUTO
function editbairro($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$editbairro = $pdo->prepare("SELECT * FROM bairros WHERE id = ?");
		$editbairro->bindValue(1,$id,PDO::PARAM_INT);
		$editbairro->execute();

		if($editbairro->rowCount() > 0):
			return $editbairro->fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO ATUALIZAR PRODUTO
function atualizarbairro($id,$bairro,$valor){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizarbairro = $pdo->prepare("UPDATE bairros SET bairro=?, valor=? WHERE id=?");
		$atualizarbairro->bindValue(1,$bairro,PDO::PARAM_STR);
		$atualizarbairro->bindValue(2,$valor,PDO::PARAM_INT);
		$atualizarbairro->bindValue(3,$id,PDO::PARAM_INT);
		$atualizarbairro->execute();

		if($atualizarbairro->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}




//-------------------------------------------- CATEGORIA PRODUTO ----------------------------------->

//FUNCAO DE LISTAR CATEGORIA
function listarcategorias(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listarcategorias = $pdo->query("SELECT * FROM categorias");

		if($listarcategorias->rowCount() > 0):
			return $listarcategorias->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Cadastrar produto
function cadastrocategoria($categoria,$img){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$cadastrocategoria = $pdo->prepare("INSERT INTO categorias (categoria,img) VALUES (?,?)");
		$cadastrocategoria->bindValue(1, $categoria, PDO::PARAM_STR);
		$cadastrocategoria->bindValue(2, $img, PDO::PARAM_STR);
		$cadastrocategoria->execute();
		if($cadastrocategoria->rowCount() > 0):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO EDITAR PRODUTO
function editcategoria($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$editcategoria = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
		$editcategoria->bindValue(1,$id,PDO::PARAM_INT);
		$editcategoria->execute();

		if($editcategoria->rowCount() > 0):
			return $editcategoria->fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO ATUALIZAR PRODUTO
function atualizarcategoria($id,$categoria,$img){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizarcategoria = $pdo->prepare("UPDATE categorias SET categoria=?, img=? WHERE id=?");
		$atualizarcategoria->bindValue(1,$categoria,PDO::PARAM_STR);
		$atualizarcategoria->bindValue(2,$img,PDO::PARAM_STR);
		$atualizarcategoria->bindValue(3,$id,PDO::PARAM_INT);
		$atualizarcategoria->execute();

		if($atualizarcategoria->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}


//-------------------------------------------- TAMANHO PRODUTO ----------------------------------->

//FUNCAO DE LISTAR TAMANHO
function listarsubcategorias(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$listarsubcategorias = $pdo->query("SELECT * FROM subcategorias");

		if($listarsubcategorias->rowCount() > 0):
			return $listarsubcategorias->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}
//LISTAR SUB CATEGORIA 2
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

//Cadastrar produto
function cadastrosubcategoria($categoria, $tamanho,$limite){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$cadastrosubcategoria = $pdo->prepare("INSERT INTO subcategorias (categoria, tamanho,limite) VALUES (?, ?,?)");
		$cadastrosubcategoria->bindValue(1, $categoria, PDO::PARAM_STR);
		$cadastrosubcategoria->bindValue(2, $tamanho, PDO::PARAM_STR);
		$cadastrosubcategoria->bindValue(3, $limite, PDO::PARAM_INT);
		$cadastrosubcategoria->execute();
		if($cadastrosubcategoria->rowCount() > 0):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO EDITAR PRODUTO
function editsubcategoria($id){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$editsubcategoria = $pdo->prepare("SELECT * FROM subcategorias WHERE id = ?");
		$editsubcategoria->bindValue(1,$id,PDO::PARAM_INT);
		$editsubcategoria->execute();

		if($editsubcategoria->rowCount() > 0):
			return $editsubcategoria->fetch(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//FUNCAO ATUALIZAR PRODUTO
function atualizarsubcategoria($id,$categoria, $tamanho,$limite){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$atualizarsubcategoria = $pdo->prepare("UPDATE subcategorias SET categoria=?, tamanho=?, limite=? WHERE id=?");
		$atualizarsubcategoria->bindValue(1,$categoria,PDO::PARAM_STR);
		$atualizarsubcategoria->bindValue(2,$tamanho,PDO::PARAM_STR);
		$atualizarsubcategoria->bindValue(3,$limite,PDO::PARAM_INT);
		$atualizarsubcategoria->bindValue(4,$id,PDO::PARAM_INT);
		$atualizarsubcategoria->execute();

		if($atualizarsubcategoria->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}

//--------------------------------------------- ESTABELECIMENTO -----------------------------------------------
//ABERTO OU FECHADO
function statusempresa(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$statusempresa = $pdo->query("SELECT * FROM empresa");

		if($statusempresa->rowCount() > 0):
			return $statusempresa->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//ALTERAR ESTADO
function alterarestado($estado){
	if($estado === '1'){$mestado = '2';}
	else{$mestado = '1';}

	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$alterarestado = $pdo->prepare("UPDATE empresa SET status=? WHERE id='1'");
		$alterarestado->bindValue(1,$mestado,PDO::PARAM_INT);
		$alterarestado->execute();

		if($alterarestado->rowCount() > 0){
			return true;
		}
		else{
			return false;
		}

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}

//vencido - perto de vencer
function alterarvencido($vencido){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$alterarvencido = $pdo->prepare("UPDATE empresa SET vencido=? WHERE id='1'");
		$alterarvencido->bindValue(1,$vencido,PDO::PARAM_INT);
		$alterarvencido->execute();

		if($alterarvencido->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}


//vencido - perto de vencer
function alterarvencimento($vencimento){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	$limiteven = date('Y-m-d', strtotime('+3 days', strtotime($vencimento)));


	try{
		$alterarvencimento = $pdo->prepare("UPDATE empresa SET vencimento=?, vencido='1', limiteven=? WHERE id='1'");
		$alterarvencimento->bindValue(1,$vencimento,PDO::PARAM_STR);
		$alterarvencimento->bindValue(2,$limiteven,PDO::PARAM_STR);
		$alterarvencimento->execute();

		if($alterarvencimento->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}

//ALTERAR ESTADO VENCIDO
function alterarestadovencido(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$alterarestado = $pdo->prepare("UPDATE empresa SET status='2' WHERE id='1'");
		$alterarestado->execute();

		if($alterarestado->rowCount() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}

//Financeiro
function financeiro(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$financeiro = $pdo->query("SELECT * FROM pedidos");

		if($financeiro->rowCount() > 0):
			return $financeiro->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

function financeiro2($visu){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$financeiro = $pdo->prepare("SELECT * FROM pedidos WHERE data=?");
		$financeiro->bindValue(1, $visu, PDO::PARAM_STR);
		$financeiro->execute();

		if($financeiro->rowCount() > 0):
			return $financeiro->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}


//RELATORIO

function relatoriocon($data1, $data2){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$relatoriocon = $pdo->prepare("SELECT * FROM pedidos WHERE data >= ? AND data < ?");
		$relatoriocon->bindValue(1, $data1, PDO::PARAM_STR);
		$relatoriocon->bindValue(2, $data2, PDO::PARAM_STR);
		$relatoriocon->execute();

		echo $relatoriocon->rowCount();

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

function relatorio2($data){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$relatorio2 = $pdo->prepare("SELECT * FROM pedidos WHERE data = ?");
		$relatorio2->bindValue(1, $data, PDO::PARAM_STR);
		$relatorio2->execute();

		echo $relatorio2->rowCount();

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}






//FUNCAO DE QNT OS
function qntclientes(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{

		$qntclientes = $pdo->query("SELECT * FROM token");

		echo $qntclientes->rowCount();

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//SELECIONAR TOKEN
function selecttoken(){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$selecttoken = $pdo->query("SELECT * FROM token");

		if($selecttoken->rowCount() > 0):
			return $selecttoken->fetchAll(PDO::FETCH_OBJ);
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//VERIFICAR SE EXISTE TOKEN
function veriftoken($token){
	$db = $_SESSION['logado']->empresa;
	$pdo = conectar($db);

	try{
		$veriftoken = $pdo->prepare("SELECT * FROM token WHERE token = ?");
		$veriftoken->bindValue(1,$token,PDO::PARAM_STR);
		$veriftoken->execute();

		if($veriftoken->rowCount() > 1):
			return true;
		else:
			return FALSE;
		endif;

	}catch(PDOException $e){
		echo $e->getMessage();
	}
}




//ENVIAR NOTIFICACAO

function send_notification($token,$titulo,$mensagem)
{

define( 'API_ACCESS_KEY', 'AAAADsf3ncQ:APA91bELSXAbc0mGPhRxSm1UHxDjwigiEU-IRhzKGETJ5LnW4cOQ8aQ8rx9nmxVrFpLwLlSaBGYU_RRrhYp5emxHKfvoVqybG2qxC6MLfTlOsNxhbyQFw3UA-vYjlkOGgm06byVnDT7r');
 //   $registrationIds = ;
#prep the bundle
     $msg = array
          (
		'body' 	=> $mensagem,
		'title'	=> $titulo,
             	
          );
	$fields = array
			(
				'to'		=> $token,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		echo $result;
		curl_close( $ch );
}