<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class ActivateAdJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $adId;
    protected $duration;

    public function __construct($adId, $duration)
    {
        $this->adId = $adId;
        $this->duration = $duration; // in seconds
    }

    public function handle()
    {
        $ad = Post::find($this->adId);
        if (!$ad) {
            Log::warning("Ad {$this->adId} not found.");
            return;
        }

        // Activate
        $ad->update(['is_Active' => 1]);
        Log::info("Ad {$ad->id} activated.");

        // Schedule deactivation after duration
        DeactivateAdJob::dispatch($ad->id)
            ->delay(now()->addSeconds($this->duration));
    }
}
