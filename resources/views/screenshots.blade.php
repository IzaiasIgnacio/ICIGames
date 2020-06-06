<br>
<h3 class="title titulo_dados_jogo">Screenshots</h3>
<div class="columns is-gapless is-multiline">
    @foreach ($screens as $screen)
        <div class="column is-2">
            <figure class="image">
                <img src="{{$screen}}">
            </figure>
        </div>
    @endforeach
</div>