<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class AdsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // $response = $this->post('/client-api/v1/posts');
        // $fileName = UploadedFile::fake()->create('videotest.mp4', 1000, 'video/mp4');
        // Storage::disk('public')->putFileAs('videos', $fileName, 'videotest.mp4');
        // Post::create([
        //     'user_id' => 1,
        //     'file_name' => 'videotest.mp4',
        //     'status' => 'advertise',
        //     'start_date' => now(),
        //     'end_date' => now()->addDays(7),
        //     'start_time' => '11:20:00',
        //     'end_time' => '12:20:00',
        //     'period' => 12,
        // ]);

        // $response->assertStatus(200);
    }
}
