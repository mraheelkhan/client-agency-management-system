<?php

namespace App\Http\Controllers;

use App\Http\Resources\PassportShowApiResource;
use App\Models\Client;
use App\Models\Passport;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client, Passport $passport)
    {
        $passport->load("media");
        return new PassportShowApiResource($passport);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Passport $passport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Passport $passport)
    {
        //
    }
}
