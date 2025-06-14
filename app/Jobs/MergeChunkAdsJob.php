<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MergeChunkAdsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunkPath, $finalPath;

    public function __construct($chunkPath, $finalPath)
    {
        $this->chunkPath = $chunkPath;
        $this->finalPath = $finalPath;
    }

    public function handle(): void
    {
        $chunks = collect(scandir($this->chunkPath))
            ->filter(fn($name) => is_numeric($name))
            ->sortBy(fn($name) => (int) $name);

        if (!file_exists(dirname($this->finalPath))) {
            mkdir(dirname($this->finalPath), 0777, true);
        }

        $finalFile = fopen($this->finalPath, 'ab');

        foreach ($chunks as $chunk) {
            $chunkContent = file_get_contents($this->chunkPath . '/' . $chunk);
            fwrite($finalFile, $chunkContent);
            unlink($this->chunkPath . '/' . $chunk);
        }

        fclose($finalFile);
        rmdir($this->chunkPath);
    }
}
