<?php

namespace App\Jobs;

use App\Actions\StateActions;
use App\Http\Controllers\StateController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCmsStates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const YEAR = '2025';
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(): void
    {
        try {
            $res = StateActions::getStates(self::YEAR,1);
            Log::info("Executed: ".((string)(isset($res->states))));
            if (!isset($res->states)){
                $this->release();
            }
        } catch ( \Exception $e ) {
            Log::info("Problem with job ProcessCmsStates");
            $this->release();
        }
    }
}
