<?php

namespace App\Console\Commands;

use App\Jobs\CheckDeviceStatus;
use Illuminate\Console\Command;

class checkStatusDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:check {interval}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status all active device';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $job = new CheckDeviceStatus($this->argument('interval'));
        dispatch($job);
        return 1;
    }
}
