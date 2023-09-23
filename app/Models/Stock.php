<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
      'in_stock' => 'boolean',
    ];

    public function track()
    {
        if ($this->retailer->name === 'Best Buy') {
            $results = \Http::get('https://foo.test')->json();

            $this->update([
                'in_stock' => $results['available'],
                'price'=> $results['price'],
            ]);
        }
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
