<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'on_sale',
        'rating', 'sold_count', 'review_count', 'price'
    ];
    protected $casts = [
        'on_sale' => 'boolean',//on_Sale是一个布尔类型的字段
    ];

    //与商品SKU关联
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    //获取图片路径
    public function getImageUrlAttribute()
    {
        //如果image字段本身就已经是完整url就直接返回
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }
        return Storage::disk('public')->url($this->attributes['image']);
    }
}
