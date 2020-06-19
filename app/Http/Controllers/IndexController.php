<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Acervo;
use App\Models\Jogo;
use App\Models\Plataforma;
use App\Models\Situacao;
use Illuminate\Support\Facades\DB;
use App\Util\Helper;

class IndexController extends Controller {

    public function exibirJogos($pagina=null) {
        $situacao = Situacao::where('pagina', $pagina)->first();
        $jogos = Acervo::buscarAcervoSituacao($situacao->id);
        $totais_topo = $this->buscarTotaisTopo();

        return view('index', \array_merge([
            'jogos' => $jogos,
            'jogos_busca' => Jogo::get(),
            'aba' => $pagina,
            'pagina' => $situacao->tipo,
            'totais_topo' => $totais_topo,
            'total_menu' => $totais_topo[$pagina],
            'plataformas_menu' => $this->buscarPlataformasMenu($situacao->id)],
            Helper::getDadosFormulario()
        ));
    }

    public function exibirDashboard() {
        return view('dashboard',\array_merge([
            'jogos_busca' => Jogo::get(),
            'aba' => 'dashboard',
            'totais_dashboard' => $this->buscarTotaisDashboard(),
            'totais_topo' => $this->buscarTotaisTopo()],
            Helper::getDadosFormulario()
        ));
    }

    private function buscarTotaisDashboard() {
        // echo Acervo::where('id_situacao', 1)->count();die;
        return [
            'total_jogos' => Jogo::count(),
            'total_colecao' => Acervo::where('id_situacao', 1)->groupBy('id_jogo')->get()->count(),
            'total_completos' => Jogo::where('completo', true)->count(),
            'total_preco' => Helper::formatarPrecoExibicao(Acervo::sum('preco')),
            'total_fisicos' => Acervo::where('formato', 'Físico')->count(),
            'total_digitais' => Acervo::where('formato', 'Digital')->where('id_situacao', 1)->count()
        ];
    }

    private function buscarTotaisTopo() {
        return Acervo::buscarTotaisSituacao();
    }

    private function buscarPlataformasMenu($situacao) {
        return Plataforma::select('plataforma.nome', 'plataforma.sigla', DB::connection('icigames')->raw('count(acervo.id) as total'))
                            ->Leftjoin('acervo', function($join) use ($situacao){
                                                    $join->on('acervo.id_plataforma', 'plataforma.id');
                                                    $join->where('acervo.id_situacao', $situacao);
                                                })
                                    ->groupBy('plataforma.id')
                                        ->orderBy('plataforma.ordem')
                                            ->get();
    }

}