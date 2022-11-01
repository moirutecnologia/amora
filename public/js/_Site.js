$(function () {

    $(window).scroll(function () {
        if ($(window).scrollTop() > 0) {
            $('nav').addClass('scroll');
        } else {
            $('nav').removeClass('scroll');
        }
    });

    let avaliacoespendentes = $('[js-avaliacoes-pendentes]');

    if (avaliacoespendentes.length == 1 && avaliacoespendentes.html().trim().length == 0) {
        avaliacoespendentes.remove();
    }

    eventoMenu();
    configurarmascaras();

    setTimeout(atualizarcabecalho, 60000);

    $(document).on('mousedown', '[js-seja-assinante]', function (e) {
        $.fancybox.open($('#seja-assinante'));
    });

    $(document).on('change', '#estado_cadastro', function (e) {
        e.preventDefault();
        let elemento = $(this);

        if (elemento.val() == '') {
            $('#cidade_cadastro').html('<option value="">Selecione o estado</option>');
            return false;
        } else {
            $('#cidade_cadastro').parent().addClass('is-loading');
        }

        let dados = {};
        dados.estado_id = elemento.val();

        ajax({
            metodo: 'cidade/carregaropcoes',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                $('#cidade_cadastro').html(retorno);
                $('#cidade_cadastro').parent().removeClass('is-loading');
            }
        });
    });

    $(document).on('click', '#cadastrar-usuario', function (e) {
        e.preventDefault();
        let elemento = $(this);

        let formulario = $('#form-cadastrar-usuario');
        formulario.validarFormulario();

        let senha = formulario.find('#senha');
        let confirma_senha = formulario.find('#confirma_senha');

        senha.removeClass('is-danger is-success');
        confirma_senha.removeClass('is-danger is-success');

        if (senha.val() != confirma_senha.val()) {
            senha.addClass('is-danger');
            confirma_senha.addClass('is-danger');
            return false;
        } else {
            senha.addClass('is-success');
            confirma_senha.addClass('is-success');
        }

        let dados = {};

        dados.nome = formulario.find('#nome').val();
        dados.email = formulario.find('#email').val();
        dados.whatsapp = formulario.find('#whatsapp').val();
        dados.estado_id = formulario.find('#estado_cadastro').val();
        dados.cidade_id = formulario.find('#cidade_cadastro').val();
        dados.senha = formulario.find('#senha').val();
        dados.confirma_senha = formulario.find('#confirma_senha').val();

        elemento.addClass('is-loading');

        ajax({
            metodo: 'cliente/cadastrar',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                if (retorno.resultado == 1) {
                    atualizarcabecalho();
                    $.fancybox.close();
                } else {
                    elemento.removeClass('is-loading');
                }
            }
        });

    });

    $(document).on('click', '#login-usuario', function (e) {
        e.preventDefault();
        let elemento = $(this);

        let formulario = $('#form-login-usuario');
        formulario.validarFormulario();

        let dados = {};

        dados.email = formulario.find('#email').val();
        dados.senha = formulario.find('#senha').val();

        elemento.addClass('is-loading');

        ajax({
            metodo: 'cliente/login',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                if (retorno.resultado == 1) {
                    atualizarcabecalho();
                    $.fancybox.close();
                } else {
                    elemento.removeClass('is-loading');
                }
            }
        });

    });

    $(document).on('keyup', 'input[type="number"]', function (e) {
        let elemento = $(this);
        valor = parseInt(elemento.val());
        min = parseInt(elemento.attr('min'));
        max = parseInt(elemento.attr('max'));

        if (valor < min) {
            elemento.val(min);
        } else if (valor > max) {
            elemento.val(max);
        }
    })

    // FANCYBOX

    $("[data-fancybox]").fancybox({
        lang: 'pt',
        i18n: {
            'pt': {
                CLOSE: 'Fechar',
                THUMBS: 'Miniaturas',
                FULL_SCREEN: 'Tela cheia',
                PLAY_START: 'Transição automática',
                NEXT: 'Próximo',
                PREV: 'Anterior',
                ZOOM: 'Zoom'
            }
        },
    });

    $(document).on('click', '[fancybox-close]', function (e) {
        e.preventDefault();
        $.fancybox.close();
    });

    $(document).on('click', '[data-fancybox-sibling]', function (e) {
        e.preventDefault();
        var elemento = $(this);

        $.fancybox.open(elemento.siblings().first(),
            {
                parentEl: elemento.parent(),
            }
        );
    });

    $(document).on('click', '[data-fancybox-menu]', function (e) {
        e.preventDefault();
        var elemento = $(this);

        $.fancybox.open(elemento.siblings().first(),
            {
                parentEl: elemento.parent(),
                width: "100%",
                margin: [0, 0, 0, 100] // top, right, bottom, left
            }
        );
    });

    // FANCYBOX - FIM

    //BULMA-MODAL
    $(document).on('click', '[bulma-modal]', function (e) {
        e.preventDefault();
        $('html').addClass('no-scroll');
        let elemento = $(this);
        $(elemento.attr('href')).addClass('is-active');
    });

    $(document).on('click', 'button.modal-close', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let elemento = $(this);
        let modal = elemento.closest('.modal');
        modal.removeClass('is-active');
        $('html').removeClass('no-scroll');
    });
    //FIM BULMA-MODAL

    //MENSAGEM
    $(document).on('click', '.message', function (e) {
        $('.message').removeClass('ativo');
    });
    //FIM - MENSAGEM

    //BULMA-GALERIA

    $(document).on('change', '[bulma-galeria] [type="file"]', function (e) {

        var galeria = $(this).closest('[bulma-galeria]');
        var repositorio = galeria.attr('repositorio');

        $.fn.simpleUpload.maxSimultaneousUploads(1);

        $(this).simpleUpload('/upload/' + repositorio, {

            start: function (file) {
                galeria.find('[imagens]').append(`<div class="column is-2" imagem-galeria enviando>Aguardando</div>`);
                this.enviando = galeria.find('[imagens] [enviando]').last();
            },

            progress: function (progresso) {
                if (progresso < 100) {
                    this.enviando.html(Math.round(progresso) + "%");
                } else {
                    this.enviando.html('Processando');
                }
            },
            success: function (retorno) {
                galeria_fancy = galeria.attr('galeria') ?? '';

                galeria.find('[imagens]').append(`
                    <div class="column is-2" value="${retorno.nome}" imagem-galeria>
                        <div class="opcoes">
                            <a class="remover"><i class="fas fa-times"></i></a>
                            <a href="/arquivo/${repositorio}/${retorno.nome}" data-fancybox="${galeria_fancy}" class="visualizar" title="Visualizar imagem"><i class="fas fa-eye"></i></a>
                        </div>
                        <img src="/arquivo/${repositorio}/${retorno.nome}"/>
                    </div>`);

                this.enviando.remove()

                $('[bulma-galeria] [imagens]').sortable();
            },
            error: function (erro) {
                //upload failed
                // console.log("upload error: " + erro.name + ": " + erro.message);
            },
            cancel: function () {
                //upload cancelled
            }
        });
    });

    $(document).on('click', '[bulma-galeria] .remover', function (e) {
        var elemento = $(this);
        elemento.closest('[imagem-galeria]').remove();
    });

    $('[bulma-galeria] [imagens]').sortable();
    //FIM - BULMA-GALERIA

    //BULMA-UPLOAD

    $(document).on('change', 'bulma-upload [type="file"]', function (e) {

        var elemento = $(this).closest('bulma-upload');
        var repositorio = elemento.attr('repositorio');

        $.fn.simpleUpload.maxSimultaneousUploads(1);

        $(this).simpleUpload('/upload/' + repositorio, {

            start: function (file) {
                this.elemento = elemento;
                this.enviando = elemento.find('arquivo label');

                this.elemento.removeAttr('value');
            },

            progress: function (progresso) {
                if (progresso < 100) {
                    this.elemento.attr('enviando', Math.round(progresso) + '%');
                } else {
                    this.elemento.attr('enviando', 'Processando');
                }
            },
            success: function (retorno) {
                this.elemento.removeAttr('enviando');
                this.elemento.attr('value', retorno.nome);
            },
            error: function (erro) {
                this.elemento.removeAttr('enviando');
                this.elemento.removeAttr('value');
            },
            cancel: function () {
                this.elemento.removeAttr('enviando');
                this.elemento.removeAttr('value');
            }
        });
    });

    $(document).on('mousedown', 'bulma-upload [js-baixar]', function (e) {
        var elemento = $(this);
        var upload = elemento.closest('bulma-upload');;
        var repositorio = upload.attr('repositorio');

        elemento.attr('href', '/arquivo/' + repositorio + '/' + upload.attr('value')).attr('download', '');
    });

    $(document).on('click', 'bulma-upload [js-visualizar]', function (e) {
        e.preventDefault();

        var elemento = $(this).closest('bulma-upload');
        var repositorio = elemento.attr('repositorio');

        $.fancybox.open([
            {
                src: '/arquivo/' + repositorio + '/' + elemento.attr('value'),
            }
        ]);
    });

    $(document).on('click', 'bulma-upload [js-remover]', function (e) {
        e.preventDefault();

        var elemento = $(this).closest('bulma-upload');
        $.fancybox.close();
        elemento.removeAttr('value');
    });

    //FIM - BULMA-UPLOAD

    //BULMA-EDITOR

    $(document).on('click', 'bulma-editor [negrito]', function (e) {
        e.preventDefault();
        document.execCommand('bold');
    });

    $(document).on('click', 'bulma-editor [italico]', function (e) {
        e.preventDefault();
        document.execCommand('italic');
    });

    $(document).on('click', 'bulma-editor [link]', function (e) {
        e.preventDefault();
        var url = prompt('Qual o link?');

        var a = document.createElement('a');
        a.href = url;
        a.title = url;
        window.getSelection().getRangeAt(0).surroundContents(a);
    });

    $(document).on('click', 'bulma-editor [ul]', function (e) {
        e.preventDefault();
        document.execCommand('insertUnorderedList');
    });

    $(document).on('click', 'bulma-editor [indent]', function (e) {
        e.preventDefault();
        document.execCommand('indent', false, null);
    });

    $(document).on('click', 'bulma-editor [outdent]', function (e) {
        e.preventDefault();
        document.execCommand('outdent', false, null);
    });

    $(document).on('click', 'bulma-editor [tabela]', function (e) {
        e.preventDefault();
        var elemento = $(this);
        var editor = elemento.closest('bulma-editor');

        editor.find('conteudo').focus();

        document.execCommand('insertHTML', false, '<table><tr><td></td></tr></table>');

        tabela_ativa = editor.find('table').last();
        tabela_linha_ativa = tabela_ativa.find('tr').first();
        tabela_coluna_ativa = tabela_linha_ativa.find('td');
        tabela_indice_td = 0;

        editor.find('conteudo').focus();
    });

    $(document).on('click', 'bulma-editor [adicionarcoluna]', function (e) {
        e.preventDefault();
        var elemento = $(this);
        var editor = elemento.closest('bulma-editor');

        tabela_ativa.find('tr').each(function () {
            $(this).get(0).insertCell(tabela_indice_td + 1);
        });

        editor.find('conteudo').focus();
    });

    $(document).on('click', 'bulma-editor [adicionarlinha]', function (e) {
        e.preventDefault();
        var nova_linha = tabela_ativa.get(0).insertRow(tabela_ativa.find('tr').length);

        for (var celula = 0; celula < tabela_linha_ativa.find('td').length; celula++) {
            nova_linha.insertCell(celula);
        }
    });

    $(document).on('click', 'bulma-editor [alinharesquerda]', function (e) {
        e.preventDefault();

        document.execCommand('justifyLeft', false, null);
    });

    $(document).on('click', 'bulma-editor [alinharesquerda]', function (e) {
        e.preventDefault();

        document.execCommand('justifyLeft', false, null);
    });

    $(document).on('click', 'bulma-editor [alinharcentro]', function (e) {
        e.preventDefault();

        document.execCommand('justifyCenter', false, null);
    });

    $(document).on('click', 'bulma-editor [alinhardireita]', function (e) {
        e.preventDefault();

        document.execCommand('justifyRight', false, null);
    });

    $(document).on('click', 'bulma-editor [flutuanteesquerda]', function (e) {
        e.preventDefault();

        document.execCommand('justifyLeft', false, null);
    });

    $(document).on('keyup', 'bulma-editor conteudo', function (e) {
        var elemento = $(window.getSelection().focusNode);

        if (elemento.is('td')) {
            tabela_linha_ativa = elemento.closest('tr');
            tabela_ativa = tabela_linha_ativa.closest('table');
            tabela_indice_td = elemento.index();
        }

        if (elemento.parent().is('td')) {
            tabela_linha_ativa = elemento.parent().closest('tr');
            tabela_ativa = tabela_linha_ativa.closest('table');
            tabela_indice_td = elemento.index();
        }

    });

    $(document).on('click', 'bulma-editor conteudo td', function (e) {
        var elemento = $(this);

        if (elemento.is('td')) {
            tabela_linha_ativa = elemento.closest('tr');
            tabela_ativa = tabela_linha_ativa.closest('table');
            tabela_indice_td = elemento.index();
        }

        if (elemento.html() == '&nbsp;') {
            elemento.html('');
        }

    });

    $(document).on('paste', 'bulma-editor conteudo *', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var elemento = $(this);

        var itens = e.originalEvent.clipboardData.items;

        for (var i = 0; i < itens.length; i++) {
            console.log(itens[i].type);
            if (itens[i].kind == "file" && (itens[i].type == "image/jpeg" || itens[i].type == "image/png")) {
                var imageFile = itens[i].getAsFile();
                var fileReader = new FileReader();
                fileReader.onloadend = function () {
                    elemento.append('<img src="' + fileReader.result + '">');
                }
                fileReader.readAsDataURL(imageFile);
                break;
            }
        }
    });

    //DIM - BULMA-EDITOR

});

