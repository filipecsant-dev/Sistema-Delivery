    <?php
    require 'funcoes/crud/crud.php';
    ?>
    <script type="text/javascript" src="js/inicio.js"></script>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $fun->empresa; ?> - Área Administrativa</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="https://wa.me/5571983855413?text=Olá,%20gostaria%20de%20saber%20mais%20sobre%20o%20aplicativo%20para%20Delivery!" target="_blank">Entrar em contato com o suporte</a>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Bem vindo novamente, <?php echo $fun->usuario; ?> | Sua função é <?php if($fun->cargo === '1'){echo 'Atendente';}elseif($fun->cargo === '2'){echo 'Gerente';}elseif($fun->cargo === '3'){echo 'Dono';}else{echo 'Administrador';} ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              //VERIFICAR SE ESTA VENCIDO
              if (statusempresa()) { 
                $statusemp = statusempresa();
                foreach ($statusemp as $status) {
                $datavencimento = $status->vencimento;
                $datalimiteven = $status->limiteven;

                  if($status->vencido != '3'){
                    if(date('Y-m-d') > $datavencimento){
                        if(date('Y-m-d') > $datalimiteven){
                          $vencido = '3';
                          alterarvencido($vencido);
                          alterarestadovencido();
                        } else {
                          $vencido = '2';
                          alterarvencido($vencido);
                        }
                      }
                  }
                }
              }

              if (statusempresa()) { 
                $statusemp = statusempresa();
                foreach ($statusemp as $status) {
                $datavencimento = date('d/m/Y', strtotime($status->vencimento));
                $datalimiteven = date('d/m/Y', strtotime($status->limiteven));



                //FIM VERIFICACAO


                  ?>




              <td style="background-color:<?php if($status->vencido === '3'){ echo '#FF8C00';} if($status->vencido != '3'){ if($status->status === '1'){echo '#006400';}else{echo '#8B0000';} } ?>; color:#FFFFFF;">Estabelecimento está: 

                <?php 
                  
                    if($status->vencido === '3'){ echo 'Vencido! Entre em contato com o suporte da NestWeb';};
                    
                    if($status->vencido != '3'){
                      if($status->status === '1'){ echo 'Funcionando';}else{echo 'Fechado';};
                 ?> 
              <button type="button" id="alterar_estado" data-id="<?php echo $status->status ?>" class="btn btn-dark" style="color:#fff;font-size:13px; float:right; margin-right: 50px;">Alterar Estado</button> <img src="img/load2.gif" align="center" id="load" style="width: 25px; height: 25px; float: right; margin-right: 5px; margin-top:5px; display: none;"></td>
               <?php
                  }
               ?>
            </tr>

            <tr>
              <td>Próximo vencimento: <?php if($status->vencido === '2'){ echo '<b>Vencido</b>!';} else{ echo $datavencimento; }?></td>
            </tr>
            <tr <?php if($status->vencido === '2'){ echo 'style="background-color:#FF8C00;"';} ?>>
              <td>Limite de vencimento: <?php echo $datalimiteven; ?> <?php if($status->vencido === '2'){ echo ' | Você está no limite do vencimento! entre em contato com suporte da NestWeb.';}?></td>
            </tr>
            <tr>
              <td>Estado atual: <?php if($status->vencido === '1'){echo 'Em dias';}else if($status->vencido === '2'){echo '<b>Dentro do prazo</b>';}else{echo '<b>Vencido</b>';}?>.</td>
            </tr>
            <?php
               }
              } 
               ?>

             <tr>
              <td>Atualmente possuímos <b><?php qntclientes(); ?></b> clientes registrados.</td>
            </tr>
            <tr>
              <td><div class="aviso"></div><br /></td>
            </tr>
            <tr>
              <td><b><center>Envie mensagens ou promoções para atrair seus clientes!</b> <br />(Atenção: É normal que demore no carregamento ao enviar a depender da quantidade de clientes!)</center></td>
            </tr>

            <form name="form_notify" style="">
              <tr>
                <td>
                   <div class="col">
                      <input type="text" class="form-control" id="title" name="titulo" placeholder="Titulo">
                    </div>
                </td>
              </tr>

              <tr style="background-color:#fff;">
                <td>
                    <div class="col">
                      <input type="text" class="form-control" id="msg" name="mensagem" placeholder="Mensagem">
                    </div>
                </td>
              </tr>

              <tr>
                <td> 
                      <button type="submit" class="btn btn-primary" style="margin-left: 15px;">Enviar notificação</button>
                      <img src="img/load2.gif" align="center" id="load2" style="width: 25px; height: 25px; margin-right: 5px; margin-top:5px; display: none;">
                </td>
              </tr>
            </form>

          </tbody>
        </table>
      </div>
    </main>