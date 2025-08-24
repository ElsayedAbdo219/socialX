<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Enum\PostTypeEnum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteExpiredPostsCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:delete-expired-posts-command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $posts = Post::whereStatus(PostTypeEnum::ADVERTISE)
      ->where('end_date', '<', now())
      ->get();
      // dd($posts->count());
      Log::info($posts);
    foreach ($posts ?? [] as $post) {
      if ($post->image)
        Storage::delete('posts/'.$post?->image);
      if ($post->video)
        Storage::delete('posts/'.$post?->file_name);
    }
    $posts->each->delete();
    Log::info('Expired posts deleted successfully.');
  }
}
