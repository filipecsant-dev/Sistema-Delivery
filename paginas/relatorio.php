<?php
  require 'funcoes/crud/crud.php';

  if($fun->cargo === '1'){
    header("Location: painel.php");
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
                label: 'Relatório (Anual)',
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBackgroundColor: '#007bff',
                borderWidth: 3,
                data: ['<?= relatoriocon("2020-01-01","2020-02-01");?>', '<?= relatoriocon("2020-02-01","2020-03-01");?>', '<?= relatoriocon("2020-03-01","2020-04-01");?>', '<?= relatoriocon("2020-04-01","2020-05-01");?>', '<?= relatoriocon("2020-05-01","2020-06-01");?>', '<?= relatoriocon("2020-06-01","2020-07-01");?>', '<?= relatoriocon("2020-07-01","2020-08-01");?>', '<?= relatoriocon("2020-08-01","2020-09-01");?>', '<?= relatoriocon("2020-09-01","2020-10-01");?>', '<?= relatoriocon("2020-10-01","2020-11-01");?>', '<?= relatoriocon("2020-11-01","2020-12-01");?>', '<?= relatoriocon("2020-12-01","2021-01-01");?>']
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
    attrelatorio('ajax/controle.php', 'attrelatorio', dataselecionada);
  }

  function attrelatorio(url,acao,data){
    $.post(url, {acao: acao, data: data}, function(retorno){
      var tbody = $('.table').find('tbody');
      var load = tbody.find('#load');

      tbody.html(retorno);
    });
  }

  </script>



    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Relatório</h1>
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
              <th><center>Total de pedidos</center></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
                $data = date('Y-m-d');
              ?>
                <td><center><?php echo relatorio2($data); ?></center></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>