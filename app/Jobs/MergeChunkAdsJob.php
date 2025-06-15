<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MergeChunkAdsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $chunkPath;
    protected string $finalPath;

    public function __construct(string $chunkPath, string $finalPath)
    {
        $this->chunkPath = $chunkPath;
        $this->finalPath = $finalPath;
    }

public function handle(): void
{
    \Log::info("🔁 Starting merge for: {$this->chunkPath}-{$this->finalPath}" );

    $chunks = collect(scandir($this->chunkPath))
        ->filter(fn($name) => is_numeric($name))
        ->sortBy(fn($name) => (int) $name);

    if ($chunks->isEmpty()) {
        \Log::error("🚫 No chunks found in: {$this->chunkPath}");
        return;
    }

    // temporary merged file
    $tempFinalPath = storage_path('app/temp/merged_' . basename($this->finalPath));
    $finalFile = fopen($tempFinalPath, 'ab');

    foreach ($chunks as $chunk) {
        $chunkFullPath = "{$this->chunkPath}/{$chunk}";
        if (!file_exists($chunkFullPath)) continue;

        fwrite($finalFile, file_get_contents($chunkFullPath));
        unlink($chunkFullPath);
    }

    fclose($finalFile);
    rmdir($this->chunkPath);

    // 👇 هنا بننضف الاسم
    $cleanName = preg_replace('/_\d+$/', '', basename($this->finalPath)); // remove _timestamp
    $finalPublicPath = storage_path("app/public/posts/{$cleanName}");
    //  \Log::info($finalPublicPath);
    // تأكد من وجود مجلد الوجهة
    if (!\File::exists(dirname($finalPublicPath))) {
        \File::makeDirectory(dirname($finalPublicPath), 0755, true);
    }

    // نقل الملف النهائي بعد الدمج
    \File::move($tempFinalPath, $finalPublicPath);

    \Log::info("✅ Merge completed: {$finalPublicPath}");
}


}
