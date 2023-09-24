<?php

namespace App\Listeners;

use App\Events\NowInStock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStockUpdateNotification
{
    public function handle(NowInStock $event): void
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
