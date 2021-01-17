<?php


namespace amirgonvt\Press\Console;


use amirgonvt\Press\Facades\Press;
use amirgonvt\Press\Repositories\PostRepository;
use Illuminate\Console\Command;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Updates blog posts.';

    public function handle(PostRepository $postRepository)
    {
        if (Press::configNotPublished()) {
            return $this->warn("Please publish the config file by running" .
                "\'php artisan vendor:publish --tag=press-config\'");
        }

        try {
            $posts = Press::driver()->fetchPosts();

            $this->info('Number of posts : ' . count($posts));

            foreach ($posts as $post) {
                $postRepository->save($post);

                $this->info('Post: ' . $post['title']);
            }
            $this->info("All posts processed successfully :)");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}