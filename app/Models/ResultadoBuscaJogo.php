<?php

namespace App\Models;

class ResultadoBuscaJogo {
    public $id;
    public $name;
    public $imagem;

    public function __construct($id, $name, $imagem) {
        $this->id = $id;
        $this->name = $name;
        $this->imagem = $imagem;
    }
    
}