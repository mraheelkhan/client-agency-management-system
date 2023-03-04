<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Passport;
use App\Traits\V1\GlobalApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    use GlobalApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Client::all();
        return $this->successResponse(
            data: $data,
            message: 'Clients retrieved successfully',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:3',
            'cnic' => 'required|min:5|unique:clients',
            'primary_phone' => 'required|min:11',
            'secondary_phone' => 'nullable'
        ]);
        if($validator->fails())
        {
            return $this->errorResponse(
                message: 'Given data in invalid.',
                errors: $validator->messages(),
                statusCode:  422
            );
        }
        $client = Client::create($validator->validated());

        return $this->successResponse(
            data: $client,
            message: 'Client created successfully',
            statusCode: 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $this->successResponse(
            data: $client,
            message: 'Client retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:3',
            'cnic' => ['required', 'min:5', Rule::unique('clients')->ignore($client->id)],
            'primary_phone' => 'required|min:11',
            'secondary_phone' => 'nullable'
        ]);

        if($validator->fails())
        {
            return $this->errorResponse(
                message: 'Given data in invalid.',
                errors: $validator->messages(),
                statusCode:  422
            );
        }

        $client = $client->update($validator->validated());
        return $this->successResponse(
            data: $client,
            message: 'Client updated successfully',
            statusCode:  201
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $this->successResponse(
            data: null,
            message: 'Client delete successfully',
        );
    }

    public function storePassport(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'passport_number' => 'required|alpha_num|min:10|unique:passports',
            'image' => 'required|file'
        ]);
        if($validator->fails())
        {
            return $this->errorResponse(
              message: "Given data invalid",
              errors: $validator->messages()
            );
        }
        $passport = Passport::create($validator->validated() + [ 'client_id' => $client->id ]);

        $passport->addMediaFromRequest('image')->toMediaCollection();
        return $this->successResponse(
            data: $passport,
            message: 'Passport created successfully.',
            statusCode: 201
        );
    }
}
