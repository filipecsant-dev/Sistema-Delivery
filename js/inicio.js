$(document).ready(function(){

	//BOTAO ALTERAR ESTADO
	$('.table').on("click", '#alterar_estado', function(){
		var estado = $(this).attr('data-id');
		var botao = $(this).find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: {acao: 'alterarestado',  estado: estado},
			beforeSend: function(){
						botao.attr('disabled', true);
						$('#load').fadeIn('slow');
					},
			success: function(retorno){
				botao.attr('disabled', false);
				
				if(retorno === 'atualizou'){
					$('#load').fadeOut('slow', function(){
						window.location.reload();
					});
				}else{
					$('#load').fadeOut('slow', function(){
						alert('Erro ao alterar estado!');
					});
				}
			}
		});
		return false;
	});

	$('.table').on("submit", 'form[name="form_notify"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: 'acao=notify_geral&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load2').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load2').fadeIn('slow');

				if(retorno === "erro1"){
					$('#load2').fadeOut('slow', function(){
						msgfun('É necessário descrever o titulo e a mensagem!', 'alerta');
					});
				} else if(retorno === "erro"){
					$('#load2').fadeOut('slow', function(){
						msgfun('Erro ao enviar notifição!', 'erro');
					});
				} else {
					$('#load2').fadeOut('slow', function(){
						msgfun('Notifição enviada com sucesso!', 'sucesso');
						$('#title').val('');
						$('#msg').val('');
						console.log(retorno);
					});
				}
			}
		});
		return false;

	});
	

	//Funções de Mensagem
	function msgfun(msg, tipo){
		var retorno = $('.aviso');
		var tipo = (tipo === 'sucesso') ? 'success' : (tipo === 'alerta') ? 'warning' : (tipo === 'erro') ? 'danger' : (tipo === 'info') ? 'info' : alert('INFORME MENSAGENS DE SUCESSO, ALERTA, ERRO E INFO');
	
		retorno.empty().fadeOut('fast', function(){
			return $(this).html('<div class="alert alert-'+tipo+'">'+msg+'</div>').fadeIn('slow');
		});

		setTimeout(function(){
			retorno.fadeOut('slow').empty();
		},6000);
	}
	

});