<?php
ob_start(); session_start();
require '../funcoes/banco/conexao.php';
require '../funcoes/login/login.php';
require '../funcoes/crud/crud.php';
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) {
	//LOGIN
	case 'login':
		$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
		$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
		$db = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
			
			if($db != ''){
				if(conectar($db) != false){
				 	if(login($usuario, $senha, $db)){
						//ENTRA
			  			$_SESSION['logado'] = pegalogin($usuario, $db);
					}else{
						echo 'logerrado';
					}
				} else {
					echo 'emperro';
				}
			} else {
				echo 'emperro';
			}

		break;

		//CADASTRO FUNCIONARIO
		case 'cadastrouser':
			$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
			$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
			$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
			$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
			$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

			if ($cargo != '0') {
				if(verifuser($usuario)){
					echo 'existente';
				} else {
					if (cadastrouser($usuario,$senha,$email,$telefone,$cargo)) {
						echo 'cadastrou';
					} else {
						echo 'erro';
					}
				}
			} else{
				echo 'valorerrado';
			}
		break;

		//EXCLUIR
		case 'excluir':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$table = filter_input(INPUT_POST, 'table', FILTER_SANITIZE_STRING);

			if (delete($table,$id)) {
				echo "deletou";
			} else{
				echo "nao deletou";
			}
			
		break;


		//LISTAR FUNCIONARIOS
		case 'listar_fun':
			if (listarfuncionarios()) { 
				$funcionarios = listarfuncionarios();
				foreach ($funcionarios as $fun) {
				?>
					<tr>
		              <td><?php echo $fun->usuario; ?></td>
		              <td><?php echo $fun->email; ?></td>
		              <td><?php echo $fun->telefone; ?></td>
		              <td><?php if($fun->cargo === '1'){echo 'Atendente';}elseif($fun->cargo === '2'){echo 'Gerente';}elseif($fun->cargo === '3'){echo 'Dono';}else{echo 'Administrador';} ?></td>
		              <td style="width: 200px;"><?php if($fun->cargo != '4'){ ?><button type="button" id="editar_user" data-id="<?php echo $fun->id; ?>" class="btn btn-warning" style="color:#fff;font-size:13px;">Editar</button><button type="button" id="excluir_user" data-id="<?php echo $fun->id; ?>" class="btn btn-danger" style="margin-left: 5px;font-size:13px;">Excluir</button><?php } ?>
		            	</td>
		            </tr>

			<?php
				}
			}
		break;
		
		//FUNCAO EDITAR USUARIO
		case 'edituser':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
			$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
			$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
			$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

			if (atualizaruser($id,$usuario,$email,$telefone,$cargo)) {
				echo "atualizou";
			} else {
				echo "erro";
			}
			
		break;

//--------------------------------------- PEDIDOS REALIZADOS -------------------------------->

		//LISTAR PEDIDOS
		case 'listar_pedidos':
		$novo = filter_input(INPUT_POST, 'novo', FILTER_SANITIZE_STRING);
			if (listarpedidos()) { 
				$pedidos = listarpedidos();
				foreach ($pedidos as $ped) {
					if($ped->status === "Enviado" or $ped->status === "Está sendo preparado" or $ped->status === "Está na fila"){


						$peddata = date('d/m/Y', strtotime($ped->data));
				?>
					<tr>
		              <th><center>
		              	<button type="button" id="imprimir_pedido" data-id="<?php echo $ped->id; ?>" class="btn btn-warning" style="background-image: url(img/impressora.png); width: 50px;height: 35px;"></button>
		              </center></th>
		              <th style="padding-top:8px;"><center><?php echo $ped->id; ?></center></th>
		              <th><center><?php echo $ped->cliente; ?></center></th>
		              <th><center><?php echo $peddata; ?></center></th>
		              <th><center><?php echo $ped->hora; ?></center></th>
		              <th><center><?php echo $ped->status; ?></center></th>
		              <th><center><?php echo $ped->observacao; ?></center></th>
		              <th><center><?php echo $ped->pagamento; ?></center></th>
		              <th><center><?php echo number_format($ped->valor, 2, ',', '.'); ?></center></th>
		              <th><center><?php echo $ped->entrega; ?></center></th>
		              <th style="width:180px;"><center>
		              	<button type="button" id="recebido_pedido" data-id="<?php echo $ped->id; ?>" data-token="<?php echo $ped->token; ?>" class="btn btn-info" style="background-image: url(img/recebido.png); width: 50px;height: 35px;"></button>
		              	<button type="button" id="naorecebido_pedido" data-id="<?php echo $ped->id; ?>" data-token="<?php echo $ped->token; ?>" class="btn btn-danger" style="background-image: url(img/naorecebido.png); width: 50px;height: 35px;"></button>
		              	<?php
		              	if($ped->entrega === "Entrega"){
		              	?>
		              	<button type="button" id="entrega_pedido" data-id="<?php echo $ped->id; ?>" data-token="<?php echo $ped->token; ?>" class="btn btn-success" style="background-image: url(img/entrega.png); width: 50px;height: 35px;"></button>
	              		<?php
		            	}else{
	              		?>
	              		<button type="button" id="retirada_pedido" data-id="<?php echo $ped->id; ?>" data-token="<?php echo $ped->token; ?>" class="btn btn-success" style="background-image: url(img/retirada.png); width: 50px;height: 35px;"></button>
	              		<?php
		            	}
	              		?>

		              </center></th>
		            </tr>
		            

			<?php
						//NOTIFY
						if($ped->notify == 0){
							
							atualizarnotify($ped->id);
							
							echo'
							

							<script type="text/javascript">

								var icon = "img/exemplo-nestweb.png";
								var title = "Novo pedido!";
								var mensagem = "acabou de chegar um novo pedido de n° '. $ped->id .' do cliente '. $ped->cliente .'.";

							    notifyMe(icon, title, mensagem);

							    function notifyMe(icon, title, mensagem, link){
									if(!Notification){
										alert("O navegador que você está utilizando é antigo. Por favor utilize o Chrome!");
										return;
									}

									if(Notification.permission !== "granted"){
										Notification.requestPermission();
									} else {
										var notification = new Notification(title, {
											icon: icon,
											body: mensagem
											});
											
											somativo();						
									}
								}


								
							</script>

								';						
							
					
						}

					}
				}
			}
		break;

		//LISTAR TODOS PEDIDOS
		case 'listar_todospedidos':
			if (listarpedidos()) { 
				$pedidos = listarpedidos();
				foreach ($pedidos as $ped) {
					$peddata = date('d/m/Y', strtotime($ped->data));
				?>
					<tr>
		              <th><center>
		              	<button type="button" id="imprimir_pedido" data-id="<?php echo $ped->id; ?>" class="btn btn-warning" style="background-image: url(img/impressora.png); width: 50px;height: 35px;"></button>
		              </center></th>
		              <th style="padding-top:8px;"><center><?php echo $ped->id; ?></center></th>
		              <th><center><?php echo $ped->cliente; ?></center></th>
		              <th><center><?php echo $peddata; ?></center></th>
		              <th><center><?php echo $ped->hora; ?></center></th>
		              <th><center><?php echo $ped->status; ?></center></th>
		              <th><center><?php echo $ped->observacao; ?></center></th>
		              <th><center><?php echo $ped->pagamento; ?></center></th>
		              <th><center><?php echo number_format($ped->valor, 2, ',', '.'); ?></center></th>
		              <th><center><?php echo $ped->entrega; ?></center></th>
		              <th style="width:180px;"><center>
		              	<?php 
		              	if($ped->status !== "Cancelado" && $ped->status !== "Entregue"){
		              	?>
		              	<button type="button" id="pedido_cancelado" data-id="<?php echo $ped->id; ?>" data-token="<?php echo $ped->token; ?>" class="btn btn-link" style="background-image: url(img/cancelar.png); width: 50px;height: 35px;"></button>
		              	<button type="button" id="pedido_entregue" data-id="<?php echo $ped->id; ?>" data-token="<?php echo $ped->token; ?>" class="btn btn-link" style="background-image: url(img/ok.png); width: 50px;height: 35px;"></button>
		              </center>
		              <?php
		          	}
		              ?>
		          </th>
		            </tr>

			<?php
				}
			}
		break;

		//VISUALIZAR E IMPRIMIR PEDIDO
		case 'imprimir_pedido';
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$ped = visualizarpedido($id);
			$data = date('d/m/Y', strtotime($ped->data));
			?>
				<form style="font-size: 17px;" action="" name="form-imp" data-id="<?php echo $ped->id ?>">
				   <div class="form-group row">
				   	<label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Cliente:</label>
				    <div class="col">
				      <label class="form-control" ><?php echo $ped->cliente; ?></label>
				    </div>
				  </div>
				  <div class="form-group row">
				   	<label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Data:</label>
				    <div class="col">
				       <label class="form-control"><?php echo $data; ?></label>
				  </div>
				</div>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Hora:</label>
				    <div class="col-sm-10">
				      <label class="form-control"><?php echo $ped->hora; ?></label>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Status:</label>
				    <div class="col-sm-10">
				       <label class="form-control"><?php echo $ped->status; ?></label>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Obs:</label>
				    <div class="col-sm-10">
				       <label  class="form-control"><?php echo $ped->observacao; ?></label>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Pagam.:</label>
				    <div class="col-sm-10">
				       <label class="form-control"><?php echo $ped->pagamento; ?></label>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Valor:</label>
				    <div class="col-sm-10">
				      <label  class="form-control"><?php echo number_format($ped->valor, 2, ',', '.'); ?></label>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-2 col-form-label" style="font-weight: bold;">Entrega:</label>
				    <div class="col-sm-10">
				      <label  class="form-control"><?php echo $ped->entrega; ?></label>
				    </div>
				  </div>

				  <input type="hidden" name="id" value="<?php echo $ped->id; ?>" />
				  <div class="col-auto my-1">
				      <button type="submit" class="btn btn-primary">Imprimir Pedido</button>
				      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
				    </div>
				  </div>
				  <br />
				</form>
			<?php
		break;

		//   
		//ATUALIZAR STATUS PEDIDO
		case 'atualizar_pedido':
			
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
			$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
			$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
			$mensagem = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);

			if(atualizarpedido($id,$status)){

				send_notification($token,$titulo,$mensagem);

			} else {
				echo "erro";
			}
		break;

