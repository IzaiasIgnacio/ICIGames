<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models;
use App\Util\Helper;
use Illuminate\Http\Request;

class AjaxController extends Controller {

    public function buscarHtml() {
        return view('linha_acervo', Helper::getDadosFormulario());
    }

    public function buscarJogosIgdb($busca) {
        return [
            ["name" => $busca],
            ["name" => "POLAND"]
        ];
    }

}