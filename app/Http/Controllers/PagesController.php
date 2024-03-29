<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    //邮箱验证通知
    public function emailVerifyNotice(Request $request)
    {
        return view('pages.email_verify_notice');
    }
}
