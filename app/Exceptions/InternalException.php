<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class InternalException extends Exception
{
    //系统内部错误
    protected $msgForUser;

    public function __construct(string $message = "", string $msgForUser='系统内部错误')
    {
        parent::__construct($message, $code);
        $this->msgForUser = $msgForUser;
    }
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['msg' => $this->msgForUser], $this->code);
        }

        return view('pages.error', ['msg' => $this->msgForUser]);
    }
}
