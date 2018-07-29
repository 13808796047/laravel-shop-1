<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at'
    ];
    //last_used_at 字段是一个时间日期类型
    protected $dates = ['last_used_at'];

    //属于用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //创建访问器，拼接完整地址
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
