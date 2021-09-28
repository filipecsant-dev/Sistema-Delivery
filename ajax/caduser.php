
<?php
ob_start(); session_start();
require '../funcoes/banco/conexao.php';
require '../funcoes/login/login.php';
require '../funcoes/crud/crud.php';
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) {
	//CADASTRAR USUÁRIO	
	case 'form_cad':

		?>	
		<script>
			$('#telefone').mask('(99) 99999-9999');
		</script>
		<div class="aviso"></div>
		<form action="" name="form_cad" method="post">
		   <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
		    <div class="col">
		      <input type="text" class="form-control" name="usuario" placeholder="Nome">
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label" >Telefone</label>
		    <div class="col">
		      <input class="form-control" type="text" name="telefone" id="telefone" placeholder="(99) 99999-9999">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
		    <div class="col-sm-10">
		      <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
		    <div class="col-sm-10">
		      <input type="password" class="form-control" name="senha" id="inputPassword" placeholder="Senha">
		    </div>
		  </div>
		  <div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Cargo</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="cargo" id="inlineFormCustomSelect">
		        <option selected value="0">Selecione</option>
		        <option value="1">Atendente</option>
		        <option value="2">Gerente</option>
		        <option value="3">Dono</option>
		      </select>
		    </div>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Cadastrar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <br />
		  <div class="aviso2"></div>
		</form>
		<?php
		break;


		//EXCLUIR USUÁRIO
		case 'form_excluir':
		?>
		<div class="aviso"></div>
		<form action="" name="form_excluir" method="post">
		  <div class="form-group row">
		   	<label style="margin-left:30px;">Deseja realmente excluir este funcionário?</label>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Excluir</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  <br />
		</form>

		<?php
		break;


		//EDITAR FUNCIONARIO DADOS
		case 'form_edit':
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$dados = edituser($id);
		?>	
		<script>
			$('#telefone').mask('(99) 99999-9999');
		</script>
		<div class="aviso"></div>
		<form action="" name="form_edituser" method="post">
		   <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
		    <div class="col">
		      <input type="text" class="form-control" value="<?php echo $dados->usuario; ?>" name="usuario" placeholder="Nome">
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label" >Telefone</label>
		    <div class="col">
		      <input class="form-control" type="text" name="telefone" value="<?php echo $dados->telefone; ?>" id="telefone" placeholder="(99) 99999-9999">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
		    <div class="col-sm-10">
		      <input type="email" class="form-control" name="email" value="<?php echo $dados->email; ?>" id="inputEmail3" placeholder="Email">
		    </div>
		  </div>
		  <div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Cargo</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="cargo" id="inlineFormCustomSelect">
		        <option <?php if($dados->cargo === "1") echo 'Selected' ?> value="1">Atendente</option>
		        <option <?php if($dados->cargo === "2") echo 'Selected' ?> value="2">Gerente</option>
		        <option <?php if($dados->cargo === "3") echo 'Selected' ?> value="3">Dono</option>
		      </select>
		    </div>
		  </div>
		  <input type="hidden" name="id" value="<?php echo $dados->id; ?>" />
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Atualizar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <br />
		  <div class="aviso2"></div>
		</form>
		<?php
		break;

//--------------------------------------------- PRODUTO ---------------------------------------------------
		case 'cad_produto':
			?>	
		<script>
			$('#valormoeda').mask('99,99');
		</script>
		<div class="aviso"></div>
		<form action="" name="form_prod" method="post">
   		  <div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Produto</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="produto" id="produto" >
		      	<option selected value="">- Escolha o produto -</option>
		      <?php
		    if(listarcategorias()){
		    	$listarcategorias = listarcategorias();
		    	foreach ($listarcategorias as $cat) {
		      ?>
		        <option data-id="<?php echo $cat->categoria; ?>" value="<?php echo $cat->categoria; ?>"><?php echo $cat->categoria; ?></option>
		      <?php
		      	}
		  	}
		      ?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Tamanho</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="tamanho" id="tamanho">
		      	<option selected value="">- Escolha o produto -</option>
		      </select>
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Sabor</label>
		    <div class="col">
		      <input type="text" class="form-control" name="sabor" placeholder="Sabor">
		    </div>
		  </div>
		   <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Descrissão</label>
		    <div class="col">
		      <input type="text" class="form-control" name="descrissao" placeholder="Descrissão">
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label" >Valor</label>
		    <div class="col">
		      <input id="valormoeda" type="text" class="form-control" name="valor" placeholder="Valor (ex: 09,00 | 10,00)">
		    </div>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Cadastrar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		</form>
		<?php
		break;

		//EDITAR PRODUTO DADOS
		case 'form_editprod':
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$dados = editprod($id);
		?>	
		<script>
			$('#valormoeda').mask('99,99');
		</script>
		<div class="aviso"></div>
		<form action="" name="form_editprod" method="post">
   		  <div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Produto</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="produto" id="inlineFormCustomSelect">
		        <option value="<?php echo $dados->produto ?>"><?php echo $dados->produto ?></option>
		      </select>
		    </div>
		  </div>
		  <div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Tamanho</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="tamanho" id="tamanho">
		      	<?php
		    if(listarsubcategorias2($dados->produto)){
		    	$listarcategorias = listarsubcategorias2($dados->produto);
		    	foreach ($listarcategorias as $cat) {
		      ?>
		        <option <?php if($dados->tamanho == $cat->tamanho) echo "selected" ?> value="<?php echo $cat->tamanho ?>"><?php echo $cat->tamanho ?></option>
		      <?php
		      	}
		  	}
		      ?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Sabor</label>
		    <div class="col">
		      <input type="text" class="form-control" name="sabor" placeholder="Sabor" value="<?php echo $dados->sabor; ?>">
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Descrissão</label>
		    <div class="col">
		      <input type="text" class="form-control" name="descrissao" placeholder="Descrissão" value="<?php echo $dados->descrissao; ?>">
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label" >Valor</label>
		    <div class="col">
		      <input type="text" id="valormoeda" class="form-control" name="valor" placeholder="Valor (ex: 9,00 | 10,00)" value="<?php echo $dados->valor; ?>"> 
		    </div>
		  </div>
		  <input type="hidden" name="id" value="<?php echo $dados->id; ?>" />
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Atualizar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <div class="aviso2"></div>
		</form>
		<?php
		break;

		//EXCLUIR PRODUTO
		case 'form_prodexcluir':
		?>
		<div class="aviso"></div>
		<form action="" name="form_prodexcluir" method="post">
		  <div class="form-group row">
		   	<label style="margin-left:30px;">Deseja realmente excluir este produto?</label>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Excluir</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  <br />
		</form>

		<?php
		break;

//-------------------------------------------- FIM PRODUTO -------------------------------------------------


//--------------------------------------------- BAIRRO ---------------------------------------------------
		case 'cad_bairro':
			?>	
		<script>
			$('#valormoeda').mask('99,99');
		</script>
		<div class="aviso"></div>
		<form action="" name="form_bairro" method="post">
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Bairro</label>
		    <div class="col">
		      <input type="text" class="form-control" name="bairro" placeholder="Bairro (ex: Gleba A)" >
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label" >Valor</label>
		    <div class="col">
		      <input id="valormoeda" type="text" class="form-control" name="valor" placeholder="Valor (ex: 9,00 | 10,00)">
		    </div>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Cadastrar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		</form>
		<?php
		break;
		
		//EDITAR BAIRRO DADOS
		case 'form_editbairro':
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$dados = editbairro($id);
		?>	
		<script>
			$('#valormoeda').mask('99,99');
		</script>
		<div class="aviso"></div>
		<form action="" name="form_editbairro" method="post">
   		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Bairro</label>
		    <div class="col">
		      <input type="text" class="form-control" name="bairro" placeholder="Bairro (ex: Gleba A)" value="<?php echo $dados->bairro; ?>" >
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label" >Valor</label>
		    <div class="col">
		      <input id="valormoeda" type="text" class="form-control" name="valor" placeholder="Valor (ex: 9,00 | 10:00)" value="<?php echo $dados->valor; ?>">
		    </div>
		  </div>
		  <input type="hidden" name="id" value="<?php echo $dados->id; ?>" />
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Atualizar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <div class="aviso2"></div>
		</form>
		<?php
		break;

		//EXCLUIR BAIRRO
		case 'form_bairroexcluir':
		?>
		<div class="aviso"></div>
		<form action="" name="form_bairroexcluir" method="post">
		  <div class="form-group row">
		   	<label style="margin-left:30px;">Deseja realmente excluir este Bairro?</label>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Excluir</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  <br />
		</form>

		<?php
		break;

//-------------------------------------------- FIM BAIRRO -------------------------------------------------


//--------------------------------------------- CATEGORIA ---------------------------------------------------
		case 'cad_categoria':
			?>	
		<div class="aviso"></div>
		<form action="" name="form_categoria" method="post">
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Categoria</label>
		    <div class="col">
		      <input type="text" class="form-control" name="categoria" placeholder="Categoria (ex: Pizza, Bebida, Açai, etc.)" >
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Imagem</label>
		    <div class="col">
		      <input type="text" class="form-control" name="img" placeholder="Cole o link da imagem (200x200)" >
		    </div>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Cadastrar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		</form>
		<?php
		break;

		//EDITAR CATEGORIA DADOS
		case 'form_editcategoria':
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$dados = editcategoria($id);
		?>	
		<div class="aviso"></div>
		<form action="" name="form_editcategoria" method="post">
   		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Categoria</label>
		    <div class="col">
		      <input type="text" class="form-control" name="categoria" placeholder="Categoria (ex: Pizza, Bebida, Açai, etc.)" value="<?php echo $dados->categoria; ?>" >
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Imagem</label>
		    <div class="col">
		      <input type="text" class="form-control" name="img" placeholder="Cole o link da imagem (200x200)" value="<?php echo $dados->img; ?>" >
		    </div>
		  </div>
		  <input type="hidden" name="id" value="<?php echo $dados->id; ?>" />
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Atualizar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <div class="aviso2"></div>
		</form>
		<?php
		break;

		//EXCLUIR CATEGORIA
		case 'form_categoriaexcluir':
		?>
		<div class="aviso"></div>
		<form action="" name="form_categoriaexcluir" method="post">
		  <div class="form-group row">
		   	<label style="margin-left:30px;">Deseja realmente excluir esta Categoria?</label>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Excluir</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  <br />
		</form>

		<?php
		break;

//-------------------------------------------- FIM CATEGORIA -------------------------------------------------



//--------------------------------------------- TAMANHO ---------------------------------------------------
		case 'cad_subcategoria':
			?>	
		<div class="aviso"></div>
		<form action="" name="form_subcategoria" method="post">
		<div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Categoria</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="categoria" id="inlineFormCustomSelect">
		      <?php
		    if(listarcategorias()){
		    	$listarcategorias = listarcategorias();
		    	foreach ($listarcategorias as $cat) {
		      ?>
		        <option value="<?php echo $cat->categoria ?>"><?php echo $cat->categoria ?></option>
		      <?php
		      	}
		  	}
		      ?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Tamanho</label>
		    <div class="col">
		      <input type="text" class="form-control" name="tamanho" placeholder="Tamanho (ex: Grande ou 1 Litro, etc.)" >
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Limite de Sabores</label>
		    <div class="col">
		      <input type="number" class="form-control" name="limite" min="0" max="10" oninput="validity.valid||(value='');" placeholder="0 = não tem limite (Min. 0 | Máx. 10)" >
		    </div>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Cadastrar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		</form>
		<?php
		break;

		//EDITAR TAMANHO DADOS
		case 'form_editsubcategoria':
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$dados = editsubcategoria($id);
		?>	
		<div class="aviso"></div>
		<form action="" name="form_editsubcategoria" method="post">
		<div class="form-group row">
		  	<label for="inputPassword" class="col-sm-2 col-form-label">Categoria</label>
		    <div class="col-auto my-1">
		      <select class="custom-select mr-sm-2" name="categoria" id="inlineFormCustomSelect">
		      <?php
		    if(listarcategorias()){
		    	$listarcategorias = listarcategorias();
		    	foreach ($listarcategorias as $cat) {
		      ?>
		        <option <?php if($dados->categoria == $cat->categoria) echo "selected" ?> value="<?php echo $cat->categoria ?>"><?php echo $cat->categoria ?></option>
		      <?php
		      	}
		  	}
		      ?>
		      </select>
		    </div>
		  </div>
   		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Tamanho</label>
		    <div class="col">
		      <input type="text" class="form-control" name="tamanho" placeholder="tamanho (ex: Pizza)" value="<?php echo $dados->tamanho; ?>" >
		    </div>
		  </div>
		  <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Limite de Sabores</label>
		    <div class="col">
		      <input type="number" class="form-control" name="limite" value="<?php if($dados->limite == 0){ echo '0'; } else { echo $dados->limite; } ?>" min="0" max="10" oninput="validity.valid||(value='');" placeholder="0 = não tem limite (Min. 0 | Máx. 10)" >
		    </div>
		  </div>
		  <input type="hidden" name="id" value="<?php echo $dados->id; ?>" />
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Atualizar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <div class="aviso2"></div>
		</form>
		<?php
		break;

		//EXCLUIR TAMANHO
		case 'form_subcategoriaexcluir':
		?>
		<div class="aviso"></div>
		<form action="" name="form_subcategoriaexcluir" method="post">
		  <div class="form-group row">
		   	<label style="margin-left:30px;">Deseja realmente excluir este tamanho?</label>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Excluir</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  <br />
		</form>

		<?php
		break;

//-------------------------------------------- FIM TAMANHO -------------------------------------------------


		
	default:
		echo 'nada';
		break;
}
?>