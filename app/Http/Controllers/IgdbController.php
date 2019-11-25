<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Cover;
use App\Models\ResultadoBuscaJogo;

class IgdbController extends Controller {

    private $plataformas = [
        '6', // PC (Microsoft Windows)
        '7', // PlayStation
        '8', // PlayStation 2
        '9', // PlayStation 3
        '38', // PlayStation Portable
        '46', // PlayStation Vita
        '48', // PlayStation 4
        '167', // PlayStation 5
    ];
    
    public function buscarJogos(Request $request) {
        $resultado = [];

        $games = Game::search($request['titulo'])
                        ->select(['name', 'cover', 'platforms'])
                        ->whereIn('platforms', $this->plataformas)
                        ->where('category', '!=', 1)
                            ->take(50)
                                ->get();

        foreach ($games as $game) {
            $cover = null;
            if ($game->cover != null) {
                $cover = Cover::find($game->cover);
            }
            $resultado[] = new ResultadoBuscaJogo($game->id, $game->name, $this->buscarUrlImagem('cover_small', @$cover->image_id));
        }

        return $resultado;
    }

    private function buscarUrlImagem($tamanho, $hash) {
        // cover_small	    90 x 128	Fit
        // screenshot_med	569 x 320	Lfill, Center gravity
        // cover_big	    264 x 374	Fit
        // logo_med	        284 x 160	Fit
        // screenshot_big	889 x 500	Lfill, Center gravity
        // screenshot_huge	1280 x 720	Lfill, Center gravity
        // thumb	        90 x 90	    Thumb, Center gravity
        // micro	        35 x 35	    Thumb, Center gravity
        // 720p	            1280 x 720	Fit, Center gravity
        // 1080p	        1920 x 1080	Fit, Center gravity
        if ($hash == '') {
            return null;
        }
        return "https://images.igdb.com/igdb/image/upload/t_".$tamanho."/".$hash.".jpg";
    }

}
