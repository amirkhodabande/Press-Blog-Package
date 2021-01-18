<?php


namespace amirgonvt\Press\Repositories;


use amirgonvt\Press\Post;
use Illuminate\Support\Str;

class PostRepository
{
    public function save($post)
    {
        $post['extra'] = $this->unsetTitleFromExtra($post);

        Post::updateOrCreate([
            'identifier' => $post['identifier'],
        ], [
            'slug' => Str::slug($post['title']),
            'title' => $post['title'],
            'body' => $post['body'],
            'extra' => $this->extra($post),
        ]);
    }

    private function unsetTitleFromExtra($post)
    {
        $post['extra'] = json_decode($post['extra']);

        unset($post['extra']->title);

        return json_encode($post['extra']);
    }

    private function extra($post)
    {
        $extra = (array)json_decode($post['extra'] ?? '[]');

        $attributes = array_except($post, ['title', 'body', 'identifier', 'extra']);

        return json_encode(array_merge($extra, $attributes));
    }
}