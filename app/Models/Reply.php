<?php

namespace App\Models;

use App\User;

class Reply extends Model
{
    protected $fillable = ['content'];

    public function user()
    {

        $this->belongsTo(User::class);
        # code...
    }

    public function topic()
    {
        $this->belongsTo(Topic::class);
    }

    
}
