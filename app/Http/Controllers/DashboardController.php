<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Acervo;
use App\Models\Jogo;
use App\Models\Plataforma;
use App\Util\Helper;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function exibirDashboard() {
        return view('dashboard',\array_merge([
            'jogos_busca' => Jogo::get(),
            'aba' => 'dashboard',
            'totais_dashboard' => $this->buscarTotaisDashboard(),
            'totais_topo' => Acervo::buscarTotaisSituacao()],
            Helper::getDadosFormulario()
        ));
    }

    private function buscarTotaisDashboard() {
        return [
            'total_jogos' => Jogo::count(),
            'total_colecao' => Acervo::where('id_situacao', 1)->groupBy('id_jogo')->get()->count(),
            'total_completos' => Jogo::where('completo', true)->count(),
            'total_preco' => Helper::formatarPrecoExibicao(Acervo::sum('preco')),
            'total_fisicos' => Acervo::where('formato', 'Físico')->count(),
            'total_digitais' => Acervo::where('formato', 'Digital')->where('id_situacao', 1)->count()
        ];
    }

    public function graficoPlataformas() {
        $dados = null;
        $plataformas = Plataforma::orderBy('ordem')->get();

        foreach ($plataformas as $plataforma) {
            $acervo = Acervo::where('id_plataforma', $plataforma->id)->where('id_situacao', 1)->count();
            $dados['plataformas'][] = $plataforma->nome.' ('.$acervo.')';
            $dados['valores'][] = $acervo;
        }

        return [
            'plataformas' => $dados['plataformas'],
            'valores' => $dados['valores']
        ];
    }

}