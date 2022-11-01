$(function () {
    $(document).on('change', '[js-filtro-change]', function (e) {
        e.preventDefault();
        let elemento = $(this);

        elemento.closest('.control').addClass('is-loading');
        elemento.closest('.select').addClass('is-loading');

        if(elemento.is('[type="date"]')){
            if(parseInt(elemento.val().split('-')[0]) < 1900){
                return false;
            }
        }
        removerGet('pagina');
        setarGet(elemento.attr('id'), elemento.val());
        listarTabela();
    });

    $(document).on('click', '[js-excluir]', function (e) {
        e.preventDefault();
        let elemento = $(this);
        let dados = {};

        dados.id = elemento.attr('js-excluir');

        elemento.addClass('is-loading');

        ajax({
            metodo: elemento.attr('controller') + '/excluir',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                if (retorno.resultado == 1) {
                    listarTabela();
                    $.fancybox.close();
                }
                elemento.removeClass('is-loading');
            }
        });
    });
});

$.fn.validarFormulario = function () {
    let elemento = $(this);

    $('.message').removeClass('ativo');

    elemento.find('.is-danger').removeClass('is-danger');

    elemento.find('[required]:visible, .select.com-filtro:visible select[required]').each(function () {
        let campo = $(this);

        if (!campo.is('[type="radio"]') && !campo.is('[type="checkbox"]')) {
            if (campo.val() == '') {
                if (!campo.is('select')) {
                    campo.addClass('is-danger');
                } else {
                    if (campo.is('.select.com-filtro select')) {
                        campo.closest('.control').addClass('is-danger');
                    } else {
                        campo.closest('.select').addClass('is-danger');
                    }
                }
            }
        } else if (campo.is('[type="radio"]') || campo.is('[type="checkbox"]')) {
            if (elemento.find('[name="' + campo.attr('name') + '"]:checked').length == 0) {
                campo.addClass('is-danger');
            }
        }
    });

    if (elemento.find('.is-danger').length > 0) {
        let primeiro = elemento.find('.is-danger').first();
        let parent = primeiro.parent();
        while (parent.length > 0 && parent.outerHeight(true) >= parent.prop('scrollHeight')) {
            parent = parent.parent();
        }

        if (parent.length > 0) {
            if (parent.prop('scrollHeight') == undefined) {
                parent = $('html, body');
            }

            parent.animate({ scrollTop: primeiro.offset().top - 30 }, 600, function () {
                primeiro.focus();
            });
        } else {
            primeiro.focus();
        }

        throw new Error("Campos obrigatórios");
    }
};

Number.prototype.toReal = function () {
    return numeroParaMoeda(this);
    // return parseFloat(this).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
};

String.prototype.toReal = function () {
    return numeroParaMoeda(this);
    // return parseFloat(this).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
};

String.prototype.toReal = function () {
    return numeroParaMoeda(this);
    // return parseFloat(this).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
};

String.prototype.toDecimal = function () {
    return moedaParaNumero(this);
};

String.prototype.toMilhar = function () {
    return parseFloat(this).toLocaleString('pt-BR');
};

