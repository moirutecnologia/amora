$(function () {

    listarTabela();    

});

var grafico_vendas = undefined;
var grafico_pagamentos = undefined;
var grafico_investimentos = undefined;
var grafico_ganhos = undefined;

function listarTabela(){
    ajax({
        metodo: 'venda/listargrafico',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            var labels = [];
            var values = [];

            for (var i = 0; i < retorno.length; i++) {
                labels.push(retorno[i].rotulo);
                values.push(retorno[i].total);
            }

            var config = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "R$",
                        backgroundColor: "rgba(71, 85, 191, 0.6)",
                        borderColor: "rgba(71, 85, 191, 0.6)",
                        data: values,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    title: {
                        display: true,
                        text: 'Vendas / mês'
                    },
                    legend: {
                        display: false
                    }
                }
            };

            var ctx = document.getElementById("grafico-vendas").getContext('2d');

            if(grafico_vendas != undefined){
                grafico_vendas.destroy();
            }

            grafico_vendas = new Chart(ctx, config);
        }
    });

    ajax({
        metodo: 'pagamento/listargrafico',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            var labels = [];
            var values = [];

            for (var i = 0; i < retorno.length; i++) {
                labels.push(retorno[i].rotulo);
                values.push(retorno[i].total);
            }

            var config = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "R$",
                        backgroundColor: "rgba(71, 85, 191, 0.6)",
                        borderColor: "rgba(71, 85, 191, 0.6)",
                        data: values,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    title: {
                        display: true,
                        text: 'Recebidos / mês'
                    },
                    legend: {
                        display: false
                    }
                }
            };

            var ctx = document.getElementById("grafico-pagamentos").getContext('2d');

            if(grafico_pagamentos != undefined){
                grafico_pagamentos.destroy();
            }
            
            grafico_pagamentos = new Chart(ctx, config);
        }
    });

    ajax({
        metodo: 'investimento/listargrafico',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            var labels = [];
            var values = [];

            for (var i = 0; i < retorno.length; i++) {
                labels.push(retorno[i].rotulo);
                values.push(retorno[i].total);
            }

            var config = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "R$",
                        backgroundColor: "rgba(211, 38, 26, 0.6)",
                        borderColor: "rgba(211, 38, 26, 0.6)",
                        data: values,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    title: {
                        display: true,
                        text: 'Investimento / mês'
                    },
                    legend: {
                        display: false
                    }
                }
            };

            var ctx = document.getElementById("grafico-investimentos").getContext('2d');
            
            if(grafico_investimentos != undefined){
                grafico_investimentos.destroy();
            }
            
            grafico_investimentos = new Chart(ctx, config);
        }
    });

    ajax({
        metodo: 'venda/listargraficoganhos',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            var labels = [];
            var values = [];

            for (var i = 0; i < retorno.length; i++) {
                labels.push(retorno[i].rotulo);
                values.push(retorno[i].total);
            }

            var config = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "R$",
                        backgroundColor: "rgba(71, 85, 191, 0.6)",
                        borderColor: "rgba(71, 85, 191, 0.6)",
                        fill: false,
                        data: values,
                        legend: {
                            display: false
                        }

                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    title: {
                        display: true,
                        text: 'Ganhos / mês'
                    },
                    legend: {
                        display: false
                    }
                },
                plugins: [{
                    beforeDraw: function (c) {
                        var data = c.data.datasets[0].data;
                        for (let i in data) {
                            var model = c.data.datasets[0]._meta[Object.keys(c.data.datasets[0]._meta)[0]].data[i]._model
                            if (data[i] > 0) {
                                model.backgroundColor = 'rgba(71, 85, 191, 0.6)';
                            } else {
                                model.backgroundColor = 'rgba(211, 38, 26, 0.6)';
                            }
                        }
                    }
                }]
            };

            var ctx = document.getElementById('grafico-ganhos').getContext('2d');
            
            if(grafico_ganhos != undefined){
                grafico_ganhos.destroy();
            }
            
            grafico_ganhos = new Chart(ctx, config);
        }
    });

    ajax({
        metodo: 'usuario/carregarcontadores/text',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function(retorno) {
            $('[js-contadores]').html(retorno);
            $('.is-loading').removeClass('is-loading');
        }
    });
}