//--------------------------------------- FIM PEDIDOS REALIZADOS -------------------------------->

//----------------------------------------------- PRODUTOS ----------------------------------------------------------

		case 'listar_produtos':
		if(listarprodutos()){
			$listarprodutos = listarprodutos();
			foreach ($listarprodutos as $prod) {
			
		?>
					<tr>
		              <th><?php echo $prod->produto; ?></th>
		              <th><?php echo $prod->tamanho; ?></th>
		              <th><?php echo $prod->sabor; ?></th>
		              <th><?php echo $prod->descrissao; ?></th>
		              <th><?php echo number_format($prod->valor/100, 2, ',', '.'); ?></th>
		              <th style="width:180px;">
		              	<button type="button" id="editar_prod" data-id="<?php echo $prod->id; ?>" class="btn btn-warning" style="color:#fff;font-size:13px;">Editar</button><button type="button" id="excluir_prod" data-id="<?php echo $prod->id; ?>" class="btn btn-danger" style="margin-left: 5px;font-size:13px;">Excluir</button>
		          	</th>
		           </tr>
		<?php
			}
		}
		break;

		case 'cadastroprod':
			$produto = filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_STRING);
			$tamanho = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_STRING);
			$sabor = filter_input(INPUT_POST, 'sabor', FILTER_SANITIZE_STRING);
			$descrissao = filter_input(INPUT_POST, 'descrissao', FILTER_SANITIZE_STRING);
			$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_INT);
			
			if($tamanho != ""){
				if (cadastroprod($produto,$tamanho,$sabor,$descrissao,$valor)) {
					echo "cadastrou";
				} else {
					echo "erro";
				}
			}
		break;

		//FUNCAO EDITAR PRODUTO
		case 'editprod':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$produto = filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_STRING);
			$tamanho = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_STRING);
			$sabor = filter_input(INPUT_POST, 'sabor', FILTER_SANITIZE_STRING);
			$descrissao = filter_input(INPUT_POST, 'descrissao', FILTER_SANITIZE_STRING);
			$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_INT);

			if (atualizarprod($id,$produto,$tamanho,$sabor,$descrissao,$valor)) {
				echo "atualizou";
			} else {
				echo "erro";
			}
			
		break;

