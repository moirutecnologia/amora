$(function () {

	$(document).on('change', '#marca_id', function (e) {
		let elemento = $(this);
		if (elemento.val() == 'novo') {
			elemento.val('');
			$('#novo').fancybox().click();
		}
	});

	$(document).on('click', '#salvar-novo', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#novo');
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

	$(document).on('click', '#salvar-novo-estoque', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#novo-estoque');
		formulario.validarFormulario();

		let dados = {};

		dados.produto_id = formulario.attr('data-id');
		dados.preco = formulario.find('#preco').val();
		dados.quantidade = formulario.find('#quantidade').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'produtosku/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				listarTabela();
				$.fancybox.close();

				elemento.removeClass('is-loading');
				formulario.find('#preco').val('');
				formulario.find('#quantidade').val('');
			}
		});
	});

	$(document).on('click', '#salvar-editar-estoque', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = elemento.closest('#editar-estoque');
		formulario.validarFormulario();

		let dados = {};

		dados.id = formulario.attr('data-produtosku_id');
		dados.produto_id = formulario.attr('data-id');
		dados.preco = formulario.find('#preco').val();
		dados.quantidade = formulario.find('#quantidade').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'produtosku/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				listarTabela();
				$.fancybox.close();
			}
		});
	});

	$(document).on('click', '#salvar', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#formulario');
		formulario.validarFormulario();

		let dados = {};

		dados.id = formulario.attr('data-id');
		dados.nome = formulario.find('#nome').val();
		dados.marca_id = formulario.find('#marca_id').val();
		dados.preco = formulario.find('#preco').val();
		dados.quantidade = formulario.find('#quantidade').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'produto/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				if (retorno.resultado == 1) {
					$('[data-id]').attr('data-id', retorno.id);
					setarUrl('/painel/cadastro/produto/' + retorno.id);
					$('[js-estoque]').removeClass('is-hidden');
				}
				elemento.removeClass('is-loading');
			}
		});
	});
});

function listarTabela() {
    let dados = {};
	dados.produto_id = $('[data-id]').attr('data-id');

	ajax({
        metodo: 'produtosku/carregartabela/text',
        dados: dados,
        assincrono: true,
        sucesso: function(retorno) {
            $('[js-tabela]').html(retorno);
            $('.is-loading').removeClass('is-loading');
        }
    });
}