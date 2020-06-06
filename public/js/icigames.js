var scroll;
$().ready(function() {

    $(".icone_exibir_grid").click(function() {
        exibir_jogos('grid');
    });

    $(".icone_exibir_lista").click(function() {
        exibir_jogos('lista');
    });

    $('.exibir_plataforma').click(function() {
        var sigla = $(this).attr('sigla');

        if (sigla == 'todas') {
            $('.coluna_thumb').each(function() {
                $(this).fadeIn();
            });

            $('.exibir_plataforma').each(function() {
                $(this).removeClass('selecionado');
            });

            $(this).addClass('selecionado');

            return;
        }
        
        $('.exibir_plataforma').each(function() {
            if ($(this).attr('sigla') == sigla) {
                $(this).addClass('selecionado');
            }
            else {
                $(this).removeClass('selecionado');
            }
        });

        $('.coluna_thumb').each(function() {
            if ($(this).hasClass('thumb_'+sigla)) {
                $(this).fadeIn();
            }
            else {
                $(this).fadeOut();
            }
        });
    });

    $('.btn_modal_add_jogo').click(function() {
        $("#modal_formulario_jogo").addClass('is-active');
    });

    $('.fechar_modal, .btn_cancelar, .modal-background').click(function() {
        $("#modal_formulario_jogo").removeClass('is-active');
    });

    $('.tabela_acervo').on('click', '.btn_remover_linha', function() {
        if ($(".tabela_acervo tbody tr").length > 1) {
            $(this).parent().parent().fadeOut('normal', function() {
                $(this).remove();
            });
        }
    });

    $('.btn_adicionar_linha').click(function() {
        $.get('/ICIGames/public/ajax/html', function(html) {
            $(".tabela_acervo tbody").append(html);
        });
    });

    $(document).keyup(function(e) {
        // esc
        if (e.keyCode === 27) {
            $("#modal_formulario_jogo").removeClass('is-active');
        }
    });

    var options = {
        url: function(phrase) {
            return "/ICIGames/public/igdb/buscar_jogos/"+phrase;
        },
        getValue: "id",
        template: {
            type: "custom",
            method: function(value, item) {
                var html = '';
                html += "<div class='columns is-gapless div_busca_igdb'>";
                html += "   <div class='column is-narrow is-2'>";
                html += "       <figure class='image is-square'>";
                html +=             "<img src='"+item.cover+"'/>";
                html += "       </figure>";
                html += "   </div>";
                html += "   <div class='column is-narrow is-10'>";
                html +=         "&nbsp;"+item.name+"<br>&nbsp;"+item.year+"<br>&nbsp;"+item.platforms;
                html += "   </div>";
                html += "</div>";
                
                return html;
            }
        },
        highlightPhrase: false,
        list: {
            onKeyEnterEvent: function() {
                $(".icon").css('display', 'inline-flex');
            },
            onSelectItemEvent: function() {
                $("#campo_busca").val($("#campo_busca").getSelectedItemData().name);
                var atual = $("#campo_busca").getSelectedItemIndex();
                $("#eac-container-campo_busca ul li.eac-item").each(function(i, e) {
                    if (i == atual) {
                        $(this).addClass('item_selecionado');
                    }
                    else {
                        $(this).removeClass('item_selecionado');
                    }
                });
            },
            onChooseEvent: function() {
                $(".coluna_igdb").fadeOut();
                $(".icon").fadeOut();
                $("#campo_busca").blur();
                $("#campo_busca").val('');
                $("#descricao").html('');
                preencherFormularioIgdb($("#campo_busca").getSelectedItemData().id);
                // $(".coluna_igdb").fadeIn();
            },
            showAnimation: {
                type: "slide", //normal|slide|fade
                time: 400,
                callback: function() {
                    $(".icon").fadeOut();
                }
            },
            hideAnimation: {
                type: "slide", //normal|slide|fade
                time: 400
            },
            maxNumberOfElements: 10
        }
    };
    
    $("#campo_busca").easyAutocomplete(options);

    $(".btn_salvar").click(function() {
        $.post('/ICIGames/public/ajax/salvar_jogo', {dados: $("#form_jogo").serialize()},
        function(resposta) {
            if (resposta == 'ok') {
                exibir_jogos('grid');
                $("#modal_formulario_jogo").removeClass('is-active');
            }
            else {
                $(".label_progresso").html(resposta);
            }
        });
    });

    // $('#sortable').sortable();
    sortable('#sortable', {
        forcePlaceholderSize: true,
        // placeholderClass: 'ph-class',
        // hoverClass: 'bg-maroon yellow'
        // handle: 'h2'
        // placeholder: '<tr><td colspan="7">&nbsp;</td></tr>'
    });
    // sortable('.sortable')[0].addEventListener('sortupdate', function(e) {
    //     console.log(e.detail);

    $(".div_jogos_index").on('click', '.li_jogo', function() {
        $.post('/ICIGames/public/ajax/exibir_dados_jogo', {jogo: $(this).attr('jogo'), 'tipo': 'lista'},
        function(resposta) {
            $(".coluna_dados_jogo").html(resposta.html);
            $(".coluna_dados_jogo").fadeIn();
        });
    });

    $(".div_jogos_index").on('click', ".div_grid .coluna_thumb", function() {
        exibir_jogo($(this).attr('jogo'), 'grid');
    });

    $(".div_jogos_index").on('click', '.icones_dados_jogo .fa-images', function() {
        $.post('/ICIGames/public/ajax/atualizar_imagens', {id: $(this).parent().attr('id')},
        function(resposta) {
            $('.icones_dados_jogo .label_progresso').html(resposta);
        });
    });

    var options = {
        create: false,
        highlight: true,
        openOnFocus: false,
        maxOptions: 10,
        maxItems: 1,
        hideSelected: true,
        closeAfterSelect: true,
        onItemAdd: function(value) {
            exibir_jogo(value, 'grid');
        }
    };
    
    $("#buscar_jogos_topo").selectize(options);

});

