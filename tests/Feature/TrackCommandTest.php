<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->seed(RetailerWithProductSeeder::class);
    }

    use RefreshDatabase;
    /** @test */
    function it_tracks_product_stock(): void
    {
        $this->assertFalse(Product::first()->inStock());

        $this->mockClientRequest();

        $this->artisan('track')->expectsOutput('All done!');

        $this->assertTrue(Product::first()->inStock());
    }

    /** @test */
    function it_does_not_notify_the_user_when_the_stock_remain_unavailable()
    {
        $this->mockClientRequest(false);

        $this->artisan('track');

        Notification::assertNothingSent();
    }

    /** @test */
    function it_notifies_the_user_when_the_stock_is_now_available()
    {
        $this->mockClientRequest();

        $this->artisan('track');

        Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
    }
}
