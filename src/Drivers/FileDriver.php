<?php


namespace amirgonvt\Press\Drivers;


use amirgonvt\Press\PressFileParser;
use Illuminate\Support\Facades\File;

class FileDriver
{
    public function fetchPosts()
    {
        $files = File::files(config('press.path'));

        foreach ($files as $key => $file) {
            $posts[] = (new PressFileParser($file->getPathname()))->getData();
            /*
             * I dont know why : the post contain extra field with duplicate values from title and description.
             *
             * so I decide to remove theme manually from here, if you know a better way please tell me :) */
            $extra = json_decode($posts[$key]['extra']);
            unset($extra->title);
            unset($extra->description);

            $extra = json_encode($extra);
            $posts[$key]['extra'] = $extra;
        }

        return $posts ?? [];
    }
}