<?php

namespace Tests\Feature\Api\Blackbook;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class BlackBookPowerSportsYMMTest extends TestCase
{
    /**
     * @var: string
     */
    const ROUTE_NAME = 'blackbook-ymm';

    /**
     * @var: string
     */
    const INVALID_API_KEY = '123';

    /**
     * @var: array
     */
    const YMM = [
        "year" => 2007,
        "make" => "Harley-Davidson",
        "model" => "VRSCDX Night Rod Special"
    ];

    /**
     * @var: array
     */
    const YMM_TWO = [
        "year" => 2007,
        "make" => "Foo",
        "model" => "Bar"
    ];

    /**
     * @var: array
     */
    const YMM_THREE = [
        "year" => 0,
        "make" => "Harley-Davidson",
        "model" => "VRSCDX Night Rod Special"
    ];

    /**
     * @var array
     */
    const DATA_ONE = [
        "powersports_vehicles" => [
            "powersports_vehicle_list" => [
                [
                    "publish_date" => "8/1/2021",
                    "country" => "US",
                    "vin" => "1HD1HHZ187K811405",
                    "uvc" => "2007022209",
                    "model_year" => "2007",
                    "make" => "Harley-Davidson",
                    "model" => "VRSCDX Night Rod Special",
                    "class_name" => "Cruiser",
                    "whole_avg" => 7795,
                    "retail_avg" => 9410,
                    "tradein_clean" => 7415,
                    "tradein_fair" => 6500,
                    "finadv" => 7985,
                    "msrp" => 16495,
                    "cylinders" => 2,
                    "engine_displacement" => 1130
                ]
            ],
        ]
    ];

    /**
     * @var array
     */
    const DATA_TWO = [
        "powersports_vehicles" => [
            "powersports_vehicle_list" => [],
        ]
    ];

    /**
     * @var array
     */
    const CONTROLLER_RESPONSE_ONE = [
        "vin" => "1HD1HHZ187K811405",
        "model_year" => "2007",
        "make" => "Harley-Davidson",
        "model" => "VRSCDX Night Rod Special",
        "class_name" => "Cruiser",
        "whole_avg" => 7795,
        "retail_avg" => 9410,
        "tradein_clean" => 7415,
        "tradein_fair" => 6500,
        "finadv" => 7985,
        "msrp" => 16495,
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
     * Test VIN route
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
     * Test VIN route with invalid api key
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
     * Test VIN route for no vehicle found from Blackbook
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