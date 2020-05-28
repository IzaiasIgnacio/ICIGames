@include('modal_formulario_jogo')
<nav class="navbar is-topo" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">Games</a>
    </div>
    <div class="container is-fluid container_topo">
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item{{($aba=='colecao') ? ' selecionado' : ''}}" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Coleção</span></a>
                <a class="navbar-item{{($aba=='wishlist') ? ' selecionado' : ''}}" href='{{route('exibir_jogos', ['pagina' => 'wishlist'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Wishlist</span></a>
                <a class="navbar-item{{($aba=='watchlist') ? ' selecionado' : ''}}" href='{{route('exibir_jogos', ['pagina' => 'watchlist'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Watchlist</span></a>
                <a class="navbar-item{{($aba=='game_pass') ? ' selecionado' : ''}}" href='{{route('exibir_jogos', ['pagina' => 'game_pass'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Game Pass</span></a>
                <a class="navbar-item{{($aba=='plus') ? ' selecionado' : ''}}" href='{{route('exibir_jogos', ['pagina' => 'plus'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">PS Plus</span></a>
                <a class="navbar-item navbar-dashboard">
                    <input class="input is-small is-rounded" type="text" placeholder="Buscar">
                    <div class='divisor'></div>
                    <i class="fas fa-chart-pie fa-lg"></i>
                    <div class='divisor'></div>
                    <i class="fas fa-cloud-upload-alt fa-lg"></i>
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