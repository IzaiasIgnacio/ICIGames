$().ready(function() {
    cores = {
        vermelho: "#DB1414",
        azul: "#2318C3",
        verde: "#037613",
        roxo: "#870598",
        rosa: "#F31BBD",
        azul_claro: "#306EE2",
        vermelho_claro: "#C53E40" 
    };

    Chart.defaults.global.layout.padding.left = 120;
    Chart.defaults.global.title.display = true;
    Chart.defaults.global.title.fontSize = 14;
    Chart.defaults.global.title.fontColor = '#fff';
    Chart.defaults.global.legend.position = 'right';
    Chart.defaults.global.legend.labels.boxWidth = 12;
    Chart.defaults.global.legend.labels.fontColor = '#fff';

    var plataformas = document.getElementById('grafico_plataformas').getContext('2d');
    var situacoes = document.getElementById('grafico_situacoes').getContext('2d');
    var lojas = document.getElementById('grafico_lojas').getContext('2d');

    $.get('/ICIGames/public/graficos',
    function(resposta) {
        exibir_grafico('pie', plataformas, resposta.plataformas.rotulos, resposta.plataformas.valores, 'Coleção por Plataforma')
        exibir_grafico('pie', situacoes, resposta.situacoes.rotulos, resposta.situacoes.valores, 'Jogos por Situação')
        exibir_grafico('horizontalBar', lojas, resposta.lojas.rotulos, resposta.lojas.valores, 'Jogos por Loja')
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
                    cores.vermelho_claro
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
            }
        }
    });
}