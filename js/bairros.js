$(document).ready(function(){
	var conteudo = $('.modal-body');

	listarbairros('ajax/controle.php', 'listar_bairros');

	function listarbairros(url, acao, atualizar){
		$.post(url, {acao: acao}, function(retorno){
			var tbody = $('.table').find('tbody');
			var load = tbody.find('#load');

			if(atualizar == true){
				tbody.html(retorno);
			}else{
				load.fadeOut('slow',function(){
					tbody.html(retorno);

				});
			}
		});
	}

	//Cadastro de BAIRRO
	$('.btn-group').on("click", '#cadbairro', function(){
		$.post('ajax/caduser.php', {acao: 'cad_bairro'}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Cadastro de Bairro');
			conteudo.html(retorno);
		});
	});

	//cadastro de BAIRRO
	$('#ExemploModalCentralizado').on('submit', 'form[name="form_bairro"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: 'acao=cadastrobairro&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeIn('slow');

				if(retorno === "cadastrou"){
					form.fadeOut('slow', function(){
						msgfun('Bairro cadastrado com sucesso!', 'sucesso');
						listarbairros('ajax/controle.php', 'listar_bairros', true);
					});
				} else {
					msgfun('Erro ao cadastrar Bairro!', 'erro');
				}
			}
		});
		return false;

	});


	//BOTAO EDITAR BAIRROS
	$('.table').on("click", '#editar_bairro', function(){
		var id = $(this).attr('data-id');
		$('#loadedit').fadeIn('slow');
		$.post('ajax/caduser.php', {acao: 'form_editbairro', id: id}, function(retorno){
			$('#loadedit').fadeOut('slow');
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Atualizar Bairro');
			conteudo.html(retorno);
		});
	
	});


	//BOTAO ATUALIZAR
	$('#ExemploModalCentralizado').on("submit", 'form[name="form_editbairro"]', function(){
		var dados = $(this);
		var botao = dados.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: 'acao=editbairro&'+dados.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},

			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if (retorno === 'atualizou') {
						listarbairros('ajax/controle.php', 'listar_bairros', true);
						dados.fadeOut('slow', function(){
						msgfun('Dados do bairro atualizado com Sucesso!', 'sucesso');

					});

				} else{
					msgfun('Nenhum dado alterado!', 'alerta');
				}
			}
		});
		return false;
	});

	//BOTAO EXCLUIR BAIRRO
	$('.table').on("click","#excluir_bairro", function(){
		var id = $(this).attr('data-id');

			$.post('ajax/caduser.php', {acao: 'form_bairroexcluir'},function(retorno){
				$('#ExemploModalCentralizado').modal({backdrop: 'static'});
				$('#TituloModalCentralizado').html('Excluir bairro');
				conteudo.html(retorno);	
			});

			$('#ExemploModalCentralizado').on("submit", 'form[name="form_bairroexcluir"]', function(){
			var dados = $(this);
			var table = 'bairros';
			var botao = dados.find(':button');

				$.ajax({
					url: 'ajax/controle.php',
					type: "POST",
					data: {acao: 'excluir',  id: id, table: table},
					beforeSend: function(){
						botao.attr('disabled', true);
						$('#load').fadeIn('slow');
					},

					success: function(retorno){
						if(retorno === "deletou"){
							listarbairros('ajax/controle.php', 'listar_bairros', true);
							dados.fadeOut('slow', function(){
								msgfun('Bairro excluido com sucesso!', 'sucesso');
							});
						} else {
							msgfun('Erro ao excluir bairro!', 'alerta');
						}
					}
				});
		return false;
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
	}

	function msgfun2(msg, tipo){
		var retorno = $('.aviso2');
		var tipo = (tipo === 'sucesso') ? 'success' : (tipo === 'alerta') ? 'warning' : (tipo === 'erro') ? 'danger' : (tipo === 'info') ? 'info' : alert('INFORME MENSAGENS DE SUCESSO, ALERTA, ERRO E INFO');
	
		retorno.empty().fadeOut('fast', function(){
			return $(this).html('<div class="alert alert-'+tipo+'">'+msg+'</div>').fadeIn('slow');
		});
	}
	
});