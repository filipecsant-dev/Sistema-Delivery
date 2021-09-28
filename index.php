<?php
	session_start();
	//CONEXAO DB
	require 'funcoes/banco/conexao.php';
	if (isset($_SESSION['logado'])) {
		header("Location: painel.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styleindex.css">
    <script src="js/popper.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplicativo Delivery">
    <meta name="author" content="Filipe Castro | contato@nestweb.com.br | (071) 98340-9647">
        <!-- Favicons -->
	<link rel="apple-touch-icon" href="img/icone2.nestweb.png" sizes="180x180">
	<link rel="icon" href="img/icone.nestweb.png" sizes="32x32" type="image/png">
	<link rel="icon" href="img/icone3.nestweb.png" sizes="16x16" type="image/png">
	<title>Administrador - NestWeb</title>
	<meta http-equiv="Content-Type" content="text/html; charset-UTF-8">
	<link href="css/log.css" rel="stylesheet" media="screen">
	<link href="css/alert.css" rel="stylesheet" media="screen">
	<link href="css/sty.css" rel="stylesheet">

</head>
<body>
	<script src="js/js.js"></script>
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/customize.js"></script>
	<div class="painel">
		<div class="box">
			<div class="line" data-anime="left"></div>
			<h2 data-anime="left">Login</h2>
			<div class="aviso"></div>
			<form action="" class="form" method="post" name="form_login">
				<div class="form-campo">
					<input type="text" name="empresa" class="form-camp" placeholder="Informe sua empresa" data-anime="right">
				</div>
				<div class="form-campo">
					<input type="text" name="usuario" class="form-camp" placeholder="Informe seu usuário" data-anime="right">
				</div>
				<div class="form-campo">
					<input type="password" name="senha" class="form-camp" placeholder="Informe sua senha" data-anime="right">
				</div>
				<button type="submit" class="form-button" data-anime="bottom">Entrar</button>
			</form>
			<center><img src="img/load.gif" align="center" id="load" style="display:none;width: 270px; height: 50px;"></center>
			<div class="developer" data-anime="bottom"><a href="../index.html"><img src="img/logo-painel.nestweb.png"></a></div>
		</div>
	</div>
	
</body>

</html>
