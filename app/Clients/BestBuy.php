<?php

namespace App\Clients;

use App\Models\Stock;
use Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $result = Http::get('https://foo.test')->json();

        return new StockStatus(
            $result['available'],
            $result['price'],
        );
    }
}
