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

  protected $path, $userId;

  public function __construct($path, $userId)
  {
    $this->path = $path;
    $this->userId = $userId;
  }

  public function handle()
  {
    $originalPath = $this->path;
    $userId = $this->userId;

    $fileName = pathinfo($originalPath, PATHINFO_FILENAME);
    $convertedFileName = $fileName . '-converted.mp4';
    $convertedPath = 'posts/' . $convertedFileName;

    // \FFMpeg::fromDisk('public')
    //   ->open($originalPath)
    //   ->export()
    //   ->toDisk('public')
    //   ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
    //   ->resize(854, 480)
    //   ->save($convertedPath);

    // Storage::disk('public')->delete($originalPath);

    // $getID3 = new \getID3;
    // $convertedAnalysis = $getID3->analyze(Storage::disk('public')->path($convertedPath));
    // $duration = $convertedAnalysis['playtime_seconds'] ?? null;

    Intro::updateOrCreate(
      ['company_id' => $userId],
      ['file_name' => $convertedFileName]
    );

    $admin = User::first();
    Notification::send($admin, new ClientNotification([
      'title' => "إضافة فيديو تقديمي جديد",
      'body' => "تمت إضافة فيديو من شركة " . (User::find($userId)->full_name ?? 'Unknown'),
    ], ['database', 'firebase']));
  }
}
