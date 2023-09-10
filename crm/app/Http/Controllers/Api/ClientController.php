<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    public function index(): AnonymousResourceCollection
    {
        return ClientResource::collection(Client::paginate(20));
    }
}
