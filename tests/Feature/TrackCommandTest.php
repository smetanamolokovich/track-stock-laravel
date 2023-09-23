<?php

namespace Tests\Feature;

use App\Clients\StockStatus;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_tracks_product_stock(): void
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 29900));

        $this->artisan('track')->expectsOutput('All done!');

        $this->assertTrue(Product::first()->inStock());
    }
}