String.prototype.ucWords = function () {
    let str = this.toLowerCase()
    let re = /(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g
    return str.replace(re, s => s.toUpperCase())
};

$(function () {

    $(document).on('click', '[js-acao]', function (e) {
        e.preventDefault();
        let elemento = $(this);

        var dados = {};
        dados.id = $(this).data('id');

        var retorno = ajax($(this).attr('js-acao'), dados, false);

        if (retorno.resultado) {
            window[elemento.attr('acao-callback')]();
        }
    });

});

function ajax(parametro, dados, assincrono) {

    let metodo;
    let sucesso;
    let erro;
    let sempre;

    if (dados == '') {
        dados = {};
    }

    if (typeof parametro == 'string') {
        metodo = parametro;
    } else {
        metodo = parametro.metodo;

        if (parametro.hasOwnProperty('dados')) {
            dados = parametro.dados;
        } else {
            dados = [];
        }

        if (parametro.hasOwnProperty('assincrono')) {
            assincrono = parametro.assincrono;
        } else {
            assincrono = true;
        }

        if (parametro.hasOwnProperty('sucesso')) {
            sucesso = parametro.sucesso;
        }

        if (parametro.hasOwnProperty('erro')) {
            erro = parametro.erro;
        }

        if (parametro.hasOwnProperty('sempre')) {
            sempre = parametro.sempre;
        }
    }

    if (assincrono) {

        let retorno = $.ajax({
            url: '/' + metodo,
            type: 'POST',
            contentType: 'application/json',
            async: true,
            data: JSON.stringify(dados),
            beforeSend: function () {
                $('.b-carregando').show();
            },
            success: function (retorno) {
                if (retorno != null) {
                    if (retorno.mensagem != undefined && retorno.mensagem != '') {
                        mensagem(retorno.mensagem, retorno.resultado == 1 ? 'success' : 'danger');
                    }
                }

                if (typeof sucesso == 'function') {
                    sucesso(retorno);
                }
            },
            error: function () {
                if (typeof erro == 'function') {
                    erro();
                }
            },
            complete: function () {
                if (typeof sempre == 'function') {
                    sempre();
                }
            }
        });

        return retorno;
    } else {
        let dados_retorno = '';

        $.ajax({
            url: '/' + metodo,
            type: 'POST',
            contentType: 'application/json',
            async: false,
            data: JSON.stringify(dados),
            success: function (retorno) {

                if (retorno != null) {
                    if (retorno.mensagem != undefined && retorno.mensagem != '') {
                        mensagem(retorno.mensagem, retorno.resultado == 1 ? 'success' : 'danger');
                    }

                    dados_retorno = retorno;
                }

                if (typeof sucesso == 'function') {
                    sucesso(dados_retorno);
                }
            },
            error: function () {
                if (typeof erro == 'function') {
                    erro();
                }
            },
            complete: function () {
                if (typeof sempre == 'function') {
                    sempre();
                }
            }
        });

        return dados_retorno;
    }
}

function pegarID(numerico, indice = -1) {

    if (numerico == undefined) {
        numerico = true;
    }

    var url = decodeURI(location.href).split('/');

    var id = url[url.length - (indice * -1)]

    id = id.split('?')[0];

    if (numerico) {
        id = parseInt(id);
        id = isNaN(id) ? undefined : id;
    }

    return id;
}

var esconder_mensagem = 0;

function mensagem(mensagem, tipo) {
    let esconder = false;
    clearTimeout(esconder_mensagem);

    if (tipo == undefined) {
        tipo = 'success';
    }

    if (tipo == 'success') {
        esconder = true;
    }

    let tempo_exibir_mensagem = 300;

    if ($('.message').hasClass('ativo')) {
        $('.message').removeClass('ativo');
    } else {
        tempo_exibir_mensagem = 0;
    }

    setTimeout(function () {
        $('.message').removeClass('is-success is-danger');
        $('.message').addClass('is-' + tipo + ' ativo');

        $('.message .message-body').html(mensagem);

        if (esconder) {
            esconder_mensagem = setTimeout(function () {
                $('.message').removeClass('ativo');
            }, 4000);
        }
    }, tempo_exibir_mensagem);
}

function is_mobile() {
    $('body').append('<div class="visivel-mobile" id="mobile-visivel-test" />');
    var result = $('.visivel-mobile').is(':visible');
    $('#mobile-visivel-test').remove();
    return result;
}

function buscarIndicesDe(termo, conteudo, sensitivo) {
    var termoTamanho = termo.length;
    if (termoTamanho == 0) {
        return [];
    }
    var indiceInicial = 0, indice, indices = [];
    if (!sensitivo) {
        conteudo = conteudo.toLowerCase();
        termo = termo.toLowerCase();
    }
    while ((indice = accentFold(conteudo).indexOf(accentFold(termo), indiceInicial)) > -1) {
        indices.push(indice);
        indiceInicial = indice + termoTamanho;
    }
    return indices;
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

function uniqid(prefix, more_entropy) {
    if (typeof prefix === 'undefined') {
        prefix = "";
    }

    var retId;
    var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10).toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
            return Array(1 + (reqWidth - seed.length)).join('0') + seed;
        }
        return seed;
    };

    // BEGIN REDUNDANT
    if (!this.php_js) {
        this.php_js = {};
    }
    // END REDUNDANT
    if (!this.php_js.uniqidSeed) { // init seed with big random int
        this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    this.php_js.uniqidSeed++;

    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
    retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10).toFixed(8).toString();
    }

    return retId;
}

