<?php
ob_start(); session_start();
require 'funcoes/banco/conexao.php';
require 'funcoes/login/login.php';
logado();

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: index.php");
}

$fun = $_SESSION['logado'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <script src="js/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="css/stylepainel.css">
    <script src="js/popper.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplicativo Delivery">
    <meta name="author" content="Filipe Castro | contato@nestweb.com.br | (071) 98340-9647">
    <meta name="generator" content="Delivery v1.0">
     <!-- Favicons -->
  <link rel="apple-touch-icon" href="img/icone2.nestweb.png" sizes="180x180">
  <link rel="icon" href="img/icone.nestweb.png" sizes="32x32" type="image/png">
  <link rel="icon" href="img/icone3.nestweb.png" sizes="16x16" type="image/png">
    <title>Painel de Controle - NestWeb</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="css/painel.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/painel.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="painel.php"><center><?php echo $fun->empresa; ?></center></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div style="color:#fff;">NestWeb - Dê um UP em seu negócio! | nestweb.com.br</div>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="?logout=true">Sair<span data-feather="log-out" style="margin-left: 5px;"></a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == pedidos){echo 'active';} ?>" href="?p=pedidos">
              <span data-feather="home"></span>
              Pedidos 
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == bairros){echo 'active';} ?>" href="?p=bairros">
              <span data-feather="file"></span>
              Bairros
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == categoria){echo 'active';} ?>" href="?p=categoria">
              <span data-feather="file-text"></span>
              Cardápio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == subcategoria){echo 'active';} ?>" href="?p=subcategoria">
              <span data-feather="menu"></span>
              Tamanho
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == produtos){echo 'active';} ?>" href="?p=produtos">
              <span data-feather="shopping-cart"></span>
              Produtos
            </a>
          </li>
          <?php
          if($fun->cargo >= 2){
          ?>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == usuarios){echo 'active';} ?>" href="?p=usuarios">
              <span data-feather="users"></span>
              Funcionários
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == financeiro){echo 'active';} ?>" href="?p=financeiro">
              <span data-feather="bar-chart-2"></span>
              Financeiro
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == relatorio){echo 'active';} ?>" href="?p=relatorio">
              <span data-feather="layers"></span>
              Relatório
            </a>
          </li>
          <?php
          }

          if($fun->cargo === "4"){
          ?>
          <li class="nav-item">
            <a class="nav-link <?php if($_GET['p'] == administrador){echo 'active';} ?>" href="?p=administrador">
              <span data-feather="pocket"></span>
              Administrador
            </a>
          </li>
          <?php
          }
          ?>
        </ul>
      </div>
    </nav>
<!----------------------------- CORPO--------------------------------->


<?php
    $pagina = @$_GET['p'];

    if($pagina == 'pedidos'){
        require 'paginas/pedidos.php';
    } else if($pagina == 'bairros'){
        require 'paginas/bairros.php';
    } else if($pagina == 'subcategoria'){
        require 'paginas/subcategoriaprod.php';
    } else if($pagina == 'categoria'){
        require 'paginas/categoriaprod.php';
    } else if($pagina == 'produtos'){
        require 'paginas/produtos.php';
    } else if($pagina == 'usuarios'){
        require 'paginas/usuarios.php';
    } else if($pagina == 'financeiro'){
        require 'paginas/financeiro.php';
    }else if($pagina == 'relatorio'){
        require 'paginas/relatorio.php';
    } else if($pagina == 'administrador'){
        require 'paginas/administrador.php';
    }else{
      require 'paginas/inicio.php';
    }

?>

<!----------------------------- CORPO--------------------------------->
  </div>
</div>
        <script src="js/bootstrap.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="js/bootstrap.js"></script>
      </body>
</html>
<?php ob_end_flush(); ?>