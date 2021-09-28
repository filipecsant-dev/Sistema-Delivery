$(document).ready(function(){
	var conteudo = $('.modal-body');

	listarprodutos('ajax/controle.php', 'listar_produtos');

	function listarprodutos(url, acao, atualizar){
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

	//Cadastro de produto
	$('.btn-group').on("click", '#cadprod', function(){
		$.post('ajax/caduser.php', {acao: 'cad_produto'}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Cadastro de Produto');
			conteudo.html(retorno);
		});
	});

	//MOSTRAR SUB CATEGORIAS
	$('#ExemploModalCentralizado').on('change', '#produto', function(){
		if( $(this).val() ) {
			$.post('ajax/subcategoria.php',{categoria: $(this).val()}, function(retorno){
				$('#tamanho').html(retorno);
			});
		} else {
			$('#tamanho').html('<option value="">– Escolha o tamanho –</option>');
		}
	});





	//cadastro de produto
	$('#ExemploModalCentralizado').on('submit', 'form[name="form_prod"]', function(){
		var form = $(this);
		var botao = form.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: 'POST',
			data: 'acao=cadastroprod&'+form.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},
			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if(retorno === "cadastrou"){
					form.fadeOut('slow', function(){
						msgfun('Produto cadastrado com sucesso!', 'sucesso');
						listarprodutos('ajax/controle.php', 'listar_produtos', true);
					});
				} else {
					msgfun('Erro ao cadastrar produto!', 'erro');
				}
			}
		});
		return false;

	});


	//BOTAO EDITAR PRODUTO
	$('.table').on("click", '#editar_prod', function(){
		var id = $(this).attr('data-id');
		$('#loadedit').fadeIn('slow');
		$.post('ajax/caduser.php', {acao: 'form_editprod', id: id}, function(retorno){
			$('#loadedit').fadeOut('slow');
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Atualizar Produto');
			conteudo.html(retorno);
		});
	
	});


	//BOTAO ATUALIZAR
	$('#ExemploModalCentralizado').on("submit", 'form[name="form_editprod"]', function(){
		var dados = $(this);
		var botao = dados.find(':button');

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: 'acao=editprod&'+dados.serialize(),
			beforeSend: function(){
				botao.attr('disabled', true);
				$('#load').fadeIn('slow');
			},

			success: function(retorno){
				botao.attr('disabled', false);
				$('#load').fadeOut('slow');

				if (retorno === 'atualizou') {
						listarprodutos('ajax/controle.php', 'listar_produtos', true);
						dados.fadeOut('slow', function(){
						msgfun('Dados do produto atualizado com Sucesso!', 'sucesso');

					});

				} else{
					msgfun('Nenhum dado alterado!', 'alerta');
				}
			}
		});
		return false;
	});

	//BOTAO EXCLUIR PRODUTO
	$('.table').on("click","#excluir_prod", function(){
		var id = $(this).attr('data-id');

			$.post('ajax/caduser.php', {acao: 'form_prodexcluir'},function(retorno){
				$('#ExemploModalCentralizado').modal({backdrop: 'static'});
				$('#TituloModalCentralizado').html('Excluir produto');
				conteudo.html(retorno);	
			});

			$('#ExemploModalCentralizado').on("submit", 'form[name="form_prodexcluir"]', function(){
			var dados = $(this);
			var table = 'produtos';
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
							listarprodutos('ajax/controle.php', 'listar_produtos', true);
							dados.fadeOut('slow', function(){
								msgfun('Produto excluido com sucesso!', 'sucesso');
							});
						} else {
							msgfun('Erro ao excluir produto!', 'alerta');
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