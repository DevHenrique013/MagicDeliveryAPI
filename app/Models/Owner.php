<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'contact'
    ];

    public function products(){
        return $this->hasMany(Product::class,'product_id','id');
    }
}
