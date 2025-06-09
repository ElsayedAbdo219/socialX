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

    public $path;
    public $userId;

    public function __construct($path, $userId)
    {
      \Log::info("Dispatching job for video: $path by user: $userId");
        $this->path = $path; // مسار نصي فقط
        $this->userId = $userId;
    }

    public function handle()
    {
        $fullPath = Storage::disk('public')->path($this->path);
        $fileName = pathinfo($this->path, PATHINFO_FILENAME);

        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        // if (in_array($extension, ['mp4', 'avi', 'mov'])) {
        //     $getID3 = new \getID3;
        //     $analysis = $getID3->analyze($fullPath);
        //     if (isset($analysis['playtime_seconds']) && $analysis['playtime_seconds'] > 60) {
        //         Storage::disk('public')->delete($this->path);
        //         return;
        //     }
        // }

        \DB::beginTransaction();

        $tempName = $fileName . '-temp.mp4';
        $finalName = $fileName . '.mp4';

        FFMpeg::fromDisk('public')
            ->open($this->path)
            ->export()
            ->toDisk('public')
            ->inFormat(new X264('aac', 'libx264'))
            ->resize(854, 480)
            ->save('posts/' . $tempName);

        Storage::disk('public')->delete($this->path);
        Storage::disk('public')->move('posts/' . $tempName, 'posts/' . $finalName);

        Intro::updateOrCreate(
            ['company_id' => $this->userId],
            ['file_name' => $finalName]
        );

        $admin = User::first();
        Notification::send($admin, new ClientNotification([
            'title' => "إضافة فيديو تقديمي جديد",
            'body' => "تمت إضافة فيديو تقديمي جديد من شركة {$this->userId}", // ما تقدر تستخدم auth هنا
        ], ['database', 'firebase']));

        \DB::commit();
    }
}
