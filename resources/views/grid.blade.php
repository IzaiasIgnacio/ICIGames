<div class="columns is-multiline div_grid">
    @foreach ($jogos as $jogo)
    <div class="column is-1 coluna_thumb thumb_{{str_replace(',',' thumb_',$jogo->siglas)}}">
        <div class="card">
            <div class="card-image">
                <figure class="image is-3by4">
                    <img src="{{Storage::disk('public')->url('capas/'.$jogo['id_igdb_cover'].'_cover_big.png')}}">
                </figure>
                <div class="stripe">{{$jogo['titulo']}}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>