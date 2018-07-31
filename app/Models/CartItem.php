<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['amount'];
    public $timestamps = false;

    //属于用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //属于sku
    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }
}
