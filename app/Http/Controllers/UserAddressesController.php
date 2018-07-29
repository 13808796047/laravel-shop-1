<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Auth;

class UserAddressesController extends Controller
{
    //展示用户收货地址
    public function index()
    {
        return view('user_addresses.index', ['addresses' => Auth::user()->addresses]);
    }

    //新增收货地址
    public function create(UserAddress $address)
    {
        return view('user_addresses.create_and_edit', compact('address'));
    }

    //存储收货地址
    public function store(UserAddressRequest $request)
    {
        Auth::user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        return redirect()->route('user_addresses.index');
    }
}
