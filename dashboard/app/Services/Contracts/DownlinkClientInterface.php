<?php

namespace App\Services\Contracts;

interface DownlinkClientInterface
{
    /**
     * Send Downlink to The App Server
     *
     * @param string $devId
     * @param string $payloadRaw
     * @param integer $port
     * @return void
     */
    public function sendDownlink($devId, $payloadRaw, $port);
}
