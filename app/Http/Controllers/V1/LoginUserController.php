<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\V1\GlobalApiResponse;
use Illuminate\Http\Request;
class LoginUserController extends Controller
{
    use GlobalApiResponse;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = $this->validateUser($request->all());
        if($validator->fails())
        {
            return $this->errorResponse("Validation error(s).", $validator->messages(), 422);
        }
        $user = User::whereEmail($request->email)->first();

        if(!$user)
        {
            return $this->successResponse(
                data: null,
                message: 'User not found',
                statusCode: 404
            );
        }

        if(auth()->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $token = $user->createToken($request->device_name);
            $data = [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
            return $this->successResponse(
                data: $data,
                message: 'Login successful.',
            );
        }
        return $this->errorResponse(
            message: 'Incorrect password.',
            statusCode: 422
        );
    }

    public function validateUser($data){
        return \Illuminate\Support\Facades\Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'device_name' => 'required|min:3'
        ]);
    }
}
