<?php

namespace Tests\Feature\Api\Blackbook;
use Illuminate\Http\JsonResponse;

use Tests\TestCase;

class ExceptionsTest extends TestCase
{
    /**
     * @var: string
     */
    const VIN = '1HD1HHZ187K811405';

    /**
     * Test invalid request method
     *
     * @return void
     */
    public function testInvalidMethod() {
        $response = $this->post("/vehicle-valuation/blackbook/powersports/VIN/".self::VIN, [], ['api-key'=>env('API_KEY')]);
        $response->assertStatus(JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }
}