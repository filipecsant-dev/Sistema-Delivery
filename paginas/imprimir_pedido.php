<?php	

	ob_start(); session_start();
	require '../funcoes/banco/conexao.php';
	require '../funcoes/login/login.php';
	require '../funcoes/crud/crud.php';
	logado();

	$id = $_GET['ped'];

	$ped = visualizarpedido($id);

	use Dompdf\Dompdf;

	require_once("../dompdf/autoload.inc.php");

	$dompdf = new DOMPDF();

	$dompdf->set_paper(array(0, 0, 164.72, 852), 'portrait');//multiplicar o MM por 2.84 para achar o valor em MM

	$html = '<title>Pedido '.$id.' - NestWeb</title>
			<style>
			body{margin-left:-45px;}
	.line{
		font-size:12px;
		font-family:sans-serif;
	}
	.title{
		font-weight:bold;
		text-align:center;
		margin-bottom:5px;
		margin-top:-5px;
	}
	.pedido{
		font-family:Courier New;
		font-size:13px;
	}
	p{
		padding-top:-10px;
	}
	</style>
		<img src="../img/logo.png" id="load" style="width:50mm; margin-left:15px;">
		<div style="width:58mm;font-size:12px; text-align:center;margin-top:5px;font-family:sans-serif;">	Pizzaria Primier<br />
				Rua Nona do Parque, 17, Gleba B<br />
				CNPJ: 36.878.812/0001-81<br />
				
		</div>
		<div style="margin-left:5px;">
		<div class="line">----------------------------------------------------</div>
		<div class="pedido">
			<p style="font-weight:bold;">Numero do Pedido -> &nbsp;'.$ped->id.'</p>
';
	$datapedido = date('d/m/Y', strtotime($ped->data));
$html .='
			<p>Data: '.$datapedido.'</p>
			<p>Hora: '.$ped->hora.'</p>



			<p>Cliente: '.$ped->cliente.'</p>
			<p>Telefone: '.$ped->telefone.'</p>
			<p>Endereço: '.$ped->endereco.'</p>
			<p>Referência: '.$ped->referencia.'</p>

			<div class="line" style="padding-top:-10px;">----------------------------------------------------</div>
			<div class="title">Pagamento</div>
			<div class="line" style="padding-top:-10px;">----------------------------------------------------</div>

			<p>Forma pagamento: '.$ped->pagamento.'</p>
			<p>Forma de entrega: '.$ped->entrega.'</p>
';
		if($ped->pagamento == "Dinheiro" or $ped->pagamento == "dinheiro")
		{
			$troco = number_format($ped->troco, 2, ',', '.');
$html .='
			<p>Troco R$: '.$troco.'</p>
';
		}

		if($ped->entrega == "Entrega" or $ped->entrega == "entrega")
		{
			$valorentrega = number_format($ped->valorentrega, 2, ',', '.');
$html .='
			<p>Taxa de entrega R$: '.$valorentrega.'</p>
';
		}

		if($ped->pagamento == "Cartão" or $ped->pagamento == "cartão")
		{
			$valorcartao = number_format($ped->valorcartao, 2, ',', '.');
$html .='
			<p>Taxa do cartão R$: '.$valorcartao.'</p>
';
		}
		$valorprodutos = number_format($ped->valorprodutos, 2, ',', '.');
		$valor = number_format($ped->valor, 2, ',', '.');
$html .='
			<p>Pedido R$: '.$valorprodutos.'</p>
			<p style="font-weight:bold;">Total R$: '.$valor.'</p>

			<div class="line" style="padding-top:-10px;">----------------------------------------------------</div>
			<div class="title">Pedido</div>
			<div class="line" style="padding-top:-10px;">----------------------------------------------------</div>
';

		if($ped->observacao != "-"){
$html .='
			<p><b>Observação: '.$ped->observacao.'</b></p>
';
		}
$html .='
			<p>Quantidade de produtos: '.$ped->qnt.'</p>
		</div>
';

	if(listarosbebida($id)){
		$listarosbebida = listarosbebida($id);
		foreach ($listarosbebida as $os) {

		//LISTAR BEBIDAS
		if($os->produto === "bebida" or $os->produto === "Bebida"){

$html .='
			<div style="margin-right:-50px; margin-top:-10px; margin-bottom:-8px;">
				<div class="pedido">
			  		<p>Bebida: '.$os->sabor.' - '.$os->tamanho.'</p>
			  	</div>
			</div>
';


			}
		}
	}


	if(listaros($id)){
		$listaros = listaros($id);
		foreach ($listaros as $os) {

			//LISTAR PIZZA
			if($os->produto != "bebida" && $os->produto != "Bebida"){

$html .='

			<div style="margin-right:-45px; margin-top:-10px; margin-bottom:-8px;">
				<div class="pedido">
					<p>Produto: '.$os->produto.'</p>
					<p>Tamanho: '.$os->tamanho.'</p>
			  		<p>Sabor: '.$os->sabor.'</p>
			  	</div>
			</div>
';
			}

			//ADICIONAIS
			if($os->adicionais != "-" && $os->produto != "bebida" && $os->produto != "Bebida"){
$html .= '
			<div style="margin-right:-45px; margin-top:-7px; padding-top:-4px; margin-bottom:-8px;">
				<div class="pedido">
			  		<p>Adicionais: '.$os->adicionais.'</p>
			  	</div>
			</div>
';
			}
		}
	}

	$dompdf->load_html($html);

	$dompdf->render();



	$dompdf->stream(
		"pedido-".$id.".pdf", 
		array(
			"Attachment" => false //Fazer download
		)
	);
?>