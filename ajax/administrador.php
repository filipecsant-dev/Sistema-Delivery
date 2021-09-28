<?php
ob_start(); session_start();
require '../funcoes/banco/conexao.php';
require '../funcoes/login/login.php';
require '../funcoes/crud/crud.php';
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) {
	//Alterar Estado JANELA
	case 'form_altestado':
		?>	
		<div class="aviso"></div>
		<form action="" name="form_altestado" method="post">
		   <div class="form-group row">
		   	<label for="inputEmail3" class="col-sm-2 col-form-label">Data</label>
		    <div class="col">
		      <input type="date" class="form-control" name="data">
		    </div>
		  </div>
		  <div class="col-auto my-1">
		      <button type="submit" class="btn btn-primary">Confirmar</button>
		      <img src="img/load2.gif" align="center" id="load" style="display:none; width: 30px;">
		    </div>
		  </div>
		  <br />
		</form>
		<?php
	break;

	//ALTERAR VENCIMENTO
	case 'alterarvencimento':
		$vencimento =filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);

			if (alterarvencimento($vencimento)) {
				echo 'alterou';
			} else {
				echo 'erro';
			}
	break;

	//LISTAR VENCIMENTO
	case 'listar_vencimento':
		if (statusempresa()) { 
				$statusemp = statusempresa();
				foreach ($statusemp as $status) {
					$datavencimento = date('d/m/Y', strtotime($status->vencimento));
                	$datalimiteven = date('d/m/Y', strtotime($status->limiteven));
				?>
					<tr>
		              <td><b><?php echo $datavencimento; ?></b></td>
		              <td><b><?php echo $datalimiteven; ?></b></td>
		              <td><b><?php if($status->vencido === '1'){echo 'Em dias';}else if($status->vencido === '2'){echo 'Dentro do prazo';}else{echo 'Vencido';}?></b></td>
		            </tr>

			<?php
				}
			}
	break;

	default:
	echo 'nada';
	break;
}
?>