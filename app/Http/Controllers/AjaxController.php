<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Util\Helper;

class AjaxController extends Controller {

    public function buscarHtml() {
        return view('linha_acervo', Helper::getDadosFormulario());
    }

}