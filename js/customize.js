$(document).ready(function(){
	$('form[name="form_login"]').submit(function(){
		var forma = $(this);
		var botao = $(this).find(':button');

		$.ajax({
			url: "ajax/controle.php",
			type: "POST",
			data: "acao=login&"+forma.serialize(),
			beforeSend: function(){
				botao.html('Aguarde Carregando...').attr('disabled', true);
			},
			success: function(retorno){
				botao.attr('disabled', false).html('Entrar');


				if(retorno === 'emperro'){
					msg('Empresa não cadastrada!','erro');
					
				} else if(retorno === 'logerrado'){
					msg('Usuário ou senha inválidos!','erro');
				} else {
					forma.fadeOut('fast', function(){
						msg('Login efetuado com sucesso', 'sucesso');
						$('#load').fadeIn('slow');

					});

					setTimeout(function(){
						$(location).attr('href', 'painel.php');
					},3000);
				}


			}
		});
		return false;
	});

	//Funções geral
	function msg(msg, tipo){
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

