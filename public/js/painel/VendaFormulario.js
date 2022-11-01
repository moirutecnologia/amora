var produtos = [];

$(function () {

	$(document).on('click', '#salvar-cliente', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#novo-cliente');
		formulario.validarFormulario();

		let dados = {};

		dados.nome = formulario.find('#nome').val();
		dados.email = formulario.find('#email').val();
		dados.whatsapp = formulario.find('#whatsapp').val();
		dados.endereco = formulario.find('#endereco').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'cliente/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('#cliente_id').html(retorno.opcoes);
				$('#cliente_id').val(retorno.id);
				$.fancybox.close();

				elemento.removeClass('is-loading');
				formulario.find('#nome').val('');
				formulario.find('#email').val('');
				formulario.find('#whatsapp').val('');
				formulario.find('#endereco').val('');
			}
		});
	});

	$(document).on('change', '#produto_id', function (e) {
		let elemento = $(this);

		if (elemento.val() == '') {
			return false;
		}

		let select = elemento.closest('.select');

		let dados = {};
		dados.produto_id = elemento.val();
		dados.produtos = produtos;

		select.addClass('is-loading');

		ajax({
			metodo: 'produtosku/carregaropcoesvenda/text',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('#entregue').html(retorno);
				$('.is-loading').removeClass('is-loading');
			}
		});
	});

	$(document).on('click', '#adicionar', function (e) {
		e.preventDefault();

		let elemento = $(this);

		$('.is-danger').removeClass('is-danger');

		if ($('#produto_id').val() == '') {
			$('#produto_id').closest('.control').addClass('is-danger');
		}

		if ($('#entregue').val() == '') {
			$('#entregue').closest('.select').addClass('is-danger');
		}

		if ($('#preco_produto').val() == '') {
			$('#preco_produto').addClass('is-danger');
		}

		if ($('#quantidade').val() == '') {
			$('#quantidade').addClass('is-danger');
		}

		if ($('.is-danger').length > 0) {
			return false;
		}

		let entregue = $('#entregue').find(':selected');

		let produto = {};
		produto.produto_id = $('#produto_id').val();
		produto.entregue = entregue.attr('entregue');
		produto.produtosku_id = entregue.attr('produtosku_id');
		produto.preco = $('#preco_produto').val().toDecimal();
		produto.quantidade = $('#quantidade').val();

		produtos.push(produto);

		let dados = {};
		dados.produtos = produtos;

		elemento.addClass('is-loading');

		ajax({
			metodo: 'venda/carregarprodutosvenda/text',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('[js-pedido]').html(retorno);
				elemento.removeClass('is-loading');
				mensagem('Adicionado com sucesso');
				elemento.blur();
				configurarmascaras();

				$('#produto_id').val('').change();
				$('#entregue').val('');
				$('#entregue').html('<option value="" selecione>Selecione o produto</option>');
				$('#preco_produto').val('');
				$('#quantidade').val('');

			}
		});

	});

	$(document).on('click', '[js-remover]', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let linha = $(this).closest('.linha');
		let indice = linha.index();

		produtos.splice(indice - 1, 1);

		elemento.html('...');

		carregarPedido();

		mensagem('Excluído com sucesso');
	});

	$(document).on('click', '#salvar-produto', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#novo-produto');
		formulario.validarFormulario();

		let dados = {};

		dados.nome = formulario.find('#nome').val();
		dados.marca_id = formulario.find('#marca_id').val();
		dados.preco = formulario.find('#preco').val();
		dados.quantidade = 0;

		elemento.addClass('is-loading');

		ajax({
			metodo: 'produto/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('#produto_id').html(retorno.opcoes);
				$('#produto_id').val(retorno.id).change();
				$.fancybox.close();

				elemento.removeClass('is-loading');
				formulario.find('#nome').val('');
				formulario.find('#marca_id').val('');
				formulario.find('#preco').val('');
			}
		});
	});

	$(document).on('click', '#salvar-marca', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#novo-marca');
		formulario.validarFormulario();

		let dados = {};

		dados.nome = formulario.find('#nome').val();
		dados.comissao = formulario.find('#comissao').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'marca/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('#marca_id').html(retorno.opcoes);
				$('#marca_id').val(retorno.id);
				$.fancybox.close();

				elemento.removeClass('is-loading');
				formulario.find('#nome').val('');
				formulario.find('#comissao').val('');
			}
		});
	});

	$(document).on('change', '#entregue', function (e) {
		let elemento = $(this);
		let selecionado = elemento.find(':selected');

		$('#quantidade').attr('min', selecionado.attr('minimo')).attr('max', selecionado.attr('maximo'));
		$('#preco_produto').val(selecionado.attr('preco').toReal());
	});

	$(document).on('keyup', '#total', function (e) {
		let total = $('#total').val().toDecimal();
		let total_pedido = $('#total_pedido').val();
		let ganho = $('[js-ganho]').attr('js-ganho').toDecimal();

		ganho += (total_pedido - total) * -1;
		$('[js-ganho]').html('R$ ' + ganho.toReal());

		previsao = (ganho * 100) / total;
		$('[js-previsao]').html(parseInt(previsao));

	});

	$(document).on('click', '#salvar', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#formulario');
		formulario.validarFormulario();

		if (produtos.length == 0) {
			mensagem('Adicione produtos no pedido', 'danger');
			return false;
		}

		let dados = {};

		dados.id = formulario.attr('data-id');
		dados.data = formulario.find('#data').val();
		dados.cliente_id = formulario.find('#cliente_id').val();
		dados.produtos = produtos;
		dados.comissao = $('[js-previsao]').html();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'venda/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				elemento.removeClass('is-loading');
				if (retorno.resultado == 1) {
					formulario.find('#cliente_id').val('').change();
					formulario.find('#produto_id').val('').change();
					produtos = [];
					carregarPedido();
				}
			}
		});
	});
});

function carregarPedido() {
	let dados = {};
	dados.produtos = produtos;

	ajax({
		metodo: 'venda/carregarprodutosvenda/text',
		dados: dados,
		assincrono: false,
		sucesso: function (retorno) {
			$('[js-pedido]').html(retorno);
		}
	});
}