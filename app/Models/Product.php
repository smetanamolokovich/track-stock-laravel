<?php

namespace App\Models;

use App\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    public function inStock(): bool
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function track(): void
    {
        $this->stock->each->track(
            fn ($stock) => $this->recordHistory($stock)
        );
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
