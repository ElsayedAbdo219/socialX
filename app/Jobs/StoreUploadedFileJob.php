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

    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function handle(): void
    {
        // اقرأ محتوى الملف من disk المحلي (storage/app/uploads)
        $content = Storage::disk('local')->get('uploads/' . $this->filename);

        // هنا بقى اعمل اللي انت عايزه بالمحتوى

        // كمثال: إعادة حفظه في مكان آخر
        Storage::disk('local')->put('processed/' . $this->filename, $content);
    }
}

