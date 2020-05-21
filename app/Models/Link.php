<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache as FacadesCache;

class Link extends Model
{
    //
    protected $fillable = ['title', 'link'];

    public $cache_key = 'larabbs_links';

    protected $cache_expire_in_mintes = 1440;

    public function getAllCached()
    {
        return FacadesCache::remember('$this->cache_key', $this->cache_expire_in_mintes, function () {
            return $this->all();
        });
    }
}
