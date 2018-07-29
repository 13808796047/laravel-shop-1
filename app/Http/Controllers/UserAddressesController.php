<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class UserAddressesController extends Controller
{
    //展示用户收货地址
    public function index()
    {
        return view('user_addresses.index', ['addresses' => Auth::user()->addresses]);
    }
}
