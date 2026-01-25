<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasUuids;

    protected $table = 'products';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'price',
        'stock',
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tags', 'tag_id','id');
    }

    public function owner(){
        return $this->belongsTo(Owner::class,'owner_id','id');
    }

    public function orders(){
        return $this->belongsToMany(
            Order::class,
            'order_products',
            'product_id',
            'order_id'
        )->withPivot([
            'quantity',
            'unit_price',
            'subtotal'
        ])->withTimestamps();
    }
}
