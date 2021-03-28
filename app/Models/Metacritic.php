<?php

namespace App\Models;

class Metacritic {

    // $name => MarcReichel\IGDBLaravel\Models\Game->name;
    // $releases => MarcReichel\IGDBLaravel\Models\ReleaseDate;
	public function buscarNotas($name, $releases) {
        try {
            foreach ($releases as $release) {
                if (Plataforma::where('id_igdb', $release->platform)->exists()) {
                    $nome_plataforma = Plataforma::where('id_igdb', $release->platform)->first()->nome_metacritic;
                    $name = $this->tratarString($name);
                    $html = file_get_contents('https://www.metacritic.com/game/'.$nome_plataforma.'/'.$name);
                    $div = substr($html, strpos($html, '<a class="metascore_anchor" href="/game/'.$nome_plataforma.'/'.$name.'/critic-reviews">'), 172);
                    $span = substr($div, strpos($div, '<span>'), 50);
                    $nota = preg_replace('/[^0-9]/', '', $span);
                    $release->metacritic = ($nota == 3401) ? null : $nota;
                }
            }
        }
        catch(\Exception $ex) {
            return $releases;
        }
        catch(\Error $ex) {
            return $releases;
        }

        return $releases;
    }
    
    private function tratarString($string) {
        return str_replace(' ', '-', str_replace(':', '', strtolower($string)));
    }
	
}