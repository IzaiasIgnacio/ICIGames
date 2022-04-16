<tr>
    <td>
        <div class="select is-fullwidth">
            <select name='plataforma[]'>
                <option value=''>Plataforma</option>
                @foreach ($plataformas as $plataforma)
                    <option value="{{$plataforma['id']}}" @if (isset($plataforma_selecionada) && $plataforma_selecionada == $plataforma['id']) selected @endif>{{$plataforma['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="select is-fullwidth">
            <select name='situacao[]'>
                <option value=''>Situação</option>
                @foreach ($situacoes as $situacao)
                    <option value="{{$situacao['id']}}">{{$situacao['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td><input class="input is-fullwidth campo_data" type="date" name='data_lancamento[]' placeholder="Data de Lançamento" value="{{$data_lancamento ?? '' }}"></td>
    <td><input class="input is-fullwidth campo_data" type="date" name='data_compra[]' placeholder="Data de Compra"></td>
    <td>
        <div class="select is-fullwidth">
            <select name='regiao[]'>
                <option value=''>Regiao</option>
                @foreach ($regioes as $regiao)
                    <option value="{{$regiao['id']}}" @if (isset($regiao_selecionada) && $regiao_selecionada == $regiao['id']) selected @endif>{{$regiao['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="select is-fullwidth">
            <select name='classificacao[]'>
                <option value=''>Classificação</option>
                @foreach ($classificacoes as $classificacao)
                    <option value="{{$classificacao['id']}}">{{$classificacao['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td><input class="input is-fullwidth" name='metacritic[]' type="text" placeholder="Metacritic" value="{{$metacritic ?? ''}}"></td>
    <td><input class="input is-fullwidth" name='preco[]' type="text" placeholder="Preço"></td>
    <td>
        <div class="select is-fullwidth">
            <select name='formato[]'>
                <option value=''>Formato</option>
                @foreach ($formatos as $formato)
                    <option value="{{$formato}}">{{$formato}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="select is-fullwidth">
            <select name='loja[]'>
                <option value=''>Loja</option>
                @foreach ($lojas as $loja)
                    <option value="{{$loja['id']}}">{{$loja['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    @if (empty($esconder_remover))
    <td>
        <a class="button is-danger is-small btn_remover_linha">
            <strong><i class="fa fa-minus"></i></strong>
        </a>
    </td>
    @endif
</tr>