//-------------------------------------------- FIM PRODUTOS ----------------------------------------------------------


//----------------------------------------------- BAIRRO ----------------------------------------------------------

		case 'listar_bairros':
		if(listarbairros()){
			$listarbairros = listarbairros();
			foreach ($listarbairros as $bairro) {
			
		?>
					<tr>
		              <th><?php echo $bairro->bairro; ?></th>
		              <th><?php echo number_format($bairro->valor/100, 2, ',', '.'); ?></th>
		              <th style="width:180px;">
		              	<button type="button" id="editar_bairro" data-id="<?php echo $bairro->id; ?>" class="btn btn-warning" style="color:#fff;font-size:13px;">Editar</button><button type="button" id="excluir_bairro" data-id="<?php echo $bairro->id; ?>" class="btn btn-danger" style="margin-left: 5px;font-size:13px;">Excluir</button>
		          	</th>
		           </tr>
		<?php
			}
		}
		break;

		case 'cadastrobairro':
			$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
			$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_INT);
			

			if (cadastrobairro($bairro,$valor)) {
				echo 'cadastrou';
			} else {
				echo 'erro';
			}

		break;

		//FUNCAO EDITAR BAIRRO
		case 'editbairro':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
			$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_INT);

			if (atualizarbairro($id,$bairro,$valor)) {
				echo "atualizou";
			} else {
				echo "erro";
			}
			
		break;

