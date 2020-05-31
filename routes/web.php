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
});

Route::prefix('/igdb')->group(function () {
    Route::get('/buscar_jogos/{busca}', 'IgdbController@buscarJogosIgdb')->name('buscar_jogos_igdb');
    Route::get('/buscar_dados_jogo/{id}', 'IgdbController@buscarDadosJogo')->name('buscar_dados_jogo');
});

Route::get('/', 'IndexController@exibirDashboard')->name('exibir_dashboard');
Route::get('/{pagina?}', 'IndexController@exibirJogos')->name('exibir_jogos');

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