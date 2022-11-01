var selecao = undefined;
var intervalo_busca = undefined;

$(function () {
    $(document).on('change', '.select.com-filtro select', function (e) {
        let elemento = $(this);
        let raiz = elemento.closest('.select');
        let select = raiz.find('select');

        if (!elemento.is('[multiple]')) {
            selecao = [elemento.val()];
            raiz.find('input').attr('placeholder', elemento.find(':selected').html());
        } else {
            let valores = elemento.val();

            if (selecao == undefined) {
                selecao = elemento.val();
            } else {

                $.each(select.find('option'), function () {
                    let opcao = $(this);
                    let valor_opcao = opcao.attr('value') ?? opcao.html();

                    if (valores.includes(valor_opcao)) {
                        if (!selecao.includes(valor_opcao)) {
                            selecao.push(valor_opcao);
                        }
                    }

                    if (!valores.includes(valor_opcao)) {
                        if (selecao.includes(valor_opcao)) {
                            selecao.splice(selecao.indexOf(valor_opcao), 1);
                        }
                    }

                });
            }

            let quantidade = selecao.length;

            raiz.find('input').attr('placeholder', quantidade + ' Selecionado' + (quantidade != 1 ? 's' : ''));

            selecionarSelecionados();
        }
    });

    $(document).on('click', '.select.com-filtro input', function (e) {
        if (screen.width > 640) {
            e.stopPropagation();
        }

        $('.select.com-filtro.aberto').removeClass('aberto');

        let elemento = $(this);
        let raiz = elemento.closest('.select');
        raiz.addClass('aberto');

        visiveis = raiz.find('select option').length

        if (visiveis <= 1) {
            visiveis = 2;
        } else if (visiveis > 10) {
            visiveis = 10;
        }

        raiz.find('select').attr('size', visiveis);
    });



    $(document).on('keyup', '.select.com-filtro input', function (e) {
        let elemento = $(this);
        let raiz = elemento.closest('.select');
        let select = raiz.find('select');
        var busca = accentFold(elemento.val().toLowerCase());

        clearTimeout(intervalo_busca);

        intervalo_busca = setTimeout(function () {
            raiz.find('select option').replaceWith(function () {
                let opcao = $(this);
                let atributos = {};

                $.each(opcao.get(0).attributes, function (i, atributo) {
                    atributos[atributo.name] = atributo.value;
                });

                atributos['html'] = $(this).html();

                return $("<hidden />", atributos);
            });

            $.each(raiz.find('select hidden'), function () {
                let opcao = $(this);
                var texto = accentFold(opcao.text().toLowerCase());

                if (texto.includes(busca)) {
                    opcao.replaceWith(function () {
                        let opcao = $(this);
                        let atributos = {};

                        $.each(opcao.get(0).attributes, function (i, atributo) {
                            atributos[atributo.name] = atributo.value;
                        });

                        atributos['html'] = $(this).html();

                        return $("<option />", atributos);
                    });
                }
            });
            selecionarSelecionados();

        }, 500);
    });

    $(document).on('click', '.select.com-filtro select[multiple]', function (e) {
        e.stopPropagation();
    });

    $(document).on('click', 'html,body', function (e) {
        let raiz = $('.select.com-filtro.aberto');

        $('.select.com-filtro input').val('');

        raiz.find('select hidden').replaceWith(function () {
            let opcao = $(this);
            let atributos = {};

            $.each(opcao.get(0).attributes, function (i, atributo) {
                atributos[atributo.name] = atributo.value;
            });

            atributos['html'] = $(this).html();

            return $("<option />", atributos);
        });

        selecionarSelecionados();

        raiz.removeClass('aberto');
    });
})

function selecionarSelecionados() {

    let raiz = $('.select.com-filtro.aberto');
    let select = raiz.find('select');

    if (selecao != undefined) {
        $.each(select.find('option'), function () {
            let opcao = $(this);
            if (selecao.includes(opcao.prop('value'))) {
                opcao.prop('selected', true);
            }
        });
    }

    let visiveis = select.find('option').length;

    if (visiveis <= 1) {
        visiveis = 2;
    } else if (visiveis > 10) {
        visiveis = 10;
    }

    select.attr('size', visiveis);
}

function accentFold(inStr) {
    return inStr.replace(
        /([àáâãäå])|([ç])|([èéêë])|([ìíîï])|([ñ])|([òóôõöø])|([ß])|([ùúûü])|([ÿ])|([æ])/g,
        function (str, a, c, e, i, n, o, s, u, y, ae) {
            if (a) return 'a';
            if (c) return 'c';
            if (e) return 'e';
            if (i) return 'i';
            if (n) return 'n';
            if (o) return 'o';
            if (s) return 's';
            if (u) return 'u';
            if (y) return 'y';
            if (ae) return 'ae';
        }
    );
}
