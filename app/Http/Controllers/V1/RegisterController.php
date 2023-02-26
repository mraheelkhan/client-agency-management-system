<?php

namespace App\Http\Controllers\V1;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, CreateNewUser $createNewUser)
    {
        $user = $createNewUser->create($request->all());
        $token = $user->createToken($user->name);
        $data = collect()->merge($user)->merge(['token' => $token->plainTextToken]);
        return $data;
    }
}
