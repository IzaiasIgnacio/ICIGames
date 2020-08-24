<div class="columns is-narrow div_lista">
    <div class="column is-2">
        <ul id='sortable'>
            @foreach ($jogos as $jogo)
                <li class="coluna_thumb thumb_{{str_replace(',',' thumb_',$jogo->siglas)}} li_jogo" jogo="{{$jogo->id}}">
                    <div class="columns is-gapless is-narrow is-vcentered">
                        <div class="column is-3 coluna_capa">
                            <figure class="image is-3by4">
                                <img src="{{Storage::disk('public')->url('capas/'.$jogo['id_igdb_cover'].'_cover_small.png')}}">
                            </figure>
                        </div>
                        <div class="column is-9 coluna_texto">
                            {{$jogo->titulo}}
                            <br>
                            {{str_replace(',', ', ',$jogo->siglas)}}
                            <br>
                            {{\App\Util\Helper::formatarDataExibicao($jogo->data_lancamento)}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="column is-10 coluna_dados_jogo" style='display: none'>
    </div>
</div>
<script>
    $().ready(function() {
        sortable('#sortable', {
            forcePlaceholderSize: true,
            // placeholderClass: 'ph-class',
            // hoverClass: 'bg-maroon yellow'
            // handle: 'h2'
            // placeholder: '<tr><td colspan="7">&nbsp;</td></tr>'
        });
        sortable('#sortable')[0].addEventListener('sortupdate', function(e) {
            var ordem = $("#sortable li").map(function(){return $(this).attr('jogo');}).get();
            $.post('/ICIGames/public/ajax/ordenar_wishlist', {ordem: ordem});
        });
    });
</script>