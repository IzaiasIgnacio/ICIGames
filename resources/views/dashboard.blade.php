<!DOCTYPE html>
<html>
    <head>
        @include('header')
    </head>
    <body>
        @include('topo')
        <div class="columns div_dashboard">
            <div class="column is-12">
                <br>
                @include('dashboard_totais')
            </div>
        </div>
    </body>
</html>
