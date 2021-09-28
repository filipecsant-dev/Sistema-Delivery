$(document).ready(function(){
	var conteudo = $('.modal-body');

	listarcategorias('ajax/controle.php', 'listar_categorias');

	function listarcategorias(url, acao, atualizar){
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

	//Cadastro de CATEGORIA
	$('.btn-group').on("click", '#cadcategoria', function(){
		$.post('ajax/caduser.php', {acao: 'cad_categoria'}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Cadastro de Categoria');
			conteudo.html(retorno);
		});
	});

	//cadastro de CATEGORIA
	$('#ExemploModalCentralizado').on('submit', 'form[name="form_categoria"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: 'acao=cadastrocategoria&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeIn('slow');

				if(retorno === "cadastrou"){
					form.fadeOut('slow', function(){
						msgfun('Categoria cadastrado com sucesso!', 'sucesso');
						listarcategorias('ajax/controle.php', 'listar_categorias', true);
					});
				} else {
					msgfun('Erro ao cadastrar Categoria!', 'erro');
				}
			}
		});
		return false;

	});


	//BOTAO EDITAR CATEGORIAS
	$('.table').on("click", '#editar_categoria', function(){
		var id = $(this).attr('data-id');
		$('#loadedit').fadeIn('slow');
		$.post('ajax/caduser.php', {acao: 'form_editcategoria', id: id}, function(retorno){
			$('#loadedit').fadeOut('slow');
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Atualizar Categoria');
			conteudo.html(retorno);
		});
	
	});


	//BOTAO ATUALIZAR
	$('#ExemploModalCentralizado').on("submit", 'form[name="form_editcategoria"]', function(){
		var dados = $(this);
		var botao = dados.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: 'acao=editcategoria&'+dados.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},

			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if (retorno === 'atualizou') {
						listarcategorias('ajax/controle.php', 'listar_categorias', true);
						dados.fadeOut('slow', function(){
						msgfun('Dados da categoria atualizado com Sucesso!', 'sucesso');

					});

				} else{
					msgfun('Nenhum dado alterado!', 'alerta');
				}
			}
		});
		return false;
	});

	//BOTAO EXCLUIR CATEGORIA
	$('.table').on("click","#excluir_categoria", function(){
		var id = $(this).attr('data-id');

			$.post('ajax/caduser.php', {acao: 'form_categoriaexcluir'},function(retorno){
				$('#ExemploModalCentralizado').modal({backdrop: 'static'});
				$('#TituloModalCentralizado').html('Excluir Categoria');
				conteudo.html(retorno);	
			});

			$('#ExemploModalCentralizado').on("submit", 'form[name="form_categoriaexcluir"]', function(){
			var dados = $(this);
			var table = 'categorias';
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
							listarcategorias('ajax/controle.php', 'listar_categorias', true);
							dados.fadeOut('slow', function(){
								msgfun('Categoria excluido com sucesso!', 'sucesso');
							});
						} else {
							msgfun('Erro ao excluir categoria!', 'alerta');
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