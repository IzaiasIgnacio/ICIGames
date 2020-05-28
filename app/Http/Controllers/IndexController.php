<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jogo;
use App\Models\Plataforma;
use Illuminate\Support\Facades\DB;
use App\Util\Helper;

class IndexController extends Controller {

    private $config = [
        'colecao' => [
            'tipo' => 'grid',
            'situacao' => 1
        ],
        'wishlist' => [
            'tipo' => 'grid',
            'situacao' => 2
        ],
        'watchlist' => [
            'tipo' => 'grid',
            'situacao' => 3
        ],
        'game_pass' => [
            'tipo' => 'grid',
            'situacao' => 5
        ],
        'plus' => [
            'tipo' => 'grid',
            'situacao' => 4
        ],
    ];

    public function exibirJogos($pagina=null) {
        if ($pagina == null) {
            return view('dashboard',[
                'aba' => 'dashboard'
            ]);
        }
        
        $busca = Jogo::select('jogo.id', 'jogo.id_igdb_cover', 'jogo.titulo', DB::connection('icigames')->raw('group_concat(plataforma.sigla) as siglas'))
                ->join('acervo', 'acervo.id_jogo', 'jogo.id')
                ->join('plataforma', 'acervo.id_plataforma', 'plataforma.id')
                    ->where('acervo.id_situacao', $this->config[$pagina]['situacao'])
                        ->groupBy('jogo.id');

        if ($pagina == 'wishlist') {
            $jogos = $busca->join('ordem_wishlist', 'acervo.id_jogo', 'ordem_wishlist.id_jogo')->orderBy('ordem_wishlist.ordem')->get();
        }
        else {
            $jogos = $busca->orderBy('titulo')->get();
        }

        return view('index', \array_merge([
            'jogos' => $jogos,
            'aba' => $pagina,
            'pagina' => $this->config[$pagina]['tipo'],
            'plataformas_menu' => $this->buscarPlataformasMenu($pagina)],
            Helper::getDadosFormulario()
        ));
    }

    private function buscarPlataformasMenu($pagina) {
        return Plataforma::select('plataforma.nome', 'plataforma.sigla', DB::connection('icigames')->raw('count(acervo.id) as total'))
                            ->Leftjoin('acervo', function($join) use ($pagina){
                                                    $join->on('acervo.id_plataforma', 'plataforma.id');
                                                    $join->where('acervo.id_situacao', $this->config[$pagina]['situacao']);
                                                })
                                    ->groupBy('plataforma.id')
                                        ->orderBy('plataforma.ordem')
                                            ->get();
    }

}