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
        $response = $this->get("/api/vehicle-valuation/blackbook/powersports/".self::VIN, ['api-key'=>$_ENV['API_KEY']]);
        $response->assertStatus(JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }
}