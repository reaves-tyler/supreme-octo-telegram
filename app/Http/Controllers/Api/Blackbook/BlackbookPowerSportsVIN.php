<?php

namespace App\Http\Controllers\Api\Blackbook;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIToTIConverter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class BlackbookPowerSportsVIN extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make(
            ['vin' => $request->vin],
            ['vin' => 'required|string|min:10|max:17']
        );
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }

        $response = $this->getVehicleValuation($request->vin);
        return $response;
    }

    private function getVehicleValuation(string $vin)
    {
        $auth = base64_encode(env('BLACKBOOK_USERNAME') . ':' . env('BLACKBOOK_PASSWORD'));
        $response = Http::withHeaders([
            'Authorization' => "Basic {$auth}"
        ])->get($this->generateUrl($vin));
        if ($response->failed()) {
            $response->throw();
        }

        return APIToTIConverter::convertBlackBookPowerSportsToDto($response);
    }

    private function generateUrl(string $vin)
    {
        return env('BLACKBOOK_BASEURL') .  "PowersportsAPI/PowersportsAPI/Vehicle/VIN/{$vin}";
    }
}
