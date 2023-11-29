<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\Client\StoreRequest;

class ClientsController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $client = Client::create($data);

        return $client;
    }
}
