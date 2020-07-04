<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Acervo;
use App\Models\Jogo;
use App\Models\Plataforma;
use App\Models\Situacao;
use App\Models\Loja;
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

    public function graficos() {
        $plataformas = Plataforma::orderBy('ordem')->get();
        $situacoes = Situacao::get();
        $lojas = Loja::get();

        $dados_plataformas = null;
        foreach ($plataformas as $plataforma) {
            $acervo = Acervo::where('id_plataforma', $plataforma->id)->where('id_situacao', 1)->count();
            $dados_plataformas['plataformas'][] = $plataforma->nome.' ('.$acervo.')';
            $dados_plataformas['valores'][] = $acervo;
        }

        $dados_situacoes = null;
        foreach ($situacoes as $situacao) {
            $acervo = Acervo::where('id_situacao', $situacao->id)->distinct('id_jogo')->count();
            $dados_situacoes['situacoes'][] = $situacao->nome.' ('.$acervo.')';
            $dados_situacoes['valores'][] = $acervo;
        }

        $dados_lojas = null;
        foreach ($lojas as $loja) {
            $acervo = Acervo::where('id_loja', $loja->id)->count();
            $dados_lojas['lojas'][] = $loja->nome.' ('.$acervo.')';
            $dados_lojas['valores'][] = $acervo;
        }

        return [
            'plataformas' => [
                'rotulos' => $dados_plataformas['plataformas'],
                'valores' => $dados_plataformas['valores']
            ],
            'situacoes' => [
                'rotulos' => $dados_situacoes['situacoes'],
                'valores' => $dados_situacoes['valores']
            ],
            'lojas' => [
                'rotulos' => $dados_lojas['lojas'],
                'valores' => $dados_lojas['valores']
            ]
        ];
    }

}