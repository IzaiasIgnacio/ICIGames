<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models;
use App\Models\Import;
use App\Http\Controllers\IgdbController;
use App\Models\_Import;
use App\Models\Acervo;
use App\Models\Jogo;
use App\Models\Loja;
use App\Models\Plataforma;
use App\Models\Situacao;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ImportController extends Controller {

    public function importarTabela() {
        $import = _Import::where('importado', false)->get();

        foreach ($import as $game) {
            $jogo = Jogo::where('titulo', $game->titulo)->firstOrCreate(['titulo' => ucwords($game->titulo)]);

            $acervo = new Acervo();
            $acervo->id_jogo = $jogo->id;
            $acervo->id_plataforma = Plataforma::where('sigla', $game->plataforma)->first()->id;
            $acervo->id_situacao = Situacao::where('pagina', $game->situacao)->first()->id;
            if (!empty($game->data)) {
                $acervo->data_compra = $game->data;
            }
            if (!empty($game->preco) || $game->preco === '0') {
                $acervo->preco = $game->preco;
            }
            if (!empty($game->formato)) {
                $acervo->formato = $game->formato;
            }
            $loja = Loja::where('nome', $game->loja);
            if (!empty($game->loja) && $loja->exists()) {
                $acervo->id_loja = $loja->first()->id;
            }
            $acervo->save();

            $game->importado = true;
            $game->save();
        }
    }

    public function capas() {
        ini_set('max_execution_time', 0);

        $jogos = Models\Jogo::whereNotNull('id_igdb')->get();

        foreach ($jogos as $jogo) {
            @$cover = \MarcReichel\IGDBLaravel\Models\Game::find($jogo->id_igdb)->cover;
            if (!empty($cover)) {
                $jogo->id_igdb_cover = \MarcReichel\IGDBLaravel\Models\Cover::find($cover)->image_id;
                $jogo->save();
                
                // if (!Storage::disk('public')->exists('capas/'.$jogo->id_igdb_cover.'_cover_big.png')) {
                //     Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_cover_big.png', file_get_contents(IgdbController::buscarUrlImagem('cover_big', $jogo->id_igdb_cover)));
                // }
                // if (!Storage::disk('public')->exists('capas/'.$jogo->id_igdb_cover.'_cover_small.png')) {
                //     Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_cover_small.png', file_get_contents(IgdbController::buscarUrlImagem('cover_small', $jogo->id_igdb_cover)));
                // }
                // if (!Storage::disk('public')->exists('capas/'.$jogo->id_igdb_cover.'_1080p.png')) {
                //     Storage::disk('public')->put('capas/'.$jogo->id_igdb_cover.'_1080p.png', file_get_contents(IgdbController::buscarUrlImagem('1080p', $jogo->id_igdb_cover)));
                // }
            }
        }
    }
    
    public function importar() {
        ini_set('max_execution_time', 0);

        DB::connection('icigames')->beginTransaction();

        foreach (Import\Game::orderBy('id')->get() as $game) {
            $this->importarJogo($game);
        }

        // foreach (Import\Status::get() as $status) {
        //     $this->importarSituacao($status);
        // }

        foreach (Import\Genre::get() as $gender) {
            $this->importarGenero($gender);
        }

        // foreach (Import\Platform::get() as $platform) {
        //     $this->importarPlataforma($platform);
        // }

        foreach (Import\DeveloperPublisher::get() as $developer_publisher) {
            $this->importarEmpresa($developer_publisher);
        }

        foreach (Import\Store::get() as $store) {
            $this->importarLoja($store);
        }

        // foreach (Import\Region::get() as $region) {
        //     $this->importarRegiao($region);
        // }
        
        foreach (Import\WishlistOrder::get() as $wishlist_order) {
            $this->importarOrdemWishlist($wishlist_order);
        }

        foreach (Import\GameDeveloperPublisher::get() as $developer_publisher) {
            $this->importarJogoEmpresa($developer_publisher);
        }

        foreach (Import\GameGenre::get() as $game_genre) {
            $this->importarJogoGenero($game_genre);
        }

        foreach (Import\GamePlatform::get() as $game_platform) {
            $this->importarAcervo($game_platform);
        }

        DB::connection('icigames')->commit();
    }

    private function importarJogo($game) {
        $jogo = Models\Jogo::firstOrCreate(['titulo' => $game->name, 'id_igdb' => $game->id_igdb]);
        // $jogo->id_igdb_cover = $game->cloudnary_id;
        $jogo->descricao = $game->summary;
        $jogo->nota = $game->nota;
        $jogo->completo = (int) $game->completo;
        $jogo->save();
    }

    private function importarSituacao($status) {
        $situacao = Models\Situacao::firstOrCreate(['nome' => $status->name]);
        $situacao->save();
    }

    private function importarGenero($gender) {
        $genero = Models\Genero::firstOrCreate(['nome' => $gender->name, 'id_igdb' => $gender->id_igdb]);
        $genero->save();
    }

    private function importarPlataforma($platform) {
        $plataforma = Models\Plataforma::firstOrCreate(['nome' => $platform->name, 'id_igdb' => $platform->id_igdb]);
        $plataforma->sigla = $platform->sigla;
        $plataforma->ordem = $platform->ordem;
        $plataforma->save();
    }

    private function importarEmpresa($developer_publisher) {
        $empresa = Models\Empresa::firstOrCreate(['nome' => $developer_publisher->name, 'id_igdb' => $developer_publisher->id_igdb]);
        $empresa->save();
    }

    private function importarLoja($store) {
        $loja = Models\Loja::firstOrCreate(['nome' => $store->name]);
        $loja->save();
    }
    
    private function importarRegiao($region) {
        $regiao = Models\Regiao::firstOrCreate(['nome' => $region->name]);
        $regiao->sigla = $region->sigla;
        $regiao->save();
    }

    private function importarOrdemWishlist($wishlist_order) {
        $ordem_wishlist = Models\OrdemWishlist::firstOrCreate([
            'id_jogo' => $this->buscarJogo($wishlist_order->id_game)->id,
            'ordem' => $wishlist_order->ordem
        ]);
        $ordem_wishlist->save();
    }

    private function importarJogoEmpresa($game_developer_publisher) {
        $jogo_empresa = Models\JogoEmpresa::firstOrCreate([
            'desenvolvedor' => ($game_developer_publisher->tipo == 1),
            'distribuidor' => ($game_developer_publisher->tipo == 2),
            'id_jogo' => $this->buscarJogo($game_developer_publisher->id_game)->id,
            'id_empresa' => $this->buscarEmpresa($game_developer_publisher->id_developerPublisher)->id
        ]);
        $jogo_empresa->save();
    }

    private function importarJogoGenero($game_genre) {
        $jogo_genero = Models\JogoGenero::firstOrCreate([
            'id_jogo' => $this->buscarJogo($game_genre->id_game)->id,
            'id_genero' => $this->buscarGenero($game_genre->id_genre)->id
        ]);
        $jogo_genero->save();
    }

    private function importarAcervo($game_platform) {
        $acervo = Models\Acervo::firstOrCreate([
            'id_jogo' => $this->buscarJogo($game_platform->id_game)->id,
            'id_plataforma' => $this->buscarPlataforma($game_platform->id_platform)->id,
            'id_situacao' => $game_platform->id_status,
            'id_loja' => $this->buscarLoja($game_platform->id_store)
        ]);

        $acervo->data_lancamento = $game_platform->release_date;
        $acervo->metacritic = $game_platform->metacritic;
        $acervo->preco = $game_platform->preco;
        $acervo->formato = ($game_platform->formato == 1) ? 'Fisico' : 'Digital';
        $acervo->id_regiao = $game_platform->id_region;
        $acervo->id_classificacao = $this->buscarClassificacao($game_platform->id_rating);

        $acervo->save();
    }

    private function buscarJogo($id) {
        $game = Import\Game::find($id);
        return Models\Jogo::where('titulo', $game->name)->where('id_igdb', $game->id_igdb)->first();
    }

    private function buscarEmpresa($id) {
        $developer_publisher = Import\DeveloperPublisher::find($id);
        return Models\Empresa::where('nome', $developer_publisher->name)->where('id_igdb', $developer_publisher->id_igdb)->first();
    }

    private function buscarGenero($id) {
        $genre = Import\Genre::find($id);
        return Models\Genero::where('nome', $genre->name)->where('id_igdb', $genre->id_igdb)->first();
    }

    private function buscarPlataforma($id) {
        $platform = Import\Platform::find($id);
        return Models\Plataforma::where('nome', $platform->name)->where('id_igdb', $platform->id_igdb)->first();
    }

    private function buscarLoja($id) {
        if (empty($id)) {
            return null;
        }

        $store = Import\Store::find($id);
        return Models\Loja::where('nome', $store->name)->first()->id;
    }

    private function buscarClassificacao($id) {
        if (empty($id)) {
            return null;
        }
        
        if ($id < 23) {
            return $id;
        }

        return $id-5;
    }

}