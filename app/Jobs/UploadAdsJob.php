<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadAdsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempChunkPath;
    protected $chunkPath;
    protected $chunkNumber;

    public function __construct($tempChunkPath, $fileName, $chunkNumber)
    {
        $this->tempChunkPath = $tempChunkPath;
        $this->chunkPath = storage_path("app/temp/chunks/{$fileName}");
        $this->chunkNumber = $chunkNumber;
    }

    public function handle(): void
    {
        if (!file_exists($this->chunkPath)) {
            mkdir($this->chunkPath, 0777, true);
        }

        rename($this->tempChunkPath, "{$this->chunkPath}/{$this->chunkNumber}");
    }
}
