<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VehicleValuation extends Controller
{
    public function __invoke()
    {
        return "Hello from Vehicle Valuation API!";
        // return BookResource::collection(Book::paginate(25));
    }
}
