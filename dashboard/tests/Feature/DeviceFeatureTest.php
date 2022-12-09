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

    public function test_device_can_be_updated()
    {
        $this->login();
        $device = Device::factory()->create();

        $response = $this->put(route('device.update', $device->id), [
            'name' => 'Test Device',
            'device_id' => 'test_device',
            'description' => 'test_description',
            'device_eui' => 'test_device_eui',
            'timezone' => 'test_timezone',
            'address' => 'test_address',
            'latitude' => -6.175392,
            'longitude' => 110.827152,
        ]);

        $this->assertDatabaseHas('devices', [
            'device_id' => 'test_device'
        ]);
    }

    public function test_device_can_be_deleted()
    {
        $this->login();
        $device = Device::factory()->create();

        $response = $this->delete(route('device.destroy', $device->id));

        $this->assertDatabaseMissing('devices', [
            'id' => $device->id
        ]);
    }

    public function test_device_can_be_shown()
    {
        $this->login();
        $device = Device::factory()->create();

        $response = $this->get(route('device.show', $device->id));

        $response->assertStatus(200);
    }
}
