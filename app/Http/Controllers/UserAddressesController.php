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
    public function create(UserAddress $user_address)
    {
        return view('user_addresses.create_and_edit', compact('user_address'));
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

    //修改收货地址
    public function edit(UserAddress $user_address)
    {
        $this->authorize('own',$user_address);
        return view('user_addresses.create_and_edit', compact('user_address'));
    }

    //更新
    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $this->authorize('own',$user_address);
        $user_address->update($request->only([
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
    //删除
    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own',$user_address);
        $user_address->delete();
        return [];
    }
}
