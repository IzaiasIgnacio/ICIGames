<div class="columns is-multiline div_grid">
    @foreach ($jogos as $jogo)
        <div class="column is-1 coluna_thumb thumb_{{str_replace(',',' thumb_',$jogo->siglas)}}" jogo="{{$jogo->id}}">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-3by4">
                        <img src="{{Storage::disk('public')->url('capas/'.$jogo['id_igdb_cover'].'_cover_big.png')}}">
                        @if (empty($jogo->id_igdb))
                            <i class="fa fa-sync-alt icone_atualizar_grid" data-id-jogo="{{$jogo->id}}" data-titulo="{{$jogo->titulo}}"></i>
                        @endif
                    </figure>
                    <div class="stripe">{{$jogo['titulo']}}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>