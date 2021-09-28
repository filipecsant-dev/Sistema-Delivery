$(document).ready(function(){
	var janela = $('#janela');
	var conteudo = $('.modal-body');

	janela.click(function(){
		$.post('ajax/caduser.php', {acao: 'form_cad'}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Cadastro de Funcionário');
			conteudo.html(retorno);
		});
	});

	$("#ExemploModalCentralizado").on('submit', 'form[name="form_cad"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: 'acao=cadastrouser&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if(retorno === 'valorerrado')
				{
					msgfun2('Selecione o cargo correto!', 'erro');
				} else if(retorno === 'existente'){
					msgfun2('Nome de usuario já existente!', 'alerta');
				} else if (retorno === 'cadastrou') {
					form.fadeOut('slow', function(){
						msgfun('Funcionário cadastrado com sucesso!', 'sucesso');
						listarfuncionarios('ajax/controle.php','listar_fun', true);
					});
				} else{
					msgfun('Erro ao cadastrar funcionário!', 'erro');
				}
			}
		});
		return false;
	});

	//BOTAO EDITAR USER
	$('.table').on("click", '#editar_user', function(){
		var id = $(this).attr('data-id');
		$('#loadedit').fadeIn('slow');
		$.post('ajax/caduser.php', {acao: 'form_edit', id: id}, function(retorno){
			$('#loadedit').fadeOut('slow');
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Atualizar Funcionário');
			conteudo.html(retorno);
		});
	
	});


	//BOTAO ATUALIZAR
	$('#ExemploModalCentralizado').on("submit", 'form[name="form_edituser"]', function(){
		var dados = $(this);
		var botao = dados.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: 'acao=edituser&'+dados.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},

			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if (retorno === 'atualizou') {
						listarfuncionarios('ajax/controle.php', 'listar_fun', true);
						dados.fadeOut('slow', function(){
						msgfun('Dados do funcionário atualizado com Sucesso!', 'sucesso');

					});

				} else{
					msgfun('Nenhum dado alterado!', 'alerta');
				}
			}
		});
		return false;
	});


	//BOTAO EXCLUIR USER
	$('.table').on("click","#excluir_user", function(){
		var id = $(this).attr('data-id');

			$.post('ajax/caduser.php', {acao: 'form_excluir'},function(retorno){
				$('#ExemploModalCentralizado').modal({backdrop: 'static'});
				$('#TituloModalCentralizado').html('Excluir Funcionário');
				conteudo.html(retorno);	
			});

			$('#ExemploModalCentralizado').on("submit", 'form[name="form_excluir"]', function(){
			var dados = $(this);
			var table = 'usuarios';
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
							listarfuncionarios('ajax/controle.php','listar_fun', true);
							dados.fadeOut('slow', function(){
								msgfun('Funcionário excluido com sucesso!', 'sucesso');
							});
						} else {
							msgfun('Erro ao excluir funcionário!', 'alerta');
						}
					}
				});
		return false;
		});	



		return false;	
	});

	
	

	//FUNCAO DE LISTAGEM
	function listarfuncionarios(url,acao, atualizar){
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

	listarfuncionarios('ajax/controle.php', 'listar_fun');

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