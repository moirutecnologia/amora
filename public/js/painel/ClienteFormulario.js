$(function () {

	$(document).on('click', '#salvar', function (e) {
		e.preventDefault();

		let elemento = $(this);

		let formulario = $('#formulario');
		formulario.validarFormulario();

		let dados = {};

		dados.id = formulario.attr('data-id');
		dados.nome = formulario.find('#nome').val();
		dados.email = formulario.find('#email').val();
		dados.whatsapp = formulario.find('#whatsapp').val();
		dados.endereco = formulario.find('#endereco').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'cliente/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				if (retorno.resultado == 1) {
					$('[data-id]').attr('data-id', retorno.id);
					setarUrl('/painel/cadastro/cliente/' + retorno.id);
				}
				elemento.removeClass('is-loading');
			}
		});
	});
});
