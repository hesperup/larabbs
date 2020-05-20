<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function make_excerpt($value,$length =20)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/',' ' ,strip_tags($value)));
        return str_limit($excerpt, $length);
        # code...
    }

}
