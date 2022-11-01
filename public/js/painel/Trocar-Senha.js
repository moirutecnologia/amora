$(function () {
    $(document).on('click', '#salvar', function(e){
        e.preventDefault();

        let elemento = $(this);

        let formulario = $('#formulario');
        formulario.validarFormulario();

        let dados = {};
        
        dados.senha = formulario.find('#senha').val();
        dados.nova_senha = formulario.find('#nova_senha').val();
        dados.confirmar_senha = formulario.find('#confirmar_senha').val();
 
        elemento.addClass('is-loading');

        ajax({
            metodo: 'usuario/trocarsenha',
            dados: dados,
            assincrono: true,
            sucesso: function(retorno){
                elemento.removeClass('is-loading');
            }
        });
    });
});