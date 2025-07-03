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
    \Log::info(" بدء الدمج: {$this->chunkPath}");

    $files = collect(scandir($this->chunkPath))
        ->filter(fn($name) => is_numeric($name) && is_file("{$this->chunkPath}/{$name}"))
        ->sortBy(fn($name) => (int) $name)
        ->values();

    if ($files->isEmpty()) {
        \Log::error(" لا يوجد أي أجزاء في: {$this->chunkPath}");
        return;
    }

    $tempFinalPath = storage_path('app/temp/merged_' . basename($this->finalPath));
    $finalFile = fopen($tempFinalPath, 'ab');

    foreach ($files as $file) {
        $fullPath = "{$this->chunkPath}/{$file}";

        $data = file_get_contents($fullPath);
        if ($data === false) {
            \Log::error("فشل قراءة: {$fullPath}");
            continue;
        }

        fwrite($finalFile, $data);
        unlink($fullPath);

        \Log::info(" تم دمج: {$file}");
    }

    fclose($finalFile);

    @rmdir($this->chunkPath);

    if (!\File::exists(dirname($this->finalPath))) {
        \File::makeDirectory(dirname($this->finalPath), 0755, true);
    }

    \File::move($tempFinalPath, $this->finalPath);

    \Log::info("✅ تم الدمج النهائي في: {$this->finalPath}");
}


}

