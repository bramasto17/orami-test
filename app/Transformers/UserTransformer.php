<?php

namespace App\Transformers;

class UserTransformer extends Transformer
{
    public $type = 'user';

    /**
     * @param \App\User $post
     * @return array
     */
    public function transform($post)
    {
        return [
            'id' => $post->id,
            'name' => $post->name,
            'email' => $post->email,
        ];
    }
}