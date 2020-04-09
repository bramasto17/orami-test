<?php

namespace App\Transformers;

class PostTransformer extends Transformer
{
    public $type = 'post';
    protected $availableIncludes = ['user'];

    public function transform($post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
        ];
    }
    public function includeUser($post)
    {
        return $this->item($post->user, new UserTransformer(), 'user');
    }
}