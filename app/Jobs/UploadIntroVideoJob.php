<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;
use App\Models\Intro;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClientNotification;
use getID3;
use FFMpeg\Format\Video\X264;

class UploadIntroVideoJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


  public function __construct()
  {

  }

public function handle()
{
    $start = now();
    \Log::info('⏱️ Start video job at: ' . $start);



}

}
