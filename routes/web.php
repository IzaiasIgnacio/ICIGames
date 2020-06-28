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
    Route::post('/salvar_jogo', 'AjaxController@salvarJogo')->name('salvar_jogo');
    Route::post('/atualizar_imagens', 'AjaxController@atualizarImagens')->name('atualizar_imagens');
    Route::post('/exibir_screenshots', 'AjaxController@exibirScreenshots')->name('exibir_screenshots');
    Route::post('/salvar_acervo', 'AjaxController@salvarAcervo')->name('salvar_acervo');
});

Route::prefix('/igdb')->group(function () {
    Route::get('/buscar_jogos/{busca}', 'IgdbController@buscarJogosIgdb')->name('buscar_jogos_igdb');
    Route::get('/buscar_dados_jogo/{id}', 'IgdbController@buscarDadosJogo')->name('buscar_dados_jogo');
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

Route::get('/teste', function () {
    $game = \MarcReichel\IGDBLaravel\Models\Game::find(72870);
    $releases = \MarcReichel\IGDBLaravel\Models\ReleaseDate::whereIn('id', $game->release_dates)->get();
    $metacritic = new \App\Models\Metacritic();
    // print_r($releases);
    $releases = $metacritic->buscarNotas($game->name, $releases);
    print_r($releases);
    // $html = file_get_contents('https://www.metacritic.com/game/playstation-4/nier-automata');
    // $div = substr($html, strpos($html, '<a class="metascore_anchor" href="/game/playstation-4/nier-automata/critic-reviews">'), 172);
    // echo $span = substr($div, strpos($div, '<span>'), 50);
    // echo preg_replace('/[^0-9]/', '', $span);
});

Route::get('/', 'IndexController@exibirDashboard')->name('exibir_dashboard');
Route::get('/{pagina?}', 'IndexController@exibirJogos')->name('exibir_jogos');