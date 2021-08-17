<?php

namespace Tests\Feature\Api\Blackbook;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class BlackBookRvUVCTest extends TestCase
{
    /**
     * @var: string
     */
    const ROUTE_NAME = 'blackbook-rv-uvc';

    /**
     * @var: string
     */
    const INVALID_API_KEY = '123';

    /**
     * @var: string
     */
    const UVC = '2000298134';

    /**
     * @var: string
     */
    const UVC_TWO = '0000000000';

    /**
     * @var array
     */
    const DATA_ONE = [
        "rv_vehicles" => [
            "rv_vehicle_list" => [
                [
                    "publish_date" => "8/1/2021",
                    "country" => "U",
                    "uvc" => "2000298134",
                    "model_year" => "2000",
                    "make" => "Jayco",
                    "model" => "Eagle Series",
                    "style" => "12",
                    "class_name" => "Camping Trailers",
                    "whole_avg" => 725,
                    "whole_clean" => 1000,
                    "retail_avg" => 1325,
                    "finadv" => 1100,
                    "width" => "7' 0\"",
                    "coach_design" => "0",
                    "floor_plan" => "0",
                    "axles" => "0",
                    "weight" => "2150",
                    "slides" => "1",
                    "sleeps" => "7",
                    "msrp" => 7400,
                    "ext_length" => "24' 0\""
                ]
            ],
        ]
    ];

    /**
     * @var array
     */
    const DATA_TWO = [
        "rv_vehicles" => [
            "rv_vehicle_list" => [],
        ]
    ];

    /**
     * @var array
     */
    const CONTROLLER_RESPONSE_ONE = [
        "uvc" => "2000298134",
        "model_year" => "2000",
        "make" => "Jayco",
        "model" => "Eagle Series",
        "style" => "12",
        "class_name" => "Camping Trailers",
        "whole_avg" => 725,
        "whole_clean" => 1000,
        "retail_avg" => 1325,
        "finadv" => 1100,
        "msrp" => 7400,
    ];

    /**
     * @var array
     */
    const CONTROLLER_RESPONSE_TWO = [];

    /**
     * @var array
     */
    const UVC_VALIDATION_ERROR_DATA = [
        "uvc" => [
            "The uvc must be at least 10 characters."
        ]
    ];

    /**
     * Test UVC route
     *
     * @return void
     */
    public function testBlackbookUVC()
    {
        Http::fake([
            env('BLACKBOOK_BASEURL')."*" => Http::response(self::DATA_ONE, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, ['uvc'=>self::UVC]);
        $response = $this->getJson($url, ['api-key'=>env('API_KEY')]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(self::CONTROLLER_RESPONSE_ONE);
    }

    /**
     * Test UVC route with invalid api key
     *
     * @return void
     */
    public function testInvalidVVAPIKey()
    {
        Http::fake([
            env('BLACKBOOK_BASEURL')."*" => Http::response(self::DATA_ONE, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, ['uvc'=>self::UVC]);
        $response = $this->getJson($url, ['api-key'=>self::INVALID_API_KEY]);
        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Test UVC route for no vehicle found from Blackbook
     *
     * @return void
     */
    public function testBlackbookUVCNoVehicle()
    {
        Http::fake([
            env('BLACKBOOK_BASEURL')."*" => Http::response(self::DATA_TWO, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, ['uvc'=>self::UVC_TWO]);
        $response = $this->getJson($url, ['api-key'=>env('API_KEY')]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(self::CONTROLLER_RESPONSE_TWO);
    }

    /**
     * Test invalid UVC
     *
     * @return void
     */
    public function testBlackbookIncorrectUVC()
    {
        Http::fake([
            env('BLACKBOOK_BASEURL')."*" => Http::response(self::DATA_ONE, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, ['uvc'=>'abc']);
        $response = $this->getJson($url, ['api-key'=>env('API_KEY')]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJson(self::UVC_VALIDATION_ERROR_DATA);
    }

    /**
     * Test failed response from BB API
     *
     * @return void
     */
    public function testBlackbookFailedAPICall()
    {
        Http::fake([
            env('BLACKBOOK_BASEURL')."*" => Http::response('', JsonResponse::HTTP_UNAUTHORIZED)
        ]);

        $url = route(self::ROUTE_NAME, ['uvc'=>self::UVC]);
        $response = $this->getJson($url, ['api-key'=>env('API_KEY')]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }
}