$(function () {

	$(document).on('change', '#investimentotipo_id', function (e) {
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

		elemento.addClass('is-loading');

		ajax({
			metodo: 'investimentotipo/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('#investimentotipo_id').html(retorno.opcoes);
				$('#investimentotipo_id').val(retorno.id);
				$.fancybox.close();

				elemento.removeClass('is-loading');
				formulario.find('#nome').val('');
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
		dados.data = formulario.find('#data').val();
		dados.investimentotipo_id = formulario.find('#investimentotipo_id').val();
		dados.valor = formulario.find('#valor').val();
		dados.parcelas = formulario.find('#parcelas').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'investimento/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				elemento.removeClass('is-loading');
				if (retorno.resultado == 1) {
					formulario.find('#investimentotipo_id').val('').change();
					formulario.find('#valor').val('');
					formulario.find('#parcelas').val('');
					elemento.removeClass('is-loading');
				}
			}
		});
	});
});
