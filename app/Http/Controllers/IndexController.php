<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jogo;

class IndexController extends Controller {

    public function exibirJogos($pagina=null) {
        if ($pagina == null) {
            return view('index');
        }
        
        $tipo = null;
        switch ($pagina) {
            case 'colecao':
                $tipo = 'grid';
            break;
        }

        $games = Jogo::orderBy('titulo')->get();

        // $games = \MarcReichel\IGDBLaravel\Models\Game::search('tomb raider')
        //                 ->select(['name', 'cover'])
        //                 ->whereIn('platforms', ['6','7','8','9','38','46','48','167'])
        //                 ->where('category', '!=', 1)
        //                     ->take(50)
        //                         ->get();

        // foreach ($games as $game) {
            // $cloudinary_id = null;
            // if ($game->cover != null) {
            //     $cloudinary_id = \MarcReichel\IGDBLaravel\Models\Cover::find($game->cover)->image_id;
            // }

        //     $resultado[] = [
        //         'id' => $game->id,
        //         'titulo' => $game->titulo
        //     ];
        // }

        return view('index', [
            'games' => $games,
            'pagina' => $tipo
        ]);
    }

}