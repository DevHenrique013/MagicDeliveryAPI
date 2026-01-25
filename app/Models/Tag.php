<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'name',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'product_id','id');
    }
}
