<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models;
use App\Models\Import;

class ImportController extends Controller {
    
    public function importar() {
        ini_set('max_execution_time', 0);
        foreach (Import\Game::orderBy('id')->get() as $game) {
            $this->importarJogo($game);
        }

        foreach (Import\Status::get() as $status) {
            $this->importarSituacao($status);
        }

        foreach (Import\DeveloperPublisher::get() as $developer_publisher) {
            $this->importarEmpresa($developer_publisher);
        }

        foreach (Import\GameDeveloperPublisher::get() as $developer_publisher) {
            $this->importarJogoEmpresa($developer_publisher);
        }
    }

    private function importarJogo($game) {
        $jogo = Models\Jogo::firstOrCreate(['titulo' => $game->name, 'id_igdb' => $game->id_igdb]);
        $jogo->id_igdb = $game->id_igdb;
        $jogo->titulo = $game->name;
        $jogo->descrição = $game->summary;
        $jogo->nota = $game->nota;
        $jogo->completo = (int) $game->completo;
        $jogo->save();
    }

    private function importarSituacao($status) {
        $situacao = Models\Situacao::firstOrCreate(['nome' => $status->name]);
        $situacao->save();
    }

    private function importarEmpresa($developer_publisher) {
        $empresa = Models\Empresa::firstOrCreate(['nome' => $developer_publisher->name, 'id_igdb' => $developer_publisher->id_igdb]);
        $empresa->save();
    }

    private function importarJogoEmpresa($game_developer_publisher) {
        $jogo_empresa = Models\JogoEmpresa::firstOrCreate([
            'desenvolvedor' => ($game_developer_publisher->tipo == 1),
            'distribuidor' => ($game_developer_publisher->tipo == 2),
            'id_jogo' => $this->buscarJogo($game_developer_publisher->id_game)->id,
            'id_empresa' => $this->buscarEmpresa($game_developer_publisher->id_developerPublisher)->id
        ]);
        $jogo_empresa->save();
    }

    private function buscarJogo($id) {
        $game = Import\Game::find($id);
        return Models\Jogo::where('titulo', $game->name)->where('id_igdb', $game->id_igdb)->first();
    }

    private function buscarEmpresa($id) {
        $developer_publisher = Import\DeveloperPublisher::find($id);
        return Models\Empresa::where('nome', $developer_publisher->name)->where('id_igdb', $developer_publisher->id_igdb)->first();
    }

}