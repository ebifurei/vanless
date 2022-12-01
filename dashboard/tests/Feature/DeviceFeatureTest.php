<?php

namespace Tests\Feature;

use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeviceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_device_index_page_can_be_rendered()
    {
        $this->login();

        $response = $this->get(route('device.index'));

        $response->assertStatus(200);
    }

    public function test_device_create_page_can_be_rendered()
    {
        $this->login();

        $response = $this->get(route('device.create'));

        $response->assertStatus(200);
    }

    public function test_device_can_be_created()
    {
        $this->login();
        $device = [
            'name' => 'Test Device',
            'device_id' => 'test_device',
            'description' => 'test_description',
            'device_eui' => 'test_device_eui',
            'timezone' => 'test_timezone',
            'address' => 'test_address',
            'latitude' => -6.175392,
            'longitude' => 110.827152,
        ];

        $response = $this->post(route('device.store'), $device);

        $this->assertDatabaseHas('devices', [
            'device_id' => $device['device_id']
        ]);
    }
}
