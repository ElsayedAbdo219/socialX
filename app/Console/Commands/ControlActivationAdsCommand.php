<?php

namespace App\Console\Commands;

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
    $today = $now->format('Y-m-d');

    $ads = Post::where('status', PostTypeEnum::ADVERTISE)
      ->whereDate('start_date', '<=', $today)
      ->whereDate('end_date', '>=', $today)
      ->whereTime('start_time', '<=', $now->format('H:i:s'))
      ->whereTime('end_time', '>=', $now->format('H:i:s'))
      ->get();
      // dd($ads);

    foreach ($ads as $ad) {
      Log::info("Processing Ad ID: {$ad->id}");
      $this->generateFlexibleScheduleVideo($ad, $now);
    }
  }

  # this function to active or not the video control (ad)###
  private function generateFlexibleScheduleVideo($ad)
  
  {
    $start = Carbon::parse($ad->start_time); # 5
    $end = Carbon::parse($ad->end_time); # 12

    $totalHours = $start->diffInHours($end); # 7
    $totalPlays = $ad->period; # 10
    $basePerHour = intdiv($totalPlays, $totalHours); # 1
    $extra = $totalPlays % $totalHours; # 3

    for ($i = 0; $i < $totalHours; $i++) {
      $currentHourStart = $start->copy()->addHours($i);
      $playsThisHour = $basePerHour + ($i < $extra ? 1 : 0);
      if ($playsThisHour > 0) {
        $minutes = collect(range(0, 59))->random($playsThisHour)->sort();
        foreach ($minutes as $minute) {
          $playTime = $currentHourStart->copy()->addMinutes($minute);
          $filePath = 'posts/' . $ad->file_name;
          $fullPath = Storage::disk('public')->path($filePath);
          $getID3 = new \getID3;
          $analysis = $getID3->analyze($fullPath);

          dispatch(function () use ($ad, $playTime) {
            $delay = now()->diffInSeconds($playTime, false);
            if ($delay > 0) {
              sleep($delay);
            }

            $ad->update(['is_Active' => 1]);
            Log::info("Ad {$ad->id} activated at {$playTime}");

            $videoDuration = $analysis['playtime_seconds'] ?? 1;
            if (isset($ad->file_name)) {
              sleep($videoDuration / 60);
              $ad->update(['is_Active' => 0]);
            } else {
              sleep(60);
              $ad->update(['is_Active' => 0]);
            }
          });
        }
      }
    }

    $this->info("Ad {$ad->id} scheduled to run {$totalPlays} times between {$start} and {$end}");
  }
}
