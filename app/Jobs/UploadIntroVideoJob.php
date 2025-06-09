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

  protected $path;
  protected $userId;

  public function __construct($path, $userId)
  {
    $this->path = $path;
    $this->userId = $userId;
  }

  public function handle()
  {
    \DB::beginTransaction();

    try {
      $path = $this->path;
      $userId = $this->userId;
      $fileName = pathinfo($path, PATHINFO_FILENAME); // بدون الامتداد
      $convertedFileName = $fileName . '-converted.mp4';
      $convertedPath = 'posts/' . $convertedFileName;

      // ✅ تحويل الفيديو إلى 480p وتخزينه باسم جديد
      \FFMpeg::fromDisk('public')
        ->open($path)
        ->export()
        ->toDisk('public')
        ->inFormat(new X264('aac', 'libx264'))
        ->resize(854, 480)
        ->save($convertedPath);

      // ✅ حذف النسخة الأصلية
      Storage::disk('public')->delete($path);

      // ✅ تحليل الفيديو الجديد
      $getID3 = new \getID3;
      $convertedAnalysis = $getID3->analyze(Storage::disk('public')->path($convertedPath));
      $width = $convertedAnalysis['video']['resolution_x'] ?? null;
      $height = $convertedAnalysis['video']['resolution_y'] ?? null;

      // ✅ حفظ في قاعدة البيانات
      Intro::updateOrCreate(
        ['company_id' => $userId],
        ['file_name' => $convertedFileName]
      );

      // ✅ إشعار الأدمن
      $admin = User::first();
      Notification::send($admin, new ClientNotification([
        'title' => "إضافة فيديو تقديمي جديد",
        'body' => "تمت إضافة فيديو تقديمي جديد من شركة " . (User::find($userId)->full_name ?? 'Unknown'),
      ], ['database', 'firebase']));

      \DB::commit();
    } catch (\Throwable $e) {
      \DB::rollBack();
      throw $e; // يخلي ال job تعيد المحاولة تلقائيًا لو فيه tries
    }
  }
}
