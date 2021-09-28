$(document).ready(function(){
	var janela = $('#janela');
	var conteudo = $('.modal-body');

	janela.click(function(){
		$.post('ajax/administrador.php', {acao: 'form_altestado'}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Definir novo vencimento');
			conteudo.html(retorno);
		});
	});

	$("#ExemploModalCentralizado").on('submit', 'form[name="form_altestado"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/administrador.php',
			type: 'POST',
			data: 'acao=alterarvencimento&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if (retorno === 'alterou') {
					form.fadeOut('slow', function(){
						msgfun('Vencimento alterado com sucesso!', 'sucesso');
						listarvencimento('ajax/administrador.php','listar_vencimento', true);
					});
				} else{
					msgfun('Erro ao definir vencimento!', 'erro');
				}
			}
		});
		return false;
	});

	//FUNCAO DE LISTAGEM
	function listarvencimento(url,acao, atualizar){
		$.post(url,{acao: acao}, function(retorno){
			var tbody = $('.table').find('tbody');
			var load = tbody.find('#load');
			if (atualizar === true) {
				tbody.html(retorno);
			}else{
				load.fadeOut('slow',function(){
					tbody.html(retorno);
				});
			}
		});
	}

	listarvencimento('ajax/administrador.php', 'listar_vencimento');

	//Funções de Mensagem
	function msgfun(msg, tipo){
		var retorno = $('.aviso');
		var tipo = (tipo === 'sucesso') ? 'success' : (tipo === 'alerta') ? 'warning' : (tipo === 'erro') ? 'danger' : (tipo === 'info') ? 'info' : alert('INFORME MENSAGENS DE SUCESSO, ALERTA, ERRO E INFO');
	
		retorno.empty().fadeOut('fast', function(){
			return $(this).html('<div class="alert alert-'+tipo+'">'+msg+'</div>').fadeIn('slow');
		});
	}

});