<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use function Laravel\Prompts\table;

class TrackCommand extends Command
{
    protected $signature = 'track';

    protected $description = 'Track all product stock.';

    public function handle()
    {
        $products = Product::all();

        $this->output->progressStart($products->count());

        $products->each(function ($product) {
            $product->track();

            $this->output->progressAdvance();
        });

        $this->output->progressFinish();

        $this->showResults();
    }

    protected function showResults(): void
    {
        $data = Product::query()
            ->leftJoin('stock', 'stock.product_id', '=', 'products.id')
            ->get($this->keys());

        $this->table(
            array_map('ucwords', $this->keys()),
            $data
        );
    }

    protected function keys(): array
    {
        return ['name', 'price', 'url', 'in_stock'];
    }
}
