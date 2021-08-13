<?php

namespace Tests\Feature\Api\Blackbook;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class BlackBookRvYMMTest extends TestCase
{
    /**
     * @var: string
     */
    const ROUTE_NAME = 'blackbook-rv-ymm';

    /**
     * @var: string
     */
    const INVALID_API_KEY = '123';

    /**
     * @var: array
     */
    const YMM = [
        "year" => 2009,
        "make" => "Safari",
        "model" => "Ivory Series",
        "style" => "127 Chevy V8"
    ];

    /**
     * @var: array
     */
    const YMM_TWO = [
        "year" => 2009,
        "make" => "Foo",
        "model" => "Bar",
        "style" => "Baz"
    ];

    /**
     * @var: array
     */
    const YMM_THREE = [
        "year" => 0,
        "make" => "Foo",
        "model" => "Bar",
        "style" => "Baz"
    ];

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
    const VIN_VALIDATION_ERROR_DATA = [
        "year" => [
            'The year must be 4 digits.'
        ]
    ];

    /**
     * Test YMM route
     *
     * @return void
     */
    public function testBlackbookYMM()
    {
        Http::fake([
            "{$_ENV['BLACKBOOK_BASEURL']}*" => Http::response(self::DATA_ONE, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, self::YMM);
        $response = $this->postJson($url, [], ['api-key'=>$_ENV['API_KEY']]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(self::CONTROLLER_RESPONSE_ONE);
    }

    /**
     * Test YMM route with invalid api key
     *
     * @return void
     */
    public function testInvalidVVAPIKey()
    {
        Http::fake([
            "{$_ENV['BLACKBOOK_BASEURL']}*" => Http::response(self::DATA_ONE, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, self::YMM);
        $response = $this->postJson($url, [], ['api-key'=>self::INVALID_API_KEY]);
        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Test YMM route for no vehicle found from Blackbook
     *
     * @return void
     */
    public function testBlackbookVINNoVehicle()
    {
        Http::fake([
            "{$_ENV['BLACKBOOK_BASEURL']}*" => Http::response(self::DATA_TWO, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, self::YMM_TWO);
        $response = $this->postJson($url, [], ['api-key'=>$_ENV['API_KEY']]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(self::CONTROLLER_RESPONSE_TWO);
    }

    /**
     * Test invalid YMM
     *
     * @return void
     */
    public function testBlackbookIncorrectYMM()
    {
        Http::fake([
            "{$_ENV['BLACKBOOK_BASEURL']}*" => Http::response(self::DATA_ONE, JsonResponse::HTTP_OK)
        ]);

        $url = route(self::ROUTE_NAME, self::YMM_THREE);
        $response = $this->postJson($url, [], ['api-key'=>$_ENV['API_KEY']]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJson(self::VIN_VALIDATION_ERROR_DATA);
    }

    /**
     * Test failed response from BB API
     *
     * @return void
     */
    public function testBlackbookFailedAPICall()
    {
        Http::fake([
            "{$_ENV['BLACKBOOK_BASEURL']}*" => Http::response('', JsonResponse::HTTP_UNAUTHORIZED)
        ]);

        $url = route(self::ROUTE_NAME, self::YMM);
        $response = $this->postJson($url, [], ['api-key'=>$_ENV['API_KEY']]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }
}