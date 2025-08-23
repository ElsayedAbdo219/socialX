<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Enum\PostTypeEnum;
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
            ->delete();
        Log::info('Expired posts deleted successfully.');
    }
}