var tabela_ativa;
var tabela_linha_ativa;
var tabela_coluna_ativa;
var tabela_indice_td;

function eventoMenu() {
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    if ($navbarBurgers.length > 0) {
        $navbarBurgers.forEach(el => {
            el.addEventListener('click', () => {
                const target = el.dataset.target;
                const $target = document.getElementById(target);

                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');
            });
        });
    }
}

function atualizarcabecalho() {
    if ($('[js-cabecalho-site]').length == 1) {
        ajax({
            metodo: 'cliente/carregarcabecalho',
            assincrono: true,
            sucesso: function (retorno) {
                $('[js-cabecalho-site]').html(retorno);
                eventoMenu();

                if ($('[js-logado-site]').length == 1) {
                    setTimeout(atualizarcabecalho, 60000);
                }
            }
        });
    }
}

function configurarmascaras() {
    $('[mascara="numero-2"]').mask('#0');
    $('[mascara="numero"]').mask('#########0');
    $('[mascara="data"]').mask('00/00/0000');
    $('[mascara="validade"]').mask('00/00');
    $('[mascara="numero_cartao"]').mask('0000 0000 0000 0000');
    $('[mascara="cvv"]').mask('000');

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('[mascara="telefone"]').mask(SPMaskBehavior, spOptions);
    $('[mascara="inscricao_estadual"]').mask('000/0000000');
    $('[mascara="cpf"]').mask("000.000.000-00");
    $('[mascara="cnpj"]').mask('00.000.000/0000-00');
    $('[mascara="valor"]').mask('#.##0,00', { reverse: true });
}
