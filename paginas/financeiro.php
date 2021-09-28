<?php
  require 'funcoes/crud/crud.php';

  if($fun->cargo === '1'){
    header("Location: painel.php");
  }

  $jan = '0';
  $fev = '0';
  $marc = '0';
  $abr = '0';
  $mai = '0';
  $jun = '0';
  $jul = '0';
  $ago = '0';
  $set = '0';
  $out = '0';
  $nov = '0';
  $dez = '0';


  //ATUALIZAR ANUALMENTE AS DATAS!
  if(financeiro()){
    $financeiro = financeiro();
    foreach ($financeiro as $finan) {

        if($finan->data >= '2020-01-01' && $finan->data < '2020-02-01'){
            $jan += $finan->valor;
        }
        if($finan->data >= '2020-02-01' && $finan->data < '2020-03-01'){
            $fev += $finan->valor;
        }
        if($finan->data >= '2020-03-01' && $finan->data < '2020-04-01'){
            $mar += $finan->valor;
        }
        if($finan->data >= '2020-04-01' && $finan->data < '2020-05-01'){
            $abr += $finan->valor;
        }
        if($finan->data >= '2020-05-01' && $finan->data < '2020-06-01'){
            $mai += $finan->valor;
        }
        if($finan->data >= '2020-06-01' && $finan->data < '2020-07-01'){
            $jun += $finan->valor;
        }
        if($finan->data >= '2020-07-01' && $finan->data < '2020-08-01'){
            $jul += $finan->valor;
        }
        if($finan->data >= '2020-08-01' && $finan->data < '2020-09-01'){
            $ago += $finan->valor;
        }
        if($finan->data >= '2020-09-01' && $finan->data < '01/10/2020'){
            $set += $finan->valor;
        }
        if($finan->data >= '2020-10-01' && $finan->data < '2020-10-01'){
            $out += $finan->valor;
        }
        if($finan->data >= '2020-11-01' && $finan->data < '2020-11-01'){
            $nov += $finan->valor;
        }
        if($finan->data >= '2020-12-01' && $finan->data < '2021-01-01'){
            $dez += $finan->valor;
        }

     } 
  }

?>

  <script type="text/javascript">
    $(document).ready(function(){

    var ctx = document.getElementById('grafico').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',

        data: {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [{
                label: 'Financeiro (Anual)',
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBackgroundColor: '#007bff',
                borderWidth: 3,
                data: ['<?= $jan;?>', '<?= $fev;?>', '<?= $marc;?>', '<?= $abr;?>', '<?= $mai;?>', '<?= $jun;?>', '<?= $jul;?>', '<?= $ago;?>', '<?= $set;?>', '<?= $out;?>', '<?= $nov;?>', '<?= $dez;?>']
            }]
        },

        options: {}
    });

    $('.btn-group').on('click', '#imprimir', function(){
      window.print();
    });

  });

  function dataselect(elemento){
    var dataselecionada = elemento.value;
    $('h2').html('Visualização de '+dataselecionada.split('-').reverse().join('/'));
    attfinanceiro('ajax/controle.php', 'attfinanceiro', dataselecionada);
  }

  function attfinanceiro(url,acao,data){
    $.post(url, {acao: acao, data: data}, function(retorno){
      var tbody = $('.table').find('tbody');
      var load = tbody.find('#load');

      tbody.html(retorno);
    });
  }

  </script>



    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Financeiro</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" id="imprimir" class="btn btn-sm btn-outline-secondary">Imprimir Relatório</button>
          </div>
          <input type="date" onchange="javascript:dataselect(this);" value="<?php echo date('Y-m-d'); ?>" class="btn btn-sm btn-outline-secondary dropdown-toggle">
        </div>
      </div>


      <canvas class="my-4 w-100" id="grafico" width="900" height="380"></canvas>

      <h2 style="font-size: 25px;">Visualização de hoje</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Produtos</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
                            
                $visu = date('Y-m-d');
                if(financeiro2($visu)){
                  $financeiro = financeiro2($visu);
                  $produtos = '0';
                  $total = '0';
                  foreach ($financeiro as $fin) {
                      $produtos += $fin->valorprodutos;
                      $total += $fin->valor;
                  }
                  ?>
                    <td>R$ <?php echo $produtos; ?></td>
                    <td>R$ <?php echo $total; ?></td>
                  <?php 
                } else{
                    ?>
                  
                    <td colspan="3" style="font-size: 15px;"><center>Nenhum pedido realizado este dia!</center></td>
                  
                    <?php
                }
              ?>
              
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>