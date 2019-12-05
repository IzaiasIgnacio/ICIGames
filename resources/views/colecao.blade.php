<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ICIGames</title>
        <link rel="stylesheet" href="{{URL::asset('public/css/bulma.min.css')}}" />
        <link rel="stylesheet" href="{{URL::asset('public/css/games.css')}}" />
        <link rel="stylesheet" href="{{URL::asset('public/css/font-awesome.css')}}">
    </head>
    <body>
        <nav class="navbar is-topo" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="#">Games</a>
            </div>
            <div class="container is-fluid container_topo">
                <div class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item navbar-dashboard">Dashboard</a>
                        <a class="navbar-item"><label class='categoria'>Coleção<br><span>222</span></label></a>
                        <a class="navbar-item"><label class='categoria'>Wishlist<br><span>222</span></label></a>
                        <a class="navbar-item"><label class='categoria'>Watchlist<br><span>222</span></label></a>
                        <a class="navbar-item"><label class='categoria'>Game Pass<br><span>222</span></label></a>
                        <a class="navbar-item"><label class='categoria'>Plus<br><span>222</span></label></a>
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
        <div class="columns">
            <div class="column coluna_menu">
                <aside class="menu">
                    <p class="menu-label">Plataformas</p>
                    <ul class="menu-list">
                        <li>
                            <a>
                                Todas <span class="qtd">222</span>
                            </a>
                        </li>
                        <li>
                            <a>
                                Xx X <span class="qtd">222</span>
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>
            <div class="column is-11">
                <br>
                <div class="columns is-multiline is-centered">
                    @for ($i=0;$i<=110;$i++)
                    <div class="column is-2 coluna_thumb">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image is-2by3">
                                    <img src="https://versions.bulma.io/0.7.1/images/placeholders/1280x960.png">
                                </figure>
                                <div class="stripe">Red trousers</div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </body>
</html>
