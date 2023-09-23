<?php

namespace App\Clients;

class StockStatus
{
    public bool $available;
    public int $price;

    public function __construct($available, $price)
    {
        $this->available = $available;
        $this->price = $price;
    }
}
