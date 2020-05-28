<tr>
    <td>
        <div class="select is-small">
            <select name='plataforma[]'>
                <option>Plataforma</option>
                @foreach ($plataformas as $plataforma)
                    <option value="{{$plataforma['id']}}">{{$plataforma['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="select is-small">
            <select name='situacao[]'>
                <option>Situação</option>
                @foreach ($situacoes as $situacao)
                    <option value="{{$situacao['id']}}">{{$situacao['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td><input class="input is-small" type="text" placeholder="Lançamento"></td>
    <td><input class="input is-small" type="text" placeholder="Compra"></td>
    <td>
        <div class="select is-small">
            <select name='Regiao[]'>
                <option>Regiao</option>
                @foreach ($regioes as $regiao)
                    <option value="{{$regiao['id']}}">{{$regiao['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="select is-small">
            <select name='classificacao[]'>
                <option>Classificação</option>
                @foreach ($classificacoes as $classificacao)
                    <option value="{{$classificacao['id']}}">{{$classificacao['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td><input class="input is-small" type="text" placeholder="Metacritic"></td>
    <td><input class="input is-small" type="text" placeholder="Preço"></td>
    <td><input class="input is-small" type="text" placeholder="Tamanho"></td>
    <td>
        <div class="select is-small">
            <select name='formata[]'>
                <option>Formato</option>
                @foreach ($formatos as $formato)
                    <option value="{{$formato}}">{{$formato}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="select is-small">
            <select name='loja[]'>
                <option>Loja</option>
                @foreach ($lojas as $loja)
                    <option value="{{$loja['id']}}">{{$loja['nome']}}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <a class="button is-danger is-small btn_remover_linha">
            <strong><i class="fa fa-minus"></i></strong>
        </a>
    </td>
</tr>