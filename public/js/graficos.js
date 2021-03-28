$().ready(function() {
    cores = {
        vermelho: "#DB1414",
        azul: "#2318C3",
        verde: "#037613",
        roxo: "#870598",
        rosa: "#F31BBD",
        azul_claro: "#306EE2",
        vermelho_claro: "#C53E40" ,
        preto: "#000000",
        cinza: "#999999",
        verde_claro: "#24b824",
    };

    Chart.defaults.global.layout.padding.left = 120;
    Chart.defaults.global.title.display = true;
    Chart.defaults.global.title.fontSize = 14;
    Chart.defaults.global.legend.position = 'right';
    Chart.defaults.global.legend.labels.boxWidth = 12;
    Chart.defaults.global.defaultFontColor = '#fff';

    var plataformas = document.getElementById('grafico_plataformas').getContext('2d');
    var situacoes = document.getElementById('grafico_situacoes').getContext('2d');
    var lojas = document.getElementById('grafico_lojas').getContext('2d');
    var lancamentos = document.getElementById('grafico_lancamentos').getContext('2d');
    var aquisicoes = document.getElementById('grafico_aquisicoes').getContext('2d');

    $.get('/ICIGames/public/graficos',
    function(resposta) {
        exibir_grafico('pie', plataformas, resposta.plataformas.rotulos, resposta.plataformas.valores, 'Coleção por Plataforma')
        exibir_grafico('pie', situacoes, resposta.situacoes.rotulos, resposta.situacoes.valores, 'Jogos por Situação')
        exibir_grafico('horizontalBar', lojas, resposta.lojas.rotulos, resposta.lojas.valores, 'Jogos por Loja (Top 10)')
        exibir_grafico('horizontalBar', lancamentos, resposta.lancamentos.rotulos, resposta.lancamentos.valores, 'Jogos por Ano de Lançamento (Top 10)')
        exibir_grafico('horizontalBar', aquisicoes, resposta.aquisicoes.rotulos, resposta.aquisicoes.valores, 'Jogos por Ano de Aquisição (Top 10)')
    });
});

function exibir_grafico(tipo, canvas, labels, valores, titulo) {
    new Chart(canvas, {
        type: tipo,
        data: {
            labels: labels,
            datasets: [{
                backgroundColor: [
                    cores.vermelho,
                    cores.azul,
                    cores.verde,
                    cores.roxo,
                    cores.rosa,
                    cores.azul_claro,
                    cores.vermelho_claro,
                    cores.preto,
                    cores.cinza,
                    cores.verde_claro
                ],
                borderColor: '#fff',
                borderWidth: 1,
                data: valores
            }]
        },
        options: {
            title: {
                text: titulo
            },
            legend: {
                display: (tipo == 'pie')
            },
            scales:{
                xAxes: [{
                    display: false
                }]
            }
        }
    });
}