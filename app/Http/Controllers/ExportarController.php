<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use File;

class ExportarController extends Controller {

    public function exportar() {
        $dump = "I:\\xampp\\htdocs\\ICIGames\dump_local.sql";
        shell_exec("I:\\xampp\\mysql\\bin\\mysqldump -u root icigames > ".$dump);
        Storage::disk('drive')->put('db_icigames.sql', File::get($dump));
        unlink($dump);
    }

}