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
                $acervo->save();
            }

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
            // imagens
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

}