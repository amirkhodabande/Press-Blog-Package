<?php


namespace amirgonvt\Press\Console;


use amirgonvt\Press\Post;
use amirgonvt\Press\PressFileParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Updates blog posts.';

    public function handle()
    {
        $files = File::files('blogs');

        foreach ($files as $file) {
            $post = (new PressFileParser($file->getPathname()))->getData();
            /*
             * I dont know why : the post contain extra field with duplicate values from title and descriotion.
             *
             * so I decide to remove theme manually from here, if you know a better way please tell me :) */
            $extra = json_decode($post['extra']);
            unset($extra->title);
            unset($extra->description);

            $extra = json_encode($extra);
            if ($extra !== "{}")
                $post['extra'] = $extra;
            else unset($post['extra']);

        }
        isset($post['extra']) ? $extra = $post['extra'] : [];

        Post::create([
            'identifier' => Str::random(),
            'slug' => Str::slug($post['title']),
            'title' => $post['title'],
            'body' => $post['body'],
            'extra' => $extra,
        ]);
    }
}