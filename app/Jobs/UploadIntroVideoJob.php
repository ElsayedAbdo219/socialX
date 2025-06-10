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
    $originalPath = Storage::disk('public')->path($this->path);
    $userId = $this->userId;

    $fileName = pathinfo($originalPath, PATHINFO_FILENAME);
    $convertedFileName = $fileName . '-converted.mp4';
    $convertedPath = Storage::disk('public')->path('posts/' . $convertedFileName);

    // 🔁 استخدم ffmpeg كـ CLI لتقليل الحمل
    $process = new Process([
        'ffmpeg',
        '-i', $originalPath,
        '-vf', 'scale=854:480',
        '-c:v', 'libx264',
        '-c:a', 'aac',
        '-preset', 'ultrafast',
        $convertedPath,
    ]);

    $process->setTimeout(0); // مهم عشان مانقفش بسبب وقت
    $process->run();

    if (!$process->isSuccessful()) {
        throw new \Exception("FFMPEG failed: " . $process->getErrorOutput());
    }

    // حذف الفيديو الأصلي
    Storage::disk('public')->delete($this->path);

    // قراءة مدة الفيديو
    $getID3 = new \getID3;
    $convertedAnalysis = $getID3->analyze($convertedPath);
    $duration = $convertedAnalysis['playtime_seconds'] ?? null;

    // تحديث أو إنشاء intro
    Intro::updateOrCreate(
        ['company_id' => $userId],
        ['file_name' => $convertedFileName]
    );

    // إشعار الإدمن
    $admin = User::first();
    Notification::send($admin, new ClientNotification([
        'title' => "إضافة فيديو تقديمي جديد",
        'body' => "تمت إضافة فيديو من شركة " . (User::find($userId)->full_name ?? 'Unknown'),
    ], ['database', 'firebase']));
}

}
