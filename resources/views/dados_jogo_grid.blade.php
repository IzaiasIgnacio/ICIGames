<div class='container container_dados_jogo container_dados_jogo_grid'>
    <input type='hidden' id='id_jogo_exibido' value='{{$jogo->id}}' />
    <h1 class="title titulo_dados_jogo">{{$jogo->titulo}}</h1>
    <div class="columns is-gapless is-narrow">
        <div class="column is-4">
            <figure class="image is-3by4">
                <img src="{{Storage::disk('public')->url('capas/'.$jogo['id_igdb_cover'].'_1080p.png')}}">
            </figure>
            <div class='icones_dados_jogo' id='{{$jogo->id}}'>
                <i class="fa fa-images fa-inverse"></i>
                <label class='label_progresso'></label>
            </div>
        </div>
        <div class="column is-8 coluna_texto">
            <label class='categoria_dados_jogo'>Desenvolvedores</label>
            <label class='valor_dados_jogo'>{{implode(', ',$desenvolvedores)}}</label>
            <br>
            <label class='categoria_dados_jogo'>Distribuidores</label>
            <label class='valor_dados_jogo'>{{implode(', ',$distribuidores)}}</label>
            <br>
            <label class='categoria_dados_jogo'>Gêneros</label>
            <label class='valor_dados_jogo'>{{implode(', ',$generos)}}</label>
            <br>
            @if (!empty($jogo->nota))
            <label class='categoria_dados_jogo'>Nota</label>
            <label class='valor_dados_jogo'>{{$jogo->nota}}</label>
            <br>
            @endif
            @if (\App\Util\Helper::possuoJogo($jogo->id))
            <label class='categoria_dados_jogo'>Completo</label>
            <label class='valor_dados_jogo'>{{($jogo->completo == 1) ? 'Sim' : "Não"}}</label>
            <br>
            @endif
            <label class='categoria_dados_jogo'>Descrição</label>
            <label class='valor_dados_jogo'>{{($jogo->descricao)}}</label>
            <br>
            <div class='container dados_jogo_grid_acervo_container'>
                <h1 class="title titulo_dados_jogo">Plataformas
                    <a class="button is-link is-small btn_adicionar_acervo botao_escondido">
                        <strong><i class="fa fa-plus"></i></strong>
                    </a>
                </h1>
                <table class='table is-narrow is-fullwidth tabela_acervo tabela_dados_jogo'>
                    <thead>
                        <tr>
                            <th><i class="fas fa-gamepad"></i></th>
                            <th><i class="fas fa-clipboard-check"></i></th>
                            <th>
                                <span class="fa-stack">
                                    <i class="fas fa-calendar fa-stack-2x"></i>
                                    <i class="fa fa-shipping-fast fa-stack-1x"></i>
                                </span>
                            </th>
                            <th>
                                <span class="fa-stack">
                                    <i class="fas fa-calendar fa-stack-2x"></i>
                                    <i class="fa fa-shopping-cart fa-stack-1x"></i>
                                </span>
                            </th>
                            <th><i class="fas fa-globe"></i></th>
                            <th><i class="fas fa-filter"></i></th>
                            <th><i class="fas fa-star"></i></th>
                            <th><i class="fas fa-money-bill-alt"></i></th>
                            <th><i class="fas fa-compact-disc"></i> / <i class="fas fa-cloud"></i></th>
                            <th><i class="fas fa-shopping-cart"></i></th>
                            <th width='1%'></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acervo as $ac)
                            <tr>
                                <td>{{$ac->plataforma}}</td>
                                <td>{{$ac->situacao}}</td>
                                <td>{{\App\Util\Helper::formatarDataExibicao($ac->data_lancamento)}}</td>
                                <td>{{\App\Util\Helper::formatarDataExibicao($ac->data_compra)}}</td>
                                <td>{{$ac->regiao}}</td>
                                <td>{{$ac->classificacao}}</td>
                                <td>{{$ac->metacritic}}</td>
                                <td>{{\App\Util\Helper::formatarPrecoExibicao($ac->preco)}}</td>
                                <td>{{$ac->formato}}</td>
                                <td>{{$ac->loja}}</td>
                                <td>
                                    <input type='hidden' class='id_acervo' value='{{$ac->id}}'>
                                    <a class="button is-link is-small btn_editar_acervo botao_escondido">
                                        <strong><i class="fa fa-edit"></i></strong>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class='div_screenshots' style='display: none'></div>
            </div>
        </div>
    </div>
</div>