window.onkeydown = function(e) {
    if (e.keyCode == 8 && e.target == document.body) {
        $(window).scrollTop(scroll);
        e.preventDefault();
        exibir_jogos('grid');
    }
}

function preencherFormularioIgdb(id_igdb) {
    $.get('/ICIGames/public/igdb/buscar_dados_jogo/'+id_igdb, function(dados) {
        $(".tabela_acervo tbody").html(dados.acervo.html);
        $("#id_igdb").val(id_igdb);
        $('#campo_busca').val(dados.name);
        $('#descricao').html(dados.summary);
        $('#desenvolvedores').html(dados.developers.join(", "));
        $('#distribuidores').html(dados.publishers.join(", "));
        $('#generos').html(dados.genres.join(", "));
        $('#capa').attr('src', dados.cover);
        $('#screen_1').attr('src', dados.screenshots[0]);
        $('#screen_2').attr('src', dados.screenshots[1]);
        $('#screen_3').attr('src', dados.screenshots[2]);
        $('#screen_4').attr('src', dados.screenshots[3]);
        $('#screen_5').attr('src', dados.screenshots[4]);
        $('#screen_6').attr('src', dados.screenshots[5]);
        $(".coluna_igdb").fadeIn();
    });
}

function exibir_jogos(tipo) {
    $.post('/ICIGames/public/ajax/exibir_jogos', {situacao: location.href.split('/').pop(), tipo: tipo},
    function(resposta) {
        $(".div_jogos_index").html(resposta.html);
    });
}

function exibir_jogo(jogo, tipo) {
    scroll = $(window).scrollTop();
    $.post('/ICIGames/public/ajax/exibir_dados_jogo', {jogo: jogo, tipo: tipo},
    function(resposta) {
        $(".div_jogos_index").fadeOut(function() {
            $(".div_jogos_index").html(resposta.html);
            $(".div_jogos_index").fadeIn(function() {
                if (resposta.id_igdb != '') {
                    exibir_screenshots(resposta.id_igdb);
                }
            });
        });
    });
}

function exibir_screenshots(id_igdb) {
    $.post('/ICIGames/public/ajax/exibir_screenshots', {id: id_igdb},
    function(resposta) {
        $('.div_screenshots').html(resposta.html);
        $('.div_screenshots').fadeIn('slow');
    });
}