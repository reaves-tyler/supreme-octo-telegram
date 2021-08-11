<?php

namespace App\Http\Controllers\Api\Blackbook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BlackbookPowerSportsYMM extends Controller
{
    private $auth;
    private $year;
    private $make;
    private $model;

    public function __invoke(Request $request)
    {
        $this->auth = base64_encode($_ENV['BLACKBOOK_USERNAME'] . ':' . $_ENV['BLACKBOOK_PASSWORD']);
        $this->year = $request->year;
        $this->make = $request->make;
        $this->model = $request->model;

        $validator = Validator::make(
            [
                'year' => $this->year,
                'make' => $this->make,
                'model' => $this->model,
            ],
            [
                'year' => 'required|integer',
                'make' => 'required|string',
                'model' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }

        $response = $this->getVehicleValuation();
        return $response->json();
    }

    private function getVehicleValuation()
    {

        $response = Http::withHeaders([
            'Authorization' => "Basic {$this->auth}"
        ])->get($this->generateUrl());
        if ($response->failed()) {
            $response->throw();
        }

        return $response;
    }

    private function generateUrl()
    {
        return $_ENV['BLACKBOOK_BASEURL'] .  "PowersportsAPI/PowersportsAPI/Vehicle/{$this->year}/{$this->make}?model={$this->model}";
    }
}