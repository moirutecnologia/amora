$(function () {

	$(document).on('click', '#salvar', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#formulario');
		formulario.validarFormulario();

		let dados = {};

		dados.id = formulario.attr('data-id');
		dados.nome = formulario.find('#nome').val();
		dados.comissao = formulario.find('#comissao').val();
		dados.enviar_whatsapp = formulario.find('#enviar_whatsapp').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'marca/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				if (retorno.resultado == 1) {
					$('[data-id]').attr('data-id', retorno.id);
					setarUrl('/painel/cadastro/marca/' + retorno.id);
				}
				elemento.removeClass('is-loading');
			}
		});
	});
});
