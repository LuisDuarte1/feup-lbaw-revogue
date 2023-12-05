<?php

namespace App\Jobs;

use App\Models\PurchaseIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Attributes\WithoutRelations;

class PurchaseIntentTimeoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $deleteWhenMissingModels = true;
    /**
     * Create a new job instance.
     */
    public function __construct(
        #[WithoutRelations]        
        public PurchaseIntent $purchaseIntent)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        error_log("deleting purchase intent". $this->purchaseIntent->id);
        $this->purchaseIntent->delete();
    }
}
