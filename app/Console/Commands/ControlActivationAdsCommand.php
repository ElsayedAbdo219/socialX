<?php

namespace App\Console\Commands;

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
        $ads = Post::whereStatus(PostTypeEnum::ADVERTISE)->get();
        foreach ($ads ?? [] as $ad) {
            $timesNumber = $ad->period;
            $timesDays = ($ad->end_date->diffInDays($ad->start_date));
            


        }

    }
}
