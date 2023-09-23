<?php

namespace App\Clients;

use App\Clients\Client;
use App\Models\Stock;

class Target implements Client
{

    public function checkAvailability(Stock $stock): StockStatus
    {
        // TODO: Implement checkAvailability() method.
    }
}
