<?php
namespace App\Console;

use App\Models\GGDeals;
use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GGDealsApi extends Command {
	protected $signature = 'keyshops';
	
	public function handle() : void {
		$games = GGDeals::get();

		$ch = curl_init('https://api.gg.deals/v1/prices/by-steam-app-id/?ids='.implode(',', $games->pluck('steam_id')->toArray()).'&key=pKlR3gfL-EYLH8DVf6uT9nUwn54mtH6t&region=br');
		$header[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);

		$ggdeals = curl_exec($ch);

		$precos = (json_decode($ggdeals, true));
		$emails = [];

		foreach ($precos['data'] as $id => $preco) {
			if (!empty($preco['prices']['currentKeyshops'])) {
				$atual = $preco['prices']['currentKeyshops'];
				$retail = $preco['prices']['currentRetail'];

				$registro = GGDeals::where('steam_id', $id)->first();
				$registro->preco = $atual;

				if (empty($registro->historico) || $registro->historico > $atual) {
					$registro->historico = $atual;
				}

				if ($atual <= $registro->alvo) {
					@$emails[$registro->titulo] .= $atual." (".$retail.")";
				}
				
				$registro->save();
			}
		}

		if (count($emails) > 0) {
			echo count($emails).' jogos';
			Mail::to('izaias.ignacio@outlook.com')->send(new Email($emails));
		}

    }
}
