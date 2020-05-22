<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable =['type','path'];

    public function use()
    {
        return $this->belongsTo(User::class);
    }


}
