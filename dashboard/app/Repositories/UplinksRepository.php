<?php

namespace App\Repositories;

use App\Models\Device;
use App\Events\UplinkReceived;
use App\Mappers\HasCounterInterface;
use App\Mappers\HasAppServerInterface;
use App\Mappers\HasEuiInterface;
use App\Mappers\UplinkMapperInterface;
use App\Models\Uplink;

/**
 * Uplinks Repository
 */
class UplinksRepository implements BaseRepositoryInterface
{
    public $model;

    public function __construct(Uplink $model)
    {
        $this->model = $model;
    }

    public function store(UplinkMapperInterface $mapper)
    {
        $data = [
            'device_id' => $mapper->getDeviceId(),
            'date' => $mapper->getTime()->toDateString(),
        ];

        $uplink = $this->model->firstOrCreate($data, [
            'payloads' => [],
            'port' => $mapper->getPort(),
        ]);

        // Prevent storing uplink if duplicate counter detected
        // if ($this->hasDuplicateCounter($uplink, $mapper)) {
        //     return $uplink;
        // }

        $payload = $mapper->getPayload();

        if ($mapper->getPort() == 0) {
            $device = Device::where('device_id', $mapper->getDeviceId())->first();
            if ($device) {
                $payload = array_merge($device->latest_payload ?: [], $payload);
            }
        }

        $uplink->push('payloads', [$payload]);
        $uplink->update(['updated_at' => now()]);

        $device = Device::firstOrCreate([
            'device_id' => $mapper->getDeviceId()
        ], [
            'name' => $mapper->getDeviceId(),
            'timezone' => 'Asia/Jakarta',
            'device_eui' => $mapper->getEui(),
        ]);

        // event(new UplinkReceived($device, $mapper));

        return $uplink;
    }

    /**
     * Has Duplicate Counter
     *
     * @param Uplink $uplink
     * @param mixed $mapper
     * @return boolean
     */
    protected function hasDuplicateCounter(Uplink $uplink, $mapper)
    {
        // if (!$mapper instanceof HasCounterInterface) {
        //     return false;
        // }

        // Device Debugging proccess will result high duplication in lower counter
        // We will determine it is a duplicate if the counter is higher than 10
        if ($mapper->getCounter() < 10) {
            return false;
        }

        if ($mapper->getCounter() == collect($uplink->payloads)->last()['counter']) {
            return true;
        }
    }
}
