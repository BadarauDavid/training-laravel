<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_contact',
        'customer_comment',
    ];

    public static function create(array $validatedData)
    {
        $newOrder = new Order();
        $newOrder->fill($validatedData);
        $newOrder->save();
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }
}
