<nav class="navbar is-topo" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">Games</a>
    </div>
    <div class="container is-fluid container_topo">
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item navbar-dashboard" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'>Dashboard</a>
                <a class="navbar-item" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Coleção</span></a>
                <a class="navbar-item" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Wishlist</span></a>
                <a class="navbar-item" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Watchlist</span></a>
                <a class="navbar-item" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">Game Pass</span></a>
                <a class="navbar-item" href='{{route('exibir_jogos', ['pagina' => 'colecao'])}}'><span class="has-badge-rounded has-badge-small" data-badge="222">PS Plus</span></a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-info is-small">
                            <strong><i class="fa fa-plus"></i></strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>