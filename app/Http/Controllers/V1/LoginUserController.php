<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);
        $user = User::whereEmail($request->email)->first();

        if(!$user)
        {
            return [
                'message' => 'User not found',
                'code' => 404
            ];
        }

        if(auth()->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $token = $user->createToken($request->device_name);
            return [
                'token' => $token->plainTextToken
            ];
        }

        return [
            'message' => 'Incorrect password'
        ];
    }
}
