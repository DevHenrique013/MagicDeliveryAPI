<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'total_amount',
        'status'
    ];   

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function products(){
        return $this->belongsToMany(
            Product::class,
            'order_products',
            'order_id',
            'product_id'
        )->withPivot([
            'quantity',
            'unit_price',
            'subtotal'
        ])->withTimestamps();
    }
}
