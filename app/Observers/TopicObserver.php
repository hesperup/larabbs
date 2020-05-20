<?php

namespace App\Observers;

use App\Models\Topic;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
        $topic->excerpt = make_excerpt($topic->body, 20);
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        Log::error('Purifier are cleaning the content ');
        $topic->body =  Purifier::clean($topic->body, 'user_topic_body');
        Log::error($topic->body);
        $topic->excerpt = make_excerpt($topic->body);
    }
}