//-------------------------------------------- FIM BAIRROS ----------------------------------------------------------


//----------------------------------------------- CATEGORIAS ----------------------------------------------------------

		case 'listar_categorias':
		if(listarcategorias()){
			$listarcategorias = listarcategorias();
			foreach ($listarcategorias as $categoria) {
			
		?>
					<tr>
		              <th><?php echo $categoria->categoria; ?></th>
		              <th style="width:180px;">
		              	<button type="button" id="editar_categoria" data-id="<?php echo $categoria->id; ?>" class="btn btn-warning" style="color:#fff;font-size:13px;">Editar</button><button type="button" id="excluir_categoria" data-id="<?php echo $categoria->id; ?>" class="btn btn-danger" style="margin-left: 5px;font-size:13px;">Excluir</button>
		          	</th>
		           </tr>
		<?php
			}
		}
		break;

		case 'cadastrocategoria':
			$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
			$img = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
			

			if (cadastrocategoria($categoria,$img)) {
				echo 'cadastrou';
			} else {
				echo 'erro';
			}

		break;

		//FUNCAO EDITAR categoria
		case 'editcategoria':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
			$img = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);

			if (atualizarcategoria($id,$categoria,$img)) {
				echo "atualizou";
			} else {
				echo "erro";
			}
			
		break;

//------------------------------------------ FIM CATEGORIAS ----------------------------------------------------------


