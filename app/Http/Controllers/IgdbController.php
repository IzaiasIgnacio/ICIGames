<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;
use MarcReichel\IGDBLaravel\Models\Company;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\ReleaseDate;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\PLatform;
use MarcReichel\IGDBLaravel\Models\Screenshot;
use App\Models\Plataforma;
use App\Models\Metacritic;

class IgdbController extends Controller {

    private $plataformas = [
        '6', // PC (Microsoft Windows)
        '7', // PlayStation
        '8', // PlayStation 2
        '9', // PlayStation 3
        '38', // PlayStation Portable
        '46', // PlayStation Vita
        '48', // PlayStation 4
        '167' // PlayStation 5
    ];

    public function buscarJogosIgdb($busca) {
        // return $this->mock();
        $resultado = [];

        $games = Game::search($busca)
                        ->select(['name', 'cover'])
                        ->whereIn('platforms', $this->plataformas)
                        ->where('category', '!=', 1)
                            ->take(10)
                                ->get();

        foreach ($games as $game) {
            $hash = null;
            $cover = Game::find($game->id)->cover;
            if (!empty($cover)) {
                $hash = Cover::find($cover)->image_id;
            }

            $dados_igdb = Game::find($game->id);

            $resultado[] = [
                'id' => $game->id,
                'name' => $game->name,
                "year" => date('Y', \strtotime($dados_igdb->first_release_date)),
                "platforms" => $this->filtrarPlataformas($dados_igdb->platforms),
                'cover' => empty($hash) ? null : $this->buscarUrlImagem('thumb', $hash)
            ];
        }

        return $resultado;
    }

    public function buscarDadosJogo($id) {
        $game = Game::find($id);
        $developers = null;
        $publishers = null;
        $lancamentos = null;
        $genres = null;

        if ($game->involved_companies != null) {
            $developers = Company::whereIn('id', InvolvedCompany::whereIn('id', $game->involved_companies)->where('developer', true)->get()->pluck('company')->toArray())->get()->pluck('name');
            $publishers = Company::whereIn('id', InvolvedCompany::whereIn('id', $game->involved_companies)->where('publisher', true)->get()->pluck('company')->toArray())->get()->pluck('name');
        }
        if ($game->release_dates != null) {
            $lancamentos = ReleaseDate::whereIn('id', $game->release_dates)->get();
            
            $metacritic = new Metacritic();
            $lancamentos = $metacritic->buscarNotas($game->name, $lancamentos);
        }
        if ($game->genres != null) {
            $genres = Genre::whereIn('id', $game->genres)->get()->pluck('name');
        }

        $releases = [];
        foreach ($lancamentos as $lancamento) {
            if (!in_array($lancamento->platform, $this->plataformas)) {
                continue;
            }

            $releases[] = [
                'id' => $lancamento->id,
                'category' => $lancamento->category,
                'platform' => $lancamento->platform,
                'date' => $lancamento->date,
                'region' => $lancamento->region,
                'metacritic' => $lancamento->metacritic
            ];

        }

        $cover = Cover::find($game->cover)->image_id;

        return [
            'id' => $game->id,
            'name' => $game->name,
            'summary' => $game->summary,
            'screenshots' => $this->buscarUrlScreenshots($game->screenshots),
            'developers' => $developers,
            'publishers' => $publishers,
            'genres' => $genres,
            'release_dates' => $releases,
            'acervo' => $this->getHtmlAcervo($releases),
            'cover' => empty($cover) ? null : $this->buscarUrlImagem('cover_big', $cover)
        ];
    }

    private function getHtmlAcervo($releases) {
        $html = null;
        foreach ($releases as $release) {
            $html .= view('linha_acervo',\array_merge([
                'plataforma_selecionada' => Plataforma::where('id_igdb', $release['platform'])->first()->id,
                'data_lancamento' => \date('Y-m-d', $release['date']),
                'regiao_selecionada' => $release['region'],
                'metacritic' => $release['metacritic']],
                \App\Util\Helper::getDadosFormulario()))->render();
        }

        return ['html' => $html];
    }

