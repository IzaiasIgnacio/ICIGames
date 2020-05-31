<div class="column coluna_menu">
    <aside class="menu">
        <p class="menu-label">Plataformas</p>
        <ul class="menu-list">
            <li class='exibir_plataforma selecionado' sigla='todas'>
                <a>
                Todas<span class="qtd">{{$total_menu}}</span>
                </a>
            </li>
            @foreach ($plataformas_menu as $plataforma)
            <li class='exibir_plataforma' sigla='{{$plataforma->sigla}}'>
                <a>
                    {{$plataforma->nome}}<span class="qtd">{{$plataforma->total}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </aside>
</div>