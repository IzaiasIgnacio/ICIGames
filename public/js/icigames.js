$().ready(function() {

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
            return "/ICIGames/public/ajax/buscar_jogos_igdb/"+phrase;
        },
        getValue: "name",
        list: {
            onKeyEnterEvent: function() {
                $(".icon").css('display', 'inline-flex');
            },
            onChooseEvent: function() {
                $(".icon").fadeOut();
                $("#campo_busca").blur();
            },
            onHideListEvent: function() {
                $(".icon").fadeOut();
            }
        }
    };
    
    $("#campo_busca").easyAutocomplete(options);
});