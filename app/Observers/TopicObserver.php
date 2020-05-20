<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
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
        $topic->body =  Purifier::clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
        dispatch(new TranslateSlug($topic));
    }
    public function deleted(Topic $topic)
    {
        //注意，在模型监听器中，数据库操作需避免再次触发 Eloquent事件，以免造成联动逻辑冲突。所以这里我们使用了 DB 类进行操作。
        DB::table('replies')->where('topic_id', $topic->id)->delete();
      //todo notify 应该也清空

    }
}
