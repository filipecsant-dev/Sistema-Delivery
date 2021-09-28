$(document).ready(function(){
	var conteudo = $('.modal-body');

	listarsubcategorias('ajax/controle.php', 'listar_subcategorias');

	function listarsubcategorias(url, acao, atualizar){
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

	//Cadastro de TAMANHO
	$('.btn-group').on("click", '#cadsubcategoria', function(){
		$.post('ajax/caduser.php', {acao: 'cad_subcategoria'}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Cadastro de Tamanho');
			conteudo.html(retorno);
		});
	});

	//cadastro de TAMANHO
	$('#ExemploModalCentralizado').on('submit', 'form[name="form_subcategoria"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: 'acao=cadastrosubcategoria&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeIn('slow');

				if(retorno === "cadastrou"){
					form.fadeOut('slow', function(){
						msgfun('Tamanho cadastrado com sucesso!', 'sucesso');
						listarsubcategorias('ajax/controle.php', 'listar_subcategorias', true);
					});
				} else {
					msgfun('Erro ao cadastrar tamanho!', 'erro');
				}
			}
		});
		return false;

	});


	//BOTAO EDITAR TAMANHO
	$('.table').on("click", '#editar_subcategoria', function(){
		var id = $(this).attr('data-id');
		$('#loadedit').fadeIn('slow');
		$.post('ajax/caduser.php', {acao: 'form_editsubcategoria', id: id}, function(retorno){
			$('#loadedit').fadeOut('slow');
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Atualizar Tamanho');
			conteudo.html(retorno);
		});
	
	});


	//BOTAO ATUALIZAR
	$('#ExemploModalCentralizado').on("submit", 'form[name="form_editsubcategoria"]', function(){
		var dados = $(this);
		var botao = dados.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: 'acao=editsubcategoria&'+dados.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},

			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if (retorno === 'atualizou') {
						listarsubcategorias('ajax/controle.php', 'listar_subcategorias', true);
						dados.fadeOut('slow', function(){
						msgfun('Dados do tamanho atualizado com Sucesso!', 'sucesso');

					});

				} else{
					msgfun('Nenhum dado alterado!', 'alerta');
				}
			}
		});
		return false;
	});

	//BOTAO EXCLUIR TAMANHO
	$('.table').on("click","#excluir_subcategoria", function(){
		var id = $(this).attr('data-id');

			$.post('ajax/caduser.php', {acao: 'form_subcategoriaexcluir'},function(retorno){
				$('#ExemploModalCentralizado').modal({backdrop: 'static'});
				$('#TituloModalCentralizado').html('Excluir Tamanho');
				conteudo.html(retorno);	
			});

			$('#ExemploModalCentralizado').on("submit", 'form[name="form_subcategoriaexcluir"]', function(){
			var dados = $(this);
			var table = 'subcategorias';
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
							listarsubcategorias('ajax/controle.php', 'listar_subcategorias', true);
							dados.fadeOut('slow', function(){
								msgfun('Tamanho excluido com sucesso!', 'sucesso');
							});
						} else {
							msgfun('Erro ao excluir tamanho!', 'alerta');
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