<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name', 'email', 'password', 'email_verified',
    ];
    //所以我们新增一个 $casts 属性，告诉 Laravel 这个字段要转换成 bool 类型：
    protected $casts = [
        'email_verified' => 'boolean'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //通用授权策略
    public function isAuthOf($model)
    {
        return $this->id == $model->user_id;
    }

    //用户拥有多个地址
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}
