$(function () {
	$('#cliente_id').change();

	$(document).on('click', '#salvar-metodopagamento', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#novo-metodopagamento');
		formulario.validarFormulario();

		let dados = {};

		dados.nome = formulario.find('#nome').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'metodopagamento/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				$('#metodopagamento_id').html(retorno.opcoes);
				$('#metodopagamento_id').val(retorno.id);
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
		dados.cliente_id = formulario.find('#cliente_id').val();
		dados.metodopagamento_id = formulario.find('#metodopagamento_id').val();
		dados.valor = formulario.find('#valor').val();
		dados.parcelas = formulario.find('#parcelas').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'pagamento/criar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				elemento.removeClass('is-loading');
				if (retorno.resultado == 1) {
					formulario.find('#cliente_id').val('').change();
					formulario.find('#metodopagamento_id').val('').change();
					formulario.find('#valor').val('');
					formulario.find('#parcelas').val('');
				}
			}
		});
	});
});
