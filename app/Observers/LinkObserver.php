<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Facades\Cache as FacadesCache;

class LinkObserver
{
    // 在保存时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        FacadesCache::forget($link->cache_key);
    }
}
