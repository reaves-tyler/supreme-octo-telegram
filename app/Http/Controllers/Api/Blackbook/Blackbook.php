<?php

namespace App\Http\Controllers\Api\Blackbook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Blackbook extends Controller
{
    public function __invoke(Request $request)
    {
        return "Hello from Blackbook API! {$_ENV['BLACKBOOK_USERNAME']}";
    }
}
