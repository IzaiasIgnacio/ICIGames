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

        $lojas = Loja::select('nome', DB::connection('icigames')->raw('count(acervo.id) as valor'))
                        ->join('acervo', 'acervo.id_loja', 'loja.id')
                            ->where('acervo.id_situacao', 1)
                                ->groupBy('loja.id')
                                    ->orderByDesc(DB::connection('icigames')->raw('count(acervo.id)'))
                                        ->take(10)
                                            ->get();

        $dados_lojas = null;
        foreach ($lojas as $loja) {
            $dados_lojas['lojas'][] = $loja->nome.' ('.$loja->valor.')';
            $dados_lojas['valores'][] = $loja->valor;
        }

        $lancamentos = Acervo::select(DB::connection('icigames')->raw('year(acervo.data_lancamento) as lancamento, count(acervo.id) as valor'))
                        ->whereNotNull('acervo.data_lancamento')
                        ->where('acervo.id_situacao', 1)
                            ->groupBy(DB::connection('icigames')->raw('year(acervo.data_lancamento)'))
                                ->orderByDesc(DB::connection('icigames')->raw('count(acervo.id)'))
                                    ->take(10)
                                        ->get();

        $dados_lancamentos = null;
        foreach ($lancamentos as $lancamento) {
            $dados_lancamentos['lancamentos'][] = $lancamento->lancamento.' ('.$lancamento->valor.')';
            $dados_lancamentos['valores'][] = $lancamento->valor;
        }

        $aquisicoes = Acervo::select(DB::connection('icigames')->raw('year(acervo.data_compra) as aquisicao, count(acervo.id) as valor'))
                        ->whereNotNull('acervo.data_compra')
                        ->where('acervo.id_situacao', 1)
                            ->groupBy(DB::connection('icigames')->raw('year(acervo.data_compra)'))
                                ->orderByDesc(DB::connection('icigames')->raw('count(acervo.id)'))
                                    ->take(10)
                                        ->get();

        $dados_aquisicoes = null;
        foreach ($aquisicoes as $aquisicao) {
            $dados_aquisicoes['aquisicoes'][] = $aquisicao->aquisicao.' ('.$aquisicao->valor.')';
            $dados_aquisicoes['valores'][] = $aquisicao->valor;
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
            ],
            'lancamentos' => [
                'rotulos' => $dados_lancamentos['lancamentos'],
                'valores' => $dados_lancamentos['valores']
            ],
            'aquisicoes' => [
                'rotulos' => $dados_aquisicoes['aquisicoes'],
                'valores' => $dados_aquisicoes['valores']
            ]
        ];
    }

}