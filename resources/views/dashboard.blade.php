<!DOCTYPE html>
<html>
    <head>
        @include('header')
        <script src="{{URL::asset('public/js/graficos.js')}}"></script>
    </head>
    <body>
        @include('topo')
        <div class="columns div_dashboard">
            <div class="column is-12">
                <br>
                @include('dashboard_totais')
                <br>
                @include('dashboard_graficos')
            </div>
        </div>
    </body>
</html>
