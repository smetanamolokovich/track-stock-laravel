<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    use HasFactory;
    public function checkAvailability(Stock $stock): StockStatus
    {
        $result = Http::get('https://foo.test')->json();

        return new StockStatus(
            $result['available'],
            $result['price'],
        );
    }
}
