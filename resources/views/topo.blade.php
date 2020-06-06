@include('modal_formulario_jogo')
<nav class="navbar is-topo" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item">Games</a>
    </div>
    <div class="container is-fluid container_topo">
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item{{($aba=='colecao') ? ' selecionado' : ''}}" href='{{Route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="{{$totais_topo['colecao']}}">Coleção</span></a>
                <a class="navbar-item{{($aba=='wishlist') ? ' selecionado' : ''}}" href='{{Route('exibir_jogos', ['pagina' => 'wishlist'])}}'><span class="has-badge-rounded has-badge-small" data-badge="{{$totais_topo['wishlist']}}">Wishlist</span></a>
                <a class="navbar-item{{($aba=='game_pass') ? ' selecionado' : ''}}" href='{{Route('exibir_jogos', ['pagina' => 'game_pass'])}}'><span class="has-badge-rounded has-badge-small" data-badge="{{$totais_topo['game_pass']}}">Game Pass</span></a>
                <a class="navbar-item{{($aba=='watchlist') ? ' selecionado' : ''}}" href='{{Route('exibir_jogos', ['pagina' => 'watchlist'])}}'><span class="has-badge-rounded has-badge-small" data-badge="{{$totais_topo['watchlist']}}">Watchlist</span></a>
                <a class="navbar-item{{($aba=='plus') ? ' selecionado' : ''}}" href='{{Route('exibir_jogos', ['pagina' => 'plus'])}}'><span class="has-badge-rounded has-badge-small" data-badge="{{$totais_topo['plus']}}">PS Plus</span></a>
                <a class="navbar-item navbar-dashboard">
                    <!-- <input class="input is-small is-rounded" type="text" placeholder="Buscar"> -->
                    <div class="control">
                        <select id='buscar_jogos_topo' placeholder="Buscar">
                            <option value=""></option>
                            @foreach ($jogos as $jogo)
                                <option value="{{$jogo->id}}">{{$jogo['titulo']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='divisor'></div>
                    <i class="fas fa-chart-pie fa-lg{{($aba=='dashboard') ? ' icone_selecionado' : ''}}" onclick="window.location.href='{{Route('exibir_dashboard')}}'"></i>
                    <div class='divisor'></div>
                    <i class="fas fa-cloud-upload-alt fa-lg"></i>
                    <div class='divisor'></div>
                    <i class="fa fa-th icone_exibir_grid"></i>
                    <div class='divisor'></div>
                    <i class="fa fa-list icone_exibir_lista"></i>
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons btn_modal_add_jogo">
                        <a class="button is-info is-small">
                            <strong><i class="fa fa-plus"></i></strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>