<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IgdbController;
use App\Util\Helper;
use App\Models\Jogo;
use App\Models\JogoEmpresa;
use App\Models\Empresa;
use App\Models\JogoGenero;
use App\Models\Genero;
use App\Models\Acervo;
use App\Models\Situacao;
use App\Models\OrdemWishlist;
use Carbon\Carbon;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;
use MarcReichel\IGDBLaravel\Models\Company;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller {

    public function buscarHtml() {
        return view('linha_acervo', Helper::getDadosFormulario());
    }

    public function salvarJogo(Request $request) {
        try {
            parse_str($request->dados, $dados);
            
            if (!empty($dados['id_jogo'])) {
                $jogo = Jogo::find($dados['id_jogo']);
            }
            else {
                $jogo = new Jogo();
            }

            $game = null;
            if (!empty($dados['id_igdb'])) {
                $game = Game::find($dados['id_igdb']);
            }
    
            DB::connection('icigames')->beginTransaction();

            $jogo->id_igdb = !empty($dados['id_igdb']) ? $dados['id_igdb'] : null;
            $jogo->id_igdb_cover = !empty($game) ? Cover::find($game->cover)->image_id : null;
            $jogo->titulo = $dados['titulo'];
            $jogo->descricao = $dados['descricao'];
            $jogo->nota = $dados['nota'];
            $jogo->completo = (!empty($dados['completo']));
    
            $jogo->save();

            foreach ($dados['plataforma'] as $i => $plataforma) {
                $acervo = new Acervo();
                $acervo->id_jogo = $jogo->id;
                $acervo->id_plataforma = $plataforma;
                $acervo->id_situacao = $dados['situacao'][$i];
                $acervo->data_lancamento = empty($dados['data_lancamento'][$i]) ? null : Carbon::createFromFormat('d/m/Y', $dados['data_lancamento'][$i])->format('Y-m-d');
                $acervo->data_compra = empty($dados['data_compra'][$i]) ? null : Carbon::createFromFormat('d/m/Y', $dados['data_compra'][$i])->format('Y-m-d');
                $acervo->id_regiao = $dados['regiao'][$i];
                $acervo->id_classificacao = $dados['classificacao'][$i];
                $acervo->metacritic = $dados['metacritic'][$i];
                $acervo->preco = $dados['preco'][$i] == '' ? null : $dados['preco'][$i];
                $acervo->formato = $dados['formato'][$i];
                $acervo->id_loja = $dados['loja'][$i];
                $acervo->save();
            }

            if (!is_null($game)) {
                if ($game->involved_companies != null) {
                    $developers = Company::select('id', 'name')->whereIn('id', InvolvedCompany::whereIn('id', $game->involved_companies)->where('developer', true)->get()->pluck('company')->toArray())->get();
                    foreach ($developers as $dev) {
                        $jogo_empresa = new JogoEmpresa();
                        $jogo_empresa->desenvolvedor = 1;
                        $jogo_empresa->distribuidor = 0;
                        $jogo_empresa->id_jogo = $jogo->id;
                        $jogo_empresa->id_empresa = Empresa::buscarEmpresa($dev)->id;
                        $jogo_empresa->save();
                    }

                    $publishers = Company::select('id', 'name')->whereIn('id', InvolvedCompany::whereIn('id', $game->involved_companies)->where('publisher', true)->get()->pluck('company')->toArray())->get();
                    foreach ($publishers as $pub) {
                        $jogo_empresa = new JogoEmpresa();
                        $jogo_empresa->desenvolvedor = 0;
                        $jogo_empresa->distribuidor = 1;
                        $jogo_empresa->id_jogo = $jogo->id;
                        $jogo_empresa->id_empresa = Empresa::buscarEmpresa($pub)->id;
                        $jogo_empresa->save();
                    }
                }

                if ($game->genres != null) {
                    $genres = Genre::select('id', 'name')->whereIn('id', $game->genres)->get();
                    foreach ($genres as $genre) {
                        $jogo_genero = new JogoGenero();
                        $jogo_genero->id_jogo = $jogo->id;
                        $jogo_genero->id_genero = Genero::buscarGenero($genre)->id;
                        $jogo_genero->save();
                    }
                }
            }
            
            if (!empty($dados['id_igdb'])) {
                Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_cover_big.png', file_get_contents(IgdbController::buscarUrlImagem('cover_big', $jogo->id_igdb_cover)));
                Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_cover_small.png', file_get_contents(IgdbController::buscarUrlImagem('cover_small', $jogo->id_igdb_cover)));
                Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_1080p.png', file_get_contents(IgdbController::buscarUrlImagem('1080p', $jogo->id_igdb_cover)));
            }

            DB::connection('icigames')->commit();
        }
        catch (\Exception $ex) {
            DB::connection('icigames')->rollback();
            return $ex->getMessage().' '.$ex->getFile().' '.$ex->getLine();
        }
        catch (\Error $ex) {
            DB::connection('icigames')->rollback();
            return $ex->getMessage().' '.$ex->getFile().' '.$ex->getLine();
        }

        return 'ok';
    }

    public function exibirJogos(Request $request) {
        $html = view($request['tipo'], ['jogos' => Acervo::buscarAcervoSituacao(Situacao::where('pagina', $request['situacao'])->first()->id)])->render();
        return ['html' => $html];
    }

    public function exibirDadosJogo(Request $request) {
        $jogo = Jogo::find($request['jogo']);

        $html = view('dados_jogo_'.$request['tipo'], [
            'jogo' => $jogo,
            'desenvolvedores' => JogoEmpresa::buscarDesenvolvedores($request['jogo'])->pluck('nome')->toArray(),
            'distribuidores' => JogoEmpresa::buscarDistribuidores($request['jogo'])->pluck('nome')->toArray(),
            'generos' => JogoGenero::buscarGeneros($request['jogo'])->pluck('nome')->toArray(),
            'acervo' => Acervo::buscarAcervoJogo($request['jogo'])
            ])->render();

        return [
            'html' => $html,
            'id_igdb' => $jogo->id_igdb
        ];
    }

    public function atualizarImagens(Request $request) {
        try {
            $jogo = Jogo::find($request->id);

            if (empty($jogo->id_igdb)) {
                return 'sem igdb';
            }

            $game = Game::find($jogo->id_igdb);
            $cover = $game->cover;

            if (empty($cover)) {
                return 'sem cover';
            }

            $jogo->id_igdb_cover = Cover::find($cover)->image_id;
            $jogo->save();           

            Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_cover_big.png', file_get_contents(IgdbController::buscarUrlImagem('cover_big', $jogo->id_igdb_cover)));
            Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_cover_small.png', file_get_contents(IgdbController::buscarUrlImagem('cover_small', $jogo->id_igdb_cover)));
            Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_1080p.png', file_get_contents(IgdbController::buscarUrlImagem('1080p', $jogo->id_igdb_cover)));

            return 'ok';
        }
        catch (\Exception $ex) {
            return 'erro';
        }
        catch (\Error $ex) {
            return 'erro';
        }
    }

    public function exibirScreenshots(Request $request) {
        $html = view('screenshots', [
            'screens' => IgdbController::buscarScreenshotsGame($request->id)
        ])->render();
        
        return ['html' => $html];
    }

    public function carregarAcervo(Request $request) {
        $acervo = Acervo::find($request->acervo);
        $acervo->data_lancamento = Carbon::createFromTimestamp(strtotime($acervo->data_lancamento))->format('d/m/Y');
        $acervo->data_compra = Carbon::createFromTimestamp(strtotime($acervo->data_compra))->format('d/m/Y');
        return $acervo;
    }

    public function salvarAcervo(Request $request) {
        if (empty($request->acervo)) {
            $acervo = new Acervo();
            $acervo->id_jogo = $request->jogo;
        }
        else {
            $acervo = Acervo::find($request->acervo);
        }
        
        parse_str($request->dados, $dados);
        $acervo->id_plataforma = $dados['plataforma'][0];
        $acervo->id_situacao = $dados['situacao'][0];
        $acervo->data_lancamento = empty($dados['data_lancamento'][0]) ? null : Carbon::createFromFormat('d/m/Y', $dados['data_lancamento'][0])->format('Y-m-d');
        $acervo->data_compra = empty($dados['data_compra'][0]) ? null : Carbon::createFromFormat('d/m/Y', $dados['data_compra'][0])->format('Y-m-d');
        $acervo->id_regiao = empty($dados['regiao'][0]) ? null : $dados['regiao'][0];
        $acervo->id_classificacao = empty($dados['classificacao'][0]) ? null : $dados['classificacao'][0];
        $acervo->metacritic = empty($dados['metacritic'][0]) ? null : $dados['metacritic'][0];
        $acervo->preco = $dados['preco'][0] == '' ? null : $dados['preco'][0];
        $acervo->formato = empty($dados['formato'][0]) ? null : $dados['formato'][0];
        $acervo->id_loja = empty($dados['loja'][0]) ? null : $dados['loja'][0];
        $acervo->save();
    }

    public function excluirJogo(Request $request, $args) {
        $jogo = Jogo::find($args);
        if (!empty($jogo->id_igdb_cover)) {
            Storage::disk('public')->delete('capas/'.$jogo->id_igdb_cover.'_cover_big.png');
            Storage::disk('public')->delete('capas/'.$jogo->id_igdb_cover.'_cover_small.png');
            Storage::disk('public')->delete('capas/'.$jogo->id_igdb_cover.'_1080p.png');
        }

        DB::connection('icigames')->beginTransaction();

        OrdemWishlist::where('id_jogo', $jogo->id)->delete();
        JogoEmpresa::where('id_jogo', $jogo->id)->delete();
        JogoGenero::where('id_jogo', $jogo->id)->delete();
        Acervo::where('id_jogo', $jogo->id)->delete();
        $jogo->delete();

        DB::connection('icigames')->commit();

        return 'ok';
    }

    public function ordenarWishlist(Request $request) {
        try {
            for ($i=1;$i<count($request['ordem']);$i++) {
                $ordem = OrdemWishlist::where('id_jogo', $request['ordem'][$i-1])->first();
                if ($ordem == null) {
                    $ordem = new OrdemWishlist();
                    $ordem->id_jogo = $request['ordem'][$i-1];
                    $ordem->save();
                }
                $ordem->update(['ordem' => $i]);
            }
        }
        catch (\Exception $ex) {
            return $ex->getMessage();
        }
        catch (\Error $ex) {
            return $ex->getMessage();
        }

        return 'ok';
    }

}