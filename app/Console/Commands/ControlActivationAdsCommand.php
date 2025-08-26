<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Post;
use App\Enum\PostTypeEnum;
use Illuminate\Console\Command;

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

        $ads = Post::where('type', PostTypeEnum::ADVERTISE)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->whereTime('start_time', '<=', $now->format('H:i:s'))
            ->whereTime('end_time', '>=', $now->format('H:i:s'))
            ->get();

        foreach ($ads as $ad) {
          if(isset($ad->image) && $ad->image) {
            $ad->update(['is_Active' => 1 ]);
            $this->info("Ad {$ad->id} is an image and activated.");


          }else{
            $totalPeriod = Carbon::parse($ad->start_time)->diffInMinutes($ad->end_time);
            $interval = $totalPeriod / $ad->play_times;

            $lastPlayed = $ad->last_played_at ? Carbon::parse($ad->last_played_at) : null;

            if (!$lastPlayed || $now->diffInMinutes($lastPlayed) >= $interval) {
                
                $ad->status = 1;
                $ad->last_played_at = $now;
                $ad->save();

                dispatch(function () use ($ad) {
                    sleep($ad->duration * 60); 
                    $ad->update(['is_Active' => 0 ]);
                });

                $this->info("Ad {$ad->id} started at {$now}");
            }
        }
        }
    

    }
}
