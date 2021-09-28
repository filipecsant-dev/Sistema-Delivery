      
    <script type="text/javascript" src="js/pedi.js"></script>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pedidos Realizados</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
           <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="notify" onclick="$('.my_audio').trigger('play'); somzero();">Ativar som em notificação</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="todos_pedidos">Todos pedidos</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="pedidos_realizados">Pedidos realizados</button>
          </div>
        </div>
      </div>
      <div class="aviso"></div>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th><center>Visualizar</center></th>
              <th><center>Pedido</center></th>
              <th><center>Cliente</center></th>
              <th><center>Data</center></th>
              <th><center>Hora</center></th>
              <th><center>Status</center></th>
              <th><center>Observação</center></th>
              <th><center>Pagamento</center></th>
              <th><center>Valor</center></th>
              <th><center>Entrega</center></th>
              <th><center>Atualizar Status</center></th>
            </tr>
          </thead>
          <tbody>
            
            <td colspan="11"><center><img src="img/load.gif" align="center" id="load" style="width: 270px; height: 50px;"></center></td>
          </tbody>
        </table>
      </div>
      <div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="TituloModalCentralizado">Visualização de Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body"></div>
            </div>
          </div>
        </div>
      </div>
    </main>
<script type="text/javascript">
$(document).ready(function(){
    var click = 0;

    $('.btn-group').on("click", '#notify', function(){
    var tbody = $('.btn-group').find('#notify');

    if(click === 0){
      tbody.html('Som em notificação ativado!');
      click = 1;
    }
    
  });
});

  

  function somzero(){
    var audio = document.getElementById("audiov");
    audio.volume = 0.0;
  }

  function somativo(){
    var audio = document.getElementById("audiov");
    audio.volume = 1.0;

    setTimeout(function() {
      somzero();
   }, 3000);
  }


</script>
  <audio class="my_audio" id="audiov" loop>
    <source src="sound/notify.mp3" type="audio/ogg">
  </audio>




