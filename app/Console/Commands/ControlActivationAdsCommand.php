<?php

namespace App\Console\Commands;

use App\Jobs\{
  ActivateAdJob,
  DeactivateAdJob
};
use Carbon\Carbon;
use App\Models\Post;
use App\Enum\PostTypeEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ControlActivationAdsCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:control-activation-ads-command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command to approved or cancel ads (images or videos)';

  /**
   * Execute the console command.
   */
  public function handle()
{
    $now = Carbon::now();

    $ads = Post::where('status', PostTypeEnum::ADVERTISE)
        ->whereDate('start_date', '<=', $now->toDateString())
        ->whereDate('end_date', '>=', $now->toDateString())
        ->whereTime('start_time', '<=', $now->toTimeString())
        ->whereTime('end_time', '>=', $now->toTimeString())
        ->get();

    foreach ($ads as $ad) {
        Log::info("Processing Ad ID: {$ad->id}");
        $this->scheduleAd($ad);
    }
}

private function scheduleAd(Post $ad)
{
    $start = Carbon::parse("{$ad->start_date} {$ad->start_time}");
    $end = Carbon::parse("{$ad->end_date} {$ad->end_time}");

    $totalHours = $start->diffInHours($end);
    if ($totalHours <= 0) {
        Log::warning("Ad {$ad->id} has invalid time range.");
        return;
    }

    $totalPlays = $ad->period;
    $basePerHour = intdiv($totalPlays, $totalHours);
    $extra = $totalPlays % $totalHours;

    Log::info("Scheduling Ad {$ad->id} - Base Plays/Hour: {$basePerHour}, Extra Plays: {$extra}");

    $filePath = 'posts/' . $ad->file_name;
    $fullPath = Storage::disk('public')->path($filePath);

    $getID3 = new \getID3;
    $analysis = $getID3->analyze($fullPath);
    $videoDuration = $analysis['playtime_seconds'] ?? 60; // seconds

    for ($i = 0; $i < $totalHours; $i++) {
        $currentHourStart = $start->copy()->addHours($i);
        $playsThisHour = $basePerHour + ($i < $extra ? 1 : 0);

        if ($playsThisHour > 0) {
            $minutes = collect(range(0, 59))->shuffle()->take($playsThisHour)->sort();

            foreach ($minutes as $minute) {
                $playTime = $currentHourStart->copy()->addMinutes($minute);
                // Dispatch a delayed job for activation
                if (isset($ad->file_name)) {
                    ActivateAdJob::dispatch($ad->id, $videoDuration)
                        ->delay($playTime);
                } elseif (isset($ad->image)) {
                    ActivateAdJob::dispatch($ad->id, 60 * 5) // assuming 5 minutes for images
                        ->delay($playTime);
                }
            }
        }
    }

    Log::info("Ad {$ad->id} scheduled to run {$totalPlays} times between {$start} and {$end}");
}
}
