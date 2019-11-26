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

Route::get('/buscar_jogos/{titulo}', 'IgdbController@buscarJogos')->name('buscar_jogos');
Route::get('/buscar_dados_jogo/{id}', 'IgdbController@buscarDadosJogo')->name('buscar_dados_jogo');
Route::get('/', function () {
    return view('colecao');
});
