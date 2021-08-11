<?php

namespace App\Http\Controllers\Api\Blackbook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BlackbookYMM extends Controller
{
    public function __invoke($year, $make, $model)
    {
        return "Hello from Blackbook API! {$year} {$make} {$model}";
    }
}
