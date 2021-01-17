<?php


namespace amirgonvt\Press\Console;


use amirgonvt\Press\Facades\Press;
use amirgonvt\Press\Post;
use Illuminate\Console\Command;
use \Illuminate\Support\Str;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Updates blog posts.';

    public function handle()
    {
        if (Press::configNotPublished()) {
            return $this->warn("Please publish the config file by running" .
                "\'php artisan vendor:publish --tag=press-config\'");
        }

        try {
            $posts = Press::driver()->fetchPosts();

            foreach ($posts as $post) {
                Post::create([
                    'identifier' => $post['identifier'],
                    'slug' => Str::slug($post['title']),
                    'title' => $post['title'],
                    'body' => $post['body'],
                    'extra' => $post['extra'],
                ]);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}