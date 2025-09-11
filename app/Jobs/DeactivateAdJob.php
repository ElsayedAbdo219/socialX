<?php
namespace App\Jobs;

use App\Models\Post;
use App\Enum\AdsStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeactivateAdJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $adId;

    public function __construct($adId)
    {
        $this->adId = $adId;
    }

    public function handle()
    {
        $ad = Post::find($this->adId);
        if (!$ad) return;
        DB::transaction(function () use ($ad) {
            // Deactivate
            $ad->adsStatus()?->update(['status' => AdsStatusEnum::CANCELLED]);
            $ad?->controlAds->delete();
            Log::info("Ad {$ad->id} deactivated.");
        });
    }
}
