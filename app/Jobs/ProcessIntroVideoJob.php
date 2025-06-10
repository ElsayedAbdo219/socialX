<?php

namespace App\Jobs;

use App\Models\Intro;
use App\Models\User;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ClientNotification;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use getID3;
class ProcessIntroVideoJob implements ShouldQueue
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
            $fileName = pathinfo($this->path, PATHINFO_FILENAME);
            $convertedFileName = $fileName . '-converted.mp4';
            $convertedPath = 'posts/' . $convertedFileName;

            // FFMpeg with ultrafast preset
            \FFMpeg::fromDisk('public')
                ->open($this->path)
                ->export()
                ->toDisk('public')
                ->inFormat((new X264('aac', 'libx264'))->setAdditionalParameters(['-preset', 'ultrafast']))
                ->resize(854, 480)
                ->save($convertedPath);

            // Delete original
            Storage::disk('public')->delete($this->path);

            // Analyze new video
            $getID3 = new \getID3;
            $convertedAnalysis = $getID3->analyze(Storage::disk('public')->path($convertedPath));
            $width = $convertedAnalysis['video']['resolution_x'] ?? null;
            $height = $convertedAnalysis['video']['resolution_y'] ?? null;

            Intro::updateOrCreate(
                ['company_id' => $this->userId],
                ['file_name' => $convertedFileName]
            );

            // Notify admin
            $admin = User::first();
            Notification::send($admin, new ClientNotification([
                'title' => "إضافة فيديو تقديمي جديد",
                'body' => "تمت إضافة فيديو تقديمي جديد من شركة " . (User::find($this->userId)->full_name ?? 'Unknown'),
            ], ['database', 'firebase']));

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
}