function validarCPF(strCPF) {
    strCPF = strCPF.replace(/[^\d]+/g, '');

    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF.length != 11 ||
        strCPF == "00000000000" ||
        strCPF == "11111111111" ||
        strCPF == "22222222222" ||
        strCPF == "33333333333" ||
        strCPF == "44444444444" ||
        strCPF == "55555555555" ||
        strCPF == "66666666666" ||
        strCPF == "77777777777" ||
        strCPF == "88888888888" ||
        strCPF == "99999999999")
        return false;

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10))) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))) return false;
    return true;
}

function validarEmail(email) {
    usuario = email.substring(0, email.indexOf("@"));
    dominio = email.substring(email.indexOf("@") + 1, email.length);

    if ((usuario.length >= 1) &&
        (dominio.length >= 3) &&
        (usuario.search("@") == -1) &&
        (dominio.search("@") == -1) &&
        (usuario.search(" ") == -1) &&
        (dominio.search(" ") == -1) &&
        (dominio.search(".") != -1) &&
        (dominio.indexOf(".") >= 1) &&
        (dominio.lastIndexOf(".") < dominio.length - 1)) {
        return true;
    } else {
        return false;
    }
}

function numeroParaMoeda(n, c, d, t) {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function moedaParaNumero(moeda) {
    let regExp = new RegExp("[R$]", 'g');
    moeda = moeda.replace(regExp, '');

    regExp = new RegExp("[.]", 'g');
    moeda = moeda.replace(regExp, '');

    regExp = new RegExp("[,]", 'g');
    moeda = moeda.replace(regExp, '.');

    let retorno = parseFloat(parseFloat(moeda).toFixed(2));

    return parseFloat(isNaN(retorno) ? 0 : retorno);
}

function pegarParametroUrl(parametro) {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get(parametro);
    return c;
}

function selectLocalImage(repositorio, editor) {

    if (repositorio == undefined) {
        throw new Error("especificar atributo repositorio-imagens");
    }

    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.click();

    // Listen upload local image and save to server
    input.onchange = () => {
        const file = input.files[0];

        // file type is only image.
        if (/^image\//.test(file.type)) {
            saveToServer(file, repositorio, editor);
        }
    };
}

function saveToServer(file, repositorio, editor) {

    var reader = new FileReader();

    reader.onloadend = function () {
        var dados = {};
        dados.repositorio = repositorio;
        dados.imagem = reader.result;

        var url = ajax('imagem/upload', dados, false);

        const range = editor.getSelection();
        editor.insertEmbed(range.index, 'image', `/imagem/${repositorio}/editor/${url}`);
    };

    reader.readAsDataURL(file);
}

function get_para_array() {
    let params = {};
    new URLSearchParams(window.location.search).forEach(function (value, key) {
        params[key] = value;
    });

    return params;
}

function setarGet(key, value) {
    key = encodeURIComponent(key);
    value = encodeURIComponent(value);

    // kvp looks like ['key1=value1', 'key2=value2', ...]
    var kvp = document.location.search == '' ? [] : document.location.search.substr(1).split('&');

    let i = 0;

    for (; i < kvp.length; i++) {
        if (kvp[i].startsWith(key + '=')) {
            let pair = kvp[i].split('=');
            pair[1] = value;
            kvp[i] = pair.join('=');
            break;
        }
    }

    if (i >= kvp.length) {
        kvp[kvp.length] = [key, value].join('=');
    }

    // can return this or...
    let params = kvp.join('&');
    const url = `${location.href.split('?')[0]}?${params}`;

    // reload page with new params
    history.replaceState(null, document.title, url);
}

function removerGet(key) {
    const urlParams = new URLSearchParams(location.search);
    urlParams.delete(key);
    const url = `${location.href.split('?')[0]}?${urlParams.toString()}`;
    history.replaceState(null, document.title, url);
}

function setarUrl(url) {
    window.history.replaceState('', '', url);
}
