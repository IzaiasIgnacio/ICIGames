<!DOCTYPE html>
<html>
    <head>
        @include('header')
    </head>
    <body>
        @include('topo')
        <div class="columns">
            @include('menu')
            <div class="column is-11">
                <br>
                @if (isset($pagina))
                    @include($pagina)
                @endif
            </div>
        </div>
    </body>
</html>
