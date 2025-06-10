<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class StoreUploadedFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fileContent;
    public $filename;

    /**
     * Create a new job instance.
     */
    public function __construct($fileContent, $filename)
    {
        $this->fileContent = $fileContent;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Storage::disk('local')->put('uploads/' . $this->filename, $this->fileContent);
    }
}