    public function buscarUrlScreenshots($screenshots) {
        if (empty($screenshots)) {
            return [];
        }

        $screen = array();
        
        foreach ($screenshots as $s) {
            $sc = Screenshot::find($s);
            $screen[] = $this->buscarUrlImagem('cover_big', $sc->image_id);
        }

        return $screen;
    }

    public static function buscarScreenshotsGame($id_igdb) {
        $igdb = new IgdbController();
        return $igdb->buscarUrlScreenshots(Game::find($id_igdb)->screenshots);
    }
    
    public static function buscarUrlImagem($tamanho, $hash) {
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

    private function filtrarPlataformas($platforms) {
        $plataformas = $this->plataformas;
        $array = array_filter($platforms, function($platform) use ($plataformas) {
            return \in_array($platform, $plataformas);
        });

        $pl = array();
        foreach ($array as $a) {
            $pl[] = str_replace(" (Microsoft Windows)","", Platform::find($a)->name);
        }
        
        return implode(", ",$pl);
    }

    private function mock() {
        return [
                    [
                        "id" => "912",
                        "name" => "Tomb Raider",
                        "cover" => "https://images.igdb.com/igdb/image/upload/t_thumb/co1nnt.jpg",
                        "year" => date('Y', \strtotime(Game::find(912)->first_release_date)),
                        "platforms" => $this->filtrarPlataformas(Game::find(912)->platforms)
                    ],
                    [
                        "id" => "1156",
                        "name" => "Tomb Raider II",
                        "cover" => "https://images.igdb.com/igdb/image/upload/t_thumb/co1nnw.jpg"
                    ],
                    [
                        "id" => "1161",
                        "name" => "Tomb Raider: Legend",
                        "cover" => "https://images.igdb.com/igdb/image/upload/t_thumb/co1nnv.jpg"
                    ],
                    [
                        "id" => "1159",
                        "name" => "Tomb Raider: The Angel of Darkness",
                        "cover" => "https://images.igdb.com/igdb/image/upload/t_thumb/co1vog.jpg"
                    ],
                    [
                        "id" => "1164",
                        "name" => "Tomb Raider",
                        "cover" => "https://images.igdb.com/igdb/image/upload/t_thumb/co1rbu.jpg"
                    ],
                    [
                        "id" => "7323",
                        "name" => "Rise of the Tomb Raider",
                        "cover" => "https://images.igdb.com/igdb/image/upload/t_thumb/co1rqa.jpg"
                    ]
        ];
    }

    #region legado
    private function getCloudnaryId($game) {
        $cloudinary_id = null;
        if ($game->cover != null) {
            $cloudinary_id = Cover::find($game->cover)->image_id;
        }

        return $cloudinary_id;
    }

    public function buscarJogosLegado($titulo) {
        $resultado = [];

        $games = Game::search($titulo)
                        ->select(['name', 'cover'])
                        ->whereIn('platforms', $this->plataformas)
                        ->where('category', '!=', 1)
                            ->take(50)
                                ->get();

        foreach ($games as $game) {
            $resultado[] = [
                'id' => $game->id,
                'name' => $game->name,
                'cover' => ['cloudinary_id' => $this->getCloudnaryId($game)]
            ];
        }

        return $resultado;
    }

    
    public function buscarDadosJogoLegado($id) {
        $game = Game::find($id);
        $developers = null;
        $publishers = null;
        $lancamentos = null;
        $genres = null;

        if ($game->involved_companies != null) {
            $developers = Company::whereIn('id', InvolvedCompany::whereIn('id', $game->involved_companies)->where('developer', true)->get()->pluck('company')->toArray())->get()->pluck('id');
            $publishers = Company::whereIn('id', InvolvedCompany::whereIn('id', $game->involved_companies)->where('publisher', true)->get()->pluck('company')->toArray())->get()->pluck('id');
        }
        if ($game->release_dates != null) {
            $lancamentos = ReleaseDate::whereIn('id', $game->release_dates)->get();
        }
        if ($game->genres != null) {
            $genres = Genre::whereIn('id', $game->genres)->get()->pluck('id');
        }

        $releases = [];
        foreach ($lancamentos as $lancamento) {
            if (!in_array($lancamento->platform, $this->plataformas)) {
                continue;
            }

            $releases[] = [
                'id' => $lancamento->id,
                'platform' => $lancamento->platform,
                'date' => $lancamento->date,
                'region' => $lancamento->region
            ];
        }

        return [[
            'id' => $game->id,
            'name' => $game->name,
            'summary' => $game->summary,
            'developers' => $developers,
            'publishers' => $publishers,
            'genres' => $genres,
            'release_dates' => $releases,
            'cover' => ['cloudinary_id' => $this->getCloudnaryId($game)]
        ]];
    }

    public function buscarDadosEmpresasLegado($ids) {
        $resultado = [];
        $empresas = Company::whereIn('id', explode(',', $ids))->get();

        foreach ($empresas as $empresa) {
            $resultado[] = [
                'id' => $empresa->id,
                'name' => $empresa->name
            ];
        }

        return $resultado;
    }

    public function buscarDadosGenerosLegado($ids) {
        $resultado = [];
        $generos = Genre::whereIn('id', explode(',', $ids))->get();

        foreach ($generos as $genero) {
            $resultado[] = [
                'id' => $genero->id,
                'name' => $genero->name
            ];
        }

        return $resultado;
    }
    #endregion

}

// {
//     "age_ratings": [
//         3456
//     ],
//     "aggregated_rating": 84.6,
//     "aggregated_rating_count": 2,
//     "alternative_names": [
//         18271,
//         18272
//     ],
//     "category": 0,
//     "collection": 183,
//     "cover": 77321,
//     "created_at": "2011-10-04T00:00:00.000000Z",
//     "external_games": [
//         12853,
//         154259,
//         225226,
//         245144,
//         250081
//     ],
//     "first_release_date": "1996-10-01T00:00:00.000000Z",
//     "game_modes": [
//         1
//     ],
//     "genres": [
//         5,
//         8,
//         9,
//         31
//     ],
//     "id": 912,
//     "involved_companies": [
//         1973,
//         21227,
//         42061,
//         42062
//     ],
//     "keywords": [
//         21,
//         46,
//     ],
//     "name": "Tomb Raider",
//     "platforms": [
//         6,
//         7,
//         13,
//         14,
//         32,
//         34,
//         39,
//         42,
//         45
//     ],
//     "player_perspectives": [
//         2
//     ],
//     "popularity": 4.566234205629367,
//     "pulse_count": 9,
//     "rating": 83.9422770015487,
//     "rating_count": 177,
//     "release_dates": [
//         1977,
//         1978,
//         1980,
//         2292,
//         2293,
//         2294,
//         61305,
//         61306,
//         61308,
//         151004
//     ],
//     "screenshots": [
//         16876,
//         37978,
//         37979,
//         37980,
//         37981
//     ],
//     "similar_games": [
//         20,
//         533,
//         538,
//         1020,
//         1164,
//         1377,
//         2031,
//         3188,
//         9498,
//         9727
//     ],
//     "slug": "tomb-raider",
//     "summary": "Adventurer Lara Croft has been hired to recover the pieces of an ancient artifact known as the Scion. With her fearless acrobatic style she runs, jumps, swims and climbs her way towards the truth of its origin and powers - leaving only a trail of empty tombs and gun-cartridges in her wake.",
//     "tags": [
//         1,
//         21,
//         33,
//     ],
//     "themes": [
//         1,
//         21,
//         33
//     ],
//     "time_to_beat": 912,
//     "total_rating": 84.27113850077436,
//     "total_rating_count": 179,
//     "updated_at": "2019-11-21T00:00:00.000000Z",
//     "url": "https://www.igdb.com/games/tomb-raider",
//     "websites": [
//         15831,
//         77364,
//         99593
//     ]
// }