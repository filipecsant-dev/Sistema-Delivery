$(document).ready(function(){

	setTimeout(function() {
	  listarpedidos2('ajax/controle.php', 'listar_pedidos',true);
	}, 30000);

	listarpedidos('ajax/controle.php', 'listar_pedidos');

	//FUNCAO DE LISTAR PEDIDOS
	function listarpedidos(url,acao, atualizar){
		$.post(url, {acao: acao}, function(retorno){
			var tbody = $('.table').find('tbody');
			var load = tbody.find('#load');

			if(atualizar === true){
				tbody.html(retorno);
			} else {
				load.fadeOut('slow', function(){
					tbody.html(retorno);
				});
			}
		});
	}


	function listarpedidos2(url,acao, atualizar){
		$.post(url, {acao: acao, novo: 'true'}, function(retorno){
			var tbody = $('.table').find('tbody');
			var load = tbody.find('#load');

			if(atualizar === true){
				tbody.html(retorno);
				setTimeout(function() {
				  listarpedidos2('ajax/controle.php', 'listar_pedidos',true);
				}, 30000);
			} else {
				load.fadeOut('slow', function(){
					tbody.html(retorno);
				});
			}
		});
	}


	//BOTAO LISTAR TODOS PEDIDOS
	$('.btn-group').on("click", '#todos_pedidos', function(){
		var tbody = $('.d-flex').find('.h2');

		listarpedidos('ajax/controle.php', 'listar_todospedidos', true);
		tbody.html('Todos Pedidos');
		
	});

	//BOTAO LISTAR PEDIDOS REALIZADOS
	$('.btn-group').on("click", '#pedidos_realizados', function(){
		tbody = $('.d-flex').find('.h2');
		listarpedidos('ajax/controle.php', 'listar_pedidos', true);
		tbody.html('Pedidos Realizados');

	});

	//BOTAO VISUALIZAR PEDIDO
	$('.table').on("click", '#imprimir_pedido', function(){
		var id = $(this).attr('data-id');

		$.post('ajax/controle.php', {acao: 'imprimir_pedido', id: id}, function(retorno){
			$('#ExemploModalCentralizado').modal({backdrop: 'static'});
			$('#TituloModalCentralizado').html('Pedido: '+id)
			$('.modal-body').html(retorno);
		});
	});

	//BOTAO IMPRIMIR PEDIDO
	$('#ExemploModalCentralizado').on('submit', 'form[name="form-imp"]', function(){
		var id = $(this).attr('data-id');
		
		window.open('paginas/imprimir_pedido.php?ped='+id, '_blank')
		
		return false;
	});

//------------------------------- ATUALIZAR PEDIDOS -------------------------------------->
	//SAIU PARA ENTREGA
	$('.table').on("click", '#entrega_pedido', function(){
		var id = $(this).attr('data-id');
		var status = 'Saiu para entrega';
		var botao = $(this).find('#entrega_pedido');
		var token = $(this).attr('data-token');
		var titulo = 'Seu pedido n° '+id;
		var msg = 'Saiu para entrega.';

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: {acao: 'atualizar_pedido', id: id, status: status, token: token, titulo: titulo, msg: msg},
			beforeSend: function(){
				botao.attr('disable', true);
			},
			success: function(retorno){
				if(retorno != "erro"){
					listarpedidos('ajax/controle.php', 'listar_pedidos',true);
					msgfun('Pedido '+id+' saiu para entrega','sucesso');
				} else {
					msgfun('Erro ao atualizar pedido '+id,'erro');
				}
			}

		});
		return false;
	});

	//PEDIDO PRONTO
	$('.table').on("click", '#retirada_pedido', function(){
		var id = $(this).attr('data-id');
		var status = 'Pronto para retirada';
		var botao = $(this).find('#retirada_pedido');
		var token = $(this).attr('data-token');
		var titulo = 'Seu pedido n° '+id;
		var msg = 'Está pronto para retirada.';

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: {acao: 'atualizar_pedido', id: id, status: status, token: token, titulo: titulo, msg: msg},
			beforeSend: function(){
				botao.attr('disable', true);
			},
			success: function(retorno){
				if(retorno != "erro"){
					listarpedidos('ajax/controle.php', 'listar_pedidos',true);
					msgfun('Pedido '+id+' pronto para retirada','sucesso');
				} else {
					msgfun('Erro ao atualizar pedido '+id,'erro');
				}
			}

		});
		return false;
	});

	//PEDIDO RECEBIDO
	$('.table').on("click", '#recebido_pedido', function(){
		var id = $(this).attr('data-id');
		var status = 'Está sendo preparado';
		var botao = $(this).find('#recebido_pedido');
		var token = $(this).attr('data-token');
		var titulo = 'Seu pedido n° '+id;
		var msg = 'Está sendo preparado.';

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: {acao: 'atualizar_pedido', id: id, status: status, token: token, titulo: titulo, msg: msg},
			beforeSend: function(){
				botao.attr('disable', true);
			},
			success: function(retorno){
				if(retorno != "erro"){
					listarpedidos('ajax/controle.php', 'listar_pedidos',true);
					msgfun('Pedido '+id+' está sendo preparado.','info');
				} else {
					msgfun('Erro ao atualizar pedido '+id,'erro');
				}
			}

		});
		return false;
	});


	//PEDIDO NA FILA
	$('.table').on("click", '#naorecebido_pedido', function(){
		var id = $(this).attr('data-id');
		var status = 'Está na fila';
		var botao = $(this).find('#naorecebido_pedido');
		var token = $(this).attr('data-token');
		var titulo = 'Seu pedido n° '+id;
		var msg = 'Está na fila para ser preparado.';

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: {acao: 'atualizar_pedido', id: id, status: status, token: token, titulo: titulo, msg: msg},
			beforeSend: function(){
				botao.attr('disable', true);
			},
			success: function(retorno){
				if(retorno != "erro"){
					listarpedidos('ajax/controle.php', 'listar_pedidos',true);
					msgfun('Pedido '+id+' está na fila de preparo.','alerta');
				} else {
					msgfun('Erro ao atualizar pedido '+id,'erro');
				}
			}

		});
		return false;
	});

	//PEDIDO ENTREGUE
	$('.table').on("click", '#pedido_entregue', function(){
		var id = $(this).attr('data-id');
		var status = 'Entregue';
		var botao = $(this).find('#pedido_entregue');
		var token = $(this).attr('data-token');
		var titulo = 'Seu pedido n° '+id;
		var msg = 'Foi entregue.';

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: {acao: 'atualizar_pedido', id: id, status: status, token: token, titulo: titulo, msg: msg},
			beforeSend: function(){
				botao.attr('disable', true);
			},
			success: function(retorno){
				if(retorno != "erro"){
					listarpedidos('ajax/controle.php', 'listar_todospedidos',true);
					msgfun('Pedido '+id+' foi entregue.','sucesso');
				} else {
					msgfun('Erro ao atualizar pedido '+id,'erro');
				}
			}

		});
		return false;
	});


	//PEDIDO CANCELADO
	$('.table').on("click", '#pedido_cancelado', function(){
		var id = $(this).attr('data-id');
		var status = 'Cancelado';
		var botao = $(this).find('#pedido_cancelado');
		var token = $(this).attr('data-token');
		var titulo = 'Seu pedido n° '+id;
		var msg = 'Foi cancelado.';

		$.ajax({
			url: 'ajax/controle.php',
			type: "POST",
			data: {acao: 'atualizar_pedido', id: id, status: status, token: token, titulo: titulo, msg: msg},
			beforeSend: function(){
				botao.attr('disable', true);
			},
			success: function(retorno){
				if(retorno != "erro"){
					listarpedidos('ajax/controle.php', 'listar_todospedidos',true);
					msgfun('Pedido '+id+' foi cancelado.','alerta');
				} else {
					msgfun('Erro ao atualizar pedido '+id,'erro');
				}
			}

		});
		return false;
	});

//---------------------------------------- FIM ATUALIZAR PEDIDO --------------------------------->
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