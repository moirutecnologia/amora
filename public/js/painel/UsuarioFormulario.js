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
		dados.perfil_ids = formulario.find('#perfil_ids').val();
		dados.senha = formulario.find('#senha').val();

		elemento.addClass('is-loading');

		ajax({
			metodo: 'usuario/salvar',
			dados: dados,
			assincrono: true,
			sucesso: function (retorno) {
				if (retorno.resultado == 1) {
					$('[data-id]').attr('data-id', retorno.id);
					setarUrl('/painel/cadastro/usuario/' + retorno.id);
				}
				elemento.removeClass('is-loading');
			}
		});
	});
});
