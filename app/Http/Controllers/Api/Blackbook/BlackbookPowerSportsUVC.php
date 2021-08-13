<?php

namespace App\Http\Controllers\Api\Blackbook;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIToTIConverter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class BlackbookPowerSportsUVC extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make(
            ['uvc' => $request->uvc],
            ['uvc' => 'required|string|min:10|max:10']
        );
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }

        $response = $this->getVehicleValuation($request->uvc);
        return $response;
    }

    private function getVehicleValuation(string $uvc)
    {
        $auth = base64_encode($_ENV['BLACKBOOK_USERNAME'] . ':' . $_ENV['BLACKBOOK_PASSWORD']);
        $response = Http::withHeaders([
            'Authorization' => "Basic {$auth}"
        ])->get($this->generateUrl($uvc));
        if ($response->failed()) {
            $response->throw();
        }

        return APIToTIConverter::convertBlackBookPowerSportsToDto($response);
    }

    private function generateUrl(string $uvc)
    {
        return $_ENV['BLACKBOOK_BASEURL'] .  "PowersportsAPI/PowersportsAPI/Vehicle/UVC/{$uvc}";
    }
}