<?php

namespace App\Http\Controllers\Api\Blackbook;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIToTIConverter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BlackbookRvYMM extends Controller
{
    private $auth;
    private $year;
    private $make;
    private $model;
    private $style;

    public function __invoke(Request $request)
    {
        $this->auth = base64_encode($_ENV['BLACKBOOK_USERNAME'] . ':' . $_ENV['BLACKBOOK_PASSWORD']);
        $this->year = $request->year;
        $this->make = $request->make;
        $this->model = $request->model;
        $this->style = $request->style;

        $validator = Validator::make(
            [
                'year' => $this->year,
                'make' => $this->make,
                'model' => $this->model,
                'style' => $this->style,
            ],
            [
                'year' => 'required|integer|digits:4',
                'make' => 'required|string',
                'model' => 'required|string',
                'style' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }

        $response = $this->getVehicleValuation();
        return $response;
    }

    private function getVehicleValuation()
    {

        $response = Http::withHeaders([
            'Authorization' => "Basic {$this->auth}"
        ])->get($this->generateUrl());
        if ($response->failed()) {
            $response->throw();
        }

        return APIToTIConverter::convertBlackBookRvToDto($response);
    }

    private function generateUrl()
    {
        return $_ENV['BLACKBOOK_BASEURL'] .  "RVAPI/RVAPI/Vehicle/{$this->year}?make={$this->make}&model={$this->model}&style={$this->style}";
    }
}
