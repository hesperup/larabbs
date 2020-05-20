<?php

namespace App\Models;

use App\User;

class Reply extends Model
{
    protected $fillable = ['content'];

    public function user()
    {

        return  $this->belongsTo(User::class);
        # code...
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }


    // public function scopeRecent($query)
    // {
    //     // 按照创建时间排序
    //     return $query->orderBy('created_at', 'desc');
    // }
}
