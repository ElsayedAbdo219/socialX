<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

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

        $ad->update(['is_Active' => 0]);
        Log::info("Ad {$ad->id} deactivated.");
    }
}
