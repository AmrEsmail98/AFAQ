<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_vehicles_page_correctly()
    {
        DB::table('vehicles')->insert([
            [
                'name' => 'Test Vehicle',
                'plate_number' => '52540079',
                'license' => '4545787545',
                'year' => 2020,
                'vin' => '4547845',
                'imei' => '4545878541',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_filters_vehicles_by_name()
    {
        Vehicle::create(['name' => 'Test Vehicle']);

        $response = $this->get('/home?name=Test');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Test Vehicle']);
    }
}
