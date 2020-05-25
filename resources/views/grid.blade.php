<div class="columns is-multiline div_grid">
    @foreach ($games as $game)
    <div class="column is-1 coluna_thumb">
        <div class="card">
            <div class="card-image">
                <figure class="image is-2by3">
                    <!-- <img src="https://images.igdb.com/igdb/image/upload/t_cover_big/{{$game['cover']}}.jpg"> -->
                    <!-- <img src="https://versions.bulma.io/0.7.1/images/placeholders/1280x960.png"> -->
                    <img src="{{asset('public/imagens/img_'.$game['id'].'.png')}}">
                </figure>
                <div class="stripe">{{$game['titulo']}}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>