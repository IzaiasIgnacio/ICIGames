<!DOCTYPE html>
<html>
    <head>
        @include('header')
    </head>
    <body>
        @include('topo')
        <div class="columns div_menu">
            @include('menu')
            <div class="column is-11 div_jogos_index">
                @if (isset($pagina))
                    @include($pagina)
                @endif
            </div>
        </div>
    </body>
</html>