<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;   // importante per eseguirlo in coda
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Services\RealSmartImporter;

class RealSmartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        \Log::info("Start Real smart import at-> ".now());

        $realSmart = new RealSmartImporter;
        $realSmart->import();
    }
}
