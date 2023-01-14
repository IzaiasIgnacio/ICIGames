<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/ajax')->group(function () {
    Route::get('/html', 'AjaxController@buscarHtml')->name('buscar_html');
    Route::post('/exibir_jogos', 'AjaxController@exibirJogos')->name('exibir_grid');
    Route::post('/exibir_dados_jogo', 'AjaxController@exibirDadosJogo')->name('exibir_dados_jogo');
    Route::post('/carregar_acervo', 'AjaxController@carregarAcervo')->name('carregar_acervo');
    Route::post('/salvar_jogo', 'AjaxController@salvarJogo')->name('salvar_jogo');
    Route::post('/atualizar_imagens', 'AjaxController@atualizarImagens')->name('atualizar_imagens');
    Route::post('/exibir_screenshots', 'AjaxController@exibirScreenshots')->name('exibir_screenshots');
    Route::post('/salvar_acervo', 'AjaxController@salvarAcervo')->name('salvar_acervo');
    Route::get('/excluir_jogo/{jogo}', 'AjaxController@excluirJogo')->name('excluir_jogo');
    Route::post('/atualizar_jogo', 'AjaxController@atualizarJogo')->name('atualizar_jogo');
    Route::post('/ordenar_wishlist', 'AjaxController@ordenarWishlist')->name('ordenar_wishlist');
});

Route::get('/graficos', 'DashboardController@graficos')->name('grafico_plataformas');

Route::prefix('/igdb')->group(function () {
    Route::get('/buscar_jogos/{busca}', 'IgdbController@buscarJogosIgdb')->name('buscar_jogos_igdb');
    Route::get('/buscar_dados_jogo/{id}', 'IgdbController@buscarDadosJogo')->name('buscar_dados_jogo');
});

Route::prefix('/opencritic')->group(function () {
    Route::get('/buscar_jogo/{busca}', function ($busca) {
        $opencritic = new \App\Models\OpenCritic();
        return $opencritic->buscarMedia($busca);
    });
});

Route::prefix('/legado')->group(function () {
    Route::get('/buscar_jogos/{titulo}', 'IgdbController@buscarJogosLegado')->name('buscar_jogos_legado');
    Route::get('/buscar_dados_jogo/{id}', 'IgdbController@buscarDadosJogoLegado')->name('buscar_dados_jogo_legado');
    Route::get('/buscar_dados_empresas/{ids}', 'IgdbController@buscarDadosEmpresasLegado')->name('buscar_dados_empresas_legado');
    Route::get('/buscar_dados_generos/{ids}', 'IgdbController@buscarDadosGenerosLegado')->name('buscar_dados_generos_legado');
});

Route::prefix('/import')->group(function () {
    Route::get('/importar', 'ImportController@importar');
    Route::get('/capas', 'ImportController@capas');
});

Route::any('exportar', 'ExportarController@exportar')->name('exportar');

Route::get('/teste', function () {
    echo Storage::disk('public')->url('a');echo env('APP_URL');die;
    $jogos = \App\Models\Keyshop::get();

    $resultado = [];
    foreach ($jogos as $jogo) {
        $html = file_get_contents($jogo['url']);
        $a = substr($html, strpos($html, '#keyshops'), 1000);
        $span = substr($a, strpos($a, '<span class="numeric">'), 50);
        $preco = preg_replace('/[^0-9,]/', '', $span);
        
        $resultado['lista'][] = [
            'titulo' => $jogo->titulo,
            'preco' => $preco
        ];

        $preco = str_replace(',', '.', $preco);

        if (empty($jogo->preco) || $preco < $jogo->preco) {
            $jogo->preco = $preco;
            $jogo->save();

            $resultado['novos'][] = [
                'titulo' => $jogo->titulo,
                'preco' => str_replace('.', ',', $preco)
            ];
        }
    }

    print_r($resultado);
    die;
    print_r(\MarcReichel\IGDBLaravel\Models\Platform::search('steamvr')->select(['name', 'id'])->get());
    die;
    // print_r(
    //     \App\Models\Loja::select('loja.nome')
    //                         ->join('acervo', 'acervo.id_loja', 'loja.id')
    //                             ->groupBy('loja.id')
    //                                 ->orderByDesc(\Illuminate\Support\Facades\DB::connection('icigames')->raw('count(acervo.id)'))
    //                                     ->get()
    // );
    $game = \MarcReichel\IGDBLaravel\Models\Game::find(1877);
    $releases = \MarcReichel\IGDBLaravel\Models\ReleaseDate::whereIn('id', $game->release_dates)->get();
    $metacritic = new \App\Models\Metacritic();
    // print_r($releases);
    $releases = $metacritic->buscarNotas($game->name, $releases);
    // print_r($releases);
    $html = file_get_contents('https://www.metacritic.com/game/playstation-4/cyberpunk-2077');
    $div = substr($html, strpos($html, '<a class="metascore_anchor" href="/game/playstation-4/cyberpunk-2077/critic-reviews">'), 172);
    echo $span = substr($div, strpos($div, '<span>'), 50);
    echo preg_replace('/[^0-9]/', '', $span);
});

Route::get('/', 'DashboardController@exibirDashboard')->name('exibir_dashboard');
Route::get('/{pagina?}', 'IndexController@exibirJogos')->name('exibir_jogos');