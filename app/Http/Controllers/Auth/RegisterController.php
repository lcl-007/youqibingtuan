<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    public function store(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return $this->response->created();
    } 
}
