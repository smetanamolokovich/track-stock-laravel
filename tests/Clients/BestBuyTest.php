<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestBuyTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function it_tracks_a_product()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $stock = tap(Stock::first())->update([
            'sku' => '6470923', // Nintendo Switch sku
            'url' => 'https://www.bestbuy.com/site/nintendo-switch-oled-model-w-white-joy-con-white/6470923.p?skuId=6470923',
        ]);

        try {
            (new BestBuy())->checkAvailability($stock);
        } catch (\Exception $e) {
            $this->fail('Failed to track the Best Buy API properly.');
        }

        $this->assertTrue(true);
    }
}
