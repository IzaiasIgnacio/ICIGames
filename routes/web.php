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

Route::get('/{pagina?}', 'IndexController@exibirJogos')->name('exibir_jogos');

Route::prefix('/ajax')->group(function () {
    Route::get('/html', 'AjaxController@buscarHtml')->name('buscar_html');
    Route::get('/buscar_jogos_igdb/{busca}', 'AjaxController@buscarJogosIgdb')->name('buscar_jogos_igdb');
});