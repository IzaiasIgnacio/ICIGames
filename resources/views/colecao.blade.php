<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ICIGames</title>
        <link rel="stylesheet" href="{{URL::asset('public/css/bulma.min.css')}}" />
        <link rel="stylesheet" href="{{URL::asset('public/css/games.css')}}" />
    </head>
    <body>
        <nav class="navbar is-topo" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="#">Games</a>
            </div>
            <div class="container is-fluid container_topo">
                <div id="" class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item">Dashboard</a>
                        <a class="navbar-item">Coleção</a>
                        <a class="navbar-item">Wishlist</a>
                        <a class="navbar-item">Watchlist</a>
                        <a class="navbar-item">Plus</a>
                    </div>
                </div>
            </div>
            <!-- <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary">
                            <strong>Adicionar</strong>
                        </a>
                    </div>
                </div>
            </div> -->
        </nav>
        <aside class="menu">
            <p class="menu-label">General</p>
            <ul class="menu-list">
                <li><a>Dashboard</a></li>
                <li><a>Customers</a></li>
            </ul>
        </aside>
    </body>
</html>