//----------------------------------------------- TAMANHO ----------------------------------------------------------

		case 'listar_subcategorias':
		if(listarsubcategorias()){
			$listarsubcategorias = listarsubcategorias();
			foreach ($listarsubcategorias as $categoria) {
			
		?>
					<tr>
		              <th><?php echo $categoria->categoria; ?></th>
		              <th><?php echo $categoria->tamanho; ?></th>
		              <th><?php if($categoria->limite == '0'){ echo 'Não'; } else { echo $categoria->limite; } ?></th>
		              <th style="width:180px;">
		              	<button type="button" id="editar_subcategoria" data-id="<?php echo $categoria->id; ?>" class="btn btn-warning" style="color:#fff;font-size:13px;">Editar</button><button type="button" id="excluir_subcategoria" data-id="<?php echo $categoria->id; ?>" class="btn btn-danger" style="margin-left: 5px;font-size:13px;">Excluir</button>
		          	</th>
		           </tr>
		<?php
			}
		}
		break;

		case 'cadastrosubcategoria':
			$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
			$tamanho = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_STRING);
			$limite = filter_input(INPUT_POST, 'limite', FILTER_SANITIZE_NUMBER_INT);
			

			if (cadastrosubcategoria($categoria,$tamanho,$limite)) {
				echo 'cadastrou';
			} else {
				echo 'erro';
			}

		break;

		//FUNCAO EDITAR categoria
		case 'editsubcategoria':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
			$tamanho = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_STRING);
			$limite = filter_input(INPUT_POST, 'limite', FILTER_SANITIZE_NUMBER_INT);

			if (atualizarsubcategoria($id,$categoria,$tamanho, $limite)) {
				echo "atualizou";
			} else {
				echo "erro";
			}
			
		break;

//------------------------------------------ FIM TAMANHO ----------------------------------------------------------

	//FUNCAO ALTERAR ESTADO
		case 'alterarestado':
			$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_NUMBER_INT);

			if (alterarestado($estado)) {
				echo "atualizou";
			} else {
				echo "erro";
			}
		break;
			

//--------------------------------------- FINANCEIRO --------------------------------------------------
	case 'attfinanceiro':
	$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
	$visu = $data;
	?>
		<tr>
              <?php

                if(financeiro2($visu)){
                  $financeiro = financeiro2($visu);
                  $bebida = '0';
                  $produtos = '0';
                  $total = '0';
                  foreach ($financeiro as $fin) {
                      $bebida += $fin->valorbebida;
                      $produtos += $fin->valorprodutos;
                      $total += $fin->valor;
                  }
                  ?>
                    <td>R$ <?php echo number_format($produtos, 2, ',', '.'); ?></td>
                    <td>R$ <?php echo number_format($total, 2, ',', '.'); ?></td>
                  <?php 
                } else{
                    ?>
                  
                    <td colspan="3" style="font-size: 15px;"><center>Nenhum pedido realizado este dia!</center></td>
                  
                    <?php
                }
              ?>
              
            </tr>
		<?php

	break;

	//--------------------------------------- RELATÓRIO --------------------------------------------------
	case 'attrelatorio':
	$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
	?>
		<tr>
                <td><center><?php echo relatorio2($data); ?></center></td>
            </tr>
		<?php

	break;

	//ENVIAR NOTIFICACAO GERAL
	case 'notify_geral':
		$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
		$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
		
		if($titulo != "" && $mensagem != ""){
			if(selecttoken()){
				$selecttok = selecttoken();
				foreach ($selecttok as $tok) {
					$token = $tok->token;
					if(veriftoken($token)){
						delete("token",$tok->id);
					} else {
						send_notification($token,$titulo,$mensagem);
					}
				}
			} else {
				echo "erro";
			}

		} else {
			echo "erro1";
		}
		
	break;



	//ERRO
	default:
		echo 'Erro';
		break;
}
ob_end_flush();