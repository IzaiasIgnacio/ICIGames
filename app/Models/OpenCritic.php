<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenCritic {

	public function buscarMedia($titulo) {
        try {
            $busca = \file_get_contents('http://api.opencritic.com/api/game/search?criteria='.\urlencode($titulo));
            $resultados = json_decode($busca, true);

            if (empty(\json_last_error())) {
                if ($resultados[0]['dist'] == 0) {
                    $busca_media = \file_get_contents('http://api.opencritic.com/api/game/'.$resultados[0]['id']);
                    $media = json_decode($busca_media, true);

                    if (empty(\json_last_error())) {
                        return (int) $media['topCriticScore'];
                    }
                }
            }
        }
        catch(\Exception $ex) {
            return $ex->getMessage();
        }
        catch(\Error $ex) {
            return $ex->getMessage();
        }

        return null;
    }
